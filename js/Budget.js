class Budget {
    constructor(budgetID) {
        this.budgetID = budgetID;
        
        this.categories = new Map();
        this.transactions = new Map();
    }

    setCategory(id, category, amount) {
        this.categories.set(id, [category, amount])
    }

    setTransaction(id, description, category, amount, transactionDate) {
        this.categories.set(id, [description, category, amount, transactionDate])
    }

    getCategory(id) {
        return this.categories.get(id)
    }

    getTransaction(id) {
        return this.transactions.get(id)
    }

    deleteCategory(id) {
        this.categories.delete(id);
    }

    deleteTransaction(id) {
        this.transactions.delete(id);
    }
}
