<?php
    $host = 'ssh-lenalaravel.alwaysdata.net';
    $dbname = 'lenalaravel_hotel_bdd'; 
    $user = 'lenalaravel';            
    $password = 'Lghnvbn148'; 
    $schema = "fraude_fiscal";
    
// Connexion MySQLi
$mysqli = new mysqli($host, $user, $pwd, $schema);
if ($mysqli->connect_error) {
    die('Erreur de connexion MySQLi : ' . $mysqli->connect_error);
}

?>