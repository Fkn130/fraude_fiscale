<?php
session_start();
?>
<nav>
    <ul>
        <a href="index.php">Accueil</a>
        <a href="page_connexion.php">Connexion</a>
        <a href="espace_client.php">Espace client</a>
        <button class="btn-theme" id="themeToggle">
          🌙 Mode nuit
        </button>
        <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
            <a href="admin.php">Administrateur</a></li>
            <a href="ajout_event.php">Ajouter un événement</a>
            <a href="deconnexion.php">Déconnexion Admin</a></li>
        <?php elseif (isset($_SESSION['id'])): ?>
            <li><a href="deconnexion.php">Déconnexion</a></li>
        <?php endif; ?>
    </ul>
</nav>