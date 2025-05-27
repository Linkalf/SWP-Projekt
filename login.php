<?php
session_start();
if (isset($_POST['submit'])) {
    if (!empty($_POST['bname']) && !empty($_POST['password'])) {
        $bname = htmlspecialchars(trim($_POST['bname']));
        $password = htmlspecialchars($_POST['password']);

        try {
            require_once("dbconnection.php");

            $stmt = $pdo->prepare("SELECT * FROM user WHERE bname = :bname");
            $stmt->bindParam(':bname', $bname);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($user) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['bname'] = $bname;
                    $_SESSION['user_id'] = $user['id'];
                    header('Location: startseite.php');
                    exit();
                } else {
                    $error = "Falsches Passwort";
                }
            } else {
                $error = "Benutzername nicht gefunden";
            }
        } catch (PDOException $e) {
            $error = "Fehler beim Anmelden: " . $e->getMessage();
        }
    } else {
        $error = "Bitte alle Felder ausfüllen";
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
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
            margin-left: 375px;
        }

        select {
            padding: 10px;
            border-radius: 5px;
            border: none;
            font-size: 16px;
            background-color: #222;
            color: white;
        }

        .login-form {
            max-width: 320px;
            margin: 80px auto;
            padding: 25px 30px;
            border-radius: 16px;
            background: linear-gradient(0deg, #000, #333);
            border: 2px solid #0f0;
            box-shadow: 0 0 15px rgba(0, 255, 0, 0.2);
        }

        .login-form h2 {
            text-align: center;
            color: #0f0;
        }

        input[type="text"],
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

        p {
            margin-bottom: 0;
            text-align: center;
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

<div class="login-form">
    <h2>Login</h2>

    <?php if (isset($error)) echo "<div class='error-message'>$error</div>"; ?>

    <form method="POST" action="">
        <label for="bname">Benutzername:</label>
        <input type="text" id="bname" name="bname" required />

        <label for="password">Passwort:</label>
        <div class="password-container">
            <input type="password" id="password" name="password" required />
            <button type="button" onclick="togglePassword()" class="eye-button">👁️</button>
        </div>

        <input type="submit" name="submit" value="Anmelden" />
    </form>

    <p>Noch kein Konto? <a href="registrieren.php">Registrieren</a></p>
</div>

<script>
function togglePassword() {
    const pw = document.getElementById("password");
    pw.type = pw.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
