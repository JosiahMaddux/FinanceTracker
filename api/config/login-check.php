<?php
    session_start(); // You need a session start on each page
    if(!empty($_SESSION)) {
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] === false) {
            echo "Access Forbiden"; 
            exit;
        }
    } else {
        echo "Access Forbiden"; 
        exit;
    }
?>