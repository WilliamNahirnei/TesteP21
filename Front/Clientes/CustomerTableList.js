import { GenericTable } from "../Components/GenericTable.js";
import { getDataList } from "../Api/CustomerApi.js";
import { deleteCustomer } from "../Components/DeleteCustomerAction.js";
import { constructUpdateForm } from "./CustomerUpdate.js";

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
                { title: "Email", functionMountColmn: (register) => document.createTextNode(register.customerEmail) },
                { title: "Identificador Externo", functionMountColmn: (register) => document.createTextNode(register.externalId) }
            ]
        });
    }

    getDataList() {
        return getDataList()
    }
}