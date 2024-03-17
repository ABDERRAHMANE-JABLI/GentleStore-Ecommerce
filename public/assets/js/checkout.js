import { postData } from "./modules.js";

window.onload = () => {

	document.querySelector("#payNow").addEventListener('click', async () => {
		var shipping_adresse = document.querySelector('#shipping_adresse').value;
		var billing_adresse = document.querySelector('#billing_adresse').value;
		if (shipping_adresse == "" || billing_adresse == "") {
			errorMSG('error', 'You should select your shipping adress and billing adress');
			return;
		}
        const result = await postData('/api/orders',{shipping_addr : shipping_adresse, billing_addr : billing_adresse});
        console.log(result);
        if(result.success){
            console.log(result.data);
            $('#orderId').val(result.data);
            $("#myModal").modal('show');
        }
        else{
            errorMSG('error', 'an error occured, please try again');
        }
	})

// stripe code ******************************************************************:

// This is your test publishable API key.
const key = document.querySelector("#publicKey").value;
console.log(key);
const stripe = Stripe(key);

// The items the customer wants to buy
const items = [{
id: "xl-tshirt"
}];

let elements;

initialize();
checkStatus();

document.querySelector("#payment-form").addEventListener("submit", handleSubmit);

// Fetches a payment intent and captures the client secret
async function initialize() {

const {clientSecret} = await fetch("/api/strip/paymentIntent", {
	method: "POST",
	headers: {
	"Content-Type": "application/json"
	},
	body: JSON.stringify({ }), // to DO : get Total from cart in the server side
	}).then((r) => r.json());

elements = stripe.elements({clientSecret});

const paymentElementOptions = {
	layout: "tabs"
};

const paymentElement = elements.create("payment", paymentElementOptions);
	paymentElement.mount("#payment-element");
}

async function handleSubmit(e) {
	e.preventDefault();
	setLoading(true);
    const orderId = $('#orderId').val();
    console.log("handle submit : "+orderId);
	const {error} = await stripe.confirmPayment({
			elements,
			confirmParams: { // Make sure to change this to your payment completion page
			return_url: "http://localhost:8000/checkout/success-payment/"+ orderId
		}
	});
	// This point will only be reached if there is an immediate error when
	// confirming the payment. Otherwise, your customer will be redirected to
	// your `return_url`. For some payment methods like iDEAL, your customer will
	// be redirected to an intermediate site first to authorize the payment, then
	// redirected to the `return_url`.
	if (error.type === "card_error" || error.type === "validation_error") {
		showMessage(error.message);
	} else {
		showMessage("An unexpected error occurred.");
	} 
	setLoading(false);
}

// Fetches the payment intent status after payment submission
async function checkStatus() {
	const clientSecret = new URLSearchParams(window.location.search).get("payment_intent_client_secret");
	if (! clientSecret) {
		return;
	}
	const {paymentIntent} = await stripe.retrievePaymentIntent(clientSecret);
	switch (paymentIntent.status) {
		case "succeeded": showMessage("Payment succeeded!");
		break;
		case "processing": showMessage("Your payment is processing.");
		break;
		case "requires_payment_method": showMessage("Your payment was not successful, please try again.");
		break;
		default: showMessage("Something went wrong.");
		break;
	}
}

// ------- UI helpers -------

function showMessage(messageText) {
	const messageContainer = document.querySelector("#payment-message");

	messageContainer.classList.remove("hidden");
	messageContainer.textContent = messageText;

	setTimeout(function () {
	messageContainer.classList.add("hidden");
	messageContainer.textContent = "";
	}, 4000);
}

// Show a spinner on payment submission
function setLoading(isLoading) {
	if (isLoading) { // Disable the button and show a spinner
		document.querySelector("#submit").disabled = true;
		document.querySelector("#spinner").classList.remove("hidden");
		document.querySelector("#button-text").classList.add("hidden");
	} 
	else {
		document.querySelector("#submit").disabled = false;
		document.querySelector("#spinner").classList.add("hidden");
		document.querySelector("#button-text").classList.remove("hidden");
	}
}

}