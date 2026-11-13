<?php
include_once "../../element/header.php";
?>
<body>
<<<<<<< HEAD
    <h1>Bonjour, bienvenue dans le tournoi du jeu vidéo !</h1>
    <?php
    include_once "../../element/nav.php";
    ?>


    <h2>Liste des inscriptions aux événements</h2>
<br>
    <div class="liste-inscriptions">
        <?php
        // Inclure la connexion à la base de données
        include_once "../../script/bdd.php";
        ?>
        <h2>S'inscrire à un événement</h2>

        <div class="liste-evenements">
            <input type="text" id="nom_evenement" name="nom_evenement" placeholder="Nom de l'événement" required><br><br>
        <?php
        // Inclure la liste des événements depuis la base de données
        include_once "../../script/table_event.php";

        if (!empty($rows)) {
            foreach ($rows as $row) {
                echo "<div class='carte-evenement' style='border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;'>";
                echo "<strong>Événement :</strong> " . htmlspecialchars($row["even_jeux_video"]) . "<br>";
                echo "<strong>Date :</strong> " . htmlspecialchars($row["date_heure_even"]) . "<br>";
                
                // Formulaire avec un bouton d'inscription pour cet événement précis
                echo "<form action='traitement_inscription.php' method='POST' style='margin-top: 8px;'>";
                // On transmet l'ID de l'événement (assurez-vous que $row['id'] correspond à votre colonne en BDD)
                echo "<input type='hidden' name='id_evenement' value='" . $row["id"] . "'>";
                echo "<button type='submit'>S'inscrire à cet événement</button>";
                echo "</form>";
                
                echo "</div>";
            }
        } else {
            echo "<p>Aucun événement disponible pour le moment.</p>";
        }
        ?>
    </div>
</body>
</html>