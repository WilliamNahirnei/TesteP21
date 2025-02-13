import { deleteOrderApi } from "../Api/OrderApi.js"
export function deleteOrder(order){
    const idOrder = order.id
    deleteOrderApi(idOrder)
}