<?php
session_start();
require_once 'config.php';
$pageTitle  = 'Minceur';
$activePage = 'minceur';
require_once 'includes/header.php';
?>
<div class="page-hero">
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
            $stmt = $pdo->query("SELECT * FROM recettes WHERE categorie = 6 ORDER BY dateCrea DESC");
            while ($recette = $stmt->fetch(PDO::FETCH_ASSOC)):
                $titre = htmlspecialchars($recette['titre']);
                $chapo = htmlspecialchars($recette['chapo']);
                $img   = htmlspecialchars($recette['img']);
                $diff  = htmlspecialchars($recette['difficulte']);
                $prix  = htmlspecialchars($recette['prix']);
            ?>
            <div class="minceur-card">
                <img src="photos/recettes/<?php echo $img; ?>" alt="<?php echo $titre; ?>" style="width:120px;height:100%;object-fit:cover;flex-shrink:0;">
                <div class="minceur-card-content">
                    <h3><?php echo $titre; ?></h3>
                    <p><?php echo mb_substr($chapo, 0, 120) . '...'; ?></p>
                    <div class="minceur-meta">
                        <span><?php echo $diff; ?></span>
                        <span><?php echo $prix; ?></span>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>


    </main>

<?php require_once 'includes/footer.php'; ?>
