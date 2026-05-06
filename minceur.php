<?php
session_start();
require_once 'config.php';
$pageTitle  = 'Minceur';
$activePage = 'minceur';
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>
<div class="page-hero hero-vert">
        <h1>MINCEUR</h1>
        <p>Manger sainement sans sacrifier le plaisir</p>
    </div>

    <main class="content-wrapper">

        <div class="tips-banner">
            <strong>Le conseil de la semaine :</strong> Privilégiez les cuissons vapeur ou à l'étouffée pour conserver un maximum de nutriments tout en limitant les matières grasses. Assaisonnez avec des herbes fraîches pour sublimer vos plats sans calories !
        </div>

        <h2 class="section-title">RECETTES LÉGÈRES</h2>

        <div class="minceur-grid">
            <?php
            $recettes = getRecettesByCategorie($pdo, 6);
            foreach ($recettes as $recette):
                $titre    = htmlspecialchars(utf8_decode($recette['titre']));
                $chapo    = htmlspecialchars(utf8_decode($recette['chapo']));
                $img      = htmlspecialchars($recette['img']);
                $diff     = htmlspecialchars(utf8_decode($recette['difficulte']));
                $prix     = htmlspecialchars(utf8_decode($recette['prix']));
                $prenom   = htmlspecialchars(utf8_decode($recette['prenom'] ?? '—'));
                $gravatar = htmlspecialchars($recette['gravatar'] ?? 'PPdéfaut.jpg');
            ?>
            <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" class="minceur-card-link">
            <div class="minceur-card">
                <img src="photos/recettes/<?php echo $img; ?>" alt="<?php echo $titre; ?>" style="width:120px;height:100%;min-height:140px;object-fit:cover;flex-shrink:0;">
                <div class="minceur-card-content">
                    <h3><?php echo $titre; ?></h3>
                    <p><?php echo mb_substr($chapo, 0, 120) . '...'; ?></p>
                    <div class="minceur-meta">
                        <span><?php echo $diff; ?></span>
                        <span><?php echo $prix; ?></span>
                    </div>
                    <div class="minceur-auteur">
                        <img src="photos/gravatars/<?php echo $gravatar; ?>" alt="Avatar" class="avatar-img" style="width:30px;height:30px;">
                        <span class="author-text">Par <strong><?php echo $prenom; ?></strong></span>
                    </div>
                </div>
            </div>
            </a>
            <?php endforeach; ?>
        </div>


    </main>

<?php require_once 'includes/footer.php'; ?>
