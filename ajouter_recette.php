<?php 
// ajouter_recette.php
session_start();
require 'config.php';

// Redirection si l'utilisateur n'est pas connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
$membre_id = $_SESSION['user_id']; 

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Déposer une recette</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            max-width: 600px;
            margin: 40px auto;
            padding: 30px;
            background: #f4f4f4;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-container input[type="text"],
        .form-container textarea,
        .form-container input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .form-container textarea {
            min-height: 120px;
            resize: vertical;
        }
        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: var(--couleur-texte);
        }
        .btn-deposer {
            /* Utilise le style existant du fichier style.css */
            display: block !important; 
            width: 100%;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
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
    <div class="form-container">
        <h2 class="section-title" style="text-align:center; margin-bottom: 30px;">Déposer une recette</h2>
        
        <form method="POST" enctype="multipart/form-data">
            
            <label for="titre">Titre de la recette :</label>
            <input type="text" id="titre" name="titre" placeholder="Ex: Gâteau au chocolat" required>
            
            <label for="chapo">Description courte (Chapo) :</label>
            <textarea id="chapo" name="chapo" placeholder="Décrivez votre recette en quelques lignes..." required></textarea>
            
            <label for="image">Photo (PNG ou JPG) :</label>
            <input type="file" id="image" name="image" accept=".jpg, .jpeg, .png" required>
            
            <button type="submit" class="btn-deposer">Envoyer la recette</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
            // Utilisation de utf8_encode pour l'insertion
            $titre = utf8_encode(htmlspecialchars($_POST['titre']));
            $chapo = utf8_encode(htmlspecialchars($_POST['chapo']));
            
            $imgName = $_FILES['image']['name'];
            $imgTmpName = $_FILES['image']['tmp_name'];
            $imgType = $_FILES['image']['type'];

            // Vérification du type de fichier (JPG ou PNG)
            $allowed_types = ['image/jpeg', 'image/png'];
            if (!in_array($imgType, $allowed_types)) {
                 echo "<p style='color:red; font-weight:bold; margin-top: 15px;'>Erreur : Seuls les formats JPG et PNG sont autorisés.</p>";
                 exit;
            }

            $target_dir = "photos/recettes/";
            $target_file = $target_dir . basename($imgName);

            // Tenter l'upload
            if (move_uploaded_file($imgTmpName, $target_file)) {

                // Insertion en base de données avec des valeurs par défaut pour les champs manquants
                $sql = "INSERT INTO recettes (titre, chapo, img, membre, categorie, difficulte, prix, tempsPreparation, tempsCuisson, preparation, ingredient, couleur) 
                        VALUES (?, ?, ?, ?, 2, 'Facile', 'Pas cher', '20 min', '10 min', 'Préparation par défaut.', 'Ingrédients par défaut.', 'fushia')";
                
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute([$titre, $chapo, $imgName, $membre_id])) {
                    echo "<p style='color:green; font-weight:bold; margin-top: 15px;'>Recette ajoutée avec succès ! <a href='index.php'>Retour à l'accueil</a></p>";
                } else {
                     echo "<p style='color:red; font-weight:bold; margin-top: 15px;'>Erreur lors de l'enregistrement en base de données.</p>";
                }

            } else {
                // Avertissement de permission (pour le serveur en ligne)
                echo "<p style='color:red; font-weight:bold; margin-top: 15px;'>Erreur lors de l'upload de l'image. Vérifiez les permissions d'écriture (CHMOD 777) sur le dossier <code>{$target_dir}</code>.</p>";
            }
        }
        ?>
    </div>
</div>
</body>
</html>