<?php 
session_start();

// Afficher la session pour déboguer (optionnel)
var_dump($_SESSION); 

// Vérification si l'utilisateur est connecté et s'il est un recruteur
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'recruiter') {
    die("Accès interdit.");
}

echo "dashboard recruiter";
?>

<a href="logout.php">Déconnexion</a>
