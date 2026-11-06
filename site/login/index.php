<?php
    include_once "../../element/header.php";
?>
<body>
    <h1>Bonjour, bienvenu dans le tournoi du jeu vidéo !</h1>
    <?php
    include_once "../../element/nav.php";
    ?>

    <?php
        include_once "../../script/table_event.php";

        foreach ($rows as $row) {
            echo $row["even_jeux_video"] . " - " . $row["date_heure_even"] . "<br>";
        }
    ?>
</body>

</html>