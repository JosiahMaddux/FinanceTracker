<?php
    header("Content-Type: application/json; charset=UTF-8");
    include_once "../config/login-check.php";
    include_once "../config/DB.php";
    

    // Init db connection
    $conn = new dataBaseConnection;
    $mysqli = $conn->getMysqli();

    if(!empty($_SESSION["ID"])) {
        
        // Get parameter
        $userID = $_SESSION["ID"];

        // Prepare and execute SQL SELECT statement
        $stmt = $mysqli->stmt_init();
        $stmt->prepare("SELECT ID, BudgetName FROM Budgets WHERE UserID = ?");
        $stmt->bind_param("s", $userID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Send the results as an array of JSON objects
        http_response_code(200);
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        json_encode(array("message" => "Unauthorized Request"));
        
    } else {

        // Send error message
        http_response_code(401);
        echo json_encode(array("message" => "Unauthorized Request"));
    }
    // What id they have no budgets?
?>
