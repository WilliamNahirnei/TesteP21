import { GenericTable } from "../Components/GenericTable.js";
import { getDataList } from "../Api/OrderApi.js";
import { deleteOrder } from "./DeleteOrderAction.js";
import { constructUpdateForm } from "./UpdateOrder.js";

export class OrderTableList extends GenericTable {
    constructor(idElementToInsert, idTable) {
        super(idElementToInsert, idTable, {
            functionGetId: (register) => register.id,
            updateButtonActionClick: (register) => constructUpdateForm(register, idElementToInsert, this),
            deleteButtonActionClick: (register) => deleteOrder(register),
            columnList: [
                { title: "ID", functionMountColmn: (register) => document.createTextNode(register.id) },
                { title: "Observações", functionMountColmn: (register) => document.createTextNode(register.orderObservations) },
                { title: "Valor total R$", functionMountColmn: (register) => document.createTextNode(register.orderTotalValue ? register.orderTotalValue : "Desconhecido") },
                { title: "Data do pedido", functionMountColmn: (register) => document.createTextNode(register.orderDate ? new Intl.DateTimeFormat('pt-BR').format(new Date(register.orderDate)) : "Desconhecido")},
                { title: "Localização de entrega", functionMountColmn: (register) => document.createTextNode(register.orderLocation ? register.orderLocation : "Desconhecido") },
                { title: "Status", functionMountColmn: (register) => document.createTextNode(register.orderStatus ? register.orderStatus : "Desconhecido") },
                { title: "Cliente", functionMountColmn: (register) => document.createTextNode(
                    register.customer.id
                    + (register.customer.customerName ? "-" +register.customer.customerName : "")
                        + (register.customer.customerEmail ? "-" + register.customer.customerEmail: "")
                    )
                }
            ]
        });
    }

    getDataList() {
        return getDataList()
    }
}