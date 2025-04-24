<?php

if (isset($_POST['submit'])) {
    
    if (!empty($_POST['sname']) && !empty($_POST['entwickler']) && !empty($_POST['releasedate'])) {
        echo ("<a href='startseite.php'>Zurück zur Hauptseite</a> <br>");

        $sname = htmlspecialchars($_POST['sname']);
        $entwickler = htmlspecialchars($_POST['entwickler']);
        $releasedate = htmlspecialchars($_POST['releasedate']);
                try {

                    require_once("dbconnection.php");
        
                    $stmt = $pdo->prepare("INSERT INTO games (sname,entwickler,releasedate) VALUES (:sname, :entwickler, :releasedate)");
        
                    $stmt->bindParam(":sname", $sname);
                    $stmt->bindParam(":entwickler", $entwickler);
                    $stmt->bindParam(":releasedate", $releasedate);


                    $stmt->execute();

                } catch (PDOException $e) {
                    die("Das Insert Into ist falsch");
                }
            }  
} else {
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css.css">
    <title>Document</title>
</head>
<body>


    <h1>Gamespace - Spiele melden</h1>
    <form enctype="multipart/form-data" action="<?php
    echo($_SERVER['SCRIPT_NAME']);
    ?>" method="post">

        <label for="sname">Name:</label><br>
        <input type="text" id="sname" name="sname" required><br><br>

        <label for="entwickler">Entwickler:</label><br>
        <input type="text" id="entwickler" name="entwickler" required><br><br>

        <label for="releasedate">Release Date:</label><br>
        <input type="date" id="releasedate" name="releasedate" required><br><br>

        <input type="submit" id="submit" name="submit" value="Spiel melden"><br><br>

    </form>
</body>
</html>

<?php
}
?>