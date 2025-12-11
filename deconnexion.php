<?php
session_start();
session_destroy(); // On détruit toutes les traces
header("Location: index.php"); // Retour à l'accueil
exit;
?>