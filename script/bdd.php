<?php
    $host = 'mysql-lenalaravel.alwaysdata.net';
    $dbname = 'lenalaravel_hotel_bdd'; 
    $user = 'lenalaravel';            
    $password = 'Lghnvbn148'; 
    
// Connexion MySQLi
$mysqli = new mysqli($host, $user, $password, $schema);
if ($mysqli->connect_error) {
    die('Erreur de connexion MySQLi : ' . $mysqli->connect_error);
}

?>