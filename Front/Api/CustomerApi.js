export function getDataList() {
    let request = new XMLHttpRequest();
    request.open("GET", "http://localhost:8000/customer", false);
    request.send();

    if (request.status !== 200) {
        alert("Erro ao buscar lista de clientes");
        return [];
    }
    return JSON.parse(request.response).data;
}

export function getCustomerById(idCustomer) {
    let request = new XMLHttpRequest();
    request.open("GET", `http://localhost:8000/customer/find?idCustumer=${idCustomer}`, false);
    request.send();
    if (request.status != 200) {
        alert("Erro ao buscar o cliente.");
        return;
    }
    const response = JSON.parse(request.response);
    return response;
}

export function storeCustomerApi(customerData = {}) {
    const bodyRequest = JSON.stringify(customerData)

    let request = new XMLHttpRequest();
    request.open("POST", "http://localhost:8000/customer", false);
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.send(bodyRequest);
    if(request.status!=201){
        alert("erro ao inserir cliente");
        return
    }
    const response = JSON.parse(request.response);
    window.location.reload();
}

export function updateCustomerApi(idCustomer, customerData = {}) {
    const bodyRequest = JSON.stringify(customerData);

    let request = new XMLHttpRequest();
    request.open("PUT", `http://localhost:8000/customer?idCustumer=${idCustomer}`, false);
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.send(bodyRequest);
    if (request.status != 200) {
        alert("Erro ao atualizar o cliente.");
        return;
    }
    const response = JSON.parse(request.response);
    return response;
}

export function deleteCustomerApi(idCustomer){
    let request = new XMLHttpRequest();
    request.open("DELETE", `http://localhost:8000/customer?idCustumer=${idCustomer}`, false)
    request.send()
    if(request.status!=200){
        alert("erro ao deletar")
        return
    }
    const response = JSON.parse(request.response)
    return response
}