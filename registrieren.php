<?php
session_start();
require_once("dbconnection.php");
//überprüft ob die Formularfelder ausgefüllt sind
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['bname'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    // Password hashen
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Überprüfen ob Benutzer bereits existiert
        $check_sql = "SELECT * FROM user WHERE bname = ?";
        $check_stmt = $pdo->prepare($check_sql);
        $check_stmt->execute([$username]);

        if ($check_stmt->rowCount() > 0) {
            $error = "Benutzername existiert bereits";
        } else {
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registrierung</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #000;
            color: white;
        }

        header {
            width: 100%;
            height: 120px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            background: linear-gradient(0deg, #000, #333);
            padding: 20px 40px;
            border-bottom: 2px solid #0f0;
        }

        header:before,
        header:after {
            content: "";
            position: absolute;
            background: linear-gradient(45deg, red, orange, yellow, green, blue, indigo, violet);
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
            0% { background-position: 0 0 }
            50% { background-position: 500% 0 }
            100% { background-position: 0 0 }
        }

        .nav-links {
            display: flex;
            gap: 30px;
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

        .spiel-melden {
            margin-left: 375px; /* Leicht nach links verschoben */
        }

        select {
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            background-color: #222;
            color: white;
        }

        .register-form {
            max-width: 320px;
            margin: 80px auto;
            padding: 25px 30px;
            border-radius: 16px;
            background: linear-gradient(0deg, #000, #333);
            border: 2px solid #0f0;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.2);
        }

        .register-form h2 {
            text-align: center;
            color: #0f0;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            margin-bottom: 20px;
            border-radius: 8px;
            border: none;
            background-color: #111;
            color: white;
            font-size: 14px;
        }

        input[type="submit"] {
            background-color: #0f0;
            color: black;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #00cc00;
        }

        .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }

        p a {
            color: #0f0;
            text-decoration: none;
        }

        p a:hover {
            text-decoration: underline;
        }

        .password-container {
            display: flex;
            align-items: center;
            background-color: #111;
            border: none;
            border-radius: 8px;
            padding: 0 10px;
            margin-bottom: 20px;
        }

        .password-container input[type="password"],
        .password-container input[type="text"] {
            flex: 1;
            background: transparent;
            border: none;
            color: white;
            font-size: 14px;
            padding: 10px 0;
            outline: none;
        }

        .eye-button {
            background: none;
            border: none;
            color: #0f0;
            font-size: 18px;
            cursor: pointer;
            margin-left: 8px;
        }
    </style>
</head>
<body>

<header>
    <div class="nav-links">
        <a href="startseite.php" class="center-link">Gamespace-Startseite</a>
        <a href="spielmelden.php" class="center-link spiel-melden">Gamespace-Spiele melden</a>
    </div>
    <select name="konto" id="konto" onchange="window.location.href=this.value">
        <option value="" disabled selected hidden>Konto</option>
        <option value="registrieren.php">Registrieren</option>
        <option value="login.php">Login</option>
        <option value="logout.php">Logout</option>
    </select>
</header>

<div class="register-form">
    <h2>Registrierung</h2>

    <?php if (isset($error)) echo "<div class='error-message'>$error</div>"; ?>

    <form method="POST" action="">
        <label for="bname">Benutzername:</label>
        <input type="text" id="bname" name="bname" required />

        <label for="email">E-Mail:</label>
        <input type="email" id="email" name="email" required />

        <label for="password">Passwort:</label>
        <div class="password-container">
            <input type="password" id="password" name="password" required />
            <button type="button" onclick="togglePassword()" class="eye-button">👁️</button>
        </div>

        <input type="submit" value="Registrieren" />
    </form>

    <p>Bereits registriert? <a href="login.php">Zum Login</a></p>
</div>

<script>
function togglePassword() {
    const pw = document.getElementById("password");
    pw.type = pw.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
