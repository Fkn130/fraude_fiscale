<?php
function inscription()
{

    include_once 'bdd.php';
    include_once 'token.php';

    $part = verif_token();

    $part[1] = json_decode(base64urlDecode($part[1]), true);

    $mail = $part[1]["mail"];
    $mdp = $part[1]["mdp"];
    $event = $_POST['id_evenement'];

    $sql = "SELECT id FROM utilisateurs WHERE adress_mail =" . $mail . " AND mdp =" . $mdp;
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_execute($stmt);
    $resultats = mysqli_stmt_get_result($stmt);

    $sql = "INSERT INTO `sinscire`(`id`, `id_1`) VALUES" . $resultats . "," . $event;
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_execute($stmt);
}
?>