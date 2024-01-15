<?php
session_start();
$username = $_SESSION['adminUsername'];
if (empty($username)) {
    session_unset();
    session_destroy();
    header("Location: index.php?loginError");
}

$studNo = $_GET['studNo'];

//connecting to database
try {
    require_once "dbh.inc.php";

    $query = "DELETE FROM student WHERE studNo = :studNo;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":studNo", $studNo);

    $stmt->execute();

    header("Location: ../adminStudent.php?deleteSuccess");
} catch (PDOException $e) {
    die("Query Failed: " > $e->getMessage());
}
