<?php
    header("Content-Type: application/json; charset=UTF-8");
    include_once "../config/login-check.php";
    include_once "../config/DB.php";
    

    // Init db connection
    $conn = new dataBaseConnection;
    $mysqli = $conn->getMysqli();

    // Get parameter
    $userID = $_SESSION["ID"];
    $budgetID = $_POST["budget-id"];
    $category = $_POST["category"];
    $ammount = $_POST["ammount"];

    // Prepare and execute SQL SELECT statement
    // Check to see if table belongs to user
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("SELECT UserID FROM Budgets WHERE ID = ?;");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($result_userID);
    $stmt->fetch();
    if($result_userID == $userID) {
        $stmt->prepare("INSERT INTO BudgetCategories (BudgetID, Category, Ammount) VALUES (?, ?, ?);");
        $stmt->bind_param("isd", $budgetID, $category, $ammount);
        $stmt->execute();
    }
?>