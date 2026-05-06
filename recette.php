<?php
session_start();
require_once 'config.php';
require_once 'includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit();
}

$recette = getRecetteById($pdo, $id);

if (!$recette) {
    $pageTitle  = 'Recette introuvable';
    $activePage = 'recettes';
    require_once 'includes/header.php';
    ?>
    <main class="content-wrapper">
        <p class="section-intro">Cette recette n'existe pas. <a href="index.php">← Retour à l'accueil</a></p>
    </main>
    <?php
    require_once 'includes/footer.php';
    exit();
}


$pageTitle  = $recette['titre'];
$activePage = 'recettes';

$couleur_map = [
    'vertClair' => ['bg' => 'var(--couleur-vert-anis)', 'text' => 'var(--couleur-texte)'],
    'bleuClair' => ['bg' => '#5D9CC9',                  'text' => 'white'],
    'fushia'    => ['bg' => 'var(--couleur-magenta-clair)', 'text' => 'white'],
];
$couleur = $recette['couleur'] ?? 'fushia';
$colors  = $couleur_map[$couleur] ?? $couleur_map['fushia'];

require_once 'includes/header.php';
?>

<main class="content-wrapper">
    <div class="recette-detail">

        <div class="recette-hero" style="background-color: <?php echo $colors['bg']; ?>; color: <?php echo $colors['text']; ?>;">
            <div class="recette-hero-img">
                <img src="photos/recettes/<?php echo htmlspecialchars($recette['img']); ?>"
                     alt="<?php echo htmlspecialchars($recette['titre']); ?>">
            </div>
            <div class="recette-hero-text">
                <h1><?php echo htmlspecialchars($recette['titre']); ?></h1>
                <p class="recette-chapo"><?php echo htmlspecialchars($recette['chapo']); ?></p>
                <div class="recette-badges">
                    <span class="badge">
                        <img src="images/temps.png" alt="Préparation">
                        <?php echo htmlspecialchars($recette['tempsPreparation']); ?>
                    </span>
                    <span class="badge">
                        <img src="images/cuisson.png" alt="Cuisson">
                        <?php echo htmlspecialchars($recette['tempsCuisson']); ?>
                    </span>
                    <span class="badge">
                        <img src="images/prix.png" alt="Prix">
                        <?php echo htmlspecialchars($recette['prix']); ?>
                    </span>
                    <span class="badge"><?php echo htmlspecialchars($recette['difficulte']); ?></span>
                </div>
            </div>
        </div>

        <div class="recette-body">
            <div class="recette-ingredients">
                <h2 class="section-title">INGRÉDIENTS</h2>
                <?php
                // SECURITY NOTE: ingredient and preparation are admin-authored HTML stored in the DB.
                // Never grant regular members write access to these fields without adding
                // sanitisation (e.g. HTMLPurifier) here.
                echo $recette['ingredient'];
                ?>
            </div>
            <div class="recette-preparation">
                <h2 class="section-title">PRÉPARATION</h2>
                <?php echo $recette['preparation']; ?>
            </div>
        </div>

        <div class="recette-auteur">
            <img src="photos/gravatars/<?php echo htmlspecialchars($recette['gravatar'] ?? 'PPdéfaut.jpg'); ?>"
                 alt="Avatar" class="avatar-img">
            <span>Proposé par <strong><?php echo htmlspecialchars($recette['prenom'] ?? 'un membre'); ?></strong></span>
            <span class="recette-date"><?php
                $dateStr = !empty($recette['dateCrea'])
                    ? date('d/m/Y', strtotime($recette['dateCrea']))
                    : 'Date inconnue';
                echo htmlspecialchars($dateStr);
            ?></span>
        </div>

        <a href="index.php" class="btn-retour">← Retour aux recettes</a>

    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
