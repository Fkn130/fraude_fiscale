<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<h1>Connexion</h1>
<nav>
    <ul>
        <a href="index.php">Accueil</a>
        <a href="page_connexion.php">Connexion</a>
    </ul>
</nav>
<body class="mon-element">
    <form method="post" action="/script/login.php" class = "login">
         identifiant 
        <input type = "mail"required name ="email"/>
        <br>
         mot de passe 
        <input type = "password"required name="password"/>
        <br>    
        
        <button name = "connect" type = "submit" value = "1" > se connecter </button><br>
        <button name = "connect" type = "submit" value = "2"> créer un compte </button>

    </form>



</body>
</html>