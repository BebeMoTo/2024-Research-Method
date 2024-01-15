<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);


    if (empty($username) || empty($password)) {
        header("Location: ../index.php?loginError");
        exit();
    }

    //connecting to database
    try {
        require_once "dbh.inc.php";

        $query = "SELECT * FROM student WHERE BINARY studID = :studID AND BINARY studPassword = :studPassword;";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":studID", $username);
        $stmt->bindParam(":studPassword", $password);

        $stmt->execute();

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            $query = "SELECT * FROM faculty WHERE BINARY facultyID = :facultyID AND BINARY facultyPassword = :facultyPassword;";

            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":facultyID", $username);
            $stmt->bindParam(":facultyPassword", $password);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (empty($results)) {
                $query = "SELECT * FROM osaaccount WHERE BINARY osaAccountID = :osaID AND BINARY osaAccountPassword = :osaPassword;";

                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":osaID", $username);
                $stmt->bindParam(":osaPassword", $password);

                $stmt->execute();

                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if (empty($results)) {
                    $query = "SELECT * FROM admin WHERE BINARY adminID = :adminID AND BINARY adminPassword = :adminPassword;";

                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":adminID", $username);
                    $stmt->bindParam(":adminPassword", $password);

                    $stmt->execute();

                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    if (empty($results)) {
                        header("Location: ../index.php?notInDB");
                    } else {
                        //require_once 'config.php';
                        session_start();
                        $_SESSION['adminUsername'] = $username;
                        header("Location: ../admin.php");
                    }
                } else {
                    //require_once 'config.php';
                    session_start();
                    $_SESSION['osaUsername'] = $username;
                    header("Location: ../osa.php");
                }
            } else {
                //require_once 'config.php';
                session_start();
                $_SESSION['facultyUsername'] = $username;
                header("Location: ../faculty.php");
            }
        } else {
            //require_once 'config.php';
            session_start();
            $_SESSION['studUsername'] = $username;
            header("Location: ../student.php");
        }
    } catch (PDOException $e) {
        die("Query Failed: " > $e->getMessage());
    }

    //going to admin page
    //header("Location: ../adminPage.php");
} else {
    header("Location: ../index.php?loginError");
}
