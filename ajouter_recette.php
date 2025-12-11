<?php require 'config.php'; ?>
<!DOCTYPE html>
<html>
<head><link rel="stylesheet" href="style.css"></head>
<body>
<div class="content-wrapper">
    <h2>Déposer une recette</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="titre" placeholder="Titre de la recette" required><br><br>
        <textarea name="chapo" placeholder="Description courte (Chapo)"></textarea><br><br>
        
        <label>Photo :</label>
        <input type="file" name="image" required><br><br>
        
        <input type="hidden" name="membre_id" value="1"> <button type="submit" class="btn-deposer">Envoyer la recette</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
        $titre = $_POST['titre'];
        $chapo = $_POST['chapo'];
        $imgName = $_FILES['image']['name'];
        
        // Upload de l'image
        move_uploaded_file($_FILES['image']['tmp_name'], "koo2fourchette/photos/recettes/" . $imgName);

        $sql = "INSERT INTO recettes (titre, chapo, img, membre, categorie, difficulte, prix, tempsPreparation, tempsCuisson, preparation, ingredient, couleur) 
                VALUES (?, ?, ?, 1, 1, 'Facile', 'Moyen', '30 min', '15 min', 'A faire...', 'Liste...', 'fushia')";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $chapo, $imgName]);
        
        echo "<p>Recette ajoutée ! <a href='index.php'>Retour à l'accueil</a></p>";
    }
    ?>
</div>
</body>
</html>