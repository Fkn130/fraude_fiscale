<?php

    function create_Token($mail , $mdp){
        date_default_timezone_set('Europe/Paris');
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

        setcookie("tokenJWT", $dataToken, time()+3600+900,"/fraude_fiscale");  
    }
?>
function base64urlDecode($data)
{
    $data = strtr($data, '-_', '+/');
    return base64_decode($data);
}
function verif_token()
{
    $sel = "FEeh4zi1YhsZ3jr5hc7fq899bc2";

    if (isset($_COOKIE['tokenJWT'])) {

        $tokenJWT = $_COOKIE['tokenJWT'];

        // Sépare le token
        $part = explode(".", $tokenJWT);

        if (count($part) == 3) {

            // Recrée la signature
            $signature = hash_hmac(
                "sha256",
                $part[0] . "." . $part[1],
                $sel,
                true
            );

            $signature = base64urlEncode($signature);

            // Vérifie la signature
            if ($signature == $part[2]) {

                // Met à jour le cookie
                setcookie("tokenJWT", $tokenJWT, time() + 900);

                return $part;

            } else {
                header("Location: ../affichage/page_login.php");
                exit();
            }

        } else {
            header("Location: ../affichage/page_login.php");
            exit();
        }

    } else {
        header("Location: ../affichage/page_login.php");
        exit();
    }
}


?>