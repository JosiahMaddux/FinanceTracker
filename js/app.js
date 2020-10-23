/* CLASSES */
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
        document.getElementById(rowID).remove();
    }

    resetTable() {
        this.table.innerHTML = '';
    }
}

/* VARIABLES */
let budgetLinksList = document.getElementById("budget-links");
let budgetCard = document.getElementById("main-card");
let background = document.getElementById("background");
let tableDiv = document.getElementById("table-wrapper");
let navBar = document.getElementById("card-nav");
let actionArea = document.getElementById("action-area");

// Buttons
let addCategoryButton = document.getElementById("add-category");
let editCategoryButton = document.getElementById("edit-category");
let deleteCategoryButton = document.getElementById("delete-category");
let cancelAddCategoryButton = document.getElementById("category-add-cancel");
let cancelUpdateCategoryButton = document.getElementById("category-update-cancel");

let addTransactionButton = document.getElementById("add-transaction");
let editTransactionButton = document.getElementById("edit-transaction");
let deleteTransactionButton = document.getElementById("delete-transaction");
let cancelAddTransactionButton = document.getElementById("transaction-add-cancel");
let cancelUpdateTransactionButton = document.getElementById("transaction-update-cancel");

// Forms
let addCategoryForm = document.getElementById("add-category-form");
let addTransactionForm = document.getElementById("add-transaction-form");
let updateCategoryForm = document.getElementById("update-category-form");
let updateTransactionForm = document.getElementById("update-transaction-form");

// Other stuff
let table = new Table("budget-table");
let budgetCategories = new Map();


// Place Markers
let currentBudget = null; // this will be an ID
let selectedRow = null; // this will be a DOM Element

/* FUNCTIONS */

// DB interaction functions
function selectFromBudgets() {
    return fetch("api/budgets/select.php").then(response => response.json());
}

function selectFromCategories() {
    return fetch("api/categories/select.php", {
        method: "POST",
        headers: {"Content-type": "application/x-www-form-urlencoded"},
        body: `budget-id=${currentBudget}`
    }).then(response => response.json());
}

function selectFromTransaction() {
    return fetch("api/spending/select.php", {
        method: "POST",
        headers: {"Content-type": "application/x-www-form-urlencoded"},
        body: `budget-id=${currentBudget}`
    }).then(response => response.json());
}

function insertIntoCategoriesTable(category, amount) {
    return fetch("api/categories/insert.php", {
        method: "POST",
        headers: {"Content-type": "application/x-www-form-urlencoded"},
        body: `budget-id=${currentBudget}&category=${category}&ammount=${amount}`
    });
}

function insertIntoTransactionsTable(description, category, amount, transactionDate) {
    return fetch("api/spending/insert.php", {
        method: "POST",
        headers: {"Content-type": "application/x-www-form-urlencoded"},
        body: `budget-id=${currentBudget}&description=${description}&category=${category}&ammount=${amount}&transaction-date=${transactionDate}`
    });
}

function updateCategoriesTable(ID, category, amount) {
    return fetch("api/categories/update.php", {
        method: "POST",
        headers: {"Content-type": "application/x-www-form-urlencoded"},
        body: `budget-id=${currentBudget}&id=${ID}&category=${category}&ammount=${amount}`
    });
}

function updateTransactionsTable(ID, description, category, amount, transactionDate) {
    return fetch("api/spending/update.php", {
        method: "POST",
        headers: {"Content-type": "application/x-www-form-urlencoded"},
        body: `budget-id=${currentBudget}&id=${ID}&description=${description}&category=${category}&ammount=${amount}&date=${transactionDate}`
    });
}

function deleteFromCategoriesTable(categoryID) {
    return fetch("api/categories/delete.php", {
        method: "POST", 
        headers: {"Content-type": "application/x-www-form-urlencoded"}, 
        body: `id=${categoryID}&budget-id=${currentBudget}`
    });
}

function deleteFromTransactionsTable(TransactionID) {
    return fetch("api/spending/delete.php", {
        method: "POST",
        headers: {"Content-type": "application/x-www-form-urlencoded"},
        body: `id=${TransactionID}&budget-id=${currentBudget}`
    });
}

function selectTotalSpendingQuery() {
    return fetch("api/queries/totalspending.php", {
        method: "POST",
        headers: {"Content-type": "application/x-www-form-urlencoded"},
        body: `budget-id=${currentBudget}`
    }).then(response => response.json());
}



// UI Ineraction Functions
function makeBudgetLinks() {
    selectFromBudgets().then(rows => {
        rows.forEach(budget => {budgetLinksList.innerHTML += `<a href="" id="budget-${budget.ID}">${budget.BudgetName}</a>`;});
    });
}

function createNewBudget() {
    // create a new budget
}

function showBudgetCard() {
    background.style.display = "none";
    budgetCard.style.display = "initial";
}

function makeCategoriesTable() {
    selectFromCategories().then(rows => {
        table.resetTable();
        table.addHeaders(["Category", "Amount"]);
        rows.forEach( (row) => {
            table.addRow([row.Category, row.Ammount], `row-category-${row.ID}`);
            budgetCategories.set(String(row.ID), [row.Category, row.Ammount]);
        });
    });
}

function makeTransactionsTable() {
    selectFromTransaction().then(rows => {
        table.resetTable();
        table.addHeaders(["Description", "Category", "Amount", "Date"]);
        rows.forEach(row => {table.addRow([row.ItemDescription, row.Category, row.Ammount, row.TransactionDate], `row-transaction-${row.ID}`)});
    });
}

function makeTotalsTable() {
    selectTotalSpendingQuery().then(rows => {
            table.resetTable();
            table.addHeaders(["Category", "Amount Set", "Total Spent", "Remaining"]);
            rows.forEach(row => {table.addRow([row.Category, row.Ammount, row.Total_Spent, row.Difference])
        });
    });
}

function hideAllActionElements() {
    addCategoryButton.style.display = "none";
    editCategoryButton.style.display = "none";
    deleteCategoryButton.style.display = "none";
    addTransactionButton.style.display = "none";
    editTransactionButton.style.display = "none";
    deleteTransactionButton.style.display = "none";
    addCategoryForm.style.display = "none";
    addTransactionForm.style.display = "none";
    updateCategoryForm.style.display = "none";
    updateTransactionForm.style.display = "none";
}

function showUpdateCategoryForm() {
    updateCategoryForm.style.display = "block";
    let category = selectedRow.children[0].innerHTML;
    let amount = selectedRow.children[1].innerHTML;
    document.getElementById("category-update-category").value = category;
    document.getElementById("category-update-amount").value = amount;
}

function showUpdateTransactionForm() {
    updateTransactionForm.style.display = "block";
    let description = selectedRow.children[0].innerHTML;
    let category = selectedRow.children[1].innerHTML;
    let amount = selectedRow.children[2].innerHTML;
    let transactionDate = selectedRow.children[3].innerHTML;
    document.getElementById("transaction-update-description").value = description;
    document.getElementById("transaction-update-category").value = category;
    document.getElementById("transaction-update-amount").value = amount;
    document.getElementById("transaction-update-date").value = transactionDate;
}

function changeSelectedRow (rowID) {
    if(!(selectedRow === null)) {
        selectedRow.style.backgroundColor = "initial";
        selectedRow.style.color = "initial"
    }
    selectedRow = document.getElementById(rowID);
    selectedRow.style.backgroundColor = "#66999B";
    selectedRow.style.color = "#fff"
}

function unSelectRow () {
    if(!(selectedRow === null)) {
        selectedRow.style.backgroundColor = "initial";
        selectedRow.style.color = "initial"
    }
    selectedRow = null;
}


/* EVENT LISTENERS */

budgetLinksList.addEventListener("click", (click) => {
    click.preventDefault();
    if(click.target.id.startsWith("budget")) {
        showBudgetCard();
        currentBudget = click.target.id.substring(7);
        makeCategoriesTable();
        hideAllActionElements();
        addCategoryButton.style.display = "initial";
        budgetCategories.clear();
    }
});

tableDiv.addEventListener("click", (event) => {
    if(event.target.parentElement.id.substring(0, 12) === "row-category") {
        changeSelectedRow(event.target.parentElement.id)
        hideAllActionElements();
        addCategoryButton.style.display = "initial";
        editCategoryButton.style.display = "initial";
        deleteCategoryButton.style.display = "initial";        
    } else if (event.target.parentElement.id.substring(0, 15) === "row-transaction") {
        changeSelectedRow(event.target.parentElement.id)
        hideAllActionElements();
        addTransactionButton.style.display = "initial";
        editTransactionButton.style.display = "initial";
        deleteTransactionButton.style.display = "initial";  
    }
});

actionArea.addEventListener("click", (click) => {
    switch(click.target.id) {
        case "add-category":
            unSelectRow();
            hideAllActionElements();
            addCategoryForm.style.display = "block";
        break;

        case "category-add-cancel": 
            hideAllActionElements();
            addCategoryButton.style.display = "initial";
        break;

        case "edit-category":
            hideAllActionElements();
            showUpdateCategoryForm();
        break;

        case "category-update-cancel": 
            unSelectRow();
            hideAllActionElements();
            addCategoryButton.style.display = "initial";
        break;

        case "delete-category":
            deleteFromCategoriesTable(selectedRow.id.substring(13))
                .then(table.deleteRow(selectedRow.id));
            hideAllActionElements();
            budgetCategories.delete(selectedRow.id.substring(13));
            addCategoryButton.style.display = "initial";
            selectedRow = null;
        break;

        case "add-transaction":
            hideAllActionElements();
            document.getElementById("transaction-add-category").innerHTML = '';
            budgetCategories.forEach((row) => {
                document.getElementById("transaction-add-category").innerHTML += `<option value="${row[0]}">${row[0]}</option>`
            });
            addTransactionForm.style.display = "block";
        break;

        case "transaction-add-cancel": 
            hideAllActionElements();
            addTransactionButton.style.display = "initial";
        break;

        case "edit-transaction":
            hideAllActionElements();
            document.getElementById("transaction-update-category").innerHTML = '';
            budgetCategories.forEach((row) => {
                document.getElementById("transaction-update-category").innerHTML += `<option value="${row[0]}">${row[0]}</option>`
            });
            showUpdateTransactionForm();
        break;

        case "transaction-update-cancel": 
            unSelectRow();
            hideAllActionElements();
            addTransactionButton.style.display = "initial";
        break;

        case "delete-transaction":
            deleteFromTransactionsTable(selectedRow.id.substring(16))
                .then(table.deleteRow(selectedRow.id));
            hideAllActionElements();
            addTransactionButton.style.display = "initial";
            selectedRow = null;
        break;
    }
});

addCategoryForm.addEventListener("submit", (event) => {
    event.preventDefault();
    let category = document.getElementById("category-add-category").value;
    let amount = document.getElementById("category-add-amount").value;
    insertIntoCategoriesTable(category, amount)
        .then(response => response.json())
        .then( (id) => {
            table.addRow([category, amount], `row-category-${id}`);
            budgetCategories.set(String(id), [category, amount]);
            console.log(id, category, amount);
        });
    document.getElementById("category-add-category").value = '';
    document.getElementById("category-add-amount").value = '';
});

updateCategoryForm.addEventListener("submit", (event) => {
    event.preventDefault();
    let ID = selectedRow.id.substring(13);
    let category = document.getElementById("category-update-category").value;
    let amount = document.getElementById("category-update-amount").value;
    updateCategoriesTable(ID, category, amount)
        .then(table.updateRow(selectedRow.id, [category, amount]));
    budgetCategories.set(String(ID), [category, amount]);
    unSelectRow();
    hideAllActionElements();
    addCategoryButton.style.display = "block";
});

addTransactionForm.addEventListener("submit", (event) => {
    event.preventDefault();
    let description = document.getElementById("transaction-add-description").value;
    let category = document.getElementById("transaction-add-category").value;
    let amount = document.getElementById("transaction-add-amount").value;
    let transactionDate = document.getElementById("transaction-add-date").value;
    insertIntoTransactionsTable(description, category, amount, transactionDate)
        .then(response => response.json())
        .then(id => table.addRow([description, category, amount, transactionDate], `row-category-${id}`));
    document.getElementById("transaction-add-description").value = '';
    document.getElementById("transaction-add-category").value = '';
    document.getElementById("transaction-add-amount").value = '';
    document.getElementById("transaction-add-date").value = '';
});

updateTransactionForm.addEventListener("submit", (event) => {
    event.preventDefault();
    let ID = selectedRow.id.substring(16);
    let description = document.getElementById("transaction-update-description").value;
    let category = document.getElementById("transaction-update-category").value;
    let amount = document.getElementById("transaction-update-amount").value;
    let transactionDate = document.getElementById("transaction-update-date").value;
    updateTransactionsTable(ID, description, category, amount, transactionDate)
        .then(table.updateRow(selectedRow.id, [description, category, amount, transactionDate]));
    unSelectRow();
    hideAllActionElements();
    addTransactionButton.style.display = "block";
});

navBar.addEventListener("click", (click) => {
    click.preventDefault();
    switch(click.target.id) {
        case "totals-tab":
            makeTotalsTable();
            hideAllActionElements();
        break;

        case "transactions-tab":
            makeTransactionsTable();
            hideAllActionElements();
            addTransactionButton.style.display = "initial";
        break;

        case "categories-tab":
            makeCategoriesTable();
            hideAllActionElements();
            addCategoryButton.style.display = "initial";
        break;
    }
});