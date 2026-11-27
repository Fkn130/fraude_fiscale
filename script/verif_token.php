<?php
function verif_token()
{
    session_start();
    $tokenJWT = $_COOKIE['tokenJWT'];

    function base64urlDecode($tokenJWT)
    {
        $tokenJWT = strtr($$tokenJWT, '-_', '+/');


        return base64_decode($tokenJWT);
    }

    $part = explode(".", $tokenJWT);

    if ($part[0] . $part[1] == $part[2]) {

        //si le token n'a pas étais changer

        $tokenJWT = $part[0] . $part[1] . $part[2];
        setcookie("tokenJWT", $tokenJWT, time() + 900);
        $header = json_decode($part[1]);
        return $header;
        
    } else {
        header('../site/page_connexion.php');
    }
}

?>