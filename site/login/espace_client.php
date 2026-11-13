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

    <section id="historique-reservations">
    <h2>Récupérer les anciennes réservations</h2>[cite: 7]
    <?php
    // Démarrer la session si ce n'est pas déjà fait pour récupérer l'ID du client connecté
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    include_once "../../script/bdd.php";

    // Vérifier si le client est connecté
    if (isset($_SESSION['id_utilisateur'])) {
        $id_client = $_SESSION['id_utilisateur'];

        // Requête pour récupérer uniquement les réservations de ce client
        $sql = "SELECT e.even_jeux_video, e.date_heure_even 
                FROM inscription i
                JOIN evenement e ON i.id_evenement = e.id
                WHERE i.id_utilisateur = :id_client
                ORDER BY e.date_heure_even DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_client' => $id_client]);
        $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($reservations)) {
            foreach ($reservations as $res) {
                echo "<div class='carte-reservation'>";
                echo "<strong>Événement :</strong> " . htmlspecialchars($res["even_jeux_video"]) . "<br>";
                echo "<strong>Date :</strong> " . htmlspecialchars($res["date_heure_even"]) . "<br>";
                echo "</div><hr>";
            }
        } else {
            echo "<p>Vous n'avez aucune réservation enregistrée.</p>";
        }
    } else {
        echo "<p>Veuillez vous connecter pour voir vos anciennes réservations.</p>";
    }
    ?>
</section>
</body>
</html>