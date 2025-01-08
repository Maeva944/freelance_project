<?php 
session_start();
require_once '../bdd/Database.php';
require_once '../model/UserModel.php';
$database = new Database();
$pdo = $database->pdo;
$userModel = new UserModel($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Code de traitement
    $firstname = trim(htmlspecialchars($_POST['firstname']));
    $lastname = trim(htmlspecialchars($_POST['lastname']));
    $username = trim(htmlspecialchars($_POST['username']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $role = trim(htmlspecialchars($_POST['role']));

    // Vérification et hashage
    if (empty($firstname) || empty($lastname) || empty($email) || empty($password) || empty($role) || empty($username)) {
        echo "Tous les champs sont requis.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        try {
            $userModel->registerUser($firstname, $lastname, $username, $email, $hashed_password, $role);
            echo "Inscription réussie !";
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
        }
    }
}

?>
<body>
    <form action="register.php" method="POST">
        <label for="firstname">Prénom</label>
        <input type="text" name="firstname" id="firstname" required>

        <label for="lastname">Nom</label>
        <input type="text" name="lastname" id="lastname" required>

        <label for="username">Nom d'utilisateur</label>
        <input type="text" name="username" id="username" required>

        <label for="email">Adresse email :</label>
        <input type="email" name="email" id="email" required>

        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" required>

        <label for="role">Vous êtes un(e)</label>
        <select name="role" id="role" required>
            <option value="freelance">Freelance</option>
            <option value="recruiter">Recruteur(euse)</option>
        </select>

        <button type="submit">S'inscrire</button>


    </form>
</body>