import { deleteCustomerApi } from "../Api/CustomerApi.js"
export function deleteCustomer(customer){
    const idCustomer = customer.id
    deleteCustomerApi(idCustomer)
}