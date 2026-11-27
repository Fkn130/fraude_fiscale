<?php
    $host = 'local_host';
    $dbname = 'fraude_fiscal'; 
    $user = 'root';            
    $password = ''; 
    
// Connexion MySQLi
$mysqli = new mysqli($host, $user, $password, $dbname);
if ($mysqli->connect_error) {
    die('Erreur de connexion MySQLi : ' . $mysqli->connect_error);
}

?>