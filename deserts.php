<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Desserts - Kooz2Fourchette</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        .page-hero {
            background-color: var(--couleur-bleu-roi);
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
        .desserts-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin: 40px 0;
        }
        .dessert-card {
            border: 1px solid #e0e0e0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }
        .dessert-card-img {
            height: 200px;
            background-color: var(--couleur-bleu-roi);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 50px;
        }
        .dessert-card-body {
            padding: 20px;
            flex-grow: 1;
        }
        .dessert-card-body h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--couleur-magenta-fonce);
        }
        .dessert-card-body p {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }
        .dessert-tag {
            display: inline-block;
            background-color: var(--couleur-bleu-roi);
            color: white;
            padding: 3px 10px;
            font-size: 11px;
            margin-top: 10px;
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
            <li><a href="deserts.php" class="active">DESERTS</a></li>
            <li><a href="minceur.php">MINCEUR</a></li>
            <li><a href="atelier.php">ATELIER</a></li>
            <li><a href="contact.php">CONTACT</a></li>
        </ul>
    </nav>

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
            <div class="dessert-card">
                <div class="dessert-card-img">🍰</div>
                <div class="dessert-card-body">
                    <h3>Fondant au Chocolat</h3>
                    <p>Un cœur coulant irrésistible pour les amateurs de chocolat. Recette facile et rapide à préparer.</p>
                    <span class="dessert-tag">Facile · 25 min</span>
                </div>
            </div>
            <div class="dessert-card">
                <div class="dessert-card-img">🍮</div>
                <div class="dessert-card-body">
                    <h3>Crème Brûlée</h3>
                    <p>La recette traditionnelle française avec sa carapace de caramel craquante et sa crème onctueuse.</p>
                    <span class="dessert-tag">Moyen · 1h</span>
                </div>
            </div>
            <div class="dessert-card">
                <div class="dessert-card-img">🍓</div>
                <div class="dessert-card-body">
                    <h3>Charlotte aux Fraises</h3>
                    <p>Un dessert frais et léger à base de biscuits à la cuillère et de mousse aux fraises.</p>
                    <span class="dessert-tag">Moyen · 2h</span>
                </div>
            </div>
            <div class="dessert-card">
                <div class="dessert-card-img">🥧</div>
                <div class="dessert-card-body">
                    <h3>Tarte Tatin</h3>
                    <p>La célèbre tarte renversée aux pommes caramélisées, servie tiède avec de la crème fraîche.</p>
                    <span class="dessert-tag">Facile · 50 min</span>
                </div>
            </div>
            <div class="dessert-card">
                <div class="dessert-card-img">🍦</div>
                <div class="dessert-card-body">
                    <h3>Île Flottante</h3>
                    <p>Des blancs en neige moelleux flottant sur une crème anglaise onctueuse au caramel.</p>
                    <span class="dessert-tag">Difficile · 1h30</span>
                </div>
            </div>
            <div class="dessert-card">
                <div class="dessert-card-img">🫐</div>
                <div class="dessert-card-body">
                    <h3>Muffins aux Myrtilles</h3>
                    <p>Moelleux à souhait, ces muffins débordent de myrtilles fraîches pour un goûter parfait.</p>
                    <span class="dessert-tag">Facile · 35 min</span>
                </div>
            </div>
        </div>

        <div class="bottom-black-block"></div>
    </main>

</body>
</html>
