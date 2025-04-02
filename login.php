<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Hier sollte die Validierung gegen eine Datenbank erfolgen
    // Dies ist nur ein Beispiel - in der Praxis sollten Passwörter gehasht sein
    if ($username === "admin" && $password === "password123") {
        $_SESSION['loggedin'] = true;
        $_SESSION['username'] = $username;
        header("Location: startseite.php");
        exit;
    } else {
        $error = "Ungültiger Benutzername oder Passwort";
    }
} else {
    ?>
    
    <!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
    </style>
</head>
<body>
    <div class="grid-container">
        <h2>Login</h2>
        <?php if (isset($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Benutzername:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Passwort: </label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit">Anmelden</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
}
?>



