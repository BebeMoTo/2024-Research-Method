<?php
session_start();
$username = $_SESSION['adminUsername'];
if (empty($username)) {
    session_unset();
    session_destroy();
    header("Location: index.php?loginError");
}

$facultyNo = $_GET['facultyNo'];

//connecting to database
try {
    require_once "dbh.inc.php";

    $query = "DELETE FROM faculty WHERE facultyNo = :facultyNo;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":facultyNo", $facultyNo);

    $stmt->execute();

    header("Location: ../adminFaculty.php?deleteSuccess");
} catch (PDOException $e) {
    die("Query Failed: " > $e->getMessage());
}
