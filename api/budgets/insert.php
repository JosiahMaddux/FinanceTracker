<?php
    header("Content-Type: application/json; charset=UTF-8");
    include_once "../config/login-check.php";
    include_once "../config/DB.php";
    

    // Init db connection
    $conn = new dataBaseConnection;
    $mysqli = $conn->getMysqli();

    // Get parameter
    $userID = $_SESSION["ID"];
    $budgetName = $_POST["budget-name"];

    
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("INSERT INTO Budgets (UserID, BudgetName) VALUES (?, ?);");
    $stmt->bind_param("is", $userID, $budgetName);
    $stmt->execute();

    http_response_code(200);
    echo $mysqli->insert_id;
?>