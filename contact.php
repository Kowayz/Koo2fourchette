<?php
session_start();
require_once 'config.php';
$pageTitle  = 'Contact';
$activePage = 'contact';
require_once 'includes/header.php';
?>
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


    </main>

<?php require_once 'includes/footer.php'; ?>
