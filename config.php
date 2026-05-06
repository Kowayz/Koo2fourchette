<?php
// config.php
$host = 'localhost';
$dbname = 'koo_2_fourchette';
$username = 'ethan';
$password = 'ethan'; // Utilisez votre vrai mot de passe MySQL ici

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    $pdo->exec("SET NAMES 'latin1'");
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>