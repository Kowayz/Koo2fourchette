<?php 
// ajouter_recette.php
session_start();
require 'config.php';

// Vérification de la connexion de l'utilisateur (sécurité)
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// Récupération de l'ID du membre connecté
$membre_id = $_SESSION['user_id']; 

?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
<div class="content-wrapper">
    <h2>Déposer une recette</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="Titre de la recette" required><br><br>
        <textarea name="chapo" placeholder="Description courte (Chapo)" required></textarea><br><br>
        <textarea name="preparation" placeholder="Étapes de préparation" required></textarea><br><br>
        <textarea name="ingredients" placeholder="Liste des ingrédients" required></textarea><br><br>
        
        <label>Photo (nom du fichier : `nom-image.jpg`) :</label>
        <input type="file" name="image" required><br><br>
        
        <label>Temps Préparation :</label><input type="text" name="temps_prep" value="15 min" required><br><br>
        <label>Temps Cuisson :</label><input type="text" name="temps_cuisson" value="30 min" required><br><br>
        <label>Difficulté :</label>
        <select name="difficulte" required>
            <option value="Facile">Facile</option>
            <option value="Moyen">Moyen</option>
            <option value="Difficile">Difficile</option>
        </select><br><br>
        <label>Prix :</label>
        <select name="prix" required>
            <option value="Pas cher">Pas cher</option>
            <option value="Abordable">Abordable</option>
            <option value="Cher">Cher</option>
        </select><br><br>
        <label>Catégorie (1:viande, 2:légume, 3:poisson, 4:fruit) :</label><input type="number" name="categorie" value="2" required><br><br>
        <label>Couleur d'affichage (fushia, vertClair, bleuClair) :</label><input type="text" name="couleur" value="fushia" required><br><br>
        
        <button type="submit" class="btn-deposer">Envoyer la recette</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
        // --- Correction: Utilisation de utf8_encode avant l'insertion ---
        $titre = utf8_encode($_POST['titre']);
        $chapo = utf8_encode($_POST['chapo']);
        $preparation = utf8_encode($_POST['preparation']);
        $ingredients = utf8_encode($_POST['ingredients']);
        
        // Champs secondaires
        $temps_prep = htmlspecialchars($_POST['temps_prep']);
        $temps_cuisson = htmlspecialchars($_POST['temps_cuisson']);
        $difficulte = htmlspecialchars($_POST['difficulte']);
        $prix = htmlspecialchars($_POST['prix']);
        $categorie = (int)$_POST['categorie'];
        $couleur = htmlspecialchars($_POST['couleur']);
        // ------------------------------------------------------------------
        
        $imgName = $_FILES['image']['name'];
        
        // Upload de l'image (chemin corrigé lors de la réponse précédente)
        if (move_uploaded_file($_FILES['image']['tmp_name'], "photos/recettes/" . $imgName)) {

            // Requête INSERT corrigée pour utiliser tous les champs et l'ID de session
            $sql = "INSERT INTO recettes (titre, chapo, img, membre, categorie, difficulte, prix, tempsPreparation, tempsCuisson, preparation, ingredient, couleur) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $pdo->prepare($sql);
            if ($stmt->execute([
                $titre, $chapo, $imgName, $membre_id, $categorie, $difficulte, $prix, 
                $temps_prep, $temps_cuisson, $preparation, $ingredients, $couleur
            ])) {
                echo "<p style='color:green; font-weight:bold;'>Recette ajoutée avec succès ! <a href='index.php'>Retour à l'accueil</a></p>";
            } else {
                 echo "<p style='color:red; font-weight:bold;'>Erreur lors de l'enregistrement en base de données.</p>";
            }

        } else {
            echo "<p style='color:red; font-weight:bold;'>Erreur lors de l'upload de l'image.</p>";
        }
    }
    ?>
</div>
</body>
</html>