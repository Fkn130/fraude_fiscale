<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
echo '
<nav>
  <ul>
    <a href="index.php">Accueil</a>
    <a href="page_connexion.php">Connexion</a>
    <a href="espace_client.php">Espace client</a>
    <a href="traitement_inscription.php">Inscription</a>
    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
            <li><a href="admin.php">Administrateur</a></li>
            <li><a href="deconnexion.php">Déconnexion (Admin)</a></li>
        <?php elseif (isset($_SESSION['id'])): ?>
            <li><a href="deconnexion.php">Déconnexion</a></li>
        <?php endif; ?>
    </ul>
</nav>
  </ul>
</nav>';
?>