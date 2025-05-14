<?php
session_start();
require_once("dbconnection.php");

try {

    $sql = "SELECT * FROM games";
    $stmt = $pdo->query($sql);

    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("keine spiele gefunden");
}
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satrtseite</title>


    <style>

        body{ 
            background-color: black;
            color: white
            }

        .header {
            width: 1300px; 
            height: 220px;
            margin: 50px auto;
            background: linear-gradient(0deg, #000, #333);
            position: relative;
        }

        .header:before,
        .header:after {
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

        .headertext{
            text-align: center;
            padding-top: 50px;
            font-size: 100px;
        }

        img {
        border-radius: 8px;
        box-shadow: 0 0 10px #888;
        margin-bottom: 20px;
        }


        .spiel-eintrag {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    background-color: #222;
    padding: 8px 12px;
    border-radius: 10px;
    max-width: 600px;
    height: 100px; /* feste Höhe für alles */
    box-shadow: 0 0 5px rgba(255,255,255,0.1);
}

.spiel-infos {
    flex: 1;
    color: white;
    font-size: 16px;
    padding-right: 10px;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
}

.spiel-cover img {
    height: 80px;
    width: 80px;
    object-fit: cover;
    border-radius: 8px;
    box-shadow: 0 0 5px #111;
}

    </style>
</head>
<body>

<header>
        <a href="liste.php" class="center-link">Gamespace-Spieleliste</a>

        <a href="spielmelden.php" class="center-link">Gamespace-Spiele melden</a>

    
    
    <select name="konto" id="konto" onchange="window.location.href=this.value">
        <option value="" disabled selected hidden>Konto</option>
        <option value="registrieren.php">Registrieren</option>
        <option value="login.php">Login</option>
        <option value="logout.php">Logout</option>
    </select>
</header>

<div class="header">
  <h1 class="headertext">Gamespace-Spieleliste</h1>
</div>

    
    <?php 
        /*if(isset($_SESSION ['sname'])){
            echo '<h1>Willkommen, ' . $_SESSION('username') . '!</h1>';
        }else {*/
            echo '<h1>Willkommen!</h1>';
        //}
    ?>
    <h1>Alle Spiele: </h1>

    <?php if (count($results) > 0): ?>
        <?php foreach ($results as $row): ?>

            <div class="spiel-eintrag">
    <div class="spiel-infos">
        <span class="spiel-text">
            <?php echo htmlspecialchars($row['sname']) . ' - ' . htmlspecialchars($row['entwickler']) . ' - ' . htmlspecialchars($row['releasedate']); ?>
        </span>
    </div>
    <?php if (!empty($row['cover'])): ?>
        <div class="spiel-cover">
            <img src="<?php echo htmlspecialchars($row['cover']); ?>" alt="Cover von <?php echo htmlspecialchars($row['sname']); ?>">
        </div>
    <?php endif; ?>
</div>


        <?php endforeach; ?>
    <?php else: ?>
        <p>Noch keine Spiele gefunden</p>
    <?php endif; ?>

</body>
</html>
