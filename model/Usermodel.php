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
            echo "Votre inscription à bien été enregistré"; 
        } catch (Exception $e) {
            throw new Exception("Erreur lors de l'inscription : " . $e->getMessage());
        }
    }
}
