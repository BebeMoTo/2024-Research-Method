<?php
session_start();
require_once "includes/dbh.inc.php";
//require_once "includes/config.php";
$username = $_SESSION['studUsername'];
if (empty($username)) {
    session_unset();
    session_destroy();
    header("Location: index.php?loginError");
}

$query = "SELECT * FROM student WHERE BINARY studID = :studID;";
$stmt = $pdo->prepare($query);
$stmt->bindParam(":studID", $username);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($results)) {
    session_unset();
    session_destroy();
    header("Location: index.php?loginError");
} else {
    foreach ($results as $row) {
        $studFirstName = htmlspecialchars($row["studFirstName"]);
        $studLastName = htmlspecialchars($row["studLastName"]);
        $studMiddleName = htmlspecialchars($row["studMiddleName"]);
        $studBlock = htmlspecialchars($row["studBlock"]);
        $studNo = htmlspecialchars($row["studNo"]);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
    <title>StudentGuard Pro || Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .card {
            width: 90%;
            margin: auto;
            margin-top: 30px;
            max-height: 75vh;
            overflow-y: scroll;
        }
    </style>
</head>

<body>
    <header class="header">
        <nav class="navbar bg-body-tertiary bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="includes/logout.php">
                    <img src="images/favicon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    StudentGuard Pro: <b>STUDENT</b>
                </a>
            </div>
        </nav>


        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?php echo $studLastName . ', ' . $studFirstName . ', ' . $studMiddleName ?></h5>
                <h6 class="card-subtitle mb-2 text-body-secondary"><?php echo $studBlock ?></h6>


                <?php
                $query = "SELECT * FROM osa WHERE osaStudID = :osaStudID;";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":osaStudID", $username);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if (empty($results)) {
                    echo ('
                        <p class="card-text text-success">You have no violation/s.</p>
                        ');
                } else {
                    foreach ($results as $row) {
                        $osaViolation = htmlspecialchars($row["osaViolation"]);
                        $osaDateViolationed = htmlspecialchars($row["osaDateViolation"]);
                        $osaDateViolation = substr($osaDateViolationed, 0, 10);
                        $query = "SELECT * FROM violation WHERE violationNo = :violationNo;";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":violationNo", $osaViolation);
                        $stmt->execute();
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($results as $row) {
                            $violationName = htmlspecialchars($row["violationName"]);
                        }
                        echo ('
                        <p class="card-text text-danger">Violation: ' . $violationName . ', <br>Date: ' . $osaDateViolation . '</p>
                        ');
                    }
                }


                ?>





            </div>
        </div>

    </header>

    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>