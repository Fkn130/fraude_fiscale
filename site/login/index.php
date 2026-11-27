<?php
include_once "../../script/inscription_event.php";
include_once "../../element/header.php";
?>
<body>
    <h1>Bonjour, bienvenue dans le tournoi du jeu vidéo !</h1>
    <?php
    include_once "../../element/nav.php";
    ?>

    <h2>Agenda des événements</h2>

    <?php
    include_once "../../script/bdd.php";

    // Date sélectionnée par l'utilisateur (ex: 2026-11-15)
    $date_choisie = $_GET['jour'] ?? '';

    // Récupération des événements (filtrés par jour si un jour est choisi)
    if (!empty($date_choisie)) {
        $sql = "SELECT id_evenement, even_jeux_video, date_heure_even 
                FROM Evenement 
                WHERE DATE(date_heure_even) = ? 
                ORDER BY date_heure_even ASC";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "s", $date_choisie);
        mysqli_stmt_execute($stmt);
        $resultats = mysqli_stmt_get_result($stmt);
        $rows = mysqli_fetch_all($resultats, MYSQLI_ASSOC);
    } else {
        include_once "../../script/table_event.php";
    }
    ?>

    <!-- Liste des événements du jour choisi -->
    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th class="tete_tableau">Horaire</th>
                    <th class="tete_tableau">Événement</th>
                    <th class="tete_tableau">Inscription</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($rows)): ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row["date_heure_even"]) ?></td>
                            <td class="nom_evenement"><?= htmlspecialchars($row["even_jeux_video"]) ?></td>
                            <td>
                                <form method="POST" action="../script/inscription_event.php">
                                    <input type="hidden" name="id_evenement" value="<?= htmlspecialchars($row["id_evenement"] ?? $row["id"] ?? '') ?>">
                                    <button type="submit" class="btn-inscription">S'inscrire</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">Aucun événement prévu pour ce jour.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include_once "../../element/footer.php"; ?>
</body>
</html>