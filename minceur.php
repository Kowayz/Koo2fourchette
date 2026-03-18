<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minceur - Kooz2Fourchette</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        .page-hero {
            background-color: var(--couleur-vert-anis);
            color: #333;
            padding: 60px 40px;
            text-align: center;
        }
        .page-hero h1 {
            font-size: 42px;
            font-weight: 900;
            margin-bottom: 15px;
        }
        .page-hero p {
            font-size: 18px;
            opacity: 0.8;
        }
        .tips-banner {
            background-color: #f9f9f9;
            border-left: 5px solid var(--couleur-vert-anis);
            padding: 20px 25px;
            margin: 30px 0;
            font-size: 15px;
            color: #444;
            line-height: 1.6;
        }
        .minceur-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px;
            margin: 40px 0;
        }
        .minceur-card {
            display: flex;
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }
        .minceur-card-accent {
            width: 8px;
            background-color: var(--couleur-vert-anis);
            flex-shrink: 0;
        }
        .minceur-card-content {
            padding: 20px;
            flex-grow: 1;
        }
        .minceur-card-content h3 {
            font-size: 17px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        .minceur-card-content p {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }
        .minceur-meta {
            display: flex;
            gap: 15px;
            margin-top: 12px;
        }
        .minceur-meta span {
            font-size: 12px;
            font-weight: 700;
            color: #fff;
            background-color: var(--couleur-vert-anis);
            padding: 3px 10px;
            color: #333;
        }
        .section-intro {
            font-size: 16px;
            color: #555;
            margin: 30px 0;
            line-height: 1.6;
        }
    </style>
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
            <li><a href="index.php">RECETTES</a></li>
            <li><a href="menus.php">MENUS</a></li>
            <li><a href="deserts.php">DESERTS</a></li>
            <li><a href="minceur.php" class="active">MINCEUR</a></li>
            <li><a href="atelier.php">ATELIER</a></li>
            <li><a href="contact.php">CONTACT</a></li>
        </ul>
    </nav>

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

        <div class="bottom-black-block"></div>
    </main>

</body>
</html>
