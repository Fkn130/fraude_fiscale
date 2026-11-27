<?php
include_once "../../script/bdd.php";

// Accès réservé aux utilisateurs connectés
$id_client = (int) ($_SESSION['id'] ?? $_SESSION['id_utilisateur'] ?? 0);
if ($id_client <= 0) {
    if (!empty($_POST['id_evenement'])) {
        $_SESSION['evenement_en_attente'] = (int) $_POST['id_evenement'];
    }
    header("Location: page_connexion.php");
    exit;
}

// Annulation d'une inscription faite par le client
if (($_POST['action'] ?? '') === 'supprimer' && !empty($_POST['id_evenement'])) {
    $id_evt = (int) $_POST['id_evenement'];
    $stmt = mysqli_prepare($mysqli, "DELETE FROM sinscire WHERE id = ? AND id_evenement = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id_client, $id_evt);
    mysqli_stmt_execute($stmt);
    header("Location: espace_client.php");
    exit;
}

// Inscription (POST depuis index.php ou reprise après connexion)
$id_evenement = null;
if (!empty($_POST['id_evenement'])) {
    $id_evenement = (int) $_POST['id_evenement'];
} elseif (!empty($_SESSION['evenement_en_attente'])) {
    $id_evenement = (int) $_SESSION['evenement_en_attente'];
    unset($_SESSION['evenement_en_attente']);
}

if ($id_evenement) {
    // On vérifie d'abord que l'inscription n'existe pas déjà
    $stmt = mysqli_prepare($mysqli, "SELECT 1 FROM sinscire WHERE id = ? AND id_evenement = ?");
    mysqli_stmt_bind_param($stmt, "ii", $id_client, $id_evenement);
    mysqli_stmt_execute($stmt);
    $deja = mysqli_fetch_all(mysqli_stmt_get_result($stmt));

    if (empty($deja)) {
        $stmt = mysqli_prepare($mysqli, "INSERT INTO sinscire (id, id_evenement) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "ii", $id_client, $id_evenement);
        if (!mysqli_stmt_execute($stmt)) {
            die("Erreur INSERT : " . mysqli_stmt_error($stmt));
        }
    }
    // Évite le renvoi du formulaire au rafraîchissement
    header("Location: espace_client.php");
    exit;
}

// Liste des inscriptions accepter par le client
$sql = "SELECT e.id_evenement, e.even_jeux_video, e.date_heure_even
        FROM sinscrire s
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
                    <form method="POST" action="espace_client.php"
                          onsubmit="return confirm('Annuler cette inscription ?');">
                        <input type="hidden" name="action" value="supprimer">
                        <input type="hidden" name="id_evenement" value="<?= (int) $res['id_evenement'] ?>">
                        <button type="submit">Annuler l'inscription</button>
                    </form>
                </div><hr>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Vous n'avez aucune inscription enregistrée.</p>
        <?php endif; ?>
    </section>
</body>
</html>