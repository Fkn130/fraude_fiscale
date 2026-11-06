<?php
require __DIR__ . '/bdd.php';

$sql = 'SELECT even_jeux_video, date_heure_even FROM Evenement';
$resultats = mysqli_query($mysqli, $sql);

$rows = mysqli_fetch_all($resultats, MYSQLI_ASSOC);
?>