<?php
// connexion.php
session_start(); 
require 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = sha1($_POST['password']); 

    $sql = "SELECT * FROM membres WHERE login = ? AND password = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Encodage du prénom pour l'affichage dans la session
        $_SESSION['user_id'] = $user['idMembre'];
        $_SESSION['pseudo'] = $user['login'];
        $_SESSION['prenom'] = utf8_decode($user['prenom']); 
        
        header("Location: index.php");
        exit();
    } else {
        $message = "Mauvais identifiant ou mot de passe !";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - Koo2Fourchette</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container {
            max-width: 500px;
            margin: 40px auto;
            padding: 30px;
            background: #f4f4f4;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: left;
        }
        .auth-container input[type="text"],
        .auth-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .btn-connecter {
            background-color: var(--couleur-vert-anis); 
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            display: block;
            text-transform: uppercase;
            margin-top: 10px;
        }
        .link-inscription {
             text-align: center; 
             margin-top: 15px;
        }
    </style>
</head>
<body>

<header class="header-container">
    <div class="header-content">
        <div class="logo-section">
            <a href="index.php">
                <img src="images/koo_2_fourchette.png" alt="Logo" class="site-logo">
            </a>
        </div>
    </div>
</header>

<div class="content-wrapper">
    <div class="auth-container">
        <h2 class="section-title" style="text-align:center;">Connexion</h2>
        
        <?php if($message): ?>
            <p style="color:red; text-align:center; font-weight:bold;"><?php echo utf8_decode($message); ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="login">Login :</label>
            <input type="text" id="login" name="login" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <button type="submit" class="btn-connecter">Se connecter</button>
        </form>
        
        <p class="link-inscription">
            Pas encore de compte ? <a href="inscription.php">S'inscrire ici</a>
        </p>
    </div>
</div>

</body>
</html>