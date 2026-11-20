<?php
function crée_token($email, $password)
{

    $mail = $email;
    $mdp = $password;

    $sel = "FEeh4zi1YhsZ3jr5hc7fq899bc2";

    function base64urlEncode($data)
    {
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

?>