<?php
include_once "../../script/inscription_event.php";
include_once "../../element/header.php";
?>
<body>
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
        <br><br>
            <?php
            // Inclure la liste des événements depuis la base de données
            include_once "../../script/table_event.php";
            echo '
            <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th class="tete_tableau">Horaire</th>
                        <th class="tete_tableau">Événement</th>
                        <th class="tete_tableau">Inscription</th>
                    </tr>
                </thead>
                <tbody>';

            foreach ($rows as $row) {
                echo '<tr>
                    <td>' . htmlspecialchars($row["date_heure_even"]) . '</td>
                    <td class="nom_evenement">' . htmlspecialchars($row["even_jeux_video"]) . '</td>
                    <td>
                    <form methode="post"
<<<<<<< HEAD
                        <input type="button" class="btn-inscription" value="'. $row["id_evenement"] .'onclick="'. inscription() .'">
=======
                        <input type="button" class="btn-inscription" value="Inscription"'. $row["id_evenement"] .'">
>>>>>>> a73f4966eff54d587c50ccf23401e9d64dd9314d
                    </td>
                </tr>';
            }

            echo '
                </tbody>
            </table>
            </div>';
        ?>
    </div>
<?php
        include_once "../../element/footer.php";
?>
</body>
</html>