<?php

session_start();
$appName = $_SERVER['HTTP_HOST'] ?? 'defaulthost';
$appName .= $_SERVER['REQUEST_URI'] ?? 'defaulturi';

$dsn = 'pgsql:host=localhost;dbname=postgres;options=\'--application_name=' . $appName . '\'';
$user = 'postgres';
$password = 'root';


// Create a PDO instance
$pdo = new PDO($dsn, $user, $password);

// Check connection
if (!$pdo) {
    echo "Connection failed";
    exit;
}