<?php

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

    </style>
</head>
<body>

<div class="header">
  <h1 class="headertext">Gamespace-Spieleliste</h1>
</div>

    
    <?php include('header.php'); ?>
    <?php 
        if(isset($_SESSION ['bname'])){
            echo '<h1>Willkommen, ' . $_SESSION('username') . '!</h1>';
        }else {
            echo '<h1>Willkommen!</h1>';
        }
    ?>
    <h1>Alle Spiele: </h1>

    <?php if (count($results) > 0): ?>
        <?php foreach ($results as $row): ?>

            <h3><?php echo(htmlspecialchars($row['name'])); ?></h3>
            <h3><?php echo(htmlspecialchars($row['entwickler'])); ?></h3>
            <h3><?php echo(htmlspecialchars($row['release'])); ?></h3>

        <?php endforeach; ?>
    <?php else: ?>
        <p>Noch keine Spiele gefunden</p>
    <?php endif; ?>

</body>
</html>
