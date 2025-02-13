<link rel="stylesheet" href="/Front/Components/tableStyle.css">
<div id="divContentCustomerTable" class="table" class = "table-container">
    <h4>Lista de Clientes</h4>
    <script type="module">
        import { CustomerTableList } from "/Front/Clientes/CustomerTableList.js";
        const customerTable = new CustomerTableList("divContentCustomerTable", "tableCustomer");
        customerTable.mountTable();
    </script>
</div>