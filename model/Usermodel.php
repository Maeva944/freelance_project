<?php

class UserModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour inscrire un utilisateur
    public function registerUser($firstname, $lastname, $username, $email, $hashed_password, $role) {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO users (first_name, last_name, username, email, password, role) 
                VALUES (:first_name, :last_name, :username, :email, :password, :role)
            ");
            $stmt->execute([
                'first_name' => $firstname,
                'last_name' => $lastname,
                'username' => $username,
                'email' => $email,
                'password' => $hashed_password,
                'role' => $role
            ]);
            echo "Votre inscription a bien été enregistrée."; 
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'inscription : " . $e->getMessage());
        }
    }

    // Méthode pour gérer la connexion et afficher le dashboard
    public function login() {
        // Récupérer les données de connexion
        $username = trim(htmlspecialchars($_POST['username']));
        $password = trim(htmlspecialchars($_POST['password']));

        // Valider si les champs sont remplis
        if (empty($username) || empty($password)) {
            return "Veuillez entrer vos identifiants.";
        }

        // Préparer la requête pour récupérer l'utilisateur
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['password'])) {
            // L'utilisateur est authentifié, récupérer son rôle
            $role = $user['role'];

            // Démarrer la session et stocker le rôle de l'utilisateur
            session_start();
            $_SESSION['role'] = $role;

            // Rediriger vers le dashboard correspondant en fonction du rôle
            if ($role === 'freelance') {
                header("Location: dashboard_freelance.php");
                exit;
            } elseif ($role === 'recruiter') {
                header("Location: dashboard_recruiter.php");
                exit;
            } else {
                return "Rôle non reconnu.";
            }
        } else {
            return "Identifiants incorrects.";
        }
    }

    /*public function NewPassword($password, $newpassword){
        $oldpassword = trim(htmlspecialchars($_POST['oldpassword']));
        $newpassword = trim(htmlspecialchars($_POST['newpassword']));
        $confirmationPassword = trim(htmlspecialchars($_POST['confirmationpassword']));

        if(empty($oldpassword) || empty($newpassword) || empty($confirmationPassword)){
            return "Veuillez remplir tous les champs.";
        }

        // Préparer la requête pour récupérer l'utilisateur
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])){

        }
    }*/
}
?>

