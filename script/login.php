<?php
require "bdd.php";  // manque le fichier pour la connexion a la bdd
$bouton = $_POST['connect'];
$email = $_POST['email'];
$password = $_POST['password'];

if ($bouton == 1) {

    $sql = "SELECT count(*) as nb FROM Utilisateurs WHERE adress_mail = '$email' AND mot_de_passe=SHA('$password')";
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
    $sql = "SELECT count(*) as nb FROM Utilisateurs WHERE adress_mail = '$email'";
    $resultats = mysqli_query($mysql, $sql);
    if ('adress_mail' == $email) {
        echo "email deja utilisé";

    } else {

        $sql = "INSERT INTO Utilisateurs (adress_mail, mot_de_passe) VALUES ('$email', SHA('$password'))";
        $resultats = mysqli_query($mysql, $sql);
        header('Location: ../site/login/index.php');//a changer plus tard


    }
}


?>