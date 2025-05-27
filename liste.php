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
    <title>Spieleliste</title>

        <style>




        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: black;
            color: white;
        }


        header {
            width: auto;
            height: 120px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            background: linear-gradient(0deg, #000, #333);
            padding: 20px 40px;
            border-bottom: 2px solid #0f0;
            margin-left: -20px;
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

        .center-link {
            color: #0f0;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
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
        }

        h1 {
            color: white;
            text-align: center;
            margin-top: 30px;
        }

        .spiel-eintrag {
            display: flex;
            align-items: center;
            margin: 20px auto;
            background-color: #222;
            padding: 10px 20px;
            border-radius: 12px;
            max-width: 800px;
            box-shadow: 0 0 10px rgba(0, 255, 0, 0.1);
        }

        .spiel-infos {
            flex: 1;
            font-size: 16px;
            color: white;
            overflow: hidden;
        }

        .spiel-cover img {
            height: 80px;
            width: 80px;
            object-fit: cover;
            border-radius: 12px;
            margin-left: 15px;
            box-shadow: 0 0 8px #0f0;
        }

        .star-button {
            font-size: 24px;
            background: none;
            border: none;
            color: gold;
            cursor: pointer;
            margin-top: 5px;
        }

        .favorite-count {
            font-size: 14px;
            margin-left: 10px;
            color: #ccc;
        }
    </style>

</head>

<body>

    <header>
        <a href="startseite.php" class="center-link">Gamespace-Startseite</a>

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
    <?php
        $isFavorite = false;
        $favoriteCount = 0;

        if (isset($_SESSION['user_id'])) {
            $checkSql = "SELECT * FROM favoriten WHERE user_id = ? AND game_id = ?";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([$_SESSION['user_id'], $row['id']]);
            $isFavorite = $checkStmt->rowCount() > 0;
        }

        $countStmt = $pdo->prepare("SELECT COUNT(*) FROM favoriten WHERE game_id = ?");
        $countStmt->execute([$row['id']]);
        $favoriteCount = $countStmt->fetchColumn();
    ?>
    
    <div class="spiel-eintrag">
        <div class="spiel-infos">
            <span class="spiel-text">
                <?php echo htmlspecialchars($row['sname']) . ' - ' . htmlspecialchars($row['entwickler']) . ' - ' . htmlspecialchars($row['releasedate']); ?>
            </span>
            <br>
            <button class="star-button" data-gameid="<?php echo $row['id']; ?>">
                <?php echo $isFavorite ? '★' : '☆'; ?>
            </button>
            <span class="favorite-count" id="count-<?php echo $row['id']; ?>">
                <?php echo $favoriteCount; ?> Nutzer
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

    <script>
        document.querySelectorAll('.star-button').forEach(button => {
            button.addEventListener('click', function () {
                const gameId = this.getAttribute('data-gameid');
                fetch('toggle_favorite.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'game_id=' + gameId
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'added') {
                            this.textContent = '★';
                        } else if (data.status === 'removed') {
                            this.textContent = '☆';
                        } else {
                            alert('Fehler: ' + data.status);
                        }

                        // Zähle aktualisieren
                        const countSpan = document.getElementById('count-' + gameId);
                        if (countSpan) {
                            countSpan.textContent = data.count + ' Nutzer';
                        }
                    });
            });
        });

    </script>


</body>

</html>