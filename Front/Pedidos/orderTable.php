<link rel="stylesheet" href="/Front/Components/tableStyle.css">
<div id="divContentOrderTable" class="table" class = "table-container">
    <h4>Lista de Pedidos</h4>
    <script type="module">
        import { OrderTableList } from "/Front/Pedidos/OrderTableList.js";
        const orderTable = new OrderTableList("divContentOrderTable", "tableOrder");
        orderTable.mountTable();
    </script>
</div><?php
