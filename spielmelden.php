<?php


if (isset($_POST['submit'])) {
    
    if (!empty($_POST['sname']) && !empty($_POST['entwickler']) && !empty($_POST['releasedate'])) {
        echo ("<a href='startseite.php'>Zurück zur Hauptseite</a> <br>");

        $sname = htmlspecialchars($_POST['sname']);
        $entwickler = htmlspecialchars($_POST['entwickler']);
        $releasedate = htmlspecialchars($_POST['releasedate']);

        $cover_name = $_FILES['cover']['name'];
        $cover_type = $_FILES['cover']['type'];
        $cover_size = $_FILES['cover']['size'];
        $cover_tmp_name = $_FILES['cover']['tmp_name'];

    }

        if (($cover_type == 'image/jpeg' || $cover_type == 'image/png' || $cover_type == 'image/gif') &&
            ($cover_size > 0 && $cover_size < MAXDATEIGROESSE)) {

            $ziel = ORDNER . $cover_name;

            if (move_uploaded_file($cover_tmp_name, $ziel)) {

                //Datei wurde in den Zielordner am Webserver verschoben. Jetzt kann der Eintrag in die DB geschrieben werden
                try {

                    require_once("dbconnection.php");
        
                    $stmt = $pdo->prepare("INSERT INTO games (sname,entwickler,releasedate,cover) VALUES (:sname, :entwickler, :releasedate, :cover)");
        
                    $stmt->bindParam(":sname", $sname);
                    $stmt->bindParam(":entwickler", $entwickler);
                    $stmt->bindParam(":releasedate", $releasedate);
                    $stmt->bindParam(":cover", $ziel);


                    $stmt->execute();
                    
                } catch (PDOException $e) {
                    if (file_exists($ziel)) {
                        unlink($ziel);
                    }
                    die("Das Insert Into ist falsch");
                }
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
<style>
        body{
            background-image: url('bilder/wp111.jpg');
            
            background-size: 100% 5%;
            color: white;
        }

        .grid-container{
            margin-top: 100px;
            margin-left: auto;
            margin-right: auto;
            width: 700px; 
            height: 500px;
            background: linear-gradient(0deg, #000, #333);
            position: relative;
  
        }

        .grid-container:before,
        .grid-container:after {
            content: "";
            position: absolute;
            background: linear-gradient(45deg, red, orange, yellow, 
            green, blue, indigo, violet);
            z-index: -1;
            width: calc(100% + 4px);
            height: calc(100% + 4px);  
            top: -2px;
            left: -2px;
            background-size: 500%;
            animation: wandernderFarbverlauf 30s linear infinite;
        }

        .header:after {
            filter: blur(25px);
        }

        @keyframes wandernderFarbverlauf {
            0%   { background-position: 0 0 }
            50%  { background-position: 500% 0 }
            100% { background-position: 0 0 }
        }

        h2{
            text-align: center;
            font-size: 50px;
            padding-top: 10px;
        }

        form {
        max-width: 400px;
        margin: 100px auto;
        font-family: Arial, sans-serif;
        margin-top: -10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: white;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }

    button {
        width: 105%;
        padding: 12px;
        background-color:rgb(87, 239, 92);
        color: black;
        font-weight: bolder;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        
    }

    button:hover {
        background-color:rgb(1, 147, 8);
    }

    .ttmmjj{
        padding: 12px;
        border: none;
        border-radius: 8px;
        color: black;


    }
    </style>

<body>

<div class="grid-container" class="formgroup">
    <h2>Gamespace - Spiele melden</h2>
    <form enctype="multipart/form-data" action="<?php
    echo($_SERVER['SCRIPT_NAME']);
    ?>" method="post">

        <label for="sname">Name:</label><br>
        <input type="text" id="sname" name="sname" required><br><br>

        
        <label for="entwickler">Entwickler:</label><br>
        <input type="text" id="entwickler" name="entwickler" required><br><br>
       
        <label for="releasedate">Release Date:</label><br>
        <input class="ttmmjj" type="date" id="releasedate" name="releasedate" required><br><br>

        <input type="file" id="cover" name="cover" required><br>
        

        <button type="submit" id="submit" name="submit">Spiel melden 
        

    </form>
    </div>
</body>
</html>

<?php
}
?>