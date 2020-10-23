class Table {
    constructor(tableID) {
        this.table = document.getElementById(tableID);
    }

    // takes an array of ths as strings
    addHeaders(headers) {
        let headerRow = '<tr>';
        headers.forEach(header => {headerRow += `<th>${header}</th>`});
        headerRow += '</tr>'
        this.table.innerHTML += headerRow;
    }

    // takes an array of tds as strings, and an optional ID for the row
    addRow(rowData, rowID = "row") {
        let newRow = `<tr id="${rowID}">`;
        rowData.forEach(td => {newRow += `<td>${td}</td>`});
        newRow += '</tr>';
        this.table.innerHTML += newRow;
    }

    // takes a row ID, and a data array, then updates that row with that array
    updateRow(rowID, rowData) {
        let row = document.getElementById(rowID);
        let updatedRow = '';
        rowData.forEach(td => {updatedRow += `<td>${td}</td>`});
        row.innerHTML = updatedRow;
    }

    // takes an ID of a row, then deletes that row
    deleteRow(rowID) {
        document.getElementById(rowID).remove;
    }

    resetTable() {
        this.table.innerHTML = '';
    }
}