<?php 
	include "../includes/login-check.php";
	include "../includes/db-server.php";

	function makeFormforNewBudget() {
		echo 	'<form action="#" method="POST">
				<label for="">Budget Name</label>
				<input type="text" id="budget-name" name="create-budget-name">
				<button type="submit">Create Budget</button>
				</form>';
	}

	function makeBudgetTable($BudgetID) {
		echo '<table><tr><th>Catagory Name</th><th>Budget Ammount</th><th>Actions</th></tr>';
		$query = 'SELECT * FROM BudgetCategories WHERE BudgetID = '.$BudgetID.';';
		$result = mysqli_query($GLOBALS['link'], $query);
		if(!empty($result->num_rows)) {
			for($i = 0; $i < $result->num_rows; $i++) {
				$row = $result->fetch_assoc();
				echo '<tr id="row-'.$row["Category"].'">';
				echo '<td>'.$row["Category"].'</td>'.'<td>$'.$row["Ammount"].'</td>'.'<td><button onclick="EditRecord(\''.$row["Category"].'\', \'$'.$row["Ammount"].'\')">Edit</button><button form="del-form" type="submit" name="submit" value="delete'.$row["Category"].'">Delete</button></td>';
				echo '</tr>';
			}
		}
		echo '<tr id="insertRow">
				<form action="#" method="POST" id="main-form" autocomplete="off">
				<td><input type="text" name="Category"></td>
				<td><input type="text" name="Ammount" required></td>
				<td><button type="submit" name="submit-budget" value="'.$BudgetID.'">Enter</button></td>
				</form>
			</tr>
			</table>';
	}

	function insertIntoBudgetsTable($UserID, $BudgetName) {
		$query = 'INSERT INTO Budgets (UserID, BudgetName) VALUES ('.$UserID.' ,'.$BudgetName.');';
		$result = mysqli_query($GLOBALS["link"], $query);
	}

	function insertIntoBudgetCategoriesTable($BudgetID, $Category, $Ammount) {
		$query = 'INSERT INTO BudgetCategories (BudgetID, Category, Ammount) VALUES ('.$BudgetID.', "'.$Category.'", '.$Ammount.');';
		$result = mysqli_query($GLOBALS["link"], $query);
	}
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Budget</title>
		<link rel="stylesheet" href="../css/main.css"/>
		<link rel="stylesheet" href="../css/transactions.css"/>
		<link rel="icon" href="../images/favicon.jpg">
	</head>
	<body>
		<main>
			<img src="../images/main.png" id="main" alt="">
			<nav>
				<a href="../index.php">Home</a>
				<a href="#">Budget</a>
				<a href="transactions.php">Spending Transactions</a>
				<a href="total-spending.php">Total Spending</a>
				<span>|</span>
                <a href="logout.php">Logout</a>
			</nav>
			<section>
			<form action="#" method="POST">
				<select name="select">
					<option value="new">Create a New Budget</option>
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
			<!-- Form processer -->
			<?php
				// Check to form has been submitted
				if(!empty($_POST)) {

					// If create a budget was selected, print a form for the new budget
					if(!empty($_POST["select"]) && $_POST["select"] == "new") {
						makeFormforNewBudget();

					// If a budget was selected, show that budget as a table
					} else if (!empty($_POST["select"]) && $_POST["select"] != "new") {
						makeBudgetTable($_POST["select"]);

					// If rows from a budget table were added, process it in the DB
					} else if(!empty($_POST["submit-budget"])) {
						insertIntoBudgetCategoriesTable($_POST["submit-budget"], $_POST["Category"], $_POST["Ammount"]);
						makeBudgetTable($_POST["submit-budget"]);
					}

					// This will procress the creation of the new budget
					if(!empty($_POST["create-budget-name"])) {
						insertIntoBudgetsTable($_SESSION["ID"], $_POST["create-budget-name"]);
					}
				}
			?>
			</section>
		</main>
	</body>
</html>