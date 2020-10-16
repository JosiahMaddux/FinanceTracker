class Budget {
    constructor(budgetName, budgetID) {
        this.budgetName = budgetName;
        this.budgetID = budgetID;
        
        this.categories = new Array;
        this.transactions = new Array;
        this.totals = new Array;
        self = this;
    }

    addCategory(category, amount) {
        // Add category to DB
        let xmlhttp = new XMLHttpRequest();

        // Once added to DB, push to array
        xmlhttp.onload = function () {self.categories.push({ID:this.responseText, Category:category, Ammount:amount})}
        
        // Send request to API
        xmlhttp.open("POST", "api/categories/insert.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(`budget-id=${self.budgetID}&category=${category}&ammount=${amount}`);
    }

    addTransaction(description, category, amount, transactionDate) {
        // Add transaction to DB
        let xmlhttp = new XMLHttpRequest();

        // Once added to DB, push to array
        xmlhttp.onload = function () {self.transactions.push({ID:this.responseText, ItemDescription:description, Category:category, Ammount:amount, TransactionDate:transactionDate})}
        
        // Send request to API
        xmlhttp.open("POST", "api/spending/insert.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(`budget-id=${self.budgetID}&description=${description}&category=${category}&ammount=${amount}&transaction-date=${transactionDate}`);
    }

    updateCategory(arrayIndex, category, amount) {
        // prepare request for DB API
        let xmlhttp = new XMLHttpRequest();

        // Send to DB API
        xmlhttp.open("POST", "api/categories/update.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(`budget-id=${self.budgetID}&id=${self.categories[arrayIndex].ID}&category=${category}&ammount=${amount}`);

        // Update array
        self.categories[arrayIndex].Category = category;
        self.categories[arrayIndex].Ammount = amount;
    }

    updateTransaction(arrayIndex, description, category, amount, transactionDate) {
        // Add transaction to DB
        let xmlhttp = new XMLHttpRequest();
        
        // Send request to API
        xmlhttp.open("POST", "api/spending/update.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(`budget-id=${self.budgetID}&id=${self.transactions[arrayIndex].ID}&description=${description}&category=${category}&ammount=${amount}&transaction-date=${transactionDate}`);

        // Update array
        self.transactions[arrayIndex].ItemDescription = description;
        self.transactions[arrayIndex].Category = category;
        self.transactions[arrayIndex].Ammount = amount;
        self.transactions[arrayIndex].TransactionDate = transactionDate;
    }

    deleteCategory(arrayIndex) {

    }

    deleteTransaction(arrayIndex) {
        
    }

}

