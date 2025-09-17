<?php
// db_connect.php - Database connection with error handling and logging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
$host = 'localhost';
$dbname = 'dbia6guegzykyo';
$user = 'uzrprp3rmtdfr';
$pass = '#[qI(M3@k1bz';
 
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    file_put_contents('error.log', date('Y-m-d H:i:s') . " - Database connection failed: " . $e->getMessage() . "\n", FILE_APPEND);
    die("Database connection failed. Please check logs or contact support.");
}
?>
