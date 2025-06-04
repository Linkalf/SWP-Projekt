<?php
//überprüft ob der Logout-Button gedrückt wurde
if(isset($_POST['logout'])) {
    //Session zerstören
session_destroy();
//Weiterleitung zur Login-Seite
header("Location: login.php");
//Beendet das Skript
exit();
}
?>
