<?php
session_start();
require_once 'config.php';

$success = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $sujet = trim($_POST['sujet'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if (empty($nom) || empty($email) || empty($sujet) || empty($message)) {
        $error = 'Veuillez remplir tous les champs du formulaire.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Adresse email invalide.';
    } else {
        // Ici vous pourrez ajouter l'envoi de mail avec mail() ou PHPMailer
        $success = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Kooz2Fourchette</title>
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
        .contact-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            margin: 40px 0;
        }
        .contact-form label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 5px;
            color: #333;
        }
        .contact-form input,
        .contact-form select,
        .contact-form textarea {
            width: 100%;
            border: 2px solid #ddd;
            padding: 10px 14px;
            font-size: 14px;
            font-family: 'Roboto', Arial, sans-serif;
            color: #333;
            outline: none;
            margin-bottom: 18px;
            transition: border-color 0.2s;
        }
        .contact-form input:focus,
        .contact-form select:focus,
        .contact-form textarea:focus {
            border-color: var(--couleur-magenta-clair);
        }
        .contact-form textarea {
            height: 160px;
            resize: vertical;
        }
        .btn-envoyer {
            background-color: var(--couleur-magenta-fonce);
            color: white;
            border: none;
            padding: 12px 40px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            font-family: 'Roboto', Arial, sans-serif;
            width: 100%;
        }
        .btn-envoyer:hover {
            background-color: var(--couleur-magenta-clair);
        }
        .alert-success {
            background-color: var(--couleur-vert-anis);
            color: #333;
            padding: 15px 20px;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .alert-error {
            background-color: #fce4ec;
            color: #c62828;
            border-left: 4px solid var(--couleur-magenta-clair);
            padding: 15px 20px;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .contact-info h3 {
            font-size: 20px;
            font-weight: 700;
            color: var(--couleur-magenta-fonce);
            margin-bottom: 20px;
        }
        .info-item {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            align-items: flex-start;
        }
        .info-icon {
            width: 44px;
            height: 44px;
            background-color: var(--couleur-magenta-clair);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .info-text strong {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #333;
            margin-bottom: 3px;
        }
        .info-text p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
        }
        .faq-section {
            margin: 40px 0;
        }
        .faq-item {
            border-bottom: 1px solid #eee;
            padding: 18px 0;
        }
        .faq-item h4 {
            font-size: 15px;
            font-weight: 700;
            color: var(--couleur-magenta-fonce);
            margin-bottom: 8px;
        }
        .faq-item p {
            font-size: 14px;
            color: #666;
            line-height: 1.5;
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
            <li><a href="atelier.php">ATELIER</a></li>
            <li><a href="contact.php" class="active">CONTACT</a></li>
        </ul>
    </nav>

    <div class="page-hero">
        <h1>CONTACT</h1>
        <p>Une question, une suggestion ? Nous sommes à votre écoute</p>
    </div>

    <main class="content-wrapper">

        <div class="contact-layout">

            <div>
                <h2 class="section-title">ENVOYER UN MESSAGE</h2>

                <?php if ($success): ?>
                    <div class="alert-success">Votre message a bien été envoyé. Nous vous répondrons dans les plus brefs délais !</div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert-error"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form class="contact-form" method="POST" action="contact.php">
                    <label for="nom">Nom complet *</label>
                    <input type="text" id="nom" name="nom" placeholder="Votre nom" value="<?php echo isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : ''; ?>" required>

                    <label for="email">Adresse email *</label>
                    <input type="email" id="email" name="email" placeholder="votre@email.com" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>

                    <label for="sujet">Sujet *</label>
                    <select id="sujet" name="sujet" required>
                        <option value="">-- Choisissez un sujet --</option>
                        <option value="question" <?php echo (isset($_POST['sujet']) && $_POST['sujet'] === 'question') ? 'selected' : ''; ?>>Question générale</option>
                        <option value="recette" <?php echo (isset($_POST['sujet']) && $_POST['sujet'] === 'recette') ? 'selected' : ''; ?>>Problème avec une recette</option>
                        <option value="compte" <?php echo (isset($_POST['sujet']) && $_POST['sujet'] === 'compte') ? 'selected' : ''; ?>>Mon compte</option>
                        <option value="partenariat" <?php echo (isset($_POST['sujet']) && $_POST['sujet'] === 'partenariat') ? 'selected' : ''; ?>>Partenariat</option>
                        <option value="autre" <?php echo (isset($_POST['sujet']) && $_POST['sujet'] === 'autre') ? 'selected' : ''; ?>>Autre</option>
                    </select>

                    <label for="message">Message *</label>
                    <textarea id="message" name="message" placeholder="Décrivez votre demande..." required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>

                    <button type="submit" class="btn-envoyer">ENVOYER LE MESSAGE</button>
                </form>
            </div>

            <div class="contact-info">
                <h2 class="section-title">NOS COORDONNÉES</h2>

                <div class="info-item">
                    <div class="info-icon">✉</div>
                    <div class="info-text">
                        <strong>Email</strong>
                        <p>contact@kooz2fourchette.fr</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">📍</div>
                    <div class="info-text">
                        <strong>Adresse</strong>
                        <p>12 rue des Saveurs<br>75011 Paris, France</p>
                    </div>
                </div>

                <div class="info-item">
                    <div class="info-icon">🕐</div>
                    <div class="info-text">
                        <strong>Horaires de réponse</strong>
                        <p>Du lundi au vendredi<br>9h00 - 18h00</p>
                    </div>
                </div>

                <h3 style="margin: 30px 0 15px; font-size: 18px; color: var(--couleur-magenta-fonce);">FAQ RAPIDE</h3>

                <div class="faq-item">
                    <h4>Comment publier une recette ?</h4>
                    <p>Connectez-vous à votre compte, puis cliquez sur le bouton "Déposer une recette" en haut de la page.</p>
                </div>
                <div class="faq-item">
                    <h4>Mon compte a été suspendu, que faire ?</h4>
                    <p>Contactez-nous via ce formulaire avec le sujet "Mon compte" et nous traiterons votre demande rapidement.</p>
                </div>
                <div class="faq-item">
                    <h4>Comment s'inscrire à un atelier ?</h4>
                    <p>Rendez-vous sur la page Atelier et cliquez sur "S'inscrire" en face de l'atelier qui vous intéresse.</p>
                </div>
            </div>

        </div>

        <div class="bottom-black-block"></div>
    </main>

</body>
</html>
