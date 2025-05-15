<?php
require_once("dbconnection.php");
session_start();

try {
    require('dbconnection.php');

    $stmt = $pdo->prepare("SELECT * FROM user WHERE bname = :bname");
    $stmt->bindParam(':bname', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && password_verify($password, $user['passwarod'])) {
        $_SESSION['login'] = true;
        $_SESSION['username'] = $username;
        header('Location: startseite.php');
        exit();
    } else {
        echo('Benutzername oder Passwort falsch');
    }
} catch (PDOException $e) {
    die('Fehler beim Anmelden');
}
 else {
echo('Bitte alle Felder ausfüllen');
}
else {
    ?>
    
    <!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <style>
        body{
            background-image: url('bilder/wp111.jpg');
            
            background-size: 100% 5%;
            color: white;
        }

        .grid-container{
            margin-top: 100px;
            margin-left: auto;
            margin-right: auto;
            width: 700px; 
            height: 500px;
            background: linear-gradient(0deg, #000, #333);
            position: relative;
  
        }

        .grid-container:before,
        .grid-container:after {
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

        h2{
            text-align: center;
            font-size: 80px;
            padding-top: 10px;
        }

        form {
        max-width: 400px;
        margin: 100px auto;
        font-family: Arial, sans-serif;
        margin-top: -10px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
        color: white;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 16px;
    }

    button {
        width: 105%;
        padding: 12px;
        background-color:rgb(87, 239, 92);
        color: black;
        font-weight: bolder;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        
    }

    button:hover {
        background-color:rgb(1, 147, 8);
    }
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
                <label for="password">Passwort:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <button type="submit" onclick="window.location.href='startseite.php'">Anmelden</button>
            </div>
        </form>
    </div>
</body>
</html>
<?php
}
?>



