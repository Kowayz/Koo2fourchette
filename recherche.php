<?php
session_start();
require_once 'config.php';
require_once 'includes/functions.php';

$query = trim($_GET['q'] ?? '');

if (empty($query)) {
    header("Location: index.php");
    exit();
}

$results    = searchRecettes($pdo, $query);
$pageTitle  = 'Recherche : ' . $query;
$activePage = 'recettes';

$couleur_map = [
    'vertClair' => ['bg' => 'var(--couleur-vert-anis)', 'text' => 'var(--couleur-texte)'],
    'bleuClair' => ['bg' => '#5D9CC9',                  'text' => 'white'],
    'fushia'    => ['bg' => 'var(--couleur-magenta-clair)', 'text' => 'white'],
];

require_once 'includes/header.php';
?>

<main class="content-wrapper">

    <h1 class="section-title">
        RÉSULTATS POUR "<?php echo htmlspecialchars(strtoupper($query)); ?>"
    </h1>

    <?php if (empty($results)): ?>
        <p class="section-intro">
            Aucune recette trouvée pour "<strong><?php echo htmlspecialchars($query); ?></strong>".
            <a href="index.php">← Retour à l'accueil</a>
        </p>
    <?php else: ?>
        <section class="recipes-grid recherche-grid">
            <?php foreach ($results as $recette):
                $couleur = $recette['couleur'] ?? 'fushia';
                $colors  = $couleur_map[$couleur] ?? $couleur_map['fushia'];
            ?>
            <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" class="recipe-card-link">
                <article class="recipe-card">
                    <div class="recipe-image-container">
                        <img src="photos/recettes/<?php echo htmlspecialchars($recette['img']); ?>"
                             alt="<?php echo htmlspecialchars($recette['titre']); ?>"
                             class="recipe-image">
                    </div>
                    <div class="recipe-text-content"
                         style="background-color: <?php echo $colors['bg']; ?>; color: <?php echo $colors['text']; ?>;">
                        <h3><?php echo htmlspecialchars($recette['titre']); ?></h3>
                        <p><?php echo mb_substr(htmlspecialchars($recette['chapo']), 0, 100, 'UTF-8') . '...'; ?></p>
                    </div>
                    <div class="recipe-footer">
                        <img src="photos/gravatars/<?php echo htmlspecialchars($recette['gravatar'] ?? 'PPdéfaut.jpg'); ?>"
                             alt="Avatar" class="avatar-img">
                        <span class="author-text">
                            Proposé par <strong><?php echo htmlspecialchars($recette['prenom'] ?? '—'); ?></strong>
                        </span>
                    </div>
                </article>
            </a>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

</main>

<?php require_once 'includes/footer.php'; ?>
