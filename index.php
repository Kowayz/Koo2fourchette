<?php
session_start(); 
require_once 'config.php'; 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kooz2Fourchette - Maquette Finale</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>

    <header class="header-container">
        <div class="header-content">
            <div class="logo-section">
                <img src="images/koo_2_fourchette.png" alt="Logo Kooz2Fourchette" class="site-logo">
                <p class="tagline">miam miam, gloup gloup, laps laps</p>
            </div>

            <div class="tools-section">
                <div class="social-icons">
                    <a href="#" class="icon-fb"><img src="images/facebook.png" alt="Facebook"></a>
                    <a href="#" class="icon-tw"><img src="images/twitter.png" alt="Twitter"></a>
                    <a href="#" class="icon-gplus"><img src="images/google.png" alt="Google"></a>
                    <a href="#" class="icon-yt"><img src="images/youtube.png" alt="Youtube"></a>
                </div>

                <div class="search-auth-row">
                    <div class="search-bar">
                        <input type="text" placeholder="Rechercher une recette">
                        <button class="btn-ok">OK</button>
                    </div>
                    <div class="auth-buttons">
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <span class="welcome-user">Bonjour <?php echo htmlspecialchars($_SESSION['prenom']); ?> !</span>
                            <a href="deconnexion.php" class="btn-logout">
                                <button class="creer-compte">Déconnexion</button>
                            </a>
                        <?php else: ?>
                            <a href="connexion.php"><button class="se-connecter">Se connecter</button></a>
                            <a href="inscription.php"><button class="creer-compte">Créer un compte</button></a>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="deposit-row">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <a href="ajouter_recette.php" class="btn-deposer">Déposer une recette</a>
                    <?php else: ?>
                        <a href="connexion.php" class="btn-deposer" onclick="return confirm('Vous devez être connecté pour déposer une recette.');">Déposer une recette</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <nav class="main-nav">
        <ul>
            <li><a href="#" class="active">RECETTES</a></li>
            <li><a href="#">MENUS</a></li>
            <li><a href="#">DESERTS</a></li>
            <li><a href="#">MINCEUR</a></li>
            <li><a href="#">ATELIER</a></li>
            <li><a href="#">CONTACT</a></li>
        </ul>
    </nav>

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
            // Récupération des 3 dernières recettes avec les infos du membre auteur
            $sql = "SELECT r.*, m.prenom, m.gravatar 
                    FROM recettes r 
                    LEFT JOIN membres m ON r.membre = m.idMembre 
                    ORDER BY r.dateCrea DESC LIMIT 3";
            
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
            <?php endwhile; ?>
        </section>
        
        <div class="bottom-black-block"></div>

    </main>

</body>
</html>