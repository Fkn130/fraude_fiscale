<?php
function base64urlEncode($data)
{
    return rtrim(strtr(base64_encode($data), '+/', '-_'));
}

function cree_token($email, $password)
{
    $sel = "FEeh4zi1YhsZ3jr5hc7fq899bc2";

    $header = json_encode([
        "alg" => "HS256",
        "typ" => "JWT"
    ]);

    $payload = json_encode([
        "mail" => $email,
        "mdp" => $password
    ]);

    $header = base64urlEncode($header);
    $payload = base64urlEncode($payload);

    $signature = hash_hmac(
        "sha256",
        $header . "." . $payload,
        $sel,
        true
    );

    $signature = base64urlEncode($signature);

    $dataToken = $header . "." . $payload . "." . $signature;

    setcookie("tokenJWT", $dataToken, time() + 900);
}

function verif_token()
{
    $tokenJWT = $_COOKIE['tokenJWT'];
    function base64urlDecode($tokenJWT)
    {
        //remet les - en + et les _ en /
        $tokenJWT = strtr($tokenJWT, '-_', '+/');
        return base64_decode($tokenJWT);
    }
    $part = explode(".", $tokenJWT);
    //si le token n'a pas étais changer par l'utilisateur

    if ($part[0] . $part[1] == $part[2]) {
        $tokenJWT = $part[0] . $part[1] . $part[2];
        setcookie("tokenJWT", $tokenJWT, time() + 900);
        return $part;
    } else {
        header('../affichage/page_login.php');
    }
}

?>