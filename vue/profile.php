<?php
session_start();
require_once'../model/ProfileModel.php';
require_once'../bdd/Database.php';

// Vérifie si l'utilisateur est connecté


// Inclure la classe Database et le modèle PortfolioModel
require_once '../bdd/Database.php';
require_once '../model/PortfolioModel.php';

// Connexion à la base de données
$database = new Database();
$pdo = $database->pdo;

// Instancier le modèle
$portfolioModel = new PortfolioModel($pdo);

// ID de l'utilisateur connecté
$freelanceId = $_SESSION['id'];

// Gestion des actions : ajout ou suppression d'un travail
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        // Ajout d'un travail
        $title = trim(htmlspecialchars($_POST['title']));
        $description = trim(htmlspecialchars($_POST['description']));
        $imageUrl = null;

        // Upload de l'image
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = '../uploads/';
            $uploadFile = $uploadDir . uniqid() . '-' . basename($_FILES['image']['name']); // Nom unique

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imageUrl = $uploadFile;
            } else {
                $error = "Erreur lors de l'upload de l'image.";
            }
        }

        if (!$error) {
            $portfolioModel->addPortfolio($freelanceId, $title, $description, $imageUrl);
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['portfolio_id'])) {
        // Suppression d'un travail
        $portfolioId = intval($_POST['portfolio_id']);
        $portfolioModel->deletePortfolio($portfolioId, $freelanceId);
    }
}

// Récupérer les travaux du portfolio
$portfolios = $portfolioModel->getPortfoliosByFreelance($freelanceId);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Portfolio</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Mon Portfolio</h1>

    <!-- Formulaire pour ajouter un nouveau travail -->
    <form action="profile.php" method="POST">
        <input type="hidden" name="action" value="add">
        <label for="title">Titre :</label>
        <input type="text" name="title" id="title" required>

        <label for="description">Description :</label>
        <textarea name="description" id="description" required></textarea>

        <label for="image">Image :</label>
        <input type="file" name="image" id="image">

        <button type="submit">Ajouter</button>
    </form>

    <h2>Travaux</h2>

    <!-- Liste des travaux -->
    <?php foreach ($portfolios as $portfolio): ?>
        <div class="portfolio-item">
            <h3><?= htmlspecialchars($portfolio['title']) ?></h3>
            <p><?= htmlspecialchars($portfolio['description']) ?></p>
            <?php if (!empty($portfolio['image_url'])): ?>
                <img src="<?= htmlspecialchars($portfolio['image_url']) ?>" alt="<?= htmlspecialchars($portfolio['title']) ?>" style="max-width: 200px;">
            <?php endif; ?>
            <form action="portfolio.php" method="POST">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="portfolio_id" value="<?= $portfolio['id'] ?>">
                <button type="submit">Supprimer</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
