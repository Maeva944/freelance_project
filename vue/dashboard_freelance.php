<?php 
session_start();
echo "dashboard freelance";
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'freelance') {
    die("Accès interdit.");
}
?>

<body>
    <section>
        <div>
            <a href="../vue/profile.php">Profils</a>
            <a href="#">Portfolio</a>
            <a href="#">Sécurité</a>
        </div>
        <div>
            <form action="dashboard_freelance.php"></form>
            <a href="logout.php">Déconnexion</a>
        </div>
    </section>
</body>