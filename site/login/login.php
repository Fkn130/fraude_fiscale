<?php
require "bdd.php";  // manque le fichier pour la connexion a la bdd
$bouton = $_POST['connect'];
$mail = $_POST['email'];
$password =$_POST['password'];

if ($bouton == 1){

    $sql ="SELECT count(*) as nb FROM user WHERE mail = '$mail' AND mdp=SHA('$password')";
    $resultats = mysqli_query($mysql, $sql);

    while ($ligne = mysqli_fetch_assoc($resultats)) {

    if ($ligne['nb'] == 1) { 
        session_start();

        if (strpos($mail, '--') !== false) {
            echo "programme arrêté";
            exit();
        }

        echo 'connecté';
        header('Location: http://localhost/Media_php/media.php');
        
        }
    else {
        echo 'pas connecté';
    } 
}
}
else {
    $sql ="SELECT count(*) as nb FROM user WHERE email = '$mail'";
    $resultats = mysqli_query($mysql, $sql);
    if ( 'email' == $mail){
        echo "email deja utilisé";

    }

else {

    $sql = "INSERT INTO user (email, mdp) VALUES ('$mail', SHA('$password'))";
    $resultats = mysqli_query($mysql, $sql);
    header('Location: http://localhost/Media_php/media.php');


}
}


?>