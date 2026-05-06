<?php
session_start();
require_once 'config.php';
$pageTitle  = 'Desserts';
$activePage = 'deserts';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>
<div class="page-hero hero-bleu">
        <h1>DESSERTS</h1>
        <p>Terminez vos repas en beauté avec nos recettes gourmandes</p>
    </div>

    <main class="content-wrapper">

        <p class="section-intro">
            Gâteaux, crèmes, tartes, mousses… Découvrez notre sélection de desserts pour toutes les occasions. Du classique au plus original, il y en a pour tous les goûts !
        </p>

        <h2 class="section-title">NOS DESSERTS GOURMANDS</h2>

        <div class="desserts-grid">
            <?php
            $recettes = getRecettesByCategorie($pdo, 5);
            foreach ($recettes as $recette):
                $titre    = htmlspecialchars($recette['titre']);
                $chapo    = htmlspecialchars($recette['chapo']);
                $img      = htmlspecialchars($recette['img']);
                $diff     = htmlspecialchars($recette['difficulte']);
                $temps    = htmlspecialchars($recette['tempsCuisson']);
                $prenom   = htmlspecialchars($recette['prenom'] ?? '—');
                $gravatar = htmlspecialchars($recette['gravatar'] ?? 'PPdéfaut.jpg');
            ?>
            <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" class="recipe-card-link dessert-card-link">
            <div class="dessert-card">
                <div class="dessert-card-img">
                    <img src="photos/recettes/<?php echo $img; ?>" alt="<?php echo $titre; ?>" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="dessert-card-body">
                    <h3><?php echo $titre; ?></h3>
                    <p><?php echo mb_substr($chapo, 0, 100) . '...'; ?></p>
                    <span class="dessert-tag"><?php echo $diff; ?> · <?php echo $temps; ?></span>
                </div>
                <div class="recipe-footer">
                    <img src="photos/gravatars/<?php echo $gravatar; ?>" alt="Avatar" class="avatar-img">
                    <span class="author-text">Proposé par <strong><?php echo $prenom; ?></strong></span>
                </div>
            </div>
            </a>
            <?php endforeach; ?>
        </div>


    </main>

<?php require_once 'includes/footer.php'; ?>
