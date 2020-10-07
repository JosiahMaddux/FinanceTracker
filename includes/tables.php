<?php
// This file automatically creates tables on the DB if they do not already exist

// Connect to server
include "db-server.php";

// Create DB
$query = 'CREATE DATABASE IF NOT EXISTS Final_Josiah_Maddux;';
$result = mysqli_query($link, $query);
$databaseName = 'Final_Josiah_Maddux';
$databaseSelected = mysqli_select_db($link, $databaseName);

// Create catagories table
$query = 'CREATE TABLE IF NOT EXISTS Categories (CategoryName VARCHAR(50) PRIMARY KEY, Ammount FLOAT);';
$result = mysqli_query($link, $query);

// Create a spending table for each month of the year
    $query = 'CREATE TABLE IF NOT EXISTS SpendingTransactions (TransactionID INT(4) UNSIGNED AUTO_INCREMENT PRIMARY KEY, ItemDescription VARCHAR(250), Category VARCHAR(50), Ammount FLOAT, TransactionDate VARCHAR(20), FOREIGN KEY (Category) REFERENCES Categories(CategoryName));';
    $result = mysqli_query($link, $query);
?>