import { storeOrderApi } from "/Front/Api/OrderApi.js"
import { getDataList } from "/Front/Api/CustomerApi.js"
export function insertOrder(){

    const observations = document.getElementById("inputObservations").value;
    const totalValue = document.getElementById("inputTotalValue").value;
    const location = document.getElementById("inputLocation").value;
    const idCustomer = document.getElementById("inputCustomer").value;

    const order = {
        observations,
        totalValue,
        location,
        idCustomer,
    }

    const response = storeOrderApi(order);
    window.location.reload();
}

export function defineCustomerOptionsField() {
    const selectField = document.getElementById("inputCustomer");

    if (!selectField) {
        alert("Elemento select 'inputCustomer' não encontrado!");
        return;
    }

    // Limpa as opções atuais (caso existam)
    selectField.innerHTML = "";

    // Adiciona uma opção padrão
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Selecione um cliente";
    defaultOption.disabled = true;
    defaultOption.selected = true;
    selectField.appendChild(defaultOption);

    const customersList = getDataList()

    // Adiciona os clientes como opções
    customersList.forEach(customer => {
        const option = document.createElement("option");
        option.value = customer.id;
        option.textContent = `${customer.id} - ${customer.customerEmail? customer.customerEmail : customer.customerName}`;
        selectField.appendChild(option);
    });
}
