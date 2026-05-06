# Design : Utilisation complète de la base de données

**Date :** 2026-04-15  
**Projet :** Koo2Fourchette  
**Statut :** Approuvé

---

## Contexte

Le site Koo2Fourchette dispose d'une base de données MySQL (`koo_2_fourchette`) avec 3 tables :
- `categories` (idCategorie, nom) — 6 catégories : viande, légume, poisson, fruit, dessert, minceur
- `membres` (idMembre, gravatar, login, password, statut, prenom, nom, dateCrea)
- `recettes` (idRecette, titre, chapo, img, preparation, ingredient, membre, couleur, dateCrea, categorie, tempsCuisson, tempsPreparation, difficulte, prix)

### Problème actuel

De nombreuses données de la BD ne sont pas exploitées :
- `preparation` et `ingredient` ne sont jamais affichés
- `tempsPreparation`, `tempsCuisson`, `difficulte`, `prix` apparaissent sur quelques pages seulement
- L'auteur (gravatar + prénom) n'est visible que sur l'index
- `menus.php` et `atelier.php` sont 100% statiques (aucune requête BD)
- La table `categories` n'est jamais utilisée (IDs codés en dur)
- La barre de recherche est inactive
- `ajouter_recette.php` ne capture que 3 champs sur 13

### Contrainte

`index.php` ne doit pas être modifié dans sa structure ou son layout — uniquement ajout de liens cliquables sur les cartes.

---

## Architecture

### Approche choisie : Option B — `functions.php` centralisé

Un fichier `includes/functions.php` concentre toutes les fonctions BD réutilisables. Les pages restent simples et n'appellent que ces fonctions.

### Nouveaux fichiers

| Fichier | Rôle |
|---|---|
| `includes/functions.php` | Fonctions BD réutilisables |
| `recette.php` | Page de détail d'une recette |
| `recherche.php` | Page de résultats de recherche |

### Fichiers modifiés

| Fichier | Changement |
|---|---|
| `index.php` | Cartes cliquables → `recette.php?id=X` (layout inchangé) |
| `deserts.php` | Auteur (gravatar + prénom) + lien vers `recette.php` |
| `minceur.php` | Auteur (gravatar + prénom) + lien vers `recette.php` |
| `menus.php` | Remplacer HTML statique par recettes réelles par catégorie |
| `ajouter_recette.php` | Ajouter tous les champs manquants |
| `includes/header.php` | Brancher la barre de recherche sur `recherche.php` |

---

## Composants

### `includes/functions.php`

Fonctions :
- `getRecetteById($pdo, $id)` — retourne une recette avec JOIN membre, ou `false` si introuvable
- `getRecettesByCategorie($pdo, $categorieId)` — retourne toutes les recettes d'une catégorie avec JOIN membre
- `searchRecettes($pdo, $query)` — recherche par titre (`LIKE %query%`) avec JOIN membre
- `getAllCategories($pdo)` — retourne toutes les catégories

### `recette.php`

Accessible via `recette.php?id=5`.

Structure de la page :
- **En-tête** : grande photo, titre, chapo — couleur de fond selon champ `couleur` (même mapping que l'index)
- **Badges métadonnées** : 4 icônes (images existantes : temps.png, cuisson.png, prix.png) + difficulté — tempsPreparation, tempsCuisson, difficulte, prix
- **Corps en 2 colonnes** :
  - Gauche : liste des ingrédients (champ `ingredient`, HTML `<ul>` existant)
  - Droite : étapes de préparation (champ `preparation`, HTML `<ol>` existant)
- **Footer** : gravatar + prénom de l'auteur + date de création
- **Lien retour** vers l'index
- **Gestion d'erreur** : si `id` absent ou invalide → message d'erreur propre, pas de crash

### `recherche.php`

Accessible via `recherche.php?q=carotte`.

- Requête `LIKE %query%` sur le champ `titre`
- Grille de résultats au même style que l'index
- Chaque carte cliquable → `recette.php?id=X`
- Si aucun résultat → message "Aucune recette trouvée pour *[terme]*"
- Si `q` vide → redirection vers `index.php`

### `menus.php`

Remplace le HTML statique par une grille dynamique :
- Une carte par catégorie de la table `categories`
- Chaque carte : nom de la catégorie en header, photo + titre de la recette la plus récente (`ORDER BY dateCrea DESC LIMIT 1`)
- Lien vers `recette.php?id=X`
- Catégorie sans recette → carte masquée

### `ajouter_recette.php`

Champs ajoutés au formulaire :
- **Catégorie** : `<select>` chargé depuis `getAllCategories()`
- **Ingrédients** : `<textarea>`
- **Préparation** : `<textarea>`
- **Temps de préparation** : `<input type="text">` (ex : "20 min")
- **Temps de cuisson** : `<input type="text">` (ex : "30 min")
- **Difficulté** : `<select>` (Facile / Moyen / Difficile)
- **Prix** : `<select>` (Pas cher / Abordable / Coûteux)
- **Couleur** : `<select>` (fushia / vertClair / bleuClair)

### `deserts.php` et `minceur.php`

- Requêtes enrichies avec `LEFT JOIN membres` pour récupérer gravatar et prénom
- Affichage de l'auteur en bas de chaque carte (même style que l'index)
- Titre de chaque carte devient un lien vers `recette.php?id=X`

### `includes/header.php`

- La `<form>` de la barre de recherche pointe vers `recherche.php` (méthode GET, param `q`)

---

## Flux de données

```
BD recettes ──┬──> index.php (3 dernières, liens vers recette.php)
              ├──> recette.php (détail complet)
              ├──> recherche.php (résultats LIKE)
              ├──> deserts.php (categorie=5, avec auteur)
              ├──> minceur.php (categorie=6, avec auteur)
              └──> menus.php (1 recette par catégorie)

BD categories ──> menus.php + ajouter_recette.php (select)

BD membres ──> recette.php + deserts.php + minceur.php + index.php (via JOIN)
```

---

## Gestion des erreurs

- `recette.php` : ID manquant ou inexistant → message clair, lien retour
- `recherche.php` : query vide → redirect index, aucun résultat → message explicite
- `ajouter_recette.php` : validation côté serveur sur tous les nouveaux champs requis

---

## Hors périmètre

- `atelier.php` — les ateliers ne sont pas dans la BD, page laissée statique
- `contact.php` — formulaire de contact, pas de lien avec la BD recettes
- Authentification — aucun changement au système de connexion/inscription
- `index.php` — layout inchangé, uniquement ajout de `href` sur les cartes existantes
