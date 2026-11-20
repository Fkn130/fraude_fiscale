<?php
    include_once 'bdd.php';
    include_once 'token.php';

    $part = verif_token();

    $mail = $part[1]["mail"];
    $mdp = $part[1]["mdp"];

    $event = $_POST['id_evenement'];

    
?>