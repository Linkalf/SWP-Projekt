<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Startseite</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url(bilder/wp_startseite.jpg);
            background-size: 100%;
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
            overflow-x: hidden;
            overflow-y: hidden;
        }

        header:before,
        header:after {
            content: "";
            position: absolute;
            background: linear-gradient(45deg, red, orange, yellow, 
            green, blue, indigo, violet);
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
            0%   { background-position: 0 0 }
            50%  { background-position: 500% 0 }
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

        select option {
            background-color: #000;
        }

        h1 {
            color:white;
            text-align: center;
            margin-top: 100px;
            font-size: 48px;
        }

        .site{

        }

        img{        
            float: left;
            border-radius: 25px;
            margin: 15px;
        }

        .topagamespics{
            margin-left: 25px;
        }
    </style>
</head>
<body>

<header>
    <a href="liste.php" class="center-link">Gamespace-Spieleliste</a>
    <a href="spielmelden.php" class="center-link" style="margin-left: -30px;">Gamespace-Spiele melden</a>    
    <select name="konto" id="konto" onchange="window.location.href=this.value">
        <option value="" disabled selected hidden >Konto</option>
        <option value="registrieren.php">Registrieren</option>
        <option value="login.php">Login</option>
        <option value="logout.php">Logout</option>
    </select>
</header>

<div class="site">
        <?php 
        if(isset($_SESSION ['bname'])){
            echo '<h1>Willkommen, ' . $_SESSION['bname']. '!</h1>';
        }else {
            echo '<h1>Willkommen!</h1>';
        }
        ?>
</div>

<div class="topagmesheader" style="text-align: center;"> neue Spiele für 2025</div>
<div class="topagamespics">
    <img src="bilder/st_doom.png">
    <img src="bilder/st_sf.png">
    <img src="bilder/st_exp33.png">
    <img src="bilder/st_kcd2.png">
    <img src="bilder/st_acs.png">
    <img src="bilder/st_sc1.png">
    <img src="bilder/st_eso.png">
    <img src="bilder/st_repo.png">
</div>

<div class="topagamespics">
    <img src="bilder/st_mhw.png">
    <img src="bilder/st_lr.png">
    <img src="bilder/st_tfb.png">
    <img src="bilder/st_rotsp.png">
    <img src="bilder/st_som.png">
    <img src="bilder/st_yaku.png">
    <img src="bilder/st_avow.png">
    <img src="bilder/st_civi.png">
</div>


</body>
</html>
