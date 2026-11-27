<?php
    include_once "../../element/header.php";
    include_once "../../element/nav.php";
?>

<main>
    <h1>Connexion</h1>
    <p class="subtitle">Connectez-vous pour accéder à votre espace.</p>

    <form method="post" action="../../script/login.php">
        <table class="table">
            <tbody>
                <tr>
                    <td><label for="email">Votre e-mail :</label></td>
                    <td><input type="email" id="email" name="email" required placeholder="votremail@email.com"></td>
                </tr>
                <tr>
                    <td><label for="password">Votre mot de passe :</label></td>
                    <td><input type="password" id="password" name="password" required placeholder="votre mot de passe"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button name="connect" type="submit" value="1" class="btn-primary">Se connecter</button>
                        <button name="connect" type="submit" value="2" class="btn-theme">Créer un compte</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</main>

<?php include_once "../../element/footer.php"; ?>