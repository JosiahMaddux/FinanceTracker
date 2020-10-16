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



<!-- Make it so when you pick a budget from the left side menu,
a card apears with a header, some links to different views, and a table -->