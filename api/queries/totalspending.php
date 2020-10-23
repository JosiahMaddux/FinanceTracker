<?php
    header("Content-Type: application/json; charset=UTF-8");
    include_once "../config/login-check.php";
    include_once "../config/DB.php";
    

    // Init db connection
    $conn = new dataBaseConnection;
    $mysqli = $conn->getMysqli();

    // Get parameters
    $userID = $_SESSION["ID"];
    $budgetID = $_POST["budget-id"];

    // Check to see if table belongs to user
    $stmt = $mysqli->stmt_init();
    $stmt->prepare("SELECT UserID FROM Budgets WHERE ID = ?;");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $stmt->bind_result($result_userID);
    $stmt->fetch();
    if($result_userID == $userID) {
        $query = 'SELECT
						Category,
						Ammount,
						Total_Spent,
						Ammount - Total_Spent AS Difference
					FROM (
					SELECT
						PersonalBudgetCategories.Category,
						PersonalBudgetCategories.Ammount,
						IFNULL(SUM(SpendingTransactions.Ammount), 0) AS Total_Spent
					FROM (
						SELECT
							Category,
							Ammount
						FROM
							BudgetCategories
						WHERE
						BudgetID = ?
					) AS PersonalBudgetCategories LEFT JOIN SpendingTransactions ON PersonalBudgetCategories.Category = SpendingTransactions.Category AND BudgetID = ? 
					GROUP BY
						PersonalBudgetCategories.Category,
						PersonalBudgetCategories.Ammount
					) AS TotalsBudget;';
        $stmt->prepare($query);
        $stmt->bind_param("ii", $budgetID, $budgetID);
        $stmt->execute();
        $result = $stmt->get_result();

        // Send the results as an array of JSON objects
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
    }

?>