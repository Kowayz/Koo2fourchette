<?php
// config.php
$host = 'localhost';
$dbname = 'koo_2_fourchette';
$username = 'ethan';
$password = 'ethan'; // Utilisez votre vrai mot de passe MySQL ici

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // CORRECTION ACCENTS : Forcer MySQL à communiquer en UTF8
    $pdo->exec("SET NAMES 'UTF8'"); 
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>