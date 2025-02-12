export class GenericTable {
    constructor(idElementToInsert, idTable, tableConfiguration) {
        this.idElementToInsert = idElementToInsert;
        this.idTable = idTable;
        this.tableConfiguration = tableConfiguration;
        this.response = this.getDataList();
    }

    getDataList() {
        return [];
    }

    mountTable() {
        document.getElementById(this.idElementToInsert).innerHTML = "";
        this.response = this.getDataList();
        this.generateGenericTable(this.idElementToInsert, this.idTable, this.response, this.tableConfiguration);
    }

    remountTableAfterAction() {
        this.removeTableFromScreen();
        this.mountTable();
    }

    removeTableFromScreen() {
        const tableElement = document.getElementById(this.idTable);
        if (tableElement) tableElement.remove();
    }

    generateGenericTable(idElementInsertion, tableId, registerList = [], tableConfiguration) {
        const table = document.createElement("table");
        const elementInsertion = document.getElementById(idElementInsertion);
        table.id = tableId;
        table.cellspacing = 1;
        table.cellpadding = 1;
        table.width = "100%";
        table.bgcolor = "white";
        table.classList.add("styled-table"); // Adicionando classe para aplicar estilo

        this.generateTableHeaders(table, tableConfiguration);
        this.generateElementsTable(table, registerList, tableConfiguration);
        elementInsertion.appendChild(table);
    }

    generateTableHeaders(table, tableConfiguration) {
        const theadHeader = document.createElement("thead");
        const lineHeader = document.createElement("tr");

        // Adiciona as colunas de dados
        tableConfiguration.columnList.forEach(column => {
            const columnHeader = document.createElement("th");
            columnHeader.appendChild(document.createTextNode(column.title ?? ""));
            lineHeader.appendChild(columnHeader);
        });

        // Adiciona a coluna de "Ações"
        const actionHeader = document.createElement("th");
        actionHeader.appendChild(document.createTextNode("Ações"));
        lineHeader.appendChild(actionHeader);

        theadHeader.appendChild(lineHeader);
        table.appendChild(theadHeader);
    }

    generateElementsTable(table, registerList, tableConfiguration) {
        const tableBody = document.createElement('tbody');
        tableBody.id = table.id + "bodyContent";

        registerList.forEach(register => {
            const registerLine = document.createElement("tr");
            registerLine.id = `listLine${tableConfiguration.functionGetId(register)}`;

            // Adiciona as colunas de dados
            tableConfiguration.columnList.forEach(column => {
                const columnContent = document.createElement("td");
                columnContent.align = "center";
                columnContent.appendChild(column.functionMountColmn(register));
                registerLine.appendChild(columnContent);
            });

            // Adiciona a coluna de "Ações"
            this.generateActionButtons(registerLine, register, tableConfiguration);
            tableBody.appendChild(registerLine);
        });

        table.appendChild(tableBody);
    }

    generateActionButtons(registerLine, register, tableConfiguration) {
        const actionCell = document.createElement("td");
        actionCell.align = "center";

        // Botão de Atualizar
        if (tableConfiguration.updateButtonActionClick) {
            this.generateUpdateTableColumnButton(actionCell, register, tableConfiguration);
        }

        // Botão de Deletar
        if (tableConfiguration.deleteButtonActionClick) {
            this.generateDeleteTableColumnButton(actionCell, register, tableConfiguration);
        }

        registerLine.appendChild(actionCell);
    }

    generateUpdateTableColumnButton(actionCell, register, tableConfiguration) {
        const updateButton = document.createElement("button");
        updateButton.textContent = "Atualizar";
        updateButton.classList.add("btn", "info");
        updateButton.addEventListener("click", () => {
            tableConfiguration.updateButtonActionClick(register);
        });

        actionCell.appendChild(updateButton);
    }

    generateDeleteTableColumnButton(actionCell, register, tableConfiguration) {
        const deleteButton = document.createElement("button");
        deleteButton.textContent = "Deletar";
        deleteButton.classList.add("btn", "danger");
        deleteButton.addEventListener("click", () => {
            tableConfiguration.deleteButtonActionClick(register);
            this.remountTableAfterAction();
        });

        actionCell.appendChild(deleteButton);
    }
}