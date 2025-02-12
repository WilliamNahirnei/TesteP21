function insertCustomer(){

    const name = document.getElementById("inputNameCreate").value
    const email = document.getElementById("inputEmailCreate").value
    const bodyRequest = JSON.stringify({
        "name": name,
        "email": email,
    })

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