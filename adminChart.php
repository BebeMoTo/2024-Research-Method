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

            #piechart {
                height: auto;
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

            #piechart {
                height: 500px;
                margin-top: 40px;
            }
        }
    </style>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {
            'packages': ['corechart']
        });
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {

            var data = google.visualization.arrayToDataTable([
                ['Task', 'Amount of Violation'],
                <?php
                $query = "SELECT * FROM violation;";
                $stmt = $pdo->prepare($query);
                $stmt->execute();
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($results)) {
                    echo ('');
                } else {
                    foreach ($results as $row) {
                        $violationNo = htmlspecialchars($row["violationNo"]);
                        $violationName = htmlspecialchars($row["violationName"]);

                        $query = "SELECT COUNT(osaViolation) AS count FROM osa WHERE osaViolation = :violationNo;";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":violationNo", $violationNo);
                        $stmt->execute();
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (empty($results)) {
                            echo ('');
                        } else {
                            foreach ($results as $row) {
                                $count = htmlspecialchars($row["count"]);

                                echo ('["' . $violationName . '", ' . $count . '],');
                            }
                        }
                    }
                }
                ?>
            ]);

            var options = {
                title: 'Violations',
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }
    </script>
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
                            <a class="nav-link" href="adminFaculty.php">Faculty</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="adminChart.php">Chart</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <div id="piechart" style="width: 100%;"></div>


    </header>

    <script src="index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>