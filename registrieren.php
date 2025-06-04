<?php
session_start();
require_once("dbconnection.php");
//überprüft ob die Formularfelder ausgefüllt sind
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['bname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    // Passwort hashen
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    try {
            // Überprüfen ob Benutzer bereits existiert
        $check_sql = "SELECT * FROM user WHERE bname = ?";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$username]);
        
        if ($check_stmt->rowCount() > 0) {
            $error = "Benutzername existiert bereits";
        } else {
            // Neuen Benutzer einfügen
            $sql = "INSERT INTO user (bname, password, email) VALUES (?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$username, $hashed_password, $email]);
            
            header("Location: login.php");
            exit();
        }
    } catch (PDOException $e) {
        $error = "Registrierung fehlgeschlagen: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
    <style>
        body {
            background-color: black;
            color: white;
        }
        .register-form {
            width: 300px;
            margin: 50px auto;
            padding: 20px;
            background: linear-gradient(0deg, #000, #333);
            border: 1px solid #0f0;
        }
    </style>
</head>
<body>
    <div class="register-form">
        <h2>Registrierung</h2>
        <?php if(isset($error)) echo "<p style='color: red'>$error</p>"; ?>
        
        <form method="POST" action="">
            <div>
                <label for="username">Benutzername:</label><br>
                <input type="text" id="bname" name="bname" required>
            </div>
            <div>
                <label for="email">E-Mail:</label><br>
                <input type="email" id="email" name="email" required>
            </div>
            <div>
                <label for="password">Passwort:</label><br>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <input type="submit" value="Registrieren">
            </div>
        </form>
        <p>Bereits registriert? <a href="login.php">Zum Login</a></p>
    </div>
</body>
</html>
