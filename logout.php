<?php
if(isset($_POST['logout'])) {
session_destroy();
//Weiterleitung zur Login-Seite
header("Location: login.php");
//Beendet das Skript
exit();
}
?>
