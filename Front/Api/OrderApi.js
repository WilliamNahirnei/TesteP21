export function uploadOrdersFile(dataUpload = {}) {
    const bodyRequest = JSON.stringify(dataUpload)

    let request = new XMLHttpRequest();
    request.open("POST", "http://localhost:8000/order/importFile", false);
    request.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
    request.send(bodyRequest);
    if(request.status!=201){
        alert("erro ao importarPerdidos");
        return
    } else {
        alert("Pedidos inseridos com sucesso")

    }
    const response = JSON.parse(request.response);
    return response;
}