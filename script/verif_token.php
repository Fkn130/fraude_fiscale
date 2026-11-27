<?php
function verif_token()
{
    session_start();

    if (!isset($_COOKIE['tokenJWT'])) {
        header('Location: ../login/page_connexion.php');
    }

    $tokenJWT = $_COOKIE['tokenJWT'];

    $part = explode(".", $tokenJWT);

    if (count($part) !== 3) {
        header('Location: ../login/page_connexion.php');
    }

    $header = json_decode(base64urlDecode($part[0]), true);
    $payload = json_decode(base64urlDecode($part[1]), true);

    if (!$header || !$payload) {
        header('Location: ../login/page_connexion.php');
    }

    // Vérification de l'algorithme
    if (($header['alg'] ?? '') !== 'HS256') {
        header('Location: ../login/page_connexion.php');
    }

    // Ta clé secrète doit être confidentielle
    $secret = $GLOBALS['sel'];

    $signature = hash_hmac(
        'sha256',
        $part[0] . "." . $part[1],
        $secret,
        true
    );

    $signature = rtrim(
        strtr(base64_encode($signature), '+/', '-_'),
        '='
    );

    if (!hash_equals($signature, $part[2])) {
        header('Location: ../login/page_connexion.php');
    }

    return $payload;
}

?>