<?php
session_start(); // Toujours démarrer la session au tout début
require 'config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login = $_POST['login'];
    $password = sha1($_POST['password']); // On crypte le MDP saisi pour le comparer

    // On cherche l'utilisateur dans la base
    $sql = "SELECT * FROM membres WHERE login = ? AND password = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$login, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // C'est gagné ! On enregistre les infos dans la session
        $_SESSION['user_id'] = $user['idMembre'];
        $_SESSION['pseudo'] = $user['login'];
        // Correction de l'encodage pour le prénom
        $_SESSION['prenom'] = utf8_decode($user['prenom']); 
        
        // Redirection vers l'accueil
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

<div class="content-wrapper" style="max-width:500px; margin: 0 auto; padding-bottom: 50px;">
    <h2 class="section-title" style="text-align:center;">Connexion</h2>
    
    <?php if($message): ?>
        <p style="color:red; text-align:center; font-weight:bold;"><?php echo utf8_decode($message); ?></p>
    <?php endif; ?>

    <form method="POST" style="background:#f4f4f4; padding:20px; border:1px solid #ddd;">
        <div style="margin-bottom:15px;">
            <label>Login :</label><br>
            <input type="text" name="login" required style="width:100%; padding:8px;">
        </div>
        
        <div style="margin-bottom:15px;">
            <label>Mot de passe :</label><br>
            <input type="password" name="password" required style="width:100%; padding:8px;">
        </div>

        <button type="submit" class="btn-ok" style="width:100%; cursor:pointer;">Se connecter</button>
    </form>
    
    <p style="text-align:center; margin-top:15px;">
        Pas encore de compte ? <a href="inscription.php">S'inscrire ici</a>
    </p>
</div>

</body>
</html>