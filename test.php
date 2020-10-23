<?php include_once "includes/login-check.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance Manager</title>
    <link rel="stylesheet" href="test.css">
    <link rel="icon" href="images/favicon.jpg">
</head>
<body>

    <div id="side">
        <div id="budgets-menu">
            <h3>Welcome <?php echo $_SESSION["username"]; ?></h3>
            <br>
            <h2>Pick a Budget:</h2>
            <a href="">Create new budget</a>
            <div id="budget-links"></div>
        </div>
    </div>


    <div id="main-display">
        <div id="main-card">
            <nav id="card-nav">
                <a href="" id="categories-tab">Categories</a>
                <a href="" id="transactions-tab">Transactions</a>
                <a href="" id="totals-tab">Totals</a>
            </nav>
            <div id="table-wrapper">
                <table id="budget-table">

                </table>
            </div>
            <div id="action-area">
                <div class="action-buttons-wrapper">
                    <button id="add-category" class="add-button" style="display: none;">+ New Category</button>
                    <button id="edit-category" class="add-button" style="display: none;">Edit Category</button>
                    <button id="delete-category" class="add-button" style="display: none;">Delete Category</button>
                </div>
                <form id="add-category-form" class="budget-forms" style="display: none;" autocomplete="off">
                    <div id="input-wrapper">
                        <div>
                            <label>Category:</label><br>
                            <input id="category-add-category" type="text" placeholder="Category Name">
                        </div>
                        <div>
                            <label>Amount:</label><br>
                            <input id="category-add-amount" type="text" placeholder="$0.00">
                        </div>
                    </div>
                    <button id="save-category">Add Category</button>
                    <button id="category-add-cancel" type="button">Cancel</button>
                </form>
                <form id="update-category-form" class="budget-forms" style="display: none;"  autocomplete="off">
                    <div id="input-wrapper">
                        <div>
                            <label>Category:</label><br>
                            <input id="category-update-category" type="text">
                        </div>
                        <div>
                            <label>Amount:</label><br>
                            <input id="category-update-amount" type="text">
                        </div>
                    </div>
                    <button>Update Category</button>
                    <button id="category-update-cancel" type="button">Cancel</button>
                </form>
                <div class="action-buttons-wrapper">
                    <button id="add-transaction" class="add-button" style="display: none;">+ New Transaction</button>
                    <button id="edit-transaction" class="add-button" style="display: none;">Edit Transaction</button>
                    <button id="delete-transaction" class="add-button" style="display: none;">Delete Transaction</button>
                </div>
                <form id="add-transaction-form" class="budget-forms" style="display: none;"  autocomplete="off">
                    <div id="input-wrapper">
                        <div>
                            <label>Description:</label><br>
                            <input id="transaction-add-description" type="text" placeholder="Description">
                        </div>
                        <div>
                            <label>Category:</label><br>
                            <select id="transaction-add-category">

                            </select>
                        </div>
                        <div>
                            <label>Amount:</label><br>
                            <input id="transaction-add-amount" type="number" placeholder="$0.00">
                        </div>
                        <div>
                            <label>Date:</label><br>
                            <input id="transaction-add-date" type="date">
                        </div>
                    </div>
                    <button>Add Transaction</button>
                    <button id="transaction-add-cancel" type="button">Cancel</button>
                </form>
                <form id="update-transaction-form" class="budget-forms" style="display: none;"  autocomplete="off">
                    <div id="input-wrapper">
                        <div>
                            <label>Description:</label><br>
                            <input id="transaction-update-description" type="text" placeholder="Description">
                        </div>
                        <div>
                            <label>Category:</label><br>
                            <select id="transaction-update-category">

                            </select>
                        </div>
                        <div>
                            <label>Amount:</label><br>
                            <input id="transaction-update-amount" type="text" placeholder="$0.00">
                        </div>
                        <div>
                            <label>Date:</label><br>
                            <input id="transaction-update-date" type="text" placeholder="MM-DD-YYYY">
                        </div>
                    </div>
                    <button id="update-transaction">Update Transaction</button>
                    <button id="transaction-update-cancel" type="button">Cancel</button>
                </form>
            </div>
        </div>


        <div id="background">
            <h1>Welcome to the SmartMoney App</h1>
            <p>We make personal finanial management easy-peasy-bacon-cheesy</p>
            <p>Just follow the steps below to start saving more money at the end of each paycheck</p>
            <img src="images/banner.jpg" alt="">
        </div>

    </div>
    <script src="js/app.js"></script>
    <script>makeBudgetLinks();</script>
</body>
</html>