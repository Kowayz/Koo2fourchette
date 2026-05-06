<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' - Kooz2Fourchette' : 'Kooz2Fourchette'; ?></title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <?php if (isset($extraStyles)) echo $extraStyles; ?>
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
                    <form class="search-bar" method="GET" action="recherche.php">
                        <input type="text" name="q" placeholder="Rechercher une recette"
                               value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                        <button type="submit" class="btn-ok">OK</button>
                    </form>
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
        <?php $active = isset($activePage) ? $activePage : ''; ?>
        <ul>
            <li><a href="index.php"   <?php if ($active === 'recettes') echo 'class="active"'; ?>>RECETTES</a></li>
            <li><a href="menus.php"   <?php if ($active === 'menus')    echo 'class="active"'; ?>>MENUS</a></li>
            <li><a href="deserts.php" <?php if ($active === 'deserts')  echo 'class="active"'; ?>>DESERTS</a></li>
            <li><a href="minceur.php" <?php if ($active === 'minceur')  echo 'class="active"'; ?>>MINCEUR</a></li>
            <li><a href="atelier.php" <?php if ($active === 'atelier')  echo 'class="active"'; ?>>ATELIER</a></li>
            <li><a href="contact.php" <?php if ($active === 'contact')  echo 'class="active"'; ?>>CONTACT</a></li>
        </ul>
    </nav>
