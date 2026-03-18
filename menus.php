<?php
session_start();
require_once 'config.php';
$pageTitle  = 'Menus';
$activePage = 'menus';
require_once 'includes/header.php';
?>
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


    </main>

<?php require_once 'includes/footer.php'; ?>
