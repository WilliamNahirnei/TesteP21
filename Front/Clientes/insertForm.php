<link rel="stylesheet" href="/Front/Clientes/customerForm.css">
<form id="createCustomer" class="styled-form">
  <h2>🪄 Adicionar cliente</h2>

  <div class="form-group">
    <label for="inputNameCreate">Nome</label>
    <input id="inputNameCreate" type="text" placeholder="Digite o nome">
  </div>

  <div class="form-group">
    <label for="inputEmailCreate">Email</label>
    <input id="inputEmailCreate" type="email" placeholder="Digite o email">
  </div>
  <div class="form-group">
    <label for="inputLocationCreate">Localização</label>
    <input id="inputLocationCreate" type="text" placeholder="Digite a localização">
  </div>

  <div class="form-actions">
    <button type="button" class="btn magic-btn" id="updateButton"">✨ Adicionar</button>
  </div>
</form>
<script type="module">
    import { insertCustomer } from "/Front/Clientes/CustomerCreate.js";

    document.getElementById("updateButton").addEventListener('click', insertCustomer);
</script>

