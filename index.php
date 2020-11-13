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

<nav id="card-nav">
    <div style="width: 15%">
        <img src="images/SMART-BUDGETS.png" style="padding: 0px 15px 5px 15px; height: 30px; position: relative; top: -5px;" alt="">
    </div>
    <div id="budget-nav" style="width: 85%; display: none; justify-content: space-between;">
        <div>
            <a href="" id="categories-tab">Categories</a>
            <a href="" id="transactions-tab">Transactions</a>
            <a href="" id="totals-tab">Totals</a>
            <div class="dropdown">
                <a href="">Options</a>
                <div class="dropdown-content">
                    <a href="" id="rename-tab">Rename Budget</a>
                    <a href="" id="delete-tab">Delete Budget</a>
                </div>
            </div>
        </div>
        <div>
            <!-- <a href="" id="rename-tab">Rename Budget</a> -->
            <!-- <a href="" id="delete-tab">Delete Budget</a> -->
            <!-- <a href="">Logout</a> -->
        </div>
    </div>
</nav>


    <div id="side">
        <div id="budgets-menu">
            <p>Welcome <?php echo $_SESSION["username"];  ?> <a href="pages/logout.php" id="sign-out-button">(Sign Out)</a></p>
            <br>
            <p>Pick a Budget:</p>
            <a href="" id="new-budget-button" style="background-color: #2b5ba1; border-radius: 10px; padding: 5px; margin: 15px 0; color: #fff; display: inline-block;">Create new budget</a>
            <div id="budget-links"></div>
        </div>
    </div>


    <div id="main-display">
        <div id="main-card">
            
            <div id="table-wrapper">
                <!-- <h1 id="title-header"></h1> -->
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
                            <input id="category-add-amount" type="number" step=".01" placeholder="$0.00">
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
                            <input id="category-update-amount" type="number" step=".01" placeholder="$0.00">
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
                            <input id="transaction-add-amount" type="number" step=".01" placeholder="$0.00">
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
                            <input id="transaction-update-amount" type="number" step=".01" placeholder="$0.00">
                        </div>
                        <div>
                            <label>Date:</label><br>
                            <input id="transaction-update-date" type="date">
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

    <div class="modal" id="new-budget-modal">
        <div class="modal-content">
            <form id="new-budget-form" autocomplete="off">
                <label for="">Name</label><br>
                <input type="text" placeholder="Budget Name" id="budget-name-input">
                <button id="new-budget-create">Create</button>
                <button id="new-budget-cancel" type="button">Cancel</button>
            </form>
        </div>
    </div>

    <div class="modal" id="rename-budget-modal">
        <div class="modal-content">
            <form id="rename-budget-form" autocomplete="off">
                <label for="">Rename Budget</label><br>
                <input type="text" placeholder="Budget Name" id="budget-rename-input">
                <button id="rename-budget-submit">Submit</button>
                <button id="rename-budget-cancel" type="button">Cancel</button>
            </form>
        </div>
    </div>

    <div class="modal" id="delete-budget-modal">
        <div class="modal-content">
            <p>Are you SURE you want to delete this budget with all of it's categories and transactions?</p>
            <button id="new-budget-create">Yes</button>
            <button id="new-budget-cancel" type="button">No</button>
        </div>
    </div>

    <script src="js/app.js"></script>
    <script>makeBudgetLinks();</script>
</body>
</html>
