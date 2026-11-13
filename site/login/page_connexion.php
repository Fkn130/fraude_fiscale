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
         identifiant: 
        <input type = "mail"required name ="email"/>
        <br>
         mot de passe: 
        <input type = "password"required name="password"/>
        <br>    
        
        <button name = "connect" type = "submit" value = "1" > se connecter </button><br>
        <button name = "connect" type = "submit" value = "2"> créer un compte </button>
    </form>
</body>
</html>