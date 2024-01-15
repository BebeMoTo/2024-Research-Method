<?php
session_start();
$username = $_SESSION['adminUsername'];
if (empty($username)) {
    session_unset();
    session_destroy();
    header("Location: index.php?loginError");
}

$facultyFirstName = $_GET['firstName'];
$facultyLastName = $_GET['lastName'];
$facultyMiddleName = $_GET['middleName'];
$facultyID = $_GET['facultyID'];
$facultyPassword = $_GET['facultyPassword'];

//connecting to database
try {
    require_once "dbh.inc.php";

    $query = "INSERT INTO faculty (facultyID, facultyPassword, facultyFirstName, facultyLastname, facultyMiddleName) VALUES (:facultyID, :facultyPassword, :facultyFirstName, :facultyLastname, :facultyMiddleName);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":facultyID", $facultyID);
    $stmt->bindParam(":facultyPassword", $facultyPassword);
    $stmt->bindParam(":facultyFirstName", $facultyFirstName);
    $stmt->bindParam(":facultyLastname", $facultyLastName);
    $stmt->bindParam(":facultyMiddleName", $facultyMiddleName);
    $stmt->execute();

    header("Location: ../adminFaculty.php?addSuccess");
} catch (PDOException $e) {
    die("Query Failed: " > $e->getMessage());
}
