<?php
session_start();
require_once 'config.php';
$pageTitle  = 'Recettes du jour';
$activePage = 'recettes';
require_once 'includes/header.php';
?>
<main class="content-wrapper">

        <section class="top-section">
            <div class="featured-image-container">
                <img src="photos/recettes/creme-petits-poids.jpg" alt="Recette principale" class="featured-image">
            </div>
            <aside class="sidebar">
                <div class="ad-block block-magenta">
                    <p>block1</p>
                    <p>140/300</p>
                </div>
                <div class="ad-block block-blue">
                    <p>block1</p>
                    <p>140/300</p>
                </div>
            </aside>
        </section>

        <h1 class="section-title">RECETTES DU JOUR</h1>

        <section class="recipes-grid">
            <?php
            // Récupération de 3 recettes aléatoires avec les infos du membre auteur
            $sql = "SELECT r.*, m.prenom, m.gravatar
                    FROM recettes r
                    LEFT JOIN membres m ON r.membre = m.idMembre
                    ORDER BY RAND() LIMIT 3";
            
            $stmt = $pdo->query($sql);

            while ($recette = $stmt->fetch(PDO::FETCH_ASSOC)): 
                $couleur = htmlspecialchars($recette['couleur'] ?? 'fushia');
                
                // Correction des accents
                $titre = utf8_decode($recette['titre']);
                $chapo = utf8_decode($recette['chapo']);
                $prenom = utf8_decode($recette['prenom']);
                $img = htmlspecialchars($recette['img']);
                $gravatar = htmlspecialchars($recette['gravatar']);
                
                // Mappage des couleurs BDD vers les styles CSS
                $couleur_map = [
                    'vertClair' => ['bg' => 'var(--couleur-vert-anis)', 'text' => 'var(--couleur-texte)'],
                    'bleuClair' => ['bg' => '#5D9CC9', 'text' => 'white'],
                    'fushia' => ['bg' => 'var(--couleur-magenta-clair)', 'text' => 'white']
                ];
                
                $colors = $couleur_map[$couleur] ?? $couleur_map['fushia'];
            ?>
                <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" class="recipe-card-link">
                <article class="recipe-card">
                    <div class="recipe-image-container">
                        <img src="photos/recettes/<?php echo $img; ?>" 
                             alt="<?php echo htmlspecialchars($titre); ?>" class="recipe-image">
                    </div>
                    <div class="recipe-text-content" style="background-color: <?php echo $colors['bg']; ?>; color: <?php echo $colors['text']; ?>;">
                        <h3><?php echo htmlspecialchars($titre); ?></h3>
                        <p><?php echo mb_substr(htmlspecialchars($chapo), 0, 100, 'UTF-8') . '...'; ?></p>
                    </div>
                    <div class="recipe-footer">
                        <img src="photos/gravatars/<?php echo $gravatar; ?>" alt="Avatar" class="avatar-img">
                        <span class="author-text">Proposé par <strong><?php echo htmlspecialchars($prenom); ?></strong></span>
                    </div>
                </article>
                </a>
            <?php endwhile; ?>
        </section>
        
    </main>

<?php require_once 'includes/footer.php'; ?>
