<?php
    include "../includes/login-check.php";
    include "../includes/db-server.php";

    function makeSpendingTransactionsTable($budgetID) {
        echo '<table><tr><th>Description</th><th>Category</th><th>Ammount</th><th>Date</th><th>Actions</th></tr>';
        $query = 'SELECT * FROM SpendingTransactions WHERE BudgetID = '.$budgetID.';';
        $result = mysqli_query($GLOBALS['link'], $query);
        if(!empty($result->num_rows)) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$row = $result->fetch_assoc();
				echo '<tr id="'.$row["ID"].'">';
				echo '<td>'.$row["ItemDescription"].'</td>'.'<td>'.$row["Category"].'</td>'.'<td>'.$row["Ammount"].'</td>'.'<td>'.$row["TransactionDate"].'</td>'.'<td><button onclick="EditRecord(\''.$row["ID"].'\', \''.$row["ItemDescription"].'\', \''.$row["Category"].'\', \'$'.$row["Ammount"].'\', \''.$row["TransactionDate"].'\')">Edit</button><button form="del-form" type="submit" name="delete-in-transactions" value="'.$row["ID"].'">Delete</button></td>';
				echo '</tr>';
			}
        }
        echo '<tr id="insertRow">
                <form action="#" method="POST" id="main-form" autocomplete="off">
                <td><input type="text" name="ItemDescription"></td>
                <td>
                    <select name="Category" id="Category">';
                        $query = 'SELECT * FROM BudgetCategories WHERE BudgetID = '.$budgetID.';';
                        $result = mysqli_query($GLOBALS['link'], $query);
                        if(!empty($result->num_rows)) {
                            for($i = 0; $i < $result->num_rows; $i++) {
                                $row = $result->fetch_assoc();
                                echo '<option value="'.$row["Category"].'" id="cat-'.$row["Category"].'">'.$row["Category"].'</option>';
                            }
                        }
        echo        '</select>
                </td>
                <td><input type="text" name="Ammount" required></td>
                <td><input type="text" name="TransactionDate"></td>
				<td><button type="submit" name="insert-into-transactions" value="'.$budgetID.'">Enter</button></td>
				</form>
			</tr>
			</table>
			<script>setBudgetID('.$budgetID.')</script>
			<form action="#" method="POST" id="del-form"><input type="hidden" name="budget-ID" value="'.$budgetID.'" form="del-form"></form>';
    }

    function insertSpendingTransaction($budgetID, $itemDescription, $category, $ammount, $transactionDate) {
        $query = 'INSERT INTO SpendingTransactions (BudgetID, ItemDescription, Category, Ammount, TransactionDate) VALUES ('.$budgetID.', "'.$itemDescription.'", "'.$category.'", '.$ammount.', "'.$transactionDate.'");';
        $result = mysqli_query($GLOBALS["link"], $query);
    }

    function updateSpendingTransaction($ID, $itemDescription, $category, $ammount, $transactionDate) {
        $query = 'UPDATE SpendingTransactions SET ItemDescription = "'.$itemDescription.'", Category = "'.$category.'", Ammount = '.$ammount.', TransactionDate = "'.$transactionDate.'" WHERE ID = '.$ID.';';
        $result = mysqli_query($GLOBALS["link"], $query);
    }

    function deleteSpendingTransaction($ID) {
        $query = 'DELETE FROM SpendingTransactions WHERE ID = '.$ID.';';
		$result = mysqli_query($GLOBALS["link"], $query);
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Spending Transactions</title>
        <link rel="stylesheet" href="../css/main.css"/>
        <link rel="stylesheet" href="../css/transactions.css"/>
        <link rel="icon" href="../images/favicon.jpg">
    </head>
    <body>
        <script src="../js/Transactions.js"></script>
        <!--The below script processes the submission of the forms on this page-->
	    <main>
            <img src="../images/main.png" id="main" alt="">
			<nav>
                <a href="../index.php">Home</a>
                <a href="budget.php">Budget</a>
                <a href="#">Spending Transactions</a>
                <a href="total-spending.php">Total Spending</a>
                <span>|</span>
                <a href="logout.php">Logout</a>
			</nav>
			<section>
                <form action="#" method="POST">
                    <select name="select">
                        <?php
                            $query = 'SELECT * FROM Budgets WHERE UserID = '.$_SESSION["ID"].';';
                            $result = mysqli_query($link, $query);
                            for($i = 0; $i < $result->num_rows; $i++) {
                                $row = $result->fetch_row();
                                echo '<option value="'.$row[0].'">';
                                echo $row[2];
                                echo '</option>';
                            }
                        ?>
                    </select>
                    <button type="submit">Go</button>
                </form>
                <?php
                    if(!empty($_POST)) {
                        if (!empty($_POST["select"])) {
                            makeSpendingTransactionsTable($_POST["select"]);
                        } else if(!empty($_POST["insert-into-transactions"])) {
                            insertSpendingTransaction($_POST["insert-into-transactions"], $_POST["ItemDescription"], $_POST["Category"], $_POST["Ammount"], $_POST["TransactionDate"]);
                            makeSpendingTransactionsTable($_POST["insert-into-transactions"]);
                        } else if(!empty($_POST["update-on-transactions"])) {
                            updateSpendingTransaction($_POST["update-on-transactions"], $_POST["Description"], $_POST["Category"], $_POST["Ammount"], $_POST["Date"]);
                            makeSpendingTransactionsTable($_POST["budget-ID"]);
                        } else if(!empty($_POST["delete-in-transactions"])) {
                            deleteSpendingTransaction($_POST["delete-in-transactions"]);
                            makeSpendingTransactionsTable($_POST["budget-ID"]);
                        } 
                    }
                ?>
			</section>
		</main>
        <form action="#" method="POST" id="del-form"></form>
    </body>
<html>
