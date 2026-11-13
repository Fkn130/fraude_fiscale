<?php
require "bdd.php";  
require '../log/log.php';
$bouton = $_POST['connect'];
$email = $_POST['email'];
$password = $_POST['password'];
var_dump($user);
$id_user = $user['id'];

$sql_admin = "SELECT id FROM Admin WHERE id = :id";
$stmt_admin = $pdo->prepare($sql_admin);
$stmt_admin->execute(['id' => $id_user]);
$isAdmin = $stmt_admin->fetch();

if ($isAdmin) {
    $_SESSION['is_admin'] = true;
} else {
    $_SESSION['is_admin'] = false;
}

$_SESSION['id_utilisateur'] = $id_user;

if ($bouton == 1) {

    $sql = "SELECT count(*) as nb FROM utilisateurs WHERE adress_mail = ? AND mot_de_passe=SHA(?)";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $email, $password);
    mysqli_stmt_execute($stmt);
    $resultats = mysqli_stmt_get_result($stmt);

    while ($ligne = mysqli_fetch_assoc($resultats)) {

        if ($ligne['nb'] == 1) {
            session_start();

            if (strpos($email, '--') !== false) {
                echo "programme arrêté";
                exit();
            }

            echo 'connecté';
             Logger::info('utilisateur '.$email.' connecté');
            header('Location: ../site/login/index.php'); //a changer plus tard

        } else {
            echo 'pas connecté';
        }
    }
} else {
    $sql = "SELECT count(*) as nb FROM utilisateurs WHERE adress_mail = ?";
    $stmt = mysqli_prepare($mysqli, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultats = mysqli_stmt_get_result($stmt);
    
    if ('adress_mail' == $email) {
        echo "email deja utilisé";

    } else {

        $sql = "INSERT INTO utilisateurs (adress_mail, mot_de_passe) VALUES (?, SHA(?))";
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        header('Location: ../site/login/index.php');//a changer plus tard

    }
}
?>