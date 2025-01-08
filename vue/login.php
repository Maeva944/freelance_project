<?php 
require_once'../model/Usermodel.php';
require_once'../bdd/Database.php';
session_start();
$database = new Database();
$pdo = $database->pdo;

$userModel = new UserModel($pdo);

$errorMessage = '';  // Variable pour afficher les erreurs

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errorMessage = $userModel->login();
}
        
?>

<body>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="Nom d'utilisateur" required><br>
        <input type="password" name="password" placeholder="Mot de passe" required>
        <button type="submit">Se connecter</button>
    </form>
    <p>Vous n'avez pas encore de compte ? <a href="register.php">S'inscrire</a></p>
</body>