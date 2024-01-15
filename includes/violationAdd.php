<?php
session_start();
$username = $_SESSION['adminUsername'];
if (empty($username)) {
    session_unset();
    session_destroy();
    header("Location: ../index.php?loginError");
}

$violationName = $_GET['violationName'];

//connecting to database
try {
    require_once "dbh.inc.php";

    $query = "INSERT INTO violation (violationName) VALUES (:violationName);";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":violationName", $violationName);

    $stmt->execute();

    header("Location: ../admin.php?addSuccess");
} catch (PDOException $e) {
    die("Query Failed: " > $e->getMessage());
}
