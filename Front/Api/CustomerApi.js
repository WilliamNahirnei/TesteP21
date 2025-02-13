export function getDataList() {
    let request = new XMLHttpRequest();
    request.open("GET", "http://localhost:8000/customer", false);
    request.send();

    if (request.status !== 200) {
        const apiMessage = JSON.parse(request.response).message
        alert("Erro ao buscar lista de clientes." + apiMessage? apiMessage : "");
        return [];
    }
    return JSON.parse(request.response).data;
}

export function getCustomerById(idCustomer) {
    let request = new XMLHttpRequest();
    request.open("GET", `http://localhost:8000/customer/find?idCustumer=${idCustomer}`, false);
    request.send();
    if (request.status != 200) {
        const apiMessage = JSON.parse(request.response).message
        alert("Erro ao buscar o cliente." + apiMessage? apiMessage : "");
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
        const apiMessage = JSON.parse(request.response).message
        console.log(apiMessage)
        alert("Erro ao inserir o cliente." + (apiMessage? apiMessage : ""));
        return
    }
    const response = JSON.parse(request.response);
    return response;
}

export function updateCustomerApi(idCustomer, customerData = {}) {
    const bodyRequest = JSON.stringify(customerData);

    let request = new XMLHttpRequest();
    request.open("PUT", `http://localhost:8000/customer?idCustumer=${idCustomer}`, false);
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.send(bodyRequest);
    if (request.status != 200) {
        const apiMessage = JSON.parse(request.response).message
        alert("Erro ao atualizar o cliente." + apiMessage? apiMessage : "");
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
        const apiMessage = JSON.parse(request.response).message
        alert("Erro ao excluir cliente." + apiMessage? apiMessage : "");
        return
    }
    const response = JSON.parse(request.response)
    return response
}