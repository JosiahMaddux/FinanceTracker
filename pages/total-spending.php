<?php 
	include "../includes/login-check.php";
	include "../includes/db-server.php";

	function makeTotalsTable($budgetID) {
		echo "<table><tr><th>Category</th><th>Budget Ammount</th><th>Ammount Spent</th><th>Difference</th></tr>";
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
							BudgetID = '.$budgetID.'
						) AS PersonalBudgetCategories LEFT JOIN SpendingTransactions ON PersonalBudgetCategories.Category = SpendingTransactions.Category
						GROUP BY
							PersonalBudgetCategories.Category,
							PersonalBudgetCategories.Ammount
					) AS Budget
					UNION SELECT
						"Total:" AS Category,
						SUM(Ammount) AS Ammount,
						SUM(Total_Spent) AS Total_Spent,
						SUM(Difference) AS Difference
					FROM (
						SELECT
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
								BudgetID = '.$budgetID.'
							) AS PersonalBudgetCategories LEFT JOIN SpendingTransactions ON PersonalBudgetCategories.Category = SpendingTransactions.Category
							GROUP BY
								PersonalBudgetCategories.Category,
								PersonalBudgetCategories.Ammount
						) AS Budget
					) AS TotalsBudget;';
						$result = mysqli_query($GLOBALS["link"], $query);
						if(!empty($result->num_rows)) {
                            for($i = 0; $i < $result->num_rows; $i++) {
                                $row = $result->fetch_row();
                                echo '<tr>';
                                echo '<td>'.$row[0].'</td>'.'<td>$'.number_format($row[1], 2).'</td>'.'<td>$'.number_format($row[2], 2).'</td>'.'<td>$'.number_format($row[3], 2).'</td>';
                                echo '</tr>';
                            }
						}
						echo"</table>";
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Monthly Spending</title>
        <link rel="stylesheet" href="../css/main.css"/>
		<link rel="stylesheet" href="../css/transactions.css"/>
		<link rel="icon" href="../images/favicon.jpg">
    </head>
    <body>
	    <main>
			<img src="../images/main.png" id="main" alt="">
			<nav>
				<a href="../index.php">Home</a>
				<a href="budget.php">Budget</a>
				<a href="transactions.php">Spending Transactions</a>
				<a href="#">Total Spending</a>
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
                            makeTotalsTable($_POST["select"]);
                        }
					}
				?>
			</section>
		</main>
    </body>
<html>
