<?php
    include_once "../../element/header.php";
?>
<h1>Connexion</h1>
<?php

    include_once "../../element/nav.php";
?>
<br>
<br>
<body class="mon-element">
    <form method="post" action="../../script/login.php" class = "login">
        <label for="email">Votre e-mail :</label>
         <input type="email" id="email" name="email" required placeholder="exemple@domaine.com">
    
        <br>
        <label for="password">Votre mot-de-passe :</label>
        <input type = "password"required name="password"/>
        <br>    
        
        <button name = "connect" type = "submit" value = "1" > se connecter </button><br>
        <button name = "connect" type = "submit" value = "2"> créer un compte </button>
    </form>

     <?php include_once "../../element/footer.php"; ?>
</body>
</html>