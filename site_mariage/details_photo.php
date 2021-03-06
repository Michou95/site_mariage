<?php
session_start();
if($_SESSION['user'] === "allowed"){

require_once ('fonctions.php');

if(isset($_GET)){
  if(isset($_GET['photo'])){
    $photo = strip_tags(trim($_GET['photo']));
  }

  if(isset($_GET['id_invite'])){
    $id_invite = $_GET['id_invite'];

    $invite = getInviteById($id_invite);
    $prenom = ucfirst($invite[0]['prenom']);
    $nom = ucfirst($invite[0]['nom']);
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
     <link rel="stylesheet" href="style.css"/>
 </head>

 <header>
   <video autoplay loop class="fillWidth" style="max-width: 220%;">
     <source src="http://localhost/site_mariage/mariage/banniere_site_mariage.mp4" type="video/mp4"/>
   </video>
   <div class="title">
     <h1>Mickael & Jennifer</h1>
     <h2>28 Juillet 2018</h2>
   </div>
 </header>

 <body>
    <div class="container" style="margin-top: 20px; background-color: #f4f8ff; border-radius:5px;">
      <div class="col-md-12">
        <h2>Detail de la Photo: <?php if(isset($prenom)){echo $prenom . " ";}if(isset($nom)){echo $nom;} ?></h2>
      </div>
      <div class="col-md-10">
        <img src="<?php echo $photo; ?>" alt="<?php echo $photo ?>" style="width: 100%;">
        <div class="col-md-12" style="margin-top: 15px;">
          <button type="button" class="btn btn-primary col-md-2"><i class="fas fa-arrow-circle-left"></i>  &nbsp;&nbsp;Précédent</button>
          <button type="button" class="btn btn-primary col-md-offset-8 col-md-2">Suivant&nbsp;&nbsp; <i class="fas fa-arrow-circle-right"></i></button>
        </div>
      </div>
      <div class="col-md-2">
        <a href="<?php echo $photo ?>" download type="button" class="btn btn-primary col-md-12"><i class="fas fa-download"></i> Télécharger</a>
        <div class="col-md-12" style="height: 10px;"></div>
        <a href="home.php?refresh=none" class="btn btn-primary col-md-12"><i class="fas fa-home"></i> Retour à l'accueil</a>
      </div>
      <div class="col-md-12" style="margin-bottom: 15px;"></div>
    </div>
<?php include_once'footer.php';
}
else{
  session_destroy();
  header('Location: index.php');
}?>
