<?php
include_once "header.php"
?>
<body>
    <H1>Bondour, bienvenuuu dans li tournwa di jou vidio !</H1>

    <?php
    include_once "table_event.php";

    foreach ($rows as $row) {
        printf($row["even_jeux_video"], $row["date_heure_even"]);
    }
    ?>
    <H1>Bonjour, bienvenu dans le tournoi du jeu vidéo !</H1>
    <nav>
        <ul>
            <a href="index.php">Accueil</a>
            <a href="page_connexion.php">Connexion</a>
        </ul>
    </nav>
</body>

</html>