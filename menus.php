<?php
session_start();
require_once 'config.php';
require_once 'includes/functions.php';
$pageTitle  = 'Menus';
$activePage = 'menus';
require_once 'includes/header.php';

$categories = getAllCategories($pdo);

$header_colors = [
    'viande'  => 'entree',
    'légume'  => 'plat',
    'poisson' => 'dessert',
    'fruit'   => 'entree',
    'dessert' => 'dessert',
    'minceur' => 'plat',
];
?>

<div class="page-hero hero-magenta">
    <h1>NOS MENUS</h1>
    <p>Découvrez nos meilleures recettes par catégorie</p>
</div>

<main class="content-wrapper">

    <p class="section-intro">
        Découvrez nos suggestions de recettes organisées par catégorie, proposées par les membres de la communauté Koo2Fourchette.
    </p>

    <h2 class="section-title">RECETTES PAR CATÉGORIE</h2>

    <div class="menus-grid">
        <?php foreach ($categories as $cat):
            $recettes = getRecettesByCategorie($pdo, $cat['idCategorie']);
            if (empty($recettes)) continue;
            $recette      = $recettes[0];
            $nomCat       = htmlspecialchars($cat['nom']);
            $colorClass   = $header_colors[$cat['nom']] ?? 'plat';
            $titre        = htmlspecialchars($recette['titre']);
            $img          = htmlspecialchars($recette['img']);
            $diff         = htmlspecialchars($recette['difficulte']);
            $temps        = htmlspecialchars($recette['tempsCuisson']);
        ?>
        <div class="menu-card">
            <div class="menu-card-header <?php echo $colorClass; ?>">
                <?php echo strtoupper($nomCat); ?>
            </div>
            <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" style="text-decoration:none;color:inherit;display:block;">
                <div class="menu-card-img">
                    <img src="photos/recettes/<?php echo $img; ?>" alt="<?php echo $titre; ?>">
                </div>
                <div class="menu-card-body">
                    <p class="menu-recette-titre"><?php echo $titre; ?></p>
                    <p class="menu-recette-meta"><?php echo $diff; ?> · <?php echo $temps; ?></p>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

</main>

<?php require_once 'includes/footer.php'; ?>
