export function getDataList() {
    let request = new XMLHttpRequest();
    request.open("GET", "http://localhost:8000/order", false);
    request.send();

    if (request.status !== 200) {
        const apiMessage = JSON.parse(request.response).message
        alert("Erro ao buscar lista de pedidos" + apiMessage? apiMessage : "");
        return [];
    }
    return JSON.parse(request.response).data;
}

export function storeOrderApi(orderData = {}) {
    const bodyRequest = JSON.stringify(orderData)

    let request = new XMLHttpRequest();
    request.open("POST", "http://localhost:8000/order", false);
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.send(bodyRequest);
    if(request.status!=201){
        const apiMessage = JSON.parse(request.response).message
        alert("erro ao inserir pedido" + apiMessage? apiMessage : "");
        return
    }
    const response = JSON.parse(request.response);
    return response;
}

export function uploadOrdersFile(dataUpload = {}) {
    const bodyRequest = JSON.stringify(dataUpload)

    let request = new XMLHttpRequest();
    request.open("POST", "http://localhost:8000/order/importFile", false);
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.send(bodyRequest);
    if(request.status!=201){
        const apiMessage = JSON.parse(request.response).message
        alert("erro ao importarPerdidos" + apiMessage? apiMessage : "");
        return
    } else {
        alert("Pedidos inseridos com sucesso")

    }
    const response = JSON.parse(request.response);
    return response;
}

export function updateOrderApi(idOrder, orderData = {}) {
    const bodyRequest = JSON.stringify(orderData);

    let request = new XMLHttpRequest();
    request.open("PUT", `http://localhost:8000/order?idOrder=${idOrder}`, false);
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.send(bodyRequest);
    if (request.status != 200) {
        const apiMessage = JSON.parse(request.response).message
        alert("Erro ao atualizar o pedido." + apiMessage? apiMessage : "");
        return;
    }
    const response = JSON.parse(request.response);
    return response;
}

export function deleteOrderApi(idOrder){
    let request = new XMLHttpRequest();
    request.open("DELETE", `http://localhost:8000/order?idOrder=${idOrder}`, false)
    request.send()
    if(request.status!=200){
        const apiMessage = JSON.parse(request.response).message
        alert("Erro ao excluir pedido." + apiMessage? apiMessage : "");
        return
    }
    const response = JSON.parse(request.response)
    return response
}