# Database Full Usage — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Exploit every field of the `koo_2_fourchette` database across the site by creating a recipe detail page, wiring the search bar, making menus dynamic, and completing the recipe submission form.

**Architecture:** Shared DB functions live in `includes/functions.php` and are required by all pages. New pages (`recette.php`, `recherche.php`) use these functions. Existing pages are modified in-place following existing PHP/HTML patterns.

**Tech Stack:** PHP 8, MySQL 8, PDO, vanilla CSS (style.css), no test framework — verification is done by loading pages in the browser.

---

## File Map

| Action | File | Responsibility |
|---|---|---|
| Create | `includes/functions.php` | All reusable DB query functions |
| Create | `recette.php` | Full recipe detail page |
| Create | `recherche.php` | Search results page |
| Modify | `style.css` | CSS for recette detail, search, and updated cards |
| Modify | `index.php` | Wrap cards in `<a href="recette.php?id=X">` |
| Modify | `deserts.php` | Add author info + links to recette.php |
| Modify | `minceur.php` | Add author info + links to recette.php |
| Modify | `menus.php` | Replace static HTML with dynamic DB content |
| Modify | `ajouter_recette.php` | Add all missing form fields |
| Modify | `includes/header.php` | Wire search bar to recherche.php |

---

## Task 1: Create `includes/functions.php`

**Files:**
- Create: `includes/functions.php`

- [ ] **Step 1: Create the file with all four DB functions**

```php
<?php
// includes/functions.php

function getRecetteById($pdo, $id) {
    $stmt = $pdo->prepare(
        "SELECT r.*, m.prenom, m.gravatar
         FROM recettes r
         LEFT JOIN membres m ON r.membre = m.idMembre
         WHERE r.idRecette = ?"
    );
    $stmt->execute([(int)$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getRecettesByCategorie($pdo, $categorieId) {
    $stmt = $pdo->prepare(
        "SELECT r.*, m.prenom, m.gravatar
         FROM recettes r
         LEFT JOIN membres m ON r.membre = m.idMembre
         WHERE r.categorie = ?
         ORDER BY r.dateCrea DESC"
    );
    $stmt->execute([(int)$categorieId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function searchRecettes($pdo, $query) {
    $stmt = $pdo->prepare(
        "SELECT r.*, m.prenom, m.gravatar
         FROM recettes r
         LEFT JOIN membres m ON r.membre = m.idMembre
         WHERE r.titre LIKE ?
         ORDER BY r.dateCrea DESC"
    );
    $stmt->execute(['%' . $query . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY idCategorie");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
```

- [ ] **Step 2: Verify the file is syntactically valid**

Run in browser or CLI:
```
php -l includes/functions.php
```
Expected output: `No syntax errors detected in includes/functions.php`

- [ ] **Step 3: Commit**

```bash
git add includes/functions.php
git commit -m "feat: add shared DB functions in includes/functions.php"
```

---

## Task 2: Create `recette.php` — Recipe Detail Page

**Files:**
- Create: `recette.php`

- [ ] **Step 1: Create the full file**

```php
<?php
session_start();
require_once 'config.php';
require_once 'includes/functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id <= 0) {
    header("Location: index.php");
    exit();
}

$recette = getRecetteById($pdo, $id);

if (!$recette) {
    $pageTitle  = 'Recette introuvable';
    $activePage = 'recettes';
    require_once 'includes/header.php';
    ?>
    <main class="content-wrapper">
        <p class="section-intro">Cette recette n'existe pas. <a href="index.php">← Retour à l'accueil</a></p>
    </main>
    <?php
    require_once 'includes/footer.php';
    exit();
}

$pageTitle  = $recette['titre'];
$activePage = 'recettes';

$couleur_map = [
    'vertClair' => ['bg' => 'var(--couleur-vert-anis)', 'text' => 'var(--couleur-texte)'],
    'bleuClair' => ['bg' => '#5D9CC9',                  'text' => 'white'],
    'fushia'    => ['bg' => 'var(--couleur-magenta-clair)', 'text' => 'white'],
];
$couleur = $recette['couleur'] ?? 'fushia';
$colors  = $couleur_map[$couleur] ?? $couleur_map['fushia'];

require_once 'includes/header.php';
?>

<main class="content-wrapper">
    <div class="recette-detail">

        <div class="recette-hero" style="background-color: <?php echo $colors['bg']; ?>; color: <?php echo $colors['text']; ?>;">
            <div class="recette-hero-img">
                <img src="photos/recettes/<?php echo htmlspecialchars($recette['img']); ?>"
                     alt="<?php echo htmlspecialchars($recette['titre']); ?>">
            </div>
            <div class="recette-hero-text">
                <h1><?php echo htmlspecialchars($recette['titre']); ?></h1>
                <p class="recette-chapo"><?php echo htmlspecialchars($recette['chapo']); ?></p>
                <div class="recette-badges">
                    <span class="badge">
                        <img src="images/temps.png" alt="Préparation">
                        <?php echo htmlspecialchars($recette['tempsPreparation']); ?>
                    </span>
                    <span class="badge">
                        <img src="images/cuisson.png" alt="Cuisson">
                        <?php echo htmlspecialchars($recette['tempsCuisson']); ?>
                    </span>
                    <span class="badge">
                        <img src="images/prix.png" alt="Prix">
                        <?php echo htmlspecialchars($recette['prix']); ?>
                    </span>
                    <span class="badge"><?php echo htmlspecialchars($recette['difficulte']); ?></span>
                </div>
            </div>
        </div>

        <div class="recette-body">
            <div class="recette-ingredients">
                <h2 class="section-title">INGRÉDIENTS</h2>
                <?php echo $recette['ingredient']; ?>
            </div>
            <div class="recette-preparation">
                <h2 class="section-title">PRÉPARATION</h2>
                <?php echo $recette['preparation']; ?>
            </div>
        </div>

        <div class="recette-auteur">
            <img src="photos/gravatars/<?php echo htmlspecialchars($recette['gravatar'] ?? 'PPdéfaut.jpg'); ?>"
                 alt="Avatar" class="avatar-img">
            <span>Proposé par <strong><?php echo htmlspecialchars($recette['prenom'] ?? 'un membre'); ?></strong></span>
            <span class="recette-date"><?php echo date('d/m/Y', strtotime($recette['dateCrea'])); ?></span>
        </div>

        <a href="index.php" class="btn-retour">← Retour aux recettes</a>

    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
```

- [ ] **Step 2: Verify syntax**

```
php -l recette.php
```
Expected: `No syntax errors detected`

- [ ] **Step 3: Add CSS for the recipe detail page to `style.css`**

Append this block at the end of `style.css`:

```css
/* ===== RECETTE DETAIL ===== */
.recette-detail {
    margin-bottom: 60px;
}

.recette-hero {
    display: flex;
    gap: 0;
    margin-bottom: 40px;
    min-height: 350px;
}

.recette-hero-img {
    width: 45%;
    flex-shrink: 0;
    overflow: hidden;
}

.recette-hero-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.recette-hero-text {
    padding: 40px;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.recette-hero-text h1 {
    font-size: 32px;
    font-weight: 900;
    margin-bottom: 15px;
    text-transform: uppercase;
}

.recette-chapo {
    font-size: 15px;
    line-height: 1.6;
    margin-bottom: 25px;
    opacity: 0.95;
}

.recette-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background-color: rgba(255,255,255,0.25);
    padding: 6px 14px;
    font-size: 13px;
    font-weight: 700;
}

.badge img {
    width: 18px;
    height: 18px;
    object-fit: contain;
}

.recette-body {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 40px;
    margin-bottom: 40px;
}

.recette-ingredients ul,
.recette-preparation ol {
    padding-left: 20px;
    line-height: 2;
    font-size: 15px;
    color: #444;
}

.recette-preparation li {
    margin-bottom: 12px;
}

.recette-auteur {
    display: flex;
    align-items: center;
    gap: 12px;
    border-top: 2px solid #eee;
    padding-top: 20px;
    margin-bottom: 25px;
    font-size: 14px;
    color: #555;
}

.recette-date {
    margin-left: auto;
    color: #999;
    font-size: 13px;
}

.btn-retour {
    display: inline-block;
    background-color: var(--couleur-magenta-clair);
    color: white;
    padding: 10px 20px;
    text-decoration: none;
    font-weight: 700;
    font-size: 14px;
}

.btn-retour:hover {
    background-color: var(--couleur-magenta-fonce);
}
```

- [ ] **Step 4: Verify in browser**

Open `http://localhost/Koo2fourchette/recette.php?id=2`

Expected: page with photo, title, chapo, 4 badges, ingredients list, preparation steps, author avatar + name, "← Retour" link.

Open `http://localhost/Koo2fourchette/recette.php?id=999`

Expected: "Cette recette n'existe pas" message with a back link.

Open `http://localhost/Koo2fourchette/recette.php` (no id)

Expected: redirect to index.php.

- [ ] **Step 5: Commit**

```bash
git add recette.php style.css
git commit -m "feat: add recipe detail page (recette.php) with full DB fields"
```

---

## Task 3: Create `recherche.php` — Search Results Page

**Files:**
- Create: `recherche.php`

- [ ] **Step 1: Create the file**

```php
<?php
session_start();
require_once 'config.php';
require_once 'includes/functions.php';

$query = trim($_GET['q'] ?? '');

if (empty($query)) {
    header("Location: index.php");
    exit();
}

$results    = searchRecettes($pdo, $query);
$pageTitle  = 'Recherche : ' . $query;
$activePage = 'recettes';

$couleur_map = [
    'vertClair' => ['bg' => 'var(--couleur-vert-anis)', 'text' => 'var(--couleur-texte)'],
    'bleuClair' => ['bg' => '#5D9CC9',                  'text' => 'white'],
    'fushia'    => ['bg' => 'var(--couleur-magenta-clair)', 'text' => 'white'],
];

require_once 'includes/header.php';
?>

<main class="content-wrapper">

    <h1 class="section-title">
        RÉSULTATS POUR "<?php echo htmlspecialchars(strtoupper($query)); ?>"
    </h1>

    <?php if (empty($results)): ?>
        <p class="section-intro">
            Aucune recette trouvée pour "<strong><?php echo htmlspecialchars($query); ?></strong>".
            <a href="index.php">← Retour à l'accueil</a>
        </p>
    <?php else: ?>
        <section class="recipes-grid recherche-grid">
            <?php foreach ($results as $recette):
                $couleur = $recette['couleur'] ?? 'fushia';
                $colors  = $couleur_map[$couleur] ?? $couleur_map['fushia'];
            ?>
            <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" class="recipe-card-link">
                <article class="recipe-card">
                    <div class="recipe-image-container">
                        <img src="photos/recettes/<?php echo htmlspecialchars($recette['img']); ?>"
                             alt="<?php echo htmlspecialchars($recette['titre']); ?>"
                             class="recipe-image">
                    </div>
                    <div class="recipe-text-content"
                         style="background-color: <?php echo $colors['bg']; ?>; color: <?php echo $colors['text']; ?>;">
                        <h3><?php echo htmlspecialchars($recette['titre']); ?></h3>
                        <p><?php echo mb_substr(htmlspecialchars($recette['chapo']), 0, 100, 'UTF-8') . '...'; ?></p>
                    </div>
                    <div class="recipe-footer">
                        <img src="photos/gravatars/<?php echo htmlspecialchars($recette['gravatar'] ?? 'PPdéfaut.jpg'); ?>"
                             alt="Avatar" class="avatar-img">
                        <span class="author-text">
                            Proposé par <strong><?php echo htmlspecialchars($recette['prenom'] ?? '—'); ?></strong>
                        </span>
                    </div>
                </article>
            </a>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

</main>

<?php require_once 'includes/footer.php'; ?>
```

- [ ] **Step 2: Add CSS for `.recipe-card-link` and `.recherche-grid` to `style.css`**

Append at the end of `style.css`:

```css
/* ===== RECHERCHE ===== */
.recipe-card-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex: 1;
}

.recipe-card-link .recipe-card {
    width: 100%;
}

.recherche-grid {
    flex-wrap: wrap;
}
```

- [ ] **Step 3: Verify syntax**

```
php -l recherche.php
```
Expected: `No syntax errors detected`

- [ ] **Step 4: Verify in browser**

Open `http://localhost/Koo2fourchette/recherche.php?q=carotte`

Expected: grid of recipe cards matching "carotte", each clickable → recette.php.

Open `http://localhost/Koo2fourchette/recherche.php?q=xyzinexistant`

Expected: "Aucune recette trouvée pour xyzinexistant" with back link.

- [ ] **Step 5: Commit**

```bash
git add recherche.php style.css
git commit -m "feat: add search results page (recherche.php)"
```

---

## Task 4: Wire Search Bar in `includes/header.php`

**Files:**
- Modify: `includes/header.php`

- [ ] **Step 1: Replace the static search div with a real form**

In `includes/header.php`, find:

```html
                    <div class="search-bar">
                        <input type="text" placeholder="Rechercher une recette">
                        <button class="btn-ok">OK</button>
                    </div>
```

Replace with:

```html
                    <form class="search-bar" method="GET" action="recherche.php">
                        <input type="text" name="q" placeholder="Rechercher une recette"
                               value="<?php echo isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                        <button type="submit" class="btn-ok">OK</button>
                    </form>
```

- [ ] **Step 2: Verify in browser**

On any page, type "poulet" in the search bar and press OK.

Expected: redirected to `recherche.php?q=poulet` with matching recipe cards.

- [ ] **Step 3: Commit**

```bash
git add includes/header.php
git commit -m "feat: wire header search bar to recherche.php"
```

---

## Task 5: Make Recipe Cards Clickable on `index.php`

**Files:**
- Modify: `index.php`

The layout must not change — only the `<article>` elements become links.

- [ ] **Step 1: Wrap each `<article>` in an `<a>` tag**

In `index.php`, find the opening article tag:

```php
            ?>
                <article class="recipe-card">
```

Replace with:

```php
            ?>
                <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" class="recipe-card-link">
                <article class="recipe-card">
```

Find the closing article tag:

```php
                </article>
            <?php endwhile; ?>
```

Replace with:

```php
                </article>
                </a>
            <?php endwhile; ?>
```

- [ ] **Step 2: Verify in browser**

Open `http://localhost/Koo2fourchette/index.php`

Expected: layout identical to before. Clicking a recipe card navigates to `recette.php?id=X`. No visual changes.

- [ ] **Step 3: Commit**

```bash
git add index.php
git commit -m "feat: make index recipe cards link to detail page"
```

---

## Task 6: Update `deserts.php` — Add Author and Links

**Files:**
- Modify: `deserts.php`

- [ ] **Step 1: Add `require_once` for functions and enrich the query**

In `deserts.php`, find:

```php
require_once 'includes/header.php';
?>
```

Replace with:

```php
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>
```

- [ ] **Step 2: Update the query to include author data and add link + author footer**

Find the entire `<?php ... ?>` block inside `.desserts-grid`:

```php
            <?php
            $stmt = $pdo->query("SELECT * FROM recettes WHERE categorie = 5 ORDER BY dateCrea DESC");
            while ($recette = $stmt->fetch(PDO::FETCH_ASSOC)):
                $titre = htmlspecialchars($recette['titre']);
                $chapo = htmlspecialchars($recette['chapo']);
                $img   = htmlspecialchars($recette['img']);
                $diff  = htmlspecialchars($recette['difficulte']);
                $temps = htmlspecialchars($recette['tempsCuisson']);
            ?>
            <div class="dessert-card">
                <div class="dessert-card-img">
                    <img src="photos/recettes/<?php echo $img; ?>" alt="<?php echo $titre; ?>" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="dessert-card-body">
                    <h3><?php echo $titre; ?></h3>
                    <p><?php echo mb_substr($chapo, 0, 100) . '...'; ?></p>
                    <span class="dessert-tag"><?php echo $diff; ?> · <?php echo $temps; ?></span>
                </div>
            </div>
            <?php endwhile; ?>
```

Replace with:

```php
            <?php
            $recettes = getRecettesByCategorie($pdo, 5);
            foreach ($recettes as $recette):
                $titre   = htmlspecialchars($recette['titre']);
                $chapo   = htmlspecialchars($recette['chapo']);
                $img     = htmlspecialchars($recette['img']);
                $diff    = htmlspecialchars($recette['difficulte']);
                $temps   = htmlspecialchars($recette['tempsCuisson']);
                $prenom  = htmlspecialchars($recette['prenom'] ?? '—');
                $gravatar = htmlspecialchars($recette['gravatar'] ?? 'PPdéfaut.jpg');
            ?>
            <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" class="recipe-card-link dessert-card-link">
            <div class="dessert-card">
                <div class="dessert-card-img">
                    <img src="photos/recettes/<?php echo $img; ?>" alt="<?php echo $titre; ?>" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div class="dessert-card-body">
                    <h3><?php echo $titre; ?></h3>
                    <p><?php echo mb_substr($chapo, 0, 100) . '...'; ?></p>
                    <span class="dessert-tag"><?php echo $diff; ?> · <?php echo $temps; ?></span>
                </div>
                <div class="recipe-footer">
                    <img src="photos/gravatars/<?php echo $gravatar; ?>" alt="Avatar" class="avatar-img">
                    <span class="author-text">Proposé par <strong><?php echo $prenom; ?></strong></span>
                </div>
            </div>
            </a>
            <?php endforeach; ?>
```

- [ ] **Step 3: Add `.dessert-card-link` CSS to `style.css`**

Append at the end of `style.css`:

```css
.dessert-card-link {
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
}

.dessert-card-link .dessert-card {
    flex-grow: 1;
}
```

- [ ] **Step 4: Verify in browser**

Open `http://localhost/Koo2fourchette/deserts.php`

Expected: dessert cards each show author gravatar + prénom at the bottom. Clicking a card opens `recette.php?id=X`.

- [ ] **Step 5: Commit**

```bash
git add deserts.php style.css
git commit -m "feat: add author info and detail links to deserts.php"
```

---

## Task 7: Update `minceur.php` — Add Author and Links

**Files:**
- Modify: `minceur.php`

- [ ] **Step 1: Add `require_once` for functions**

In `minceur.php`, find:

```php
require_once 'includes/header.php';
?>
```

Replace with:

```php
require_once 'includes/functions.php';
require_once 'includes/header.php';
?>
```

- [ ] **Step 2: Update the query and card template**

Find the entire `<?php ... ?>` block inside `.minceur-grid`:

```php
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
```

Replace with:

```php
            <?php
            $recettes = getRecettesByCategorie($pdo, 6);
            foreach ($recettes as $recette):
                $titre   = htmlspecialchars($recette['titre']);
                $chapo   = htmlspecialchars($recette['chapo']);
                $img     = htmlspecialchars($recette['img']);
                $diff    = htmlspecialchars($recette['difficulte']);
                $prix    = htmlspecialchars($recette['prix']);
                $prenom  = htmlspecialchars($recette['prenom'] ?? '—');
                $gravatar = htmlspecialchars($recette['gravatar'] ?? 'PPdéfaut.jpg');
            ?>
            <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" class="minceur-card-link">
            <div class="minceur-card">
                <img src="photos/recettes/<?php echo $img; ?>" alt="<?php echo $titre; ?>" style="width:120px;height:100%;min-height:140px;object-fit:cover;flex-shrink:0;">
                <div class="minceur-card-content">
                    <h3><?php echo $titre; ?></h3>
                    <p><?php echo mb_substr($chapo, 0, 120) . '...'; ?></p>
                    <div class="minceur-meta">
                        <span><?php echo $diff; ?></span>
                        <span><?php echo $prix; ?></span>
                    </div>
                    <div class="minceur-auteur">
                        <img src="photos/gravatars/<?php echo $gravatar; ?>" alt="Avatar" class="avatar-img" style="width:30px;height:30px;">
                        <span class="author-text">Par <strong><?php echo $prenom; ?></strong></span>
                    </div>
                </div>
            </div>
            </a>
            <?php endforeach; ?>
```

- [ ] **Step 3: Add `.minceur-card-link` CSS to `style.css`**

Append at the end of `style.css`:

```css
.minceur-card-link {
    text-decoration: none;
    color: inherit;
    display: block;
}

.minceur-auteur {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-top: 10px;
}
```

- [ ] **Step 4: Verify in browser**

Open `http://localhost/Koo2fourchette/minceur.php`

Expected: minceur cards each show author avatar + prénom. Clicking a card opens `recette.php?id=X`.

- [ ] **Step 5: Commit**

```bash
git add minceur.php style.css
git commit -m "feat: add author info and detail links to minceur.php"
```

---

## Task 8: Make `menus.php` Dynamic from DB

**Files:**
- Modify: `menus.php`

- [ ] **Step 1: Replace entire file content**

```php
<?php
session_start();
require_once 'config.php';
require_once 'includes/functions.php';
$pageTitle  = 'Menus';
$activePage = 'menus';
require_once 'includes/header.php';

$categories = getAllCategories($pdo);

$header_colors = [
    'viande'  => 'entree',
    'légume'  => 'plat',
    'poisson' => 'dessert',
    'fruit'   => 'entree',
    'dessert' => 'dessert',
    'minceur' => 'plat',
];
?>

<div class="page-hero hero-magenta">
    <h1>NOS MENUS</h1>
    <p>Découvrez nos meilleures recettes par catégorie</p>
</div>

<main class="content-wrapper">

    <p class="section-intro">
        Découvrez nos suggestions de recettes organisées par catégorie, proposées par les membres de la communauté Koo2Fourchette.
    </p>

    <h2 class="section-title">RECETTES PAR CATÉGORIE</h2>

    <div class="menus-grid">
        <?php foreach ($categories as $cat):
            $recettes = getRecettesByCategorie($pdo, $cat['idCategorie']);
            if (empty($recettes)) continue;
            $recette      = $recettes[0];
            $nomCat       = htmlspecialchars($cat['nom']);
            $colorClass   = $header_colors[$cat['nom']] ?? 'plat';
            $titre        = htmlspecialchars($recette['titre']);
            $img          = htmlspecialchars($recette['img']);
            $diff         = htmlspecialchars($recette['difficulte']);
            $temps        = htmlspecialchars($recette['tempsCuisson']);
        ?>
        <div class="menu-card">
            <div class="menu-card-header <?php echo $colorClass; ?>">
                <?php echo strtoupper($nomCat); ?>
            </div>
            <a href="recette.php?id=<?php echo (int)$recette['idRecette']; ?>" style="text-decoration:none;color:inherit;display:block;">
                <div class="menu-card-img">
                    <img src="photos/recettes/<?php echo $img; ?>" alt="<?php echo $titre; ?>">
                </div>
                <div class="menu-card-body">
                    <p class="menu-recette-titre"><?php echo $titre; ?></p>
                    <p class="menu-recette-meta"><?php echo $diff; ?> · <?php echo $temps; ?></p>
                </div>
            </a>
        </div>
        <?php endforeach; ?>
    </div>

</main>

<?php require_once 'includes/footer.php'; ?>
```

- [ ] **Step 2: Add `.menu-card-img` CSS to `style.css`**

Append at the end of `style.css`:

```css
/* ===== MENUS DYNAMIC ===== */
.menu-card-img {
    height: 160px;
    overflow: hidden;
}

.menu-card-img img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
    transition: transform 0.2s ease;
}

.menu-card:hover .menu-card-img img {
    transform: scale(1.03);
}

.menu-recette-titre {
    font-weight: 700;
    font-size: 15px;
    color: #333;
    margin-bottom: 5px;
}

.menu-recette-meta {
    font-size: 12px;
    color: #888;
}
```

- [ ] **Step 3: Verify in browser**

Open `http://localhost/Koo2fourchette/menus.php`

Expected: one card per category (up to 6), each showing a real recipe photo, title, difficulty, cook time. Clicking a card opens `recette.php?id=X`.

- [ ] **Step 4: Commit**

```bash
git add menus.php style.css
git commit -m "feat: replace static menus.php with dynamic DB content by category"
```

---

## Task 9: Complete `ajouter_recette.php` — All DB Fields

**Files:**
- Modify: `ajouter_recette.php`

- [ ] **Step 1: Replace the entire file**

```php
<?php
session_start();
require 'config.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}
$membre_id = $_SESSION['user_id'];
$categories = getAllCategories($pdo);

$success = false;
$error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    $titre           = trim($_POST['titre']           ?? '');
    $chapo           = trim($_POST['chapo']           ?? '');
    $preparation     = trim($_POST['preparation']     ?? '');
    $ingredient      = trim($_POST['ingredient']      ?? '');
    $tempsPrep       = trim($_POST['tempsPreparation'] ?? '');
    $tempsCuiss      = trim($_POST['tempsCuisson']    ?? '');
    $difficulte      = trim($_POST['difficulte']      ?? '');
    $prix            = trim($_POST['prix']            ?? '');
    $couleur         = trim($_POST['couleur']         ?? '');
    $categorie       = (int)($_POST['categorie']      ?? 0);

    $allowed_diff    = ['Facile', 'Moyen', 'Difficile'];
    $allowed_prix    = ['Pas cher', 'Abordable', 'Coûteux'];
    $allowed_couleur = ['fushia', 'vertClair', 'bleuClair'];

    if (empty($titre) || empty($chapo) || empty($preparation) || empty($ingredient)
        || empty($tempsPrep) || empty($tempsCuiss) || $categorie <= 0
        || !in_array($difficulte, $allowed_diff)
        || !in_array($prix, $allowed_prix)
        || !in_array($couleur, $allowed_couleur)) {
        $error = 'Veuillez remplir tous les champs correctement.';
    } else {
        $imgType = $_FILES['image']['type'];
        if (!in_array($imgType, ['image/jpeg', 'image/png'])) {
            $error = 'Seuls les formats JPG et PNG sont autorisés.';
        } else {
            $imgName   = basename($_FILES['image']['name']);
            $targetDir = 'photos/recettes/';
            $targetFile = $targetDir . $imgName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $sql = "INSERT INTO recettes
                            (titre, chapo, img, preparation, ingredient, membre, categorie,
                             difficulte, prix, tempsPreparation, tempsCuisson, couleur)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $pdo->prepare($sql);
                if ($stmt->execute([
                    $titre, $chapo, $imgName, $preparation, $ingredient,
                    $membre_id, $categorie, $difficulte, $prix,
                    $tempsPrep, $tempsCuiss, $couleur
                ])) {
                    $success = true;
                } else {
                    $error = 'Erreur lors de l\'enregistrement en base de données.';
                }
            } else {
                $error = 'Erreur lors de l\'upload. Vérifiez les permissions CHMOD 777 sur ' . $targetDir;
            }
        }
    }
}

$pageTitle  = 'Déposer une recette';
$activePage = 'recettes';
require_once 'includes/header.php';
?>

<div class="page-hero hero-magenta">
    <h1>DÉPOSER UNE RECETTE</h1>
    <p>Partagez votre recette avec la communauté</p>
</div>

<main class="content-wrapper">
    <div class="form-container">
        <h2 class="section-title" style="text-align:center; margin-bottom:30px;">Nouvelle recette</h2>

        <?php if ($success): ?>
            <p style="color:green; font-weight:bold; text-align:center; padding:20px;">
                Recette ajoutée avec succès ! <a href="index.php">Retour à l'accueil</a>
            </p>
        <?php else: ?>

        <?php if ($error): ?>
            <p style="color:red; font-weight:bold; margin-bottom:20px;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">

            <label for="titre">Titre de la recette *</label>
            <input type="text" id="titre" name="titre" placeholder="Ex: Gâteau au chocolat"
                   value="<?php echo htmlspecialchars($_POST['titre'] ?? ''); ?>" required>

            <label for="chapo">Description courte *</label>
            <textarea id="chapo" name="chapo" placeholder="Décrivez votre recette en quelques lignes..." required><?php echo htmlspecialchars($_POST['chapo'] ?? ''); ?></textarea>

            <label for="categorie">Catégorie *</label>
            <select id="categorie" name="categorie" required>
                <option value="">-- Choisissez --</option>
                <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['idCategorie']; ?>"
                    <?php if (isset($_POST['categorie']) && $_POST['categorie'] == $cat['idCategorie']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars(ucfirst($cat['nom'])); ?>
                </option>
                <?php endforeach; ?>
            </select>

            <label for="ingredient">Ingrédients *</label>
            <textarea id="ingredient" name="ingredient"
                      placeholder="Ex: 200g de farine, 3 oeufs..." required><?php echo htmlspecialchars($_POST['ingredient'] ?? ''); ?></textarea>

            <label for="preparation">Préparation *</label>
            <textarea id="preparation" name="preparation"
                      placeholder="Décrivez les étapes de préparation..." required><?php echo htmlspecialchars($_POST['preparation'] ?? ''); ?></textarea>

            <div class="form-row">
                <div class="form-col">
                    <label for="tempsPreparation">Temps de préparation *</label>
                    <input type="text" id="tempsPreparation" name="tempsPreparation"
                           placeholder="Ex: 20 min"
                           value="<?php echo htmlspecialchars($_POST['tempsPreparation'] ?? ''); ?>" required>
                </div>
                <div class="form-col">
                    <label for="tempsCuisson">Temps de cuisson *</label>
                    <input type="text" id="tempsCuisson" name="tempsCuisson"
                           placeholder="Ex: 30 min"
                           value="<?php echo htmlspecialchars($_POST['tempsCuisson'] ?? ''); ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label for="difficulte">Difficulté *</label>
                    <select id="difficulte" name="difficulte" required>
                        <option value="">-- Choisissez --</option>
                        <?php foreach (['Facile','Moyen','Difficile'] as $d): ?>
                        <option value="<?php echo $d; ?>"
                            <?php if (isset($_POST['difficulte']) && $_POST['difficulte'] === $d) echo 'selected'; ?>>
                            <?php echo $d; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-col">
                    <label for="prix">Budget *</label>
                    <select id="prix" name="prix" required>
                        <option value="">-- Choisissez --</option>
                        <?php foreach (['Pas cher','Abordable','Coûteux'] as $p): ?>
                        <option value="<?php echo $p; ?>"
                            <?php if (isset($_POST['prix']) && $_POST['prix'] === $p) echo 'selected'; ?>>
                            <?php echo $p; ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <label for="couleur">Couleur de la carte *</label>
            <select id="couleur" name="couleur" required>
                <option value="">-- Choisissez --</option>
                <option value="fushia"    <?php if (isset($_POST['couleur']) && $_POST['couleur'] === 'fushia')    echo 'selected'; ?>>Rose Fushia</option>
                <option value="vertClair" <?php if (isset($_POST['couleur']) && $_POST['couleur'] === 'vertClair') echo 'selected'; ?>>Vert Anis</option>
                <option value="bleuClair" <?php if (isset($_POST['couleur']) && $_POST['couleur'] === 'bleuClair') echo 'selected'; ?>>Bleu</option>
            </select>

            <label for="image">Photo (JPG ou PNG) *</label>
            <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png" required>

            <button type="submit" class="btn-deposer" style="margin-top:20px;">Envoyer la recette</button>

        </form>

        <?php endif; ?>
    </div>
</main>

<?php require_once 'includes/footer.php'; ?>
```

- [ ] **Step 2: Add form layout CSS to `style.css`**

Append at the end of `style.css`:

```css
/* ===== FORM AJOUTER RECETTE ===== */
.form-container {
    max-width: 700px;
    margin: 40px auto;
    padding: 30px;
    background: #f4f4f4;
    border: 1px solid #ddd;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.form-container label {
    display: block;
    margin-bottom: 5px;
    font-weight: bold;
    color: var(--couleur-texte);
}

.form-container input[type="text"],
.form-container textarea,
.form-container select,
.form-container input[type="file"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    font-size: 14px;
}

.form-container textarea {
    min-height: 120px;
    resize: vertical;
}

.form-row {
    display: flex;
    gap: 20px;
}

.form-col {
    flex: 1;
}
```

- [ ] **Step 3: Verify in browser**

1. Log in as any member (e.g. login: `annie`, password: look up SHA1 in the DB — or create a test account via inscription.php).
2. Open `http://localhost/Koo2fourchette/ajouter_recette.php`
3. Expected: full form with all fields (titre, chapo, catégorie dropdown, ingrédients, préparation, 2 temps, difficulté, prix, couleur, photo).
4. Submit a test recipe → expected success message.
5. Open `index.php` → new recipe should appear in the 3 most recent if it's the latest.

- [ ] **Step 4: Commit**

```bash
git add ajouter_recette.php style.css
git commit -m "feat: complete ajouter_recette.php with all DB fields"
```

---

## Self-Review

### Spec Coverage Check

| Spec Requirement | Task |
|---|---|
| `includes/functions.php` with 4 functions | Task 1 |
| `recette.php` with all fields, badges, author, error handling | Task 2 |
| `recherche.php` with LIKE search, empty state, redirect | Task 3 |
| Header search bar wired to recherche.php | Task 4 |
| `index.php` cards clickable, layout unchanged | Task 5 |
| `deserts.php` with author + links | Task 6 |
| `minceur.php` with author + links | Task 7 |
| `menus.php` dynamic from DB by category | Task 8 |
| `ajouter_recette.php` with all 13 fields | Task 9 |
| `categories` table used (menus + ajouter) | Tasks 8 & 9 |

### Function Name Consistency

- `getRecetteById` — defined Task 1, used Task 2 ✓
- `getRecettesByCategorie` — defined Task 1, used Tasks 6, 7, 8 ✓
- `searchRecettes` — defined Task 1, used Task 3 ✓
- `getAllCategories` — defined Task 1, used Tasks 8, 9 ✓

### Placeholder Scan

No TBD, no TODO, no "similar to Task N", no missing code blocks. All field names match the SQL schema.
