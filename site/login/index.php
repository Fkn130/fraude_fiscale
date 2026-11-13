<?php
include_once "../../element/header.php";
?>
<body>
    <h1>Bonjour, bienvenu dans le tournoi du jeu vidéo !</h1>
    <?php include_once "../../element/nav.php"; ?>
<br>
<br>
    <h2>Liste des inscriptions aux événements</h2>
<br>
    <div class="liste-inscriptions">
        <?php
        // Inclure la connexion à la base de données
        include_once "../../script/bdd.php";
        ?>
        <h2>S'inscrire à un événement</h2>

        <!-- Formulaire d'inscription sur la page d'accueil -->
        <form action="traitement_inscription.php" method="POST">
        <label for="nom_evenement">Nom de l''événement :</label><br>
        <input type="text" id="nom_evenement" name="nom_evenement" placeholder="Nom de l'événement" required><br><br>

        <label for="date_evenement">Date de l''événement :</label><br>
        <input type="date" id="date_evenement" name="date_evenement" required><br><br>

        <button type="submit">Inscription à l'événement</button>
    </form>
</body>
</html>