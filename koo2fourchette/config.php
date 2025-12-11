<?php
// config.php
$host = 'localhost';
$dbname = 'koo_2_fourchette';
$username = 'ethan';
$password = 'TON_MOT_DE_PASSE'; // Mets le vrai mot de passe que tu as défini

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>