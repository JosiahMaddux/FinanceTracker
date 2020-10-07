<?php session_start(); ?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Super Budget Tracker</title>
		<link rel="stylesheet" href="css/main.css"/>
	</head>
	<body>
	<?php
		include "includes/tables.php";
	?>
		<main>
			<img src="images/main.png" id="main" alt="">
			<nav>
				<a href="#">Home</a>
				<a href="pages/budget.php">Budget</a>
				<a href="pages/transactions.php">Spending Transactions</a>
				<a href="pages/total-spending.php">Total Spending</a>
				<span>|</span>
				<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {echo "<a href=\"pages/logout.php\">Logout</a>";} else {echo "<a href=\"pages/login.php\">Login</a>";}?>
			</nav>
			<section>
				<p>Super Budget Tracker helps you keep track of your finacnes and stay on budget.</p>
				<p>Keeping track of your finances is something that everyone needs to do. It helps you to have more control over your life it it enables you to be able to succeed financially</p>
				<p>We provide free helpful tools to help you get your finances back on track! To learn about how to use our tools, please read below.</p>
				<p>Step 1: Go to our budgets page and set up your budgets.</p>
				<p>Step 2: Start keeping track of your spending transactions by entering them into our database.</p>
				<p>Step 3: Find out how well you stick to your budget by going to the total spending page.</p>
				<p>Once you have a budget and know how well you're sticking to it, you'll be better empowered to start reaching your financial goals!</p>
			</section>
		</main>
	</body>
</html>