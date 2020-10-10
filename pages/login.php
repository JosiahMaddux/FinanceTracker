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

        // Process submitted form
        if(!empty($_POST)) {
            $stmt = mysqli_prepare($link, "SELECT id, username, password FROM users WHERE username = ?");
            mysqli_stmt_bind_param($stmt, "s", $_POST["username"]);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $id, $username, $password);
            mysqli_stmt_fetch($stmt);
            if(!empty($id)) {
                if(password_verify($_POST["password"], $password)) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["username"] = $username;
                    $_SESSION["ID"] = $id;
                    header("location: total-spending.php");
                    exit;
                } else {
                    echo "<h1>Wrong username or password</h1>";
                }
            } else {
                echo "<h1>Wrong username or password</h1>";
            }
            mysqli_stmt_close($stmt);
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