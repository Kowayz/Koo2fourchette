<?php
session_start();
require_once 'config.php';
$pageTitle  = 'Atelier';
$activePage = 'atelier';
require_once 'includes/header.php';
?>
<div class="page-hero hero-magenta-fonce">
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


    </main>

<?php require_once 'includes/footer.php'; ?>
