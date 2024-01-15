<?php
session_start();
$username = $_SESSION['osaUsername'];
if (empty($username)) {
    session_unset();
    session_destroy();
    header("Location: ../index.php?loginError");
}

$violationID = $_GET['violationID'];

//connecting to database
try {
    require_once "dbh.inc.php";

    $query = "DELETE FROM osa WHERE osaNo = :violationID;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":violationID", $violationID);

    $stmt->execute();

    header("Location: ../osa.php?deleteSuccess");
} catch (PDOException $e) {
    die("Query Failed: " > $e->getMessage());
}
