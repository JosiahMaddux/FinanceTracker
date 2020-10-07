<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="../images/favicon.jpg">
</head>
<body>
    <?php
        // If signed in, redirect to total spending
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            header("location: total-spending.php");
            exit;
        }
    
        // Connect to server
        include "../includes/db-server.php";
        mysqli_select_db($link, "Final_Josiah_Maddux");

        // Process submitted form
        if(!empty($_POST)) {
            $sql = "SELECT id, username, password FROM users WHERE username = \"".$_POST["username"]."\"";
            $result = mysqli_query($link, $sql);
            $row = $result->fetch_row();
            if(!empty($row)) {
                if($row[2] == $_POST["password"]) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $_POST["username"];
                    header("location: total-spending.php");
                    exit;
                } else {
                    echo "<h1>Wrong username or password</h1>";
                }
            } else {
                echo "<h1>Wrong username or password</h1>";
            }
        } 
     

    ?>
    
    <!-- Login form -->
    <h1>Login</h1>
    <form action="#" method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
        <label for="password">Password</label>
        <input type="password" name="password" id="password">
        <input type="submit">
    </form>
</body>
</html>