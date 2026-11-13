<?php
    include_once "../../element/header.php";
?>
<body>
    <h1>Client</h1>
    <?php
    include_once "../../element/nav.php";
    ?>
    <input type="text" placeholder="Rechercher un événement" id="searchInput" onkeyup="searchEvents()">
    <div id="eventList">
        <?php
            include_once "../../script/table_event.php";

            foreach ($rows as $row) {
                printf($row["even_jeux_video"], $row["date_heure_even"]);
            }
        ?>
    </div>
    <form action="traitement_inscription.php" method="POST">
        <input type="text" name="nom_evenement" placeholder="Nom de l'événement" required><br>
        <input type="date" name="date_evenement" required><br><br>
         <button type="submit">Inscription à l'événement</button>
    </form>       
</body>

</html>
Récup les anciennes réservations.<br>
Pouvoir s'incrire a un evenement