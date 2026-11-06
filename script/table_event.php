<?php
    require "bdd.php";

    $sql = 'SELECT even_jeux_video , date_heure_even FROM Evenement';
    $resultats = mysqli_query($mysql, $sql);
    
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>