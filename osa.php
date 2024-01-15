<?php
session_start();
require_once "includes/dbh.inc.php";
$username = $_SESSION['osaUsername'];
if (empty($username)) {
    session_unset();
    session_destroy();
    header("Location: index.php?loginError");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>StudentGuard Pro || Student Affairs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .card {
            width: 90%;
            margin: auto;
            margin-top: 20px;
        }

        @media all and (max-width: 400px) {
            .toast {
                width: 90%;
            }
        }
    </style>

</head>

<body>
    <header class="header">
        <nav class="navbar bg-body-tertiary bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="includes/logout.php">
                    <img src="images/favicon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    StudentGuard Pro: <b>S. A.</b>
                </a>
            </div>
        </nav>

        <?php
        $query = "SELECT * FROM osa ORDER BY osaDateViolation DESC;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            //edrfvfdvbf
        } else {
            foreach ($results as $row) {
                $osaDateViolationed = htmlspecialchars($row["osaDateViolation"]);
                $osaDateViolation = substr($osaDateViolationed, 0, 10);
                $osaFacultyID = htmlspecialchars($row["osaFacultyID"]);
                $osaStudID = htmlspecialchars($row["osaStudID"]);
                $osaStudSurname = htmlspecialchars($row["osaStudSurname"]);
                $osaViolation = htmlspecialchars($row["osaViolation"]);
                $osaNo = htmlspecialchars($row["osaNo"]);

                $query = "SELECT * FROM student WHERE studID = :studID;";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":studID", $osaStudID);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $row) {
                    $studFirstName = htmlspecialchars($row["studFirstName"]);
                    $studLastName = htmlspecialchars($row["studLastName"]);
                    $studMiddleName = htmlspecialchars($row["studMiddleName"]);
                    $studBlock = htmlspecialchars($row["studBlock"]);
                }

                $query = "SELECT * FROM faculty WHERE facultyID = :facultyID;";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":facultyID", $osaFacultyID);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $row) {
                    $facultyFirstName = htmlspecialchars($row["facultyFirstName"]);
                    $facultyLastName = htmlspecialchars($row["facultyLastName"]);
                    $facultyMiddleName = htmlspecialchars($row["facultyMiddleName"]);
                }

                $query = "SELECT * FROM violation WHERE violationNo = :violationNo;";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":violationNo", $osaViolation);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $row) {
                    $violationName = htmlspecialchars($row["violationName"]);
                }

                echo ('
                    <div class="card">
                        <div class="card-header">
                        Date: ' . $osaDateViolation . '
                        </div>
                        <div class="card-body">
                        <h5 class="card-title">' . $studLastName . ', ' . $studFirstName . ', ' . $studMiddleName . '</h5>
                        <p class="card-text">Block: ' . $studBlock . '<br>Violation: ' . $violationName . '<br>Reported By: ' . $facultyLastName . ', ' . $facultyFirstName . '</p>
                        <a href="includes/violationDelete.php?violationID=' . $osaNo . '" class="btn btn-primary">Clear</a>
                        </div>
                    </div>
                ');
            }
        }
        ?>

        <div class="toast" id="EpicToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <strong class="me-auto text-white">Cleared</strong>
                <small class="text-white">...</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                The record was cleared successfully.
            </div>
        </div>
    </header>


    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        var option = {
            animation: true,
            delay: 3000
        }
        if (window.location.href.includes("deleteSuccess")) {
            var toastHTMLElement = document.getElementById("EpicToast");
            var toastElement = new bootstrap.Toast(toastHTMLElement, option);
            toastElement.show();
        }
    </script>
</body>

</html>