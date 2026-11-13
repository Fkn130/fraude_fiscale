<?php
require "bdd.php";  // manque le fichier pour la connexion a la bdd
$bouton = $_POST['connect'];
$email = $_POST['email'];
$password = $_POST['password'];

if ($bouton == 1) {

    $sql = "SELECT count(*) as nb FROM utilisateurs WHERE adress_mail = ? AND mot_de_passe=SHA(?)";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $resultats = mysqli_stmt_get_result($stmt);

    while ($ligne = mysqli_fetch_assoc($resultats)) {

        if ($ligne['nb'] == 1) {
            session_start();

            if (strpos($email, '--') !== false) {
                echo "programme arrêté";
                exit();
            }

            echo 'connecté';
            header('Location: ../site/login/index.php'); //a changer plus tard

        } else {
            echo 'pas connecté';
        }
    }
} else {
    $sql = "SELECT count(*) as nb FROM utilisateurs WHERE adress_mail = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultats = mysqli_stmt_get_result($stmt);
    
    if ('adress_mail' == $email) {
        echo "email deja utilisé";

    } else {

        $sql = "INSERT INTO utilisateurs (adress_mail, mot_de_passe) VALUES (?, SHA(?))";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        header('Location: ../site/login/index.php');//a changer plus tard

    }
}
?>