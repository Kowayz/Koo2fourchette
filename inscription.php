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
        $pass = sha1($_POST['password']); 
        // Correction: Utilisation de utf8_encode avant l'insertion
        $prenom = utf8_encode($_POST['prenom']);
        $nom = utf8_encode($_POST['nom']);
        
        // CORRECTION GRAVATAR : Stocker le nom du fichier PPdéfaut.jpg
        $gravatar_defaut = 'PPdéfaut.jpg'; 
        
        $sql = "INSERT INTO membres (login, password, prenom, nom, statut, gravatar) VALUES (?, ?, ?, ?, 'membre', ?)";
        $stmt = $pdo->prepare($sql);
        if($stmt->execute([$login, $pass, $prenom, $nom, $gravatar_defaut])) {
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