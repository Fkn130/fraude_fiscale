<?php
    $host = '';
    $dbname = '';
    $user = '';
    $pasword = '';

    $mysql = new mysqli($host, $user, $pasword, $dbname);
    
    if($mysqli->connect_error){
        die('Erreur de connexion mySQL :' . $mysqli->connect_error);
    }

?>