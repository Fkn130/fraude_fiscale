<?php
require "bdd.php";  // manque le fichier pour la connexion a la bdd
$bouton = $_POST['connect'];
$email = $_POST['email'];
$password = $_POST['password'];

if ($bouton == 1) {

    $sql = "SELECT count(*) as nb FROM user WHERE mail = '$email' AND mdp=SHA('$password')";
    $resultats = mysqli_query($mysql, $sql);

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
    $sql = "SELECT count(*) as nb FROM user WHERE mail = '$email'";
    $resultats = mysqli_query($mysql, $sql);
    if ('email' == $email) {
        echo "email deja utilisé";

    } else {

        $sql = "INSERT INTO user (mail, mdp) VALUES ('$email', SHA('$password'))";
        $resultats = mysqli_query($mysql, $sql);
        header('Location: ../site/login/index.php');//a changer plus tard


    }
}


?>