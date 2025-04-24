<?php

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
            background: linear-gradient(to right, #000000, #111111);
            background-image: repeating-linear-gradient(
                to right,
                rgba(255, 255, 255, 0.1),
                rgba(255, 255, 255, 0.1) 1px,
                transparent 1px,
                transparent 30px
            );
            color: white;
        }

        header {
            width: auto; 
            height: 220px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position:relative;
            background: linear-gradient(0deg, #000, #333);
            padding: 20px 40px;
            border-bottom: 2px solid #0f0;
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
            color:black;
            text-align: center;
            margin-top: 100px;
            font-size: 48px;
        }
    </style>
</head>
<body>

<header>
    <a href="liste.php" class="center-link">Gamespace-Spieleliste</a>

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
