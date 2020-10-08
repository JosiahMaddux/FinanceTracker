<?php include "../includes/login-check.php" ?>
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
				<table>
					<tr>
						<th>Category</th><th>Budget Ammount</th><th>Ammount Spent</th><th>Difference</th>
					</tr>
					<?php
						$host = 'localhost';
						$user = 'root';
						$password = '';
						$link = mysqli_connect($host, $user, $password);
						mysqli_select_db($link, "Final_Josiah_Maddux");
						$query = 'SELECT
									CategoryName,
									Ammount,
									SumOfAmmount,
									Ammount - SumOfAmmount AS Leftover
								FROM (
									SELECT
										Categories.CategoryName,
										Categories.Ammount, 
										IFNULL(Sum(SpendingTransactions.Ammount), 0) AS SumOfAmmount
									FROM
										Categories 
									LEFT JOIN SpendingTransactions ON Categories.CategoryName = SpendingTransactions.Category
									GROUP BY
									Categories.CategoryName,
									Categories.Ammount
								) AS budget
								UNION SELECT
									"Total:" AS CategoryName,
									Sum(Ammount) AS Ammount,
									Sum(SumOfAmmount) AS SumOfAmmount,
									Sum(Ammount - SumOfAmmount) AS Leftover
								FROM (
									SELECT
										Categories.CategoryName,
										Categories.Ammount, 
										IFNULL(Sum(SpendingTransactions.Ammount), 0) AS SumOfAmmount
									FROM
										Categories 
									LEFT JOIN SpendingTransactions ON Categories.CategoryName = SpendingTransactions.Category
									GROUP BY
									Categories.CategoryName,
									Categories.Ammount
								) AS budget';
						$result = mysqli_query($link, $query);
						if(!empty($result->num_rows)) {
                            for($i = 0; $i < $result->num_rows; $i++) {
                                $row = $result->fetch_row();
                                echo '<tr>';
                                echo '<td>'.$row[0].'</td>'.'<td>$'.number_format($row[1], 2).'</td>'.'<td>$'.number_format($row[2], 2).'</td>'.'<td>$'.number_format($row[3], 2).'</td>';
                                echo '</tr>';
                            }
                        }
                	?>
				</table>
			</section>
		</main>
    </body>
<html>
