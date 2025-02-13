import { GenericTable } from "./GenericTable.js";
import { getDataList } from "../Api/CustomerApi.js";
import { deleteCustomer } from "./DeleteCustomerAction.js";
import { constructUpdateForm } from "../Clientes/CustomerUpdate.js";

export class CustomerTableList extends GenericTable {
    constructor(idElementToInsert, idTable) {
        // const remountTableAfterAction = () => super.remountTableAfterAction()
        super(idElementToInsert, idTable, {
            functionGetId: (register) => register.id,
            updateButtonActionClick: (register) => constructUpdateForm(register, idElementToInsert, this),
            deleteButtonActionClick: (register) => deleteCustomer(register),
            columnList: [
                { title: "ID", functionMountColmn: (register) => document.createTextNode(register.id) },
                { title: "Name", functionMountColmn: (register) => document.createTextNode(register.customerName) },
                { title: "Email", functionMountColmn: (register) => document.createTextNode(register.customerEmail) }
            ]
        });
    }

    getDataList() {
        return getDataList()
    }
}