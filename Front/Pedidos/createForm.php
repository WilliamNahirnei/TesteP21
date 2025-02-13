<link rel="stylesheet" href="/Front/Pedidos/createForm.css">

<form id="createOrderForm" class="styled-form">
    <h2>📦 Adicionar Pedido</h2>

    <div class="form-group">
        <label for="inputObservations">Observações</label>
        <textarea id="inputObservations" placeholder="Digite observações"></textarea>
    </div>

    <div class="form-group">
        <label for="inputTotalValue">Valor Total</label>
        <input id="inputTotalValue" type="number" step="0.01" placeholder="Digite o valor total">
    </div>

    <div class="form-group">
        <label for="inputLocation">Localização</label>
        <input id="inputLocation" type="text" placeholder="Digite a localização">
    </div>

    <div class="form-group">
        <label for="inputCustomer">Status</label>
        <select id="inputCustomer">
        </select>
    </div>

    <div class="form-actions">
        <button type="button" class="btn magic-btn full-width" id="createButton">✨ Adicionar Pedido</button>
    </div>
</form>

<script type="module">
    import { insertOrder, defineCustomerOptionsField } from "/Front/Pedidos/OrderCreate.js";

    document.getElementById("createButton").addEventListener('click', insertOrder);
    defineCustomerOptionsField();
</script>
