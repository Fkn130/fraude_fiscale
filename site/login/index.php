<?php
include_once "../../element/header.php";
?>
<body>
    <h1>Bonjour, bienvenue dans le tournoi du jeu vidéo !</h1>
    <?php
    include_once "../../element/nav.php";
    ?>


    <h2>Liste des inscriptions aux événements</h2>
<br>
<<<<<<< HEAD
        <?php
        // Inclure la liste des événements depuis la base de données
        include_once "../../script/table_event.php";
=======
    <div class="liste-inscriptions">
        <?php
            // Inclure la connexion à la base de données
            include_once "../../script/bdd.php";
        ?>
        <h2>S'inscrire à un événement</h2>

        <div class="liste-evenements">
            <input type="text" id="nom_evenement" name="nom_evenement" placeholder="Nom de l'événement" required><br><br>
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
>>>>>>> efc0d315a4d2386df88f33b517110951aa911c15

            foreach ($rows as $row) {
                echo '<tr>
                    <td>' . htmlspecialchars($row["date_heure_even"]) . '</td>
                    <td class="nom_evenement">' . htmlspecialchars($row["even_jeux_video"]) . '</td>
                    <td>
                        <input type="button" class="btn-inscription" value="S\'inscrire">
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
    include_once "../../element/nav.php";
?>
</body>
</html>