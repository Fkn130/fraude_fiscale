<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<nav>
    <ul>
        <a href="index.php">Accueil</a></li>
        <a href="page_connexion.php">Connexion</a></li>
        <a href="espace_client.php">Espace client</a></li>
        <a href="traitement_inscription.php">Inscription</a></li>

        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
            <a href="admin.php">Administrateur</a></li>
            <a href="deconnexion.php">Déconnexion (Admin)</a></li>
        <?php elseif (isset($_SESSION['id_utilisateur'])): ?>
            <li><a href="deconnexion.php">Déconnexion</a></li>
        <?php endif; ?>
    </ul>
</nav>