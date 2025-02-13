
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loja Mágica de Tecnologia</title>
    <link rel="stylesheet" href="/Front/style.css">
    <link rel="stylesheet" href="/Front/Pedidos/Importar/uploadFile.css">
</head>
<?php include '../../header.php'; ?>

<main>
    <section>
        <form id="uploadForm" class="styled-form">
            <h2 id="formTitle">Importar Pedidos</h2>

            <div class="form-group">
                <label for="fileInput">Selecione um arquivo (.xlsx ou .xml)</label>
                <input id="fileInput" type="file" accept=".xlsx, .xml">
            </div>

            <div class="form-actions">
                <button type="button" class="btn info" id="uploadButton">Enviar</button>
            </div>
        </form>
    </section>
</main>

<script type="module">
    import { uploadFile } from "/Front/Pedidos/Importar/UploadFile.js";

    document.getElementById("uploadButton").addEventListener('click', uploadFile);
</script>



