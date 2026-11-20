<?php
session_start();
require_once '../../script/bdd.php';

// Vérification admin connecté
$id_admin = $_SESSION['id'] ?? null;
$sql = "SELECT id FROM Utilisateur WHERE id = 1";

/*if (!isset($_SESSION['id']) || !isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: page_connexion.php');
    exit();
}
    if (!$isAdmin) {
        header('Location: admin.php');
        exit();
    }*/
$errors = [];
$msg = '';

// ==============================================================
// GESTION DES ACTIONS POUR AJOUT ET SUPPRIMER LES ÉVÉNEMENTS
// ==============================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    // Ajout d'un Événement
    if ($action === 'add') {
        $event_jeux= trim($_POST['even_jeux_video'] ?? '');
        $date_heure = $_POST['date_heure_event'] ?? null;
        $id= $_POST['id'] ?? null;
        $id_evenement= null;
    if (empty($event_jeux) || empty($date_heure)) {
            $errors[] = "Tous les champs sont obligatoires.";    
    }
    if (empty($errors)) {
        try {
            // INSERTION
            $sql = "INSERT INTO Evenement(date_heure, event_jeux_video, id, id_evenment) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([ $date_heure, $event_jeux,  $id, $id_evenement]);
            $msg = "L'événement $event_jeux a été ajouté avec succès !";
             Logger::info('evenement '.$event_jeux.' ajouté');
            } catch (Exception $e) {
                $errors[] = "Erreur lors de l'ajout : " . $e->getMessage();
                Logger::warning('erreur '.$event_jeux.' non ajouté');

            }
        }
    }
    // SUPPRESSION
    if ($action === 'delete' && isset($_POST['id_evenement'])) {
        try {
            $stmt = $pdo->prepare("DELETE FROM Evenement WHERE id_evenement = ?");
            $stmt->execute([$_POST['id_evenement']]);
            $msg = "Suppression effectuée avec succès.";
             Logger::info('évenement suprimer');

        } catch (Exception $e) {
            $errors[] = "Erreur lors de la suppression : " . $e->getMessage();
             Logger::warning('Erreur lors de la suppression');

        }
    }
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

        <label>Date de heure :</label>
        <input type="datetime-local" name="date_heure" required>      

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
      <?php if (!empty($id_evenement)): ?>
          <?php foreach($id_evenement as $e): ?>
          <tr>
            <td><?= htmlspecialchars($e['nom'] ?? '') ?></td>
            <td><?= htmlspecialchars($e['date_heure'] ?? 'Non spécifiée') ?></td>
            <td>
              <form method="POST" style="display:inline;" onsubmit="return confirm('Confirmer la suppression de cet événement ?');">
                <input type="hidden" name="action" value="delete" />
                <input type="hidden" name="id_evenement" value="<?= $e['id_evenement'] ?>" />
                <button type="submit" class="btn-suppr">Supprimer</button>
              </form>
            </td>
          </tr>
          <?php endforeach; ?>
      <?php else: ?>
          <tr>
              <td colspan="5" style="text-align: center;">Aucun événement enregistré pour le moment.</td>
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