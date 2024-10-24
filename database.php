<?php
session_start(); 

$host = 'localhost:8080';
$dbname = 'todo_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); 
    exit();
}

?>
