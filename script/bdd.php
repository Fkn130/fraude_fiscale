<?php
    $host = "localhost";
    $user = "root";
    $pwd = "";
    $schema = "fraude_fiscal";
    
// Connexion MySQLi
$mysqli = new mysqli($host, $user, $pwd, $schema);
if ($mysqli->connect_error) {
    die('Erreur de connexion MySQLi : ' . $mysqli->connect_error);
}

?>