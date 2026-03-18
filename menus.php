<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menus - Kooz2Fourchette</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        .page-hero {
            background-color: var(--couleur-magenta-clair);
            color: white;
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
            opacity: 0.9;
        }
        .menus-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin: 40px 0;
        }
        .menu-card {
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }
        .menu-card-header {
            padding: 20px;
            color: white;
            font-size: 20px;
            font-weight: 700;
        }
        .menu-card-header.entree { background-color: var(--couleur-vert-anis); color: #333; }
        .menu-card-header.plat { background-color: var(--couleur-magenta-clair); }
        .menu-card-header.dessert { background-color: var(--couleur-bleu-roi); }
        .menu-card-body {
            padding: 20px;
        }
        .menu-card-body ul {
            list-style: none;
            padding: 0;
        }
        .menu-card-body ul li {
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 14px;
            color: #555;
        }
        .menu-card-body ul li:last-child { border-bottom: none; }
        .menu-card-body ul li::before {
            content: "→ ";
            color: var(--couleur-magenta-clair);
            font-weight: bold;
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
            <li><a href="menus.php" class="active">MENUS</a></li>
            <li><a href="deserts.php">DESERTS</a></li>
            <li><a href="minceur.php">MINCEUR</a></li>
            <li><a href="atelier.php">ATELIER</a></li>
            <li><a href="contact.php">CONTACT</a></li>
        </ul>
    </nav>

    <div class="page-hero">
        <h1>NOS MENUS</h1>
        <p>Des menus équilibrés et savoureux pour tous les jours de la semaine</p>
    </div>

    <main class="content-wrapper">

        <p class="section-intro">
            Découvrez nos suggestions de menus complets, conçus par nos membres pour vous aider à organiser vos repas de la semaine. Entrée, plat et dessert — tout est pensé pour vous !
        </p>

        <h2 class="section-title">MENU DE LA SEMAINE</h2>

        <div class="menus-grid">
            <div class="menu-card">
                <div class="menu-card-header entree">Lundi</div>
                <div class="menu-card-body">
                    <ul>
                        <li>Salade de tomates cerises</li>
                        <li>Poulet rôti aux herbes</li>
                        <li>Tarte aux pommes maison</li>
                    </ul>
                </div>
            </div>
            <div class="menu-card">
                <div class="menu-card-header plat">Mardi</div>
                <div class="menu-card-body">
                    <ul>
                        <li>Soupe de légumes</li>
                        <li>Saumon grillé, riz basmati</li>
                        <li>Mousse au chocolat</li>
                    </ul>
                </div>
            </div>
            <div class="menu-card">
                <div class="menu-card-header dessert">Mercredi</div>
                <div class="menu-card-body">
                    <ul>
                        <li>Taboulé maison</li>
                        <li>Bœuf bourguignon</li>
                        <li>Crème brûlée</li>
                    </ul>
                </div>
            </div>
            <div class="menu-card">
                <div class="menu-card-header entree">Jeudi</div>
                <div class="menu-card-body">
                    <ul>
                        <li>Velouté de carottes</li>
                        <li>Lasagnes maison</li>
                        <li>Salade de fruits frais</li>
                    </ul>
                </div>
            </div>
            <div class="menu-card">
                <div class="menu-card-header plat">Vendredi</div>
                <div class="menu-card-body">
                    <ul>
                        <li>Œufs mimosa</li>
                        <li>Moules marinières &amp; frites</li>
                        <li>Île flottante</li>
                    </ul>
                </div>
            </div>
            <div class="menu-card">
                <div class="menu-card-header dessert">Weekend</div>
                <div class="menu-card-body">
                    <ul>
                        <li>Plateau de charcuterie</li>
                        <li>Côte de bœuf &amp; légumes grillés</li>
                        <li>Fondant au chocolat</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bottom-black-block"></div>
    </main>

</body>
</html>
