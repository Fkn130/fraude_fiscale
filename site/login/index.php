<?php
include_once "element/header.php"
?>
<body>
    <H1>Bonjour, bienvenu dans le tournoi du jeu vidéo !</H1>
    <?php
        include_once "element/nav_bar.php"
    ?>
    <?php
        include_once "script/table_event.php";

        foreach ($rows as $row) {
            printf($row["even_jeux_video"], $row["date_heure_even"]);
        }
    ?>
</body>

</html>