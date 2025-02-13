import { updateOrderApi } from "/Front/Api/OrderApi.js"
export function constructUpdateForm(order, idContainer, registerTable) {
    const idOrder = order.id;

    // Carregar o arquivo HTML usando fetch
    fetch('/Front/Pedidos/updateForm.php')
        .then(response => response.text())  // Obtém o conteúdo HTML do arquivo
        .then(html => {
            // Criar o contêiner e inserir o HTML
            let formContainer = document.getElementById(idContainer);

            // Inserir o conteúdo HTML no contêiner
            formContainer.insertAdjacentHTML('afterbegin', html);
            // Preencher os campos do formulário com os dados do cliente
            document.getElementById("inputObservations").value = order.orderObservations ?? "";
            document.getElementById("inputTotalValue").value = order.orderTotalValue ?? "";
            document.getElementById("inputLocation").value = order.orderLocation ?? "";

            // Adicionar eventos aos botões de ação
            document.getElementById("updateButton").addEventListener("click", function () {
                updateOrder(idOrder);
                document.getElementById("updateForm").remove();
                if (registerTable != null) {
                    registerTable.remountTableAfterAction()
                }
            });

            document.getElementById("cancelButton").addEventListener("click", function () {
                document.getElementById("updateForm").remove();
            });
        })
        .catch(error => {
            alert('Erro ao carregar o formulário:');
        });
}

function updateOrder(idOrder) {
    const observations = document.getElementById("inputObservations").value;
    const totalValue = document.getElementById("inputTotalValue").value;
    const location = document.getElementById("inputLocation").value;
    const status = document.getElementById("inputStatus").value;

    const order = {
        observations,
        totalValue,
        location,
        status,
    }

    const response = updateOrderApi(idOrder, order);
    const responseData = response.data;
}