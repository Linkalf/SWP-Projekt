<?php
if(){


}else{
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Satrtseite</title>
</head>
<body>
    <h1>Gamespace - Spieleliste</h1>

    
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

<?php
}
?>