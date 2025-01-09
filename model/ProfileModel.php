<?php

class ProfileModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer le profil par user_id
    public function getProfileByUserId($userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM profiles WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Ajouter ou mettre à jour un profil
    public function upsertProfile($userId, $bio, $profilePicture, $portfolioLink) {
        $stmt = $this->pdo->prepare("
            INSERT INTO profiles (id, bio, profile_picture, portfolio_link) 
            VALUES (:id, :bio, :profile_picture, :portfolio_link)
            ON DUPLICATE KEY UPDATE 
                bio = :bio, 
                profile_picture = :profile_picture, 
                portfolio_link = :portfolio_link
        ");
        $stmt->execute([
            'id' => $userId,
            'bio' => $bio,
            'profile_picture' => $profilePicture,
            'portfolio_link' => $portfolioLink
        ]);
    }
}
