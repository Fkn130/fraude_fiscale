<?php
    include_once "../../element/header.php";
?>
<body>
    <h1>Client</h1>
    <?php
    include_once "../../element/nav.php";
    ?>
    <br>

    <section id="historique-reservations">
    <h2>Récupérer les anciennes réservations</h2>
    <?php
    // Démarrer la session si ce n'est pas déjà fait pour récupérer l'ID du client connecté
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    // Inclure la connexion à la base de données
    include_once "../../script/bdd.php";

    // Vérifier si le client est connecté
    if (isset($_SESSION['id_utilisateur'])) {
        $id_client = $_SESSION['id_utilisateur'];    
        if (!empty($reservations)) {
            foreach ($reservations as $res) {
                echo "<div class='carte-reservation'>";
                echo "<strong>Événement :</strong> " . htmlspecialchars($res["even_jeux_video"]) . "<br>";
                echo "<strong>Date :</strong> " . htmlspecialchars($res["date_heure_even"]) . "<br>";
                echo "</div><hr>";
            }
        } else {
            // Si aucune réservation n'est trouvée pour le client
            echo "<p>Vous n'avez aucune réservation enregistrée.</p>";
        }
    }
    ?>
</section>
</body>
</html>