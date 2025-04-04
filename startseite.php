<?php

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satrtseite</title>
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

    <h1>Gamespace - Startseite</h1>

    

</body>
</html>
