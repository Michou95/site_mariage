

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
      <link rel="stylesheet" href="site_mariage/style_log-login.css"/>
      <link rel="stylesheet" href="site_mariage/style.css"/>
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
          <button type="submit" class="btn btn-primary" id="valider">Valider</button>
        </form>
        <form id="SearchForm" class="form-inline" method="post" style="display:none">
          <label for="search" id="space">Veuillez vous sélectionner dans la liste</label>
          <div class="mute"></div>
          <div class="form-group">
              <input type="hidden" name="passwordSave">
              <div class="input-group">
                <input id="search" type="text" class="form-control" data-id="" data-mode="personne" placeholder="Entrez Votre Prénom" autocomplete="off">
                <div id="submitForm" class="input-group-addon" style="width:5%"><a><i class="fas fa-search"></i></a></div>
              </div>
              <ul id="resultSearch"></ul>
              <small id="small">Entrez votre prénom et/ou votre nom</small>
          </div>
        </form>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script type="text/javascript" src="site_mariage/script.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
  </body>
</html>