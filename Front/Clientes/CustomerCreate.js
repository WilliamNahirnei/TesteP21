import { storeCustomerApi } from "/Front/Api/CustomerApi.js"
export function insertCustomer(){

    const name = document.getElementById("inputNameCreate").value
    const email = document.getElementById("inputEmailCreate").value
    const customerData = {
        "name": name,
        "email": email,
    }

    const response = storeCustomerApi(customerData)
    window.location.reload();
}