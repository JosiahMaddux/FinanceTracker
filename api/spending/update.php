<?php
    header("Content-Type: application/json; charset=UTF-8");
    include_once "../config/login-check.php";
    include_once "../config/DB.php";
    

    // Init db connection
    $conn = new dataBaseConnection;
    $mysqli = $conn->getMysqli();

    // Get parameter
    $userID = $_SESSION["ID"];
    $id = $_POST["id"];
    $budgetID = $_POST["budget-id"];
    $itemDescription = $_POST["description"];
    $category = $_POST["category"];
    $ammount = $_POST["ammount"];
    $transactionDate = $_POST["date"];

    // Prepare and execute SQL SELECT statement
    // Check to see if table belongs to user
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("SELECT UserID FROM Budgets WHERE ID = ?;");
    $stmt->bind_param("i", $budgetID);
    $stmt->execute();
    $stmt->bind_result($result_userID);
    $stmt->fetch();
    if($result_userID == $userID) {
        $stmt->prepare("UPDATE SpendingTransactions SET ItemDescription = ?, Category = ?, Ammount = ?, TransactionDate = ? WHERE ID = ?;");
        $stmt->bind_param("ssdsi", $itemDescription, $category, $ammount, $transactionDate, $id);
        $stmt->execute();
    }
?>