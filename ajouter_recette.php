<?php
session_start();
require 'config.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
$membre_id = $_SESSION['user_id'];
$categories = getAllCategories($pdo);

$success = false;
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $titre           = trim($_POST['titre']            ?? '');
    $chapo           = trim($_POST['chapo']            ?? '');
    $preparation     = trim($_POST['preparation']      ?? '');
    $ingredient      = trim($_POST['ingredient']       ?? '');
    $tempsPrep       = trim($_POST['tempsPreparation'] ?? '');
    $tempsCuiss      = trim($_POST['tempsCuisson']     ?? '');
    $difficulte      = trim($_POST['difficulte']       ?? '');
    $prix            = trim($_POST['prix']             ?? '');
    $couleur         = trim($_POST['couleur']          ?? '');
    $categorie       = (int)($_POST['categorie']       ?? 0);

    $allowed_diff    = ['Facile', 'Moyen', 'Difficile'];
    $allowed_prix    = ['Pas cher', 'Abordable', 'Coûteux'];
    $allowed_couleur = ['fushia', 'vertClair', 'bleuClair'];

    if (empty($titre) || empty($chapo) || empty($preparation) || empty($ingredient)
        || empty($tempsPrep) || empty($tempsCuiss) || $categorie <= 0
        || !in_array($difficulte, $allowed_diff)
        || !in_array($prix, $allowed_prix)
        || !in_array($couleur, $allowed_couleur)) {
        $error = 'Veuillez remplir tous les champs correctement.';
    } else {
        $imgType = $_FILES['image']['type'];
        $ext     = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (!in_array($imgType, ['image/jpeg', 'image/png']) || !in_array($ext, ['jpg', 'jpeg', 'png'])) {
            $error = 'Seuls les formats JPG et PNG sont autorisés.';
        } else {
            $imgName    = uniqid('recette_') . '.' . $ext;
            $targetDir  = 'photos/recettes/';
            $targetFile = $targetDir . $imgName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $sql = "INSERT INTO recettes
                            (titre, chapo, img, preparation, ingredient, membre, categorie,
                             difficulte, prix, tempsPreparation, tempsCuisson, couleur)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute([
                    $titre, $chapo, $imgName, $preparation, $ingredient,
                    $membre_id, $categorie, $difficulte, $prix,
                    $tempsPrep, $tempsCuiss, $couleur
                ])) {
                    $success = true;
                } else {
                    $error = 'Erreur lors de l\'enregistrement en base de données.';
                }
            } else {
                $error = 'Erreur lors de l\'upload. Vérifiez les permissions CHMOD 777 sur ' . htmlspecialchars($targetDir);
            }
        }
    }
}

$pageTitle  = 'Déposer une recette';
$activePage = 'recettes';
require_once 'includes/header.php';
?>

<div class="page-hero hero-magenta">
    <h1>DÉPOSER UNE RECETTE</h1>
    <p>Partagez votre recette avec la communauté</p>
</div>

<main class="content-wrapper">
    <div class="form-container">
        <h2 class="section-title" style="text-align:center; margin-bottom:30px;">Nouvelle recette</h2>

        <?php if ($success): ?>
            <p style="color:green; font-weight:bold; text-align:center; padding:20px;">
                Recette ajoutée avec succès ! <a href="index.php">Retour à l'accueil</a>
            </p>
        <?php else: ?>

        <?php if ($error): ?>
            <p style="color:red; font-weight:bold; margin-bottom:20px;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label for="titre">Titre de la recette *</label>
            <input type="text" id="titre" name="titre" placeholder="Ex: Gâteau au chocolat"
                   value="<?php echo htmlspecialchars($_POST['titre'] ?? ''); ?>" required>

            <label for="chapo">Description courte *</label>
            <textarea id="chapo" name="chapo" placeholder="Décrivez votre recette en quelques lignes..." required><?php echo htmlspecialchars($_POST['chapo'] ?? ''); ?></textarea>

            <label for="categorie">Catégorie *</label>
            <select id="categorie" name="categorie" required>
                <option value="">-- Choisissez --</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?php echo (int)$cat['idCategorie']; ?>"
                    <?php if (isset($_POST['categorie']) && (int)$_POST['categorie'] === (int)$cat['idCategorie']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars(ucfirst($cat['nom'])); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="ingredient">Ingrédients *</label>
            <textarea id="ingredient" name="ingredient"
                      placeholder="Ex: 200g de farine, 3 oeufs..." required><?php echo htmlspecialchars($_POST['ingredient'] ?? ''); ?></textarea>

            <label for="preparation">Préparation *</label>
            <textarea id="preparation" name="preparation"
                      placeholder="Décrivez les étapes de préparation..." required><?php echo htmlspecialchars($_POST['preparation'] ?? ''); ?></textarea>

            <div class="form-row">
                <div class="form-col">
                    <label for="tempsPreparation">Temps de préparation *</label>
                    <input type="text" id="tempsPreparation" name="tempsPreparation"
                           placeholder="Ex: 20 min"
                           value="<?php echo htmlspecialchars($_POST['tempsPreparation'] ?? ''); ?>" required>
                </div>
                <div class="form-col">
                    <label for="tempsCuisson">Temps de cuisson *</label>
                    <input type="text" id="tempsCuisson" name="tempsCuisson"
                           placeholder="Ex: 30 min"
                           value="<?php echo htmlspecialchars($_POST['tempsCuisson'] ?? ''); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="difficulte">Difficulté *</label>
                    <select id="difficulte" name="difficulte" required>
                        <option value="">-- Choisissez --</option>
                        <?php foreach (['Facile','Moyen','Difficile'] as $d): ?>
                        <option value="<?php echo $d; ?>"
                            <?php if (isset($_POST['difficulte']) && $_POST['difficulte'] === $d) echo 'selected'; ?>>
                            <?php echo $d; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="prix">Budget *</label>
                    <select id="prix" name="prix" required>
                        <option value="">-- Choisissez --</option>
                        <?php foreach (['Pas cher','Abordable','Coûteux'] as $p): ?>
                        <option value="<?php echo $p; ?>"
                            <?php if (isset($_POST['prix']) && $_POST['prix'] === $p) echo 'selected'; ?>>
                            <?php echo $p; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <label for="couleur">Couleur de la carte *</label>
            <select id="couleur" name="couleur" required>
                <option value="">-- Choisissez --</option>
                <option value="fushia"    <?php if (isset($_POST['couleur']) && $_POST['couleur'] === 'fushia')    echo 'selected'; ?>>Rose Fushia</option>
                <option value="vertClair" <?php if (isset($_POST['couleur']) && $_POST['couleur'] === 'vertClair') echo 'selected'; ?>>Vert Anis</option>
                <option value="bleuClair" <?php if (isset($_POST['couleur']) && $_POST['couleur'] === 'bleuClair') echo 'selected'; ?>>Bleu</option>
            </select>

            <label for="image">Photo (JPG ou PNG) *</label>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png" required>

            <button type="submit" class="btn-deposer" style="margin-top:20px;">Envoyer la recette</button>

        </form>

        <?php endif; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
