<?php
session_start();
require_once "includes/dbh.inc.php";
$username = $_SESSION['adminUsername'];
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
    <title>StudentGuard Pro || Log-In</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        .card {
            width: 500px;
            margin-top: 20px;
        }

        .toast {
            position: fixed;
        }

        @media all and (max-width: 400px) {
            .toast {
                width: 90%;
            }

            .card {
                width: 90%;
                margin: auto;
                margin-top: 20px;
            }
        }


        input {
            background-color: #fff;
            padding: 1rem;
            padding-right: 3rem;
            font-size: 0.875rem;
            line-height: 1.25rem;
            width: 100%;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }


        @media all and (min-width: 401px) {
            .card {
                margin-left: 20px;
            }
        }
    </style>
</head>

<body>

    <header class="header">
        <nav class="navbar navbar-expand-lg bg-body-tertiary bg-dark border-bottom border-body" data-bs-theme="dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="includes/logout.php">
                    <img src="images/favicon.png" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
                    StudentGuard Pro: <b>ADMIN</b>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">Violations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminStudent.php">Students</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="adminFaculty.php">Faculty</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="adminChart.php">Chart</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <?php
        $query = "SELECT * FROM faculty;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            echo ('');
        } else {
            foreach ($results as $row) {
                $facultyFirstName = htmlspecialchars($row["facultyFirstName"]);
                $facultyLastName = htmlspecialchars($row["facultyLastName"]);
                $facultyMiddleName = htmlspecialchars($row["facultyMiddleName"]);
                $facultyID = htmlspecialchars($row["facultyID"]);
                $facultyNo = htmlspecialchars($row["facultyNo"]);
                echo ('
                    
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">' . $facultyLastName . ', ' .  $facultyFirstName . ', ' . $facultyMiddleName . '</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">' . $facultyID . '</h6>
                            <a href="includes/facultyDelete.php?facultyNo=' . $facultyNo . '"><button type="button" class="card-link btn btn-danger">Delete</button></a>
                        </div>
                    </div>
                    
                    ');
            }
        }
        ?>


        <div class="card">
            <div class="card-body">
                <form action="includes/facultyAdd.php" method="GET">
                    <h5 class="card-title">Add Faculty Member</h5>
                    <input required type="text" name="firstName" class="card-title" placeholder="First Name">
                    <input required type="text" name="middleName" class="card-title" placeholder="Middle Name">
                    <input required type="text" name="lastName" class="card-title" placeholder="Last Name">
                    <input required type="text" name="facultyID" class="card-title" placeholder="Faculty ID">
                    <input required type="text" name="facultyPassword" class="card-title" placeholder="Faculty Password">
                    <button type="submit" class="card-link btn btn-primary">Submit</button>
                    <button type="reset" class="card-link btn btn-danger">Clear</button>
                </form>
            </div>
        </div>


        <div class="toast" id="EpicToast1" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <strong class="me-auto text-white">Added!!!</strong>
                <small class="text-white">...</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Faculty Member Added Successfully
            </div>
        </div>

        <div class="toast" id="EpicToast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-success">
                <strong class="me-auto text-white">Deleted!!!</strong>
                <small class="text-white">...</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                Faculty member deleted.
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
        if (window.location.href.includes("addSuccess")) {
            var toastHTMLElement = document.getElementById("EpicToast1");
            var toastElement = new bootstrap.Toast(toastHTMLElement, option);
            toastElement.show();
        } else if (window.location.href.includes("deleteSuccess")) {
            var toastHTMLElement = document.getElementById("EpicToast");
            var toastElement = new bootstrap.Toast(toastHTMLElement, option);
            toastElement.show();
        }
    </script>
</body>

</html>