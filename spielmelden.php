<?php
require_once("appKonstanten.php");

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

            try {

                require_once("dbconnection.php");

                $stmt = $pdo->prepare("INSERT INTO games (sname, entwickler, releasedate, cover) VALUES (:sname, :entwickler, :releasedate, :cover)");

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
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Spiel melden</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #000;
            color: white;
        }

        header {
            width: 100%;
            height: 120px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            background: linear-gradient(0deg, #000, #333);
            padding: 20px 40px;
            border-bottom: 2px solid #0f0;
        }

        header:before,
        header:after {
            content: "";
            position: absolute;
            background: linear-gradient(45deg, red, orange, yellow, green, blue, indigo, violet);
            z-index: -1;
            width: calc(100% + 4px);
            height: calc(100% + 4px);
            background-size: 500%;
            top: -2px;
            left: -2px;
            animation: wandernderFarbverlauf 30s linear infinite;
        }

        header:after {
            filter: blur(25px);
        }

        @keyframes wandernderFarbverlauf {
            0% { background-position: 0 0 }
            50% { background-position: 500% 0 }
            100% { background-position: 0 0 }
        }

        .nav-links {
            display: flex;
            gap: 30px;
        }

        .center-link {
            color: #0f0;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            align-self: center;
        }

        .center-link:hover {
            text-decoration: underline;
        }

        select {
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            background-color: #222;
            color: white;
            cursor: pointer;
        }

        /* Formularcontainer */
        .form-container {
            max-width: 700px;
            margin: 60px auto 100px auto;
            padding: 30px 40px;
            border-radius: 16px;
            background: linear-gradient(0deg, #000, #333);
            border: 2px solid #0f0;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.2);
            font-family: Arial, sans-serif;
        }

        .form-container h2 {
            text-align: center;
            color: #0f0;
            margin-bottom: 40px;
            font-size: 48px;
            font-weight: 900;
            text-shadow: 0 0 10px #0f0;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: white;
            font-size: 16px;
        }

        input[type="text"],
        input[type="date"],
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 25px;
            border: none;
            border-radius: 8px;
            background-color: #111;
            color: white;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 105%;
            padding: 12px;
            background-color: rgb(87, 239, 92);
            color: black;
            font-weight: bolder;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 15px;
            display: block;
            margin-left: -15px;
        }

        button:hover {
            background-color: rgb(1, 147, 8);
        }
    </style>
</head>
<body>

<header>
    <div class="nav-links">
        <a href="startseite.php" class="center-link">Gamespace-Startseite</a>
        <a href="liste.php" class="center-link" style="margin-left: 375px;">Gamespace-Spieleliste</a>
    </div>
    <select name="konto" id="konto" onchange="window.location.href=this.value">
        <option value="" disabled selected hidden>Konto</option>
        <option value="registrieren.php">Registrieren</option>
        <option value="login.php">Login</option>
        <option value="logout.php">Logout</option>
    </select>
</header>

<div class="form-container">
    <h2>Gamespace - Spiele melden</h2>
    <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['SCRIPT_NAME']); ?>" method="post">

        <label for="sname">Name:</label>
        <input type="text" id="sname" name="sname" required />

        <label for="entwickler">Entwickler:</label>
        <input type="text" id="entwickler" name="entwickler" required />
       
        <label for="releasedate">Release Date:</label>
        <input type="date" id="releasedate" name="releasedate" required />

        <label for="cover">Cover Bild:</label>
        <input type="file" id="cover" name="cover" required />

        <button type="submit" id="submit" name="submit">Spiel melden</button>
    </form>
</div>

</body>
</html>

<?php
}
?>
