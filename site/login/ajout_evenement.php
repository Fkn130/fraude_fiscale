<?php
session_start();
require_once '../../script/bdd.php';

// Vérification admin connecté
$id_admin = $_SESSION['id'] ?? 1;

//si admin non connecté redirection vers page connexion
if (!isset($_SESSION['id']) || ($_SESSION['is_admin'] ?? false) !== true) {
    header('Location: page_connexion.php'); // page de connexion, pas admin.php
    exit();
}
$errors = [];
$msg = '';

// ==============================================================
// GESTION DES ACTIONS POUR AJOUT ET SUPPRIMER LES ÉVÉNEMENTS
// ==============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    // Ajout d'un Événement
    if ($action === 'add') {
        $nom = trim($_POST['nom'] ?? '');
        $date_heure = $_POST['date_heure'] ?? '';

        if ($nom === '' || $date_heure === '') {
            $errors[] = "Tous les champs sont obligatoires.";
        }

        if (empty($errors)) {
            $date_sql = str_replace('T', ' ', $date_heure) . ':00';
            //Insere les données pour ajouter les evenements
            $stmt = $mysqli->prepare("INSERT INTO Evenement (even_jeux_video, date_heure_even, id) VALUES (?, ?, ?)");
            if ($stmt) {
                // s = string, s = string, i = integer
                $stmt->bind_param("ssi", $nom, $date_sql, $id_admin);
                if ($stmt->execute()) {
                    $msg = "L'événement $nom a été ajouté avec succès !";
                    if (class_exists('Logger')) Logger::info('evenement '.$nom.' ajouté');
                } else {
                    $errors[] = "Erreur lors de l'ajout : " . $stmt->error;
                    if (class_exists('Logger')) Logger::warning('erreur '.$nom.' non ajouté');
                }
                $stmt->close();
            } else {
                $errors[] = "Erreur de préparation : " . $mysqli->error;
            }
        }
    }

    // SUPPRESSION
    if ($action === 'delete' && isset($_POST['id_evenement'])) {
        $id_evenement = (int) $_POST['id_evenement'];

        $stmt = $mysqli->prepare("DELETE FROM Evenement WHERE id_evenement = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id_evenement);
            if ($stmt->execute()) {
                $msg = "Suppression effectuée avec succès.";
                if (class_exists('Logger')) Logger::info('évènement supprimé');
            } else {
                $errors[] = "Erreur lors de la suppression : " . $stmt->error;
                if (class_exists('Logger')) Logger::warning('Erreur lors de la suppression');
            }
            $stmt->close();
        } else {
            $errors[] = "Erreur de préparation : " . $mysqli->error;
        }
    }
}

// LECTURE des événements (version mysqli)
$evenements = [];
$result = $mysqli->query("SELECT * FROM Evenement ORDER BY date_heure_even ASC");
if ($result) {
    $evenements = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Admin - Ajouter Événements</title>
</head>
<body>
  <div class="main-container">
  <h1>Ajout des Événements</h1>
  <?php if (!empty($errors)): ?>
      <div class="error">
          <?php foreach ($errors as $error): ?>
              <p style="margin: 5px 0;"><?= htmlspecialchars($error) ?></p>
          <?php endforeach; ?>
      </div>
  <?php endif; ?>

  <?php if (!empty($msg)): ?>
      <div class="msg">
          <p style="margin: 0;"><?= htmlspecialchars($msg) ?></p>
      </div>
  <?php endif; ?>
<br>
  <div class="admin-form">
      <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add" />

        <label>Nom événement :</label>
        <input type="text" name="nom" required>
        <br>

        <label>Date de heure :</label>
        <input type="datetime-local" name="date_heure" required>      
        <br>
        <button type="submit" class="button-add">Ajouter un événement</button>
      </form>
  </div>
  <br>
  <br>

  <table class="admin-table">
    <thead>
      <tr>
        <th>Nom événement</th>
        <th>Date de l'événement</th>
      </tr>
    </thead>
   <tbody>
    <?php if (!empty($evenements)): ?>
        <?php foreach ($evenements as $e): ?>
        <tr>
            <td><?= htmlspecialchars($e['even_jeux_video']) ?></td>
            <td><?= htmlspecialchars($e['date_heure_even']) ?></td>
            <td>
                <form method="POST" style="display:inline;" onsubmit="return confirm('Confirmer la suppression de cet événement ?');">
                    <input type="hidden" name="action" value="delete" />
                    <input type="hidden" name="id_evenement" value="<?= (int)$e['id_evenement'] ?>" />
                    <button type="submit" class="btn-suppr">Supprimer</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php else: ?>
    <tr>
      <td colspan="3" style="text-align:center;">Aucun événement enregistré pour le moment.</td>
    </tr>
  <?php endif; ?>
</tbody>
  </table>
  <p style="text-align:center; margin-top:30px;">
    <a href="index.php" style="text-decoration:none; color:#B52C24; font-weight:bold;">Retour à l'accueil</a>
  </p>
</div>
</body>
</html>