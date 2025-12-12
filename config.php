<?php
// config.php
$host = 'localhost';
$dbname = 'koo_2_fourchette';
$username = 'ethan';
$password = 'ethan'; // REMPLACEZ PAR VOTRE VRAI MOT DE PASSE MYSQL !

try {
    // Connexion initiale sans forcer le charset dans le DSN
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // NOUVEAU : Forcer MySQL à utiliser l'encodage UTF8 pour corriger les accents (Ã©)
    $pdo->exec("SET NAMES 'UTF8'"); 
    
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si l'erreur persiste, affichez le message
    die("Erreur de connexion : " . $e->getMessage());
}
?>