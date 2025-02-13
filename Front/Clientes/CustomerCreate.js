import { storeCustomerApi } from "/Front/Api/CustomerApi.js"
export function insertCustomer(){

    const name = document.getElementById("inputNameCreate").value
    const email = document.getElementById("inputEmailCreate").value
    const location = document.getElementById("inputLocationCreate").value
    const customerData = {
        name,
        email,
        location,
    }

    const response = storeCustomerApi(customerData)
    window.location.reload();
}