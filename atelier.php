<?php
session_start();
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atelier - Kooz2Fourchette</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <style>
        .page-hero {
            background-color: var(--couleur-magenta-fonce);
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
        .ateliers-list {
            margin: 40px 0;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        .atelier-item {
            display: flex;
            border: 1px solid #e0e0e0;
            overflow: hidden;
        }
        .atelier-date {
            background-color: var(--couleur-magenta-fonce);
            color: white;
            width: 110px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 15px;
            text-align: center;
        }
        .atelier-date .day {
            font-size: 36px;
            font-weight: 900;
            line-height: 1;
        }
        .atelier-date .month {
            font-size: 14px;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .atelier-info {
            padding: 20px 25px;
            flex-grow: 1;
        }
        .atelier-info h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--couleur-magenta-fonce);
            margin-bottom: 8px;
        }
        .atelier-info p {
            font-size: 14px;
            color: #555;
            line-height: 1.5;
            margin-bottom: 12px;
        }
        .atelier-meta {
            display: flex;
            gap: 20px;
            font-size: 13px;
            color: #888;
        }
        .atelier-meta span::before {
            color: var(--couleur-magenta-clair);
            font-weight: bold;
            margin-right: 4px;
        }
        .atelier-cta {
            display: flex;
            align-items: center;
            padding: 20px;
        }
        .btn-inscrire {
            background-color: var(--couleur-magenta-fonce);
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            white-space: nowrap;
            font-family: 'Roboto', Arial, sans-serif;
        }
        .btn-inscrire:hover {
            background-color: var(--couleur-magenta-clair);
        }
        .section-intro {
            font-size: 16px;
            color: #555;
            margin: 30px 0;
            line-height: 1.6;
        }
        .complet-badge {
            background-color: #999;
            color: white;
            border: none;
            padding: 12px 25px;
            font-size: 14px;
            font-weight: 700;
            font-family: 'Roboto', Arial, sans-serif;
            cursor: not-allowed;
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
            <li><a href="minceur.php">MINCEUR</a></li>
            <li><a href="atelier.php" class="active">ATELIER</a></li>
            <li><a href="contact.php">CONTACT</a></li>
        </ul>
    </nav>

    <div class="page-hero">
        <h1>ATELIERS CUISINE</h1>
        <p>Apprenez, pratiquez et partagez votre passion de la cuisine</p>
    </div>

    <main class="content-wrapper">

        <p class="section-intro">
            Rejoignez nos ateliers animés par des chefs passionnés et des membres de la communauté. Que vous soyez débutant ou cuisinier confirmé, il y a un atelier fait pour vous !
        </p>

        <h2 class="section-title">PROCHAINS ATELIERS</h2>

        <div class="ateliers-list">

            <div class="atelier-item">
                <div class="atelier-date">
                    <span class="day">22</span>
                    <span class="month">Mars 2026</span>
                </div>
                <div class="atelier-info">
                    <h3>Les Bases de la Pâtisserie Française</h3>
                    <p>Apprenez à réaliser les grands classiques : pâte à choux, crème pâtissière et macarons. Un atelier incontournable pour tous les amoureux du sucré !</p>
                    <div class="atelier-meta">
                        <span>14h00 - 17h00</span>
                        <span>Paris 11e</span>
                        <span>12 places</span>
                        <span>Niveau : Débutant</span>
                    </div>
                </div>
                <div class="atelier-cta">
                    <button class="btn-inscrire">S'inscrire</button>
                </div>
            </div>

            <div class="atelier-item">
                <div class="atelier-date">
                    <span class="day">05</span>
                    <span class="month">Avr. 2026</span>
                </div>
                <div class="atelier-info">
                    <h3>Cuisine du Monde : Spécial Asie</h3>
                    <p>Dim sum, pad thaï, ramens maison… Explorez les saveurs asiatiques et repartez avec vos propres créations et les recettes du chef.</p>
                    <div class="atelier-meta">
                        <span>10h00 - 13h30</span>
                        <span>Paris 3e</span>
                        <span>10 places</span>
                        <span>Niveau : Intermédiaire</span>
                    </div>
                </div>
                <div class="atelier-cta">
                    <button class="btn-inscrire">S'inscrire</button>
                </div>
            </div>

            <div class="atelier-item">
                <div class="atelier-date">
                    <span class="day">19</span>
                    <span class="month">Avr. 2026</span>
                </div>
                <div class="atelier-info">
                    <h3>Cuisine Minceur &amp; Équilibrée</h3>
                    <p>Préparez des plats savoureux et légers avec des techniques de cuisson saines. Repartez avec 5 recettes prêtes à intégrer dans votre quotidien.</p>
                    <div class="atelier-meta">
                        <span>11h00 - 14h00</span>
                        <span>Lyon 6e</span>
                        <span>8 places</span>
                        <span>Niveau : Tous niveaux</span>
                    </div>
                </div>
                <div class="atelier-cta">
                    <button class="complet-badge">Complet</button>
                </div>
            </div>

            <div class="atelier-item">
                <div class="atelier-date">
                    <span class="day">10</span>
                    <span class="month">Mai 2026</span>
                </div>
                <div class="atelier-info">
                    <h3>Barbecue &amp; Grillades : Techniques de Pro</h3>
                    <p>Maîtrisez les températures, les marinades et les temps de cuisson pour épater vos convives cet été. Séance en extérieur.</p>
                    <div class="atelier-meta">
                        <span>12h00 - 16h00</span>
                        <span>Bordeaux</span>
                        <span>15 places</span>
                        <span>Niveau : Débutant+</span>
                    </div>
                </div>
                <div class="atelier-cta">
                    <button class="btn-inscrire">S'inscrire</button>
                </div>
            </div>

        </div>

        <div class="bottom-black-block"></div>
    </main>

</body>
</html>
