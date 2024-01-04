function updateCartHeader(data){
    const cart_length = document.querySelector('#length_cart')
    const cart_list = document.querySelector('#cart_Header')
    cart_length.innerText = data.length;
    var content = '';
    data.items.forEach((item)=>{
        content += `<li>
                        <a href="/cart">
                            <img width="50" height="50" alt="${item.product.name}" src="/assets/images/products/${item.product.image}">
                            ${item.product.name}&nbsp;: <strong>${format_currency(item.product.soldePrice / 100)}</strong>
                        </a>
                    </li>`;
    });
    cart_list.innerHTML = content
}

const format_currency = (price)=>{
    return Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(price);
}

function successMSG(title,msg){
    const audio = document.createElement('audio');
    audio.src = "/assets/audios/success.wav";
    audio.play();
    toastr.success(title,msg, {timeout:1000});
}

function errorMSG(title,msg){
    toastr.error(title,msg, {timeout:1500});
}

function infoMSG(msg){
    toastr.info(msg);
}

const fetchData = async (url)=>{
    const response = await fetch(url)
    return await response.json();
}