<?php
session_start();
session_destroy();

if(isset($_POST['password'])){

  $password = strip_tags(trim($_POST['password']));

  if(!empty($password)){
    if($password === "Suce ma bite 2018!"){
      session_start();
      $_SESSION['user'] = 'allowed';
      header('Location: site_mariage/home.php');
    }
    else{
      session_start();
      $_SESSION['user'] = 'forbidden';
      header('Location: index.php?password=false');
    }
  }
  else{
    header('Location: index.php?password=false');
  }

}
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

  <head>
      <meta charset="utf-8">
      <title>Notre Mariage</title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
      <link rel="stylesheet" href="site_mariage/style_log-admin.css"/>
  </head>
  <body>
    <h1 class="login">Mariage Mickael & Jennifer</h1>
    <h1 class="login">Connexion</h1>
    <div class="container">
      <div class="col-md-offset-2 col-md-8">
        <form action="index.php" method="post" class="form-login">
          <div class="form-group">
            <label for="password">Mot de Passe</label>
            <?php if(isset($_GET['password'])){
              if($_GET['password'] === "false"){ ?>
                  <p class="wrong">Mot de Passe Incorrect</p>
      <?php   }
            } ?>
            <input type="password" name="password" class="form-control" placeholder="Entrez le mot de passe" required/>
          </div>
          <button type="submit" class="btn btn-primary">Valider</button>
        </form>
      </div>
    </div>
  </body>
</html>
