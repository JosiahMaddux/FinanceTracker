<?php include "../includes/login-check.php" ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Spending Transactions</title>
        <link rel="stylesheet" href="../css/main.css"/>
        <link rel="stylesheet" href="../css/transactions.css"/>
    </head>
    <body>
        <?php
            include "../includes/tables.php";
        ?>
        <script src="../js/transactions.js"></script>
        <!--The below script processes the submission of the forms on this page-->
        <?php
            $host = 'localhost';
            $user = 'root';
            $password = '';
            $link = mysqli_connect($host, $user, $password);
            mysqli_select_db($link, "Final_Josiah_Maddux");
            if(!empty($_POST)) {
                if($_POST['submit'] == 'insert') {
                    $query = 'INSERT INTO SpendingTransactions (ItemDescription, Category, Ammount, TransactionDate) VALUES ("'.$_POST["Description"].'","'.$_POST["Category"].'",'.$_POST["Ammount"].',"'.$_POST["Date"].'");';
                    $result = mysqli_query($link, $query);
                } else if(substr($_POST['submit'], 0, 6) == 'delete') {
                    $query = 'DELETE FROM SpendingTransactions WHERE TransactionID="'.substr($_POST['submit'], 6).'"';
                    $result = mysqli_query($link, $query);
                } else if(substr($_POST['submit'], 0, 6) == 'update') {
                    $query = 'UPDATE SpendingTransactions SET ItemDescription="'.$_POST["Description"].'", Category="'.$_POST["Category"].'", Ammount='.$_POST["Ammount"].', TransactionDate="'.$_POST["Date"].'" WHERE TransactionID="'.substr($_POST['submit'], 6).'"';
                    $result = mysqli_query($link, $query);
                }                
            }
        ?>
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
                <table>
                    <tr><th>Description</th><th>Category</th><th>Ammount</th><th>Date</th><th>Actions</th></tr>
                    <?php
                        $query = 'SELECT * FROM SpendingTransactions;';
                        $result = mysqli_query($link, $query);
                        if(!empty($result->num_rows)) {
                            for($i = 0; $i < $result->num_rows; $i++) {
                                $row = $result->fetch_row();
                                echo '<tr id="row'.$row[0].'">';
                                echo '<td>'.$row[1].'</td>'.'<td>'.$row[2].'</td>'.'<td>$'.number_format($row[3], 2).'</td>'.'<td>'.$row[4].'</td><td><button onclick="EditRecord(\''.$row[0].'\', \''.$row[1].'\', \''.$row[2].'\', \'$'.number_format($row[3], 2).'\', \''.$row[4].'\')">Edit</button><button form="del-form" type="submit" name="submit" value="delete'.$row[0].'">Delete</button></td>';
                                echo '</tr>';
                            }
                        }
                    ?>
                    <tr id="insertRow">
                        <form id="main-form" action="#" method="POST" autocomplete="off">
                        <td><input type="text" name="Description" id="Description" required></td>
                        <td>
                            <select name="Category" id="Category">
                                <?php
                                    $query = 'SELECT * FROM Categories;';
                                    $result = mysqli_query($link, $query);
                                    for($i = 0; $i < $result->num_rows; $i++) {
                                        $row = $result->fetch_row();
                                        echo '<option value="'.$row[0].'" id="cat-'.$row[0].'">';
                                        echo $row[0];
                                        echo '</option>';
                                    }
                                ?>
                            </select>
                        </td>
                        <td><input type="text" name="Ammount" id="Ammount" required></td>
                        <td><input type="text" name="Date" id="Date" pattern="(0[1-9]|1[012])[- /.](0[1-9]|[12][0-9]|3[01])[- /.](19|20)\d\d" title="MM/DD/YYYY"></td>
                        <td><button type="submit" name="submit" value="insert" id="Enter-Button">Enter</button></td>
                        </form>
                    </tr>
                </table>
			</section>
		</main>
        <form action="#" method="POST" id="del-form"></form>
    </body>
<html>
