<?php
session_start();
$username = $_SESSION['adminUsername'];
if (empty($username)) {
    session_unset();
    session_destroy();
    header("Location: index.php?loginError");
}

$studFirstName = $_GET['firstName'];
$studLastName = $_GET['lastName'];
$studMiddleName = $_GET['middleName'];
$studBlock = $_GET['block'];
$studID = $_GET['studID'];
$studPassword = $_GET['studPassword'];

//connecting to database
try {
    require_once "dbh.inc.php";

    $query = "INSERT INTO student (studID, studPassword, studFirstName, studLastname, studMiddleName, studBlock) VALUES (:studID, :studPassword, :studFirstName, :studLastname, :studMiddleName, :studBlock);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":studID", $studID);
    $stmt->bindParam(":studPassword", $studPassword);
    $stmt->bindParam(":studFirstName", $studFirstName);
    $stmt->bindParam(":studLastname", $studLastName);
    $stmt->bindParam(":studMiddleName", $studMiddleName);
    $stmt->bindParam(":studBlock", $studBlock);
    $stmt->execute();

    header("Location: ../adminStudent.php?addSuccess");
} catch (PDOException $e) {
    die("Query Failed: " > $e->getMessage());
}
