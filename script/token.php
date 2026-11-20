<?php
function crée_token($email, $password)
{
    $mail = $email;
    $mdp = $password;
    $sel = "FEeh4zi1YhsZ3jr5hc7fq899bc2";
    function base64urlEncode($data)
    {
        //met + en - et / en _
        return rtrim(strtr(base64_encode($data), '+/', '-_'));
    }

    $header = json_encode([
        "alg" => "HS256",
        "typ" => "JWT"
    ]);
    $header = base64urlEncode($header);

    $payload = json_encode([
        "mail" => $mail,
        "mdp" => $mdp
    ]);
    $payload = base64urlEncode($payload);

    $signature = hash_hmac("sha256", $header . "." . $payload, $sel, true);
    $signature = base64urlEncode($signature);

    $dataToken = $header . "." . $payload . "." . "$signature";

    setcookie("tokenJWT", $dataToken, time() + 900);
}

function vérif_token()
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
    } else {
        header('../affichage/page_login.php');
    }
}

?>