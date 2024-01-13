<?php

$dsn = "mysql:host=localhost;dbname=student_guard_pro";
$dbusername = "root";
$dbpassword = "";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {

    //try this withoud opening xampp
    echo "Connection failed: " > $e->getMessage();
}
