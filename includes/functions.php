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
    $safe = str_replace(['\\', '%', '_'], ['\\\\', '\\%', '\\_'], $query);
    $stmt = $pdo->prepare(
        "SELECT r.*, m.prenom, m.gravatar
         FROM recettes r
         LEFT JOIN membres m ON r.membre = m.idMembre
         WHERE r.titre LIKE ? ESCAPE '\\\\'
         ORDER BY r.dateCrea DESC"
    );
    $stmt->execute(['%' . $safe . '%']);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllCategories($pdo) {
    $stmt = $pdo->query("SELECT * FROM categories ORDER BY idCategorie");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
