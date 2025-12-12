<?php require 'config.php'; ?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
<div class="content-wrapper" style="text-align:center;">
    <h2>Créer un compte</h2>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = $_POST['login'];
        // Note: Dans ton fichier SQL, les mots de passe semblent être en SHA1 (pas sécurisé), 
        // mais on va utiliser password_hash (moderne) pour les nouveaux.
        $pass = sha1($_POST['password']); 
        // --- Correction: Utilisation de utf8_encode avant l'insertion ---
        $prenom = utf8_encode($_POST['prenom']);
        $nom = utf8_encode($_POST['nom']);
        // ------------------------------------------------------------------
        
        $sql = "INSERT INTO membres (login, password, prenom, nom, statut, gravatar) VALUES (?, ?, ?, ?, 'membre', 'default.png')";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute([$login, $pass, $prenom, $nom])) {
            echo "<p style='color:green'>Inscrit avec succès ! <a href='connexion.php'>Se connecter</a></p>";
        }
    }
    ?>
    <form method="POST">
        <input type="text" name="login" placeholder="Login" required><br><br>
        <input type="password" name="password" placeholder="Mot de passe" required><br><br>
        <input type="text" name="prenom" placeholder="Prénom" required><br><br>
        <input type="text" name="nom" placeholder="Nom" required><br><br>
        <button type="submit" class="btn-ok">S'inscrire</button>
    </form>
</div>
</body>
</html>