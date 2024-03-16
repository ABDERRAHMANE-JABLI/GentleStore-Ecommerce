/**
 * 
 * @description methode pour récupere les données
 * @returns response 
 * @param  url = endpoint
 */
const fetchData = async (url) => {
    const response = await fetch(url)
    return await response.json();
}

/**
 * @description methode pour insérer une ligne
 * @param  url = endpoint
 * @param  data l'objet à inserer
 * @returns response
 */
const postData = async (url, data) => {
    try {
      const response = await fetch(url, {
        method: 'POST', // Use 'PUT' if you're updating existing data
        headers: {
          'Content-Type': 'application/json',
          // Add any other headers as needed
        },
        body: JSON.stringify(data),
      });
      const result =  await response.json();
      return result;
    } catch (error) {
      console.error('Error when inserting data: ', error);
    }
};

/**
 * @description methode pour supprimer une ligne
 * @param  url = endpoint
 * @param  data = objet {"budget_id" : 12}
 * @returns response
 */
const deleteData = async (url, data)=>{
    try {
      const response = await fetch(url, {
        method: 'DELETE',
        headers: {
          'Content-Type': 'application/json',
          // Add any other headers as needed
        },
        body: JSON.stringify(data),
      });

      const result =  await response.json();
      //console.log(result);
      return result;
    } catch (error) {
      console.error('Error when deleting data:', error);
    }
  }

  /**
 * @description methode qui retourne une ligne
 * @param  url  = endpoint
 * @param  condition = objet {"condition" : "budget_id=12"}
 * @returns response
 */
  const getData = async (url, condition) => {
    try {
      const response = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          // Add any other headers as needed
        },
        body: JSON.stringify(condition),
      });
      const result =  await response.json();
      return result;
    } catch (error) {
      console.error('Error when Geting data: ', error);
    }
  };

/**
 * @description methode pour modifier une ligne : 
 * @param  url  /db/update/table-name/:id
 * @param  data new data to update
 * @returns response
 */

const updateData = async (url, data) => {
    try {
      const response = await fetch(url, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
          // Add any other headers as needed
        },
        body: JSON.stringify(data),
      });
      const result =  await response.json();
      return result;
    } catch (error) {
      console.error('Error when Updating data: ', error);
    }
};


export {fetchData, getData,deleteData, postData, updateData}