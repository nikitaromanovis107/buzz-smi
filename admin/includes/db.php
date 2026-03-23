<?php
$host = "localhost";         
$dbname = "demo_db";          
$username = "demo_user";                 
$password = "demo_password";          

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    error_log("DB Error: " . $e->getMessage());
    die('Ошибка БД');
}