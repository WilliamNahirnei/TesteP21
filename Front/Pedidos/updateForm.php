<link rel="stylesheet" href="/Front/Pedidos/updateForm.css">

<form id="updateForm" class="styled-form">
    <h2>📦 Editar Pedido</h2>

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
        <label for="inputStatus">Status</label>
        <select id="inputStatus">
            <option value="pendente">Pendente</option>
            <option value="processando">Processando</option>
            <option value="enviado">Enviado</option>
            <option value="entregue">Entregue</option>
            <option value="cancelado">Cancelado</option>
        </select>
    </div>

    <div class="form-actions">
        <button type="button" class="btn magic-btn" id="updateButton">✨ Atualizar Pedido</button>
        <button type="button" class="btn cancel-btn" id="cancelButton">❌ Cancelar</button>
    </div>
</form>
