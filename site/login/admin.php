<?php include_once "element/header.php"; ?>

<body>

    <h1>Gestion des evenements</h1>

    <section class="Liste_event_admin">
        
    <?php 
        // Requete d'affichage de la gestion des elements 
        $requete = "SELECT * FROM Evenement";
        $resultat = mysqli_query($connexion, $requete);

        if($resultat) {
            // affichage du resultat
            while($row = mysqli_fetch_assoc($resultat)){
                echo "<div class='liste-item'>";   
                echo "<h2>" . $row['even_jeux_video'] . " - " . $row['date_heure_even'] . "</h2>";
                echo "</div>";

            }
        }


    ?>

    

    </section>



</body>