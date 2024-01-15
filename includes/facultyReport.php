<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $osaFacultyID = htmlspecialchars($_POST["facultyID"]);
    $osaStudID = htmlspecialchars($_POST["studID"]);
    $osaViolation = htmlspecialchars($_POST["violation"]);

    if (empty($osaFacultyID) || empty($osaStudID) || empty($osaViolation)) {
        header("Location: ../faculty.php?submitError");
        exit();
    }

    try {
        require_once "dbh.inc.php";
        $query = "SELECT * FROM student WHERE BINARY studID = :studID;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":studID", $osaStudID);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($results)) {
            header("Location: ../faculty.php?noStudentFound");
            exit();
        } else {
            foreach ($results as $row) {
                $studLastName = htmlspecialchars($row["studLastName"]);
            }

            $query = "INSERT INTO osa (osaFacultyID, osaStudID, osaStudSurname, osaViolation) VALUES (:osaFacultyID, :osaStudID, :osaStudSurname, :osaViolation);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":osaFacultyID", $osaFacultyID);
            $stmt->bindParam(":osaStudID", $osaStudID);
            $stmt->bindParam(":osaStudSurname", $studLastName);
            $stmt->bindParam(":osaViolation", $osaViolation);
            $stmt->execute();

            header("Location: ../faculty.php?submitSuccess");
        }
    } catch (PDOException $e) {
        die("Query Failed: " > $e->getMessage());
    }
} else {
    header("Location: ../faculty.php?loginError");
}
