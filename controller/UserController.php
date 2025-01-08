<?php

require_once '../model/UserModel.php';

class UserController {
    private $model;

    public function __construct($pdo) {
        $this->model = new UserModel($pdo);
    }

    // Méthode pour afficher la page d'inscription et gérer la soumission du formulaire
    public function register() {
        $error = null;
        $success = null;

        // Vérifie si le formulaire est soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et validation des données du formulaire
            $firstname = trim(htmlspecialchars($_POST['firstname']));
            $lastname = trim(htmlspecialchars($_POST['lastname']));
            $username = trim(htmlspecialchars($_POST['username']));
            $email = trim(htmlspecialchars($_POST['email']));
            $password = trim(htmlspecialchars($_POST['password']));
            $role = trim(htmlspecialchars($_POST['role'])); // 'freelance' ou 'recruiter'

            // Vérification des champs vides
            if (empty($lastname) || empty($email) || empty($password) || empty($role) || empty($firstname) || empty($username)) {
                $error = "Tous les champs sont requis.";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Veuillez entrer une adresse email valide.";
            } elseif (!in_array($role, ['freelance', 'recruiter'])) {
                $error = "Le rôle sélectionné est invalide.";
            } else {
                // Hashage du mot de passe
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                try {
                    // Appelle le modèle pour enregistrer l'utilisateur
                    $this->model->registerUser($firstname, $lastname, $username, $email, $hashed_password, $role);
                    $success = "Inscription réussie ! Vous pouvez maintenant vous connecter.";
                } catch (Exception $e) {
                    $error = $e->getMessage();
                }
            }
        }

        // Charge la vue d'inscription
        include '../vue/register.php';
    }
}
