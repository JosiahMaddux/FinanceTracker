// DOM Variables
let budgetLinksList = document.getElementById("budget-links");
let budgetCard = document.getElementById("main-card");
let background = document.getElementById("background");
let tableDiv = document.getElementById("table-wrapper");
let navBar = document.getElementById("card-nav");

// Place Markers
let currentBudget = null;
let selectedCategory = null;
let selectedTransaction = null;


// Functions
function makeBudgetLinks() {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function() {
        let response = JSON.parse(this.responseText);
        response.forEach(row => {
            budgetLinksList.innerHTML += `
                <a href="" id="budget-${row.ID}">${row.BudgetName}</a>
            `;
        });
    };
    xmlhttp.open("GET", "api/budgets/select.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send();
}


function createNewBudget() {
    // create a new budget
}


function showBudgetCard() {
    background.style.display = "none";
    budgetCard.style.display = "initial";
}


function makeCategoriesTable(budgetID) {

    // Mark current budget
    currentBudget = budgetID;

    // Create table element
    table = document.createElement("table");
    table.innerHTML = `
            <table>
                <tr><th>Category</th><th>Amount</th></tr>
            `;

    // Make request
    let xmlhttp = new XMLHttpRequest();

    // When request is ready
    xmlhttp.onload = function() {
        let response = JSON.parse(this.responseText);
        response.forEach(row => {
            table.innerHTML += `
                <tr id="category-${row.ID}">
                    <td>${row.Category}</td>
                    <td>${row.Ammount}</td>
                    <td class="table-images"><img id="edit" src="images/edit.png"><img id="delete" src="images/delete.png"></td>
                </tr>
            `;
        });
        table.innerHTML += `
            </table>
        `;
        tableDiv.innerHTML = table.outerHTML;
        let addCategoryButton = document.createElement("button");
        addCategoryButton.innerHTML = '+ New Category';
        addCategoryButton.id = "add-category";
        addCategoryButton.classList.add("add-button");
        tableDiv.appendChild(addCategoryButton);
    };

    // Send request
    xmlhttp.open("POST", "api/categories/select.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`budget-id=${budgetID}`);

}


function makeTransactionsTable() {
    // Create table element
    table = document.createElement("table");
    table.innerHTML = `
            <table>
                <tr><th>Description</th><th>Category</th><th>Amount</th><th>Date</th></tr>
            `;

    // Make a reqest object
    let xmlhttp = new XMLHttpRequest();

    // When request is ready
    xmlhttp.onload = function() {
        let response = JSON.parse(this.responseText);
        response.forEach(row => {
            table.innerHTML += `
                <tr id="transaction-${row.ID}">
                    <td>${row.ItemDescription}</td>
                    <td>${row.Category}</td>
                    <td>${row.Ammount}</td>
                    <td>${row.TransactionDate}</td>
                    <td class="table-images"><img id="edit-transaction" src="images/edit.png"><img id="delete-transaction" src="images/delete.png"></td>
                </tr>
            `;
        });
        table.innerHTML += "</table>";
        tableDiv.innerHTML = table.outerHTML;


        let addTransactionButton = document.createElement("button");
        addTransactionButton.innerHTML = '+ New Transaction';
        addTransactionButton.id = "add-transaction";
        addTransactionButton.classList.add("add-button");
        tableDiv.appendChild(addTransactionButton);
    };

    // Send request
    xmlhttp.open("POST", "api/spending/select.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`budget-id=${currentBudget}`);
}


function makeTotalsTable() {

    // Create table element
    table = document.createElement("table");
    table.innerHTML = `
            <table>
                <tr><th>Category</th><th>Amount</th><th>Total Spent</th><th>Difference</th></tr>
            `;

    // Make a reqest object
    let xmlhttp = new XMLHttpRequest();

    // When request is ready
    xmlhttp.onload = function() {
        let response = JSON.parse(this.responseText);
        response.forEach(row => {
            table.innerHTML += `
                <tr><td>${row.Category}</td><td>${row.Ammount}</td><td>${row.Total_Spent}</td><td>${row.Difference}</td></tr>
            `;
        });
        table.innerHTML += "</table>";
        tableDiv.innerHTML = table.outerHTML;
    };

    // Send request
    xmlhttp.open("POST", "api/queries/totalspending.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`budget-id=${currentBudget}`);
}


function makeInsertCategoryForm() {
    document.getElementById("add-category").remove();
    let form = document.createElement("form");
    form.id = "new-category-form";
    form.classList.add("budget-forms")
    form.innerHTML= `
        <div id="input-wrapper">
            <div>
                <label>Category:</label><br>
                <input id="category" type="text" placeholder="Category Name">
            </div>
            <div>
                <label>Amount:</label><br>
                <input id="amount" type="text" placeholder="$0.00">
            </div>
            </div>
        <button id="save-category">Add Category</button>
    `;
    tableDiv.appendChild(form);
}


function makeUpdateCategoryForm(RowID) {
    let addButton = document.getElementById("add-category");
    if(!(addButton === null)) {
        addButton.remove();
    }

    let addForm = document.getElementById("new-category-form");
    if(!(addForm === null)) {
        addForm.remove();
    }
    let updateForm = document.getElementById("update-category-form");
    if(!(updateForm === null)) {
        updateForm.remove();
    }

    let row = document.getElementById(RowID);
    
    if(!(selectedCategory === null)) {
        selectedCategory.style.backgroundColor = "initial";
        selectedCategory.style.color = "initial"
    }
    selectedCategory = row;
    selectedCategory.style.backgroundColor = "#66999B";
    selectedCategory.style.color = "#fff"

    let category = row.children[0].innerHTML;
    let amount = row.children[1].innerHTML;

    let form = document.createElement("form");
    form.id = "update-category-form";
    form.classList.add("budget-forms")
    form.innerHTML= `
        <div id="input-wrapper">
            <div>
                <label>Category:</label><br>
                <input id="category" type="text" value="${category}">
            </div>
            <div>
                <label>Amount:</label><br>
                <input id="amount" type="text" value="${amount}">
            </div>
            </div>
        <button id="update-category">Update Category</button>
    `;
    tableDiv.appendChild(form);
}


function makeInsertTransactionForm() {
    document.getElementById("add-transaction").remove();
    let form = document.createElement("form");
    form.id = "new-transaction-form";
    form.classList.add("budget-forms")
    form.innerHTML= `
        <div id="input-wrapper">
            <div>
                <label>Description:</label><br>
                <input id="description" type="text" placeholder="Description">
            </div>
            <div>
                <label>Category:</label><br>
                <input id="category" type="text" placeholder="Category">
            </div>
            <div>
                <label>Amount:</label><br>
                <input id="amount" type="text" placeholder="$0.00">
            </div>
            <div>
                <label>Date:</label><br>
                <input id="date" type="text" placeholder="MM-DD-YYYY">
            </div>
        </div>
        <button id="save-transaction">Add Transaction</button>
    `;
    tableDiv.appendChild(form);
}


function makeUpdateTransactionForm(RowID) {

    let addButton = document.getElementById("add-transaction");
    if(!(addButton === null)) {
        addButton.remove();
    }

    let addForm = document.getElementById("new-transaction-form");
    if(!(addForm === null)) {
        addForm.remove();
    }
    let updateForm = document.getElementById("update-transaction-form");
    if(!(updateForm === null)) {
        updateForm.remove();
    }

    let row = document.getElementById(RowID);
    
    if(!(selectedTransaction === null)) {
        selectedTransaction.style.backgroundColor = "initial";
        selectedTransaction.style.color = "initial"
    }
    selectedTransaction = row;
    selectedTransaction.style.backgroundColor = "#66999B";
    selectedTransaction.style.color = "#fff"

    let description = row.children[0].innerHTML;
    let category = row.children[1].innerHTML;
    let amount = row.children[2].innerHTML;
    let transactionDate = row.children[3].innerHTML;
    

    let form = document.createElement("form");
    form.id = "update-transaction-form";
    form.classList.add("budget-forms")
    form.innerHTML= `
        <div id="input-wrapper">
            <div>
                <label>Description:</label><br>
                <input id="description" type="text" value="${description}">
            </div>
            <div>
                <label>Category:</label><br>
                <input id="category" type="text" value="${category}">
            </div>
            <div>
                <label>Amount:</label><br>
                <input id="amount" type="text" value="${amount}">
            </div>
            <div>
                <label>Date:</label><br>
                <input id="date" type="text" value="${transactionDate}">
            </div>
        </div>
        <button id="update-transaction">Update Transaction</button>
    `;
    tableDiv.appendChild(form);
}


function insertIntoCategoriesTable(budgetID, category, amount) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.onload = function () {
        console.log(this.responseText)
    }
    xmlhttp.open("POST", "api/categories/insert.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`budget-id=${budgetID}&category=${category}&ammount=${amount}`);
    makeCategoriesTable(currentBudget);
}


function insertIntoTransactionsTable(budgetID, description, category, amount, transactionDate) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "api/spending/insert.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`budget-id=${budgetID}&description=${description}&category=${category}&ammount=${amount}&transaction-date=${transactionDate}`);
    makeTransactionsTable();
}


function updateCategoriesTable(ID, category, amount) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "api/categories/update.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`budget-id=${currentBudget}&id=${ID}&category=${category}&ammount=${amount}`);
    makeCategoriesTable(currentBudget, makeAddCategoryButton);
}


function updateTransactionsTable(ID, description, category, amount, transactionDate) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "api/spending/update.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`budget-id=${currentBudget}&id=${ID}&description=${description}&category=${category}&ammount=${amount}&date=${transactionDate}`);
    makeTransactionsTable();
}


function deleteFromCategoriesTable(categoryID) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "api/categories/delete.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`id=${categoryID}&budget-id=${currentBudget}`);
    makeCategoriesTable(currentBudget);
}


function deleteFromTransactionsTable(TransactionID) {
    let xmlhttp = new XMLHttpRequest();
    xmlhttp.open("POST", "api/spending/delete.php", true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xmlhttp.send(`id=${TransactionID}&budget-id=${currentBudget}`);
    makeTransactionsTable();
}


// Event listeners

// Clicking on a budget link
budgetLinksList.addEventListener("click", function(event) {
    event.preventDefault();
    if(event.target.id.startsWith("budget")) {
        showBudgetCard();
        budgetID = event.target.id.substring(7);
        makeCategoriesTable(budgetID);
    }
});

// clicking on an action button
tableDiv.addEventListener("click", function(event) {
    if(event.target.id == "save-category") {
        event.preventDefault();
        let category = document.querySelector("input#category").value;
        let amount = document.querySelector("input#amount").value;
        insertIntoCategoriesTable(currentBudget, category, amount);
    } else if(event.target.id == "delete") {
        deleteFromCategoriesTable(event.target.parentElement.parentElement.id.substring(9));
    } else if(event.target.id == "edit") {
        makeUpdateCategoryForm(event.target.parentElement.parentElement.id);
    } else if (event.target.id == "update-category") {
        event.preventDefault();
        let ID = selectedCategory.id.substring(9);
        let category = document.querySelector("input#category").value;
        let amount = document.querySelector("input#amount").value;
        updateCategoriesTable(ID, category, amount);
    } else if (event.target.id == "add-category") {
        makeInsertCategoryForm();
    } else if (event.target.id == "add-transaction") {
        makeInsertTransactionForm();
    } else if(event.target.id == "save-transaction") {
        event.preventDefault();
        let description = document.querySelector("input#description").value;
        let category = document.querySelector("input#category").value;
        let amount = document.querySelector("input#amount").value;
        let transactionDate = document.querySelector("input#date").value;
        insertIntoTransactionsTable(currentBudget, description, category, amount, transactionDate)
    } else if(event.target.id == "delete-transaction") {
        deleteFromTransactionsTable(event.target.parentElement.parentElement.id.substring(12));
    } else if(event.target.id == "edit-transaction") {
        makeUpdateTransactionForm(event.target.parentElement.parentElement.id)
    } else if(event.target.id == "update-transaction") {
        event.preventDefault();
        let ID = selectedTransaction.id.substring(12);
        let description = document.querySelector("input#description").value;
        let category = document.querySelector("input#category").value;
        let amount = document.querySelector("input#amount").value;
        let transactionDate = document.querySelector("input#date").value;
        updateTransactionsTable(ID, description, category, amount, transactionDate);
    }
});

// This handles the nav bar links
navBar.addEventListener("click", function(event) {
    event.preventDefault();
    if(event.target.id == "totals-tab") {
        makeTotalsTable();
    } else if(event.target.id == "transactions-tab") {
        makeTransactionsTable();
    } else if(event.target.id == "categories-tab") {
        makeCategoriesTable(currentBudget);
    }
});