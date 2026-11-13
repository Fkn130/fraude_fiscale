<?php include_once "element/header.php" ?>

<body>

    <h1>Gestion des evenements</h1>

    <section class="Liste_event_admin">
        
    <?php 
        // Requete d'affichage de la gestion des elements 
        $requete = "SELECT * FROM Evenement";
        $resultat = mysqli_query($connexion, $requete);
    ?>



    </section>



</body>