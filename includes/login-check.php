<?php
    session_start(); // You need a session start on each page
    if(!empty($_SESSION)) {
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
            header("location: login.php");
            exit;
        }
    } else {
        header("location: login.php");
        exit;
    }
?>