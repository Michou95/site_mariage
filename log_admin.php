<?php
if(isset($_POST['password'])){
  $password = strip_tags(trim($_POST['password']));
}

if(!empty($password)){
  if($password === "What the funk!"){
    header('Location: dashboard/dashboard.php');
  }
  else{
    header('Location: log_admin.php?password=false');
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
      <link rel="stylesheet" href="style_log-admin.css"/>
  </head>
  <body>
    <h1>Accès Admin</h1>
    <div class="container">
      <div class="col-md-offset-2 col-md-8">
        <form action="log_admin.php" method="post" class="form-admin">
          <div class="form-group">
            <label for="password">Password</label>
            <?php if(isset($_GET['password'])){
              if($_GET['password'] === "false"){ ?>
                  <p style="color: red;">Mot de Passe Incorrect</p>
      <?php   }
            } ?>
            <input type="password" name="password" class="form-control" placeholder="Password" />
          </div>
          <button type="submit" class="btn btn-primary">Valider</button>
        </form>
      </div>
    </div>
  </body>
</html>
