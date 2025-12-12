<?php 
// inscription.php
require 'config.php'; 

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et encodage des données
    $login = htmlspecialchars($_POST['login']);
    $pass = sha1($_POST['password']); 
    $prenom = utf8_encode(htmlspecialchars($_POST['prenom']));
    $nom = utf8_encode(htmlspecialchars($_POST['nom']));
    
    // Gravatar par défaut (doit être un nom de fichier existant dans photos/gravatars/)
    // Utilisation de 'PPdéfaut.jpg' comme demandé, le caractère 'é' est géré par l'encodage.
    $gravatar_defaut = 'PPdéfaut.jpg'; 
    
    $sql = "INSERT INTO membres (login, password, prenom, nom, statut, gravatar) VALUES (?, ?, ?, ?, 'membre', ?)";
    $stmt = $pdo->prepare($sql);
    
    if($stmt->execute([$login, $pass, $prenom, $nom, $gravatar_defaut])) {
        $message = "<p style='color:green'>Inscrit avec succès ! <a href='connexion.php'>Se connecter</a></p>";
    } else {
        $message = "<p style='color:red'>Erreur lors de l'inscription.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Koo2Fourchette</title>
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
        .btn-creer-compte {
            background-color: var(--couleur-bleu-roi); 
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
        <h2 class="section-title" style="text-align:center;">Créer un compte</h2>
        
        <?php echo utf8_decode($message); ?>
        
        <form method="POST">
            <label for="login">Login :</label>
            <input type="text" id="login" name="login" required>
            
            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>
            
            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>
            
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>
            
            <button type="submit" class="btn-creer-compte">S'inscrire</button>
        </form>
    </div>
</div>
</body>
</html>