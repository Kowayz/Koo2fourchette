<?php
session_start();
require_once 'config.php';
$pageTitle  = 'Desserts';
$activePage = 'deserts';
require_once 'includes/header.php';
?>
<div class="page-hero">
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
            $stmt = $pdo->query("SELECT * FROM recettes WHERE categorie = 5 ORDER BY dateCrea DESC");
            while ($recette = $stmt->fetch(PDO::FETCH_ASSOC)):
                $titre = htmlspecialchars($recette['titre']);
                $chapo = htmlspecialchars($recette['chapo']);
                $img   = htmlspecialchars($recette['img']);
                $diff  = htmlspecialchars($recette['difficulte']);
                $temps = htmlspecialchars($recette['tempsCuisson']);
            ?>
            <div class="dessert-card">
                <div class="dessert-card-img">
                    <img src="photos/recettes/<?php echo $img; ?>" alt="<?php echo $titre; ?>" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="dessert-card-body">
                    <h3><?php echo $titre; ?></h3>
                    <p><?php echo mb_substr($chapo, 0, 100) . '...'; ?></p>
                    <span class="dessert-tag"><?php echo $diff; ?> · <?php echo $temps; ?></span>
                </div>
            </div>
            <?php endwhile; ?>
        </div>


    </main>

<?php require_once 'includes/footer.php'; ?>
