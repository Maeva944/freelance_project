<?php

class PortfolioModel {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Récupérer les travaux du portfolio d'un freelance
    public function getPortfoliosByFreelance($freelanceId) {
        $stmt = $this->pdo->prepare("SELECT * FROM portfolios WHERE freelance_id = :freelance_id ORDER BY created_at DESC");
        $stmt->execute(['freelance_id' => $freelanceId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Ajouter un travail au portfolio
    public function addPortfolio($freelanceId, $title, $description, $imageUrl) {
        $stmt = $this->pdo->prepare("
            INSERT INTO portfolios (freelance_id, title, description, image_url) 
            VALUES (:freelance_id, :title, :description, :image_url)
        ");
        $stmt->execute([
            'freelance_id' => $freelanceId,
            'title' => $title,
            'description' => $description,
            'image_url' => $imageUrl
        ]);
    }

    // Supprimer un travail du portfolio
    public function deletePortfolio($portfolioId, $freelanceId) {
        $stmt = $this->pdo->prepare("DELETE FROM portfolios WHERE id = :id AND freelance_id = :freelance_id");
        $stmt->execute([
            'id' => $portfolioId,
            'freelance_id' => $freelanceId
        ]);
    }
}
