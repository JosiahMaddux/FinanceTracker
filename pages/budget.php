<?php include "../includes/login-check.php" ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Budget</title>
		<link rel="stylesheet" href="../css/main.css"/>
		<link rel="stylesheet" href="../css/transactions.css"/>
		<link rel="icon" href="../images/favicon.jpg">
	</head>
	<body>
	<?php
		include "../includes/tables.php";
	?>
	<!--The below script processes the submission of the forms on this page-->
	<script src="../js/Budgets.js"></script>
	<?php
		$host = 'localhost';
		$user = 'root';
		$password ='';
		$database = 'Final_Josiah_Maddux';
		$link = mysqli_connect($host, $user, $password, $database);
		if(!empty($_POST)) {
			if($_POST["submit"] == 'insert') {
				$query = 'INSERT INTO Categories (CategoryName, Ammount) VALUES ("'.$_POST["Category"].'", '.$_POST["Ammount"].')';
				$result = mysqli_query($link, $query);
			} else if(substr($_POST["submit"], 0, 6) == 'delete') {
				$query = 'DELETE FROM Categories WHERE CategoryName="'.substr($_POST["submit"], 6).'"';
				$result = mysqli_query($link, $query);
			} else if(substr($_POST["submit"], 0, 6) == 'update') {
				$query = 'UPDATE Categories set CategoryName="'.$_POST["Category"].'", Ammount='.$_POST["Ammount"].' WHERE CategoryName="'.substr($_POST['submit'], 6).'"';
				$result = mysqli_query($link, $query);
			}
		} 
	?>
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
				<table>
					<tr><th>Catagory Name</th><th>Budget Ammount</th><th>Actions</th></tr>
					<?php
						$query = 'SELECT * FROM Categories;';
						$result = mysqli_query($link, $query);
						if(!empty($result->num_rows)) {
							for($i = 0; $i < $result->num_rows; $i++) {
								$row = $result->fetch_row();
								echo '<tr id="row-'.$row[0].'">';
								echo '<td>'.$row[0].'</td>'.'<td>$'.number_format($row[1], 2).'</td>'.'<td><button onclick="EditRecord(\''.$row[0].'\', \'$'.number_format($row[1], 2).'\')">Edit</button><button form="del-form" type="submit" name="submit" value="delete'.$row[0].'">Delete</button></td>';
								echo '</tr>';
							}
						}
					?>
					<tr id="insertRow">
						<form action="#" method="POST" id="main-form" autocomplete="off">
							<td><input type="text" name="Category"></td>
							<td><input type="text" name="Ammount" required></td>
							<td><button type="submit" name="submit" value="insert">Enter</button></td>
						</form>
					</tr>
				</table>
			</section>
		</main>
	</body>
	<form action="#" method="POST" id="del-form"></form>
</html>