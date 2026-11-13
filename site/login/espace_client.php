<?php
    include_once "../../element/header.php";
?>
<body>
    <h1>Client</h1>
    <?php
    include_once "../../element/nav.php";
    ?>
    <br>
    <section id="recherche-evenements">
        <input type="text" placeholder="Rechercher un événement" id="searchInput" onkeyup="searchEvents()">
        
        <div id="eventList">
            <?php
            include_once "../../script/table_event.php";

            if (!empty($rows)) {
                foreach ($rows as $row) {
                    echo "<div>" . htmlspecialchars($row["even_jeux_video"]) . " — " . htmlspecialchars($row["date_heure_even"]) . "</div>";
                }
            } else {
                echo "<p>Aucun événement disponible.</p>";
            }
            ?>
        </div>
    </section>

    <section id="formulaire-inscription">
        <h2>Pouvoir s'inscrire à un événement</h2>
        <form action="traitement_inscription.php" method="POST">
            <label for="nom_evenement">Nom de l'événement :</label><br>
            <input type="text" id="nom_evenement" name="nom_evenement" placeholder="Nom de l'événement" required><br><br>[cite: 2]

            <label for="date_evenement">Date de l'événement :</label><br>
            <input type="date" id="date_evenement" name="date_evenement" required><br><br>
            <button type="submit">Inscription à l'événement</button>
        </form>
    </section>

    <section id="historique-reservations">
        <h2>Récupérer les anciennes réservations</h2>
        <?php
        // Ajouter la requête SQL et l'affichage des anciennes réservations du client
        ?>
    </section>
</body>
</html>