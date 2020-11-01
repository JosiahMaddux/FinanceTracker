<?php
// This file automatically creates tables on the DB if they do not already exist

// Connect to server
// You have to have a DB named finance_tracker
include "db-server.php";

// Create Users table
$query = 'CREATE TABLE IF NOT EXISTS Users
    (ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP);';
$result = mysqli_query($link, $query);

// Create Budgets table
$query = 'CREATE TABLE IF NOT EXISTS Budgets
    (ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    UserID INT UNSIGNED NOT NULL REFERENCES Users(ID),
    BudgetName VARCHAR(64));';
$result = mysqli_query($link, $query);

// Create BudgetCatagories table
$query = 'CREATE TABLE IF NOT EXISTS BudgetCategories
    (ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    BudgetID INT UNSIGNED NOT NULL REFERENCES Budgets(ID),
    Category VARCHAR(64),
    Ammount DECIMAL(12, 2));';
$result = mysqli_query($link, $query);

// Create SpendingTransactions table
$query = 'CREATE TABLE IF NOT EXISTS SpendingTransactions
    (ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    BudgetID INT UNSIGNED NOT NULL REFERENCES Budgets(ID),
    ItemDescription VARCHAR(255),
    Category VARCHAR(64) REFERENCES BudgetCategories(Category),
    Ammount DECIMAL(12, 2),
    TransactionDate VARCHAR(20));';
$result = mysqli_query($link, $query);

// use this later
//
// ALTER TABLE `budgetcategories` ADD UNIQUE( `BudgetID`, `Category`);
//
// Also this
//
// ALTER TABLE `SpendingTransactions`
// 	ADD CONSTRAINT
// 	FOREIGN KEY (`Category`) REFERENCES `BudgetCategories` (`Category`)
// 	ON UPDATE CASCADE
// 	ON DELETE RESTRICT;



?>


