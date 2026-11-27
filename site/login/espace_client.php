<?php
include_once "../../script/bdd.php";

$id_client = $_SESSION['id'] ?? $_SESSION['id_utilisateur'] ?? null;
/*
if (!$id_client) {
    if (!empty($_POST['id_evenement'])) {
        $_SESSION['evenement_en_attente'] = (int) $_POST['id_evenement'];
    }
    header("Location: page_connexion.php");
    exit;
}*/

$id_client = (int) $id_client;

// Inscription à un événement (POST depuis index.php ou reprise après connexion)
$id_evenement = null;
if (!empty($_POST['id_evenement'])) {
    $id_evenement = (int) $_POST['id_evenement'];
} elseif (!empty($_SESSION['evenement_en_attente'])) {
    $id_evenement = (int) $_SESSION['evenement_en_attente'];
    unset($_SESSION['evenement_en_attente']);
}

if ($id_evenement) {
    $stmt = mysqli_prepare(
        $mysqli,
        "INSERT IGNORE INTO sinscire (id, id_evenement) VALUES (?, ?)"
    );
    mysqli_stmt_bind_param($stmt, "ii", $id_client, $id_evenement);
    mysqli_stmt_execute($stmt);
}

// Récupérer les inscriptions du client
$sql = "SELECT e.even_jeux_video, e.date_heure_even
        FROM sinscire s
        JOIN Evenement e ON e.id_evenement = s.id_evenement
        WHERE s.id = ?
        ORDER BY e.date_heure_even ASC";
$stmt = mysqli_prepare($mysqli, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_client);
mysqli_stmt_execute($stmt);
$reservations = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

include_once "../../element/header.php";
?>
<body>
    <h1>Client</h1>
    <?php include_once "../../element/nav.php"; ?>
    <br>

    <section id="historique-reservations">
        <h2>Mes inscriptions</h2>
        <?php if (!empty($reservations)): ?>
            <?php foreach ($reservations as $res): ?>
                <div class="carte-reservation">
                    <strong>Événement :</strong> <?= htmlspecialchars($res["even_jeux_video"]) ?><br>
                    <strong>Date :</strong> <?= htmlspecialchars($res["date_heure_even"]) ?><br>
                </div><hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Vous n'avez aucune inscription enregistrée.</p>
        <?php endif; ?>
    </section>
</body>
</html>