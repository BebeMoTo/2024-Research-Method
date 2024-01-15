<?php
session_start();
$username = $_SESSION['adminUsername'];
if (empty($username)) {
    session_unset();
    session_destroy();
    header("Location: index.php?loginError");
}

$violationNo = $_GET['violationNo'];

//connecting to database
try {
    require_once "dbh.inc.php";

    $query = "DELETE FROM violation WHERE violationNo = :violationNo;";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":violationNo", $violationNo);

    $stmt->execute();

    header("Location: ../admin.php?deleteSuccess");
} catch (PDOException $e) {
    die("Query Failed: " > $e->getMessage());
}
