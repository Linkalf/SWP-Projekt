<?php
session_start();
session_unset();
session_destroy();
//Weiterleitung zur Login-Seite
header('Location: login.php');
//Beendet das Skript
exit();

?>