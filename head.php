<?php
require_once ('connexion.php');

//-------------------------------------//
// Instanciation de la class connexion //
//-------------------------------------//
$connexion = new Connexion();

//--------------------------------------------------------//
// Récupération de l'ip de la machine qui demande la page //
//--------------------------------------------------------//
$ip = $connexion->getIp();

//---------------------------------------//
// Incrémentation du compteur de visites //
//---------------------------------------//
$connexion->addCountVisites($ip);

//-------------------------------------//
// Check si l'ip appartient a un admin //
//-------------------------------------//
$admin_ip = $connexion->isAllowedIp($ip);
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
  <div id="what_the_funk"></div>
  <video autoplay loop class="fillWidth" style="max-width: 220%;">
    <source src="http://localhost/site_mariage/mariage/banniere_site_mariage.mp4" type="video/mp4"/>
  </video>
  <?php if($admin_ip){ ?>
    <div class="admin">
      <a href="log_admin.php" type="button" class="btn btn-default">Accès Admin Dashboard</a>
    </div>
  <?php } ?>
  <div class="title">
    <h1>Mickael & Jennifer</h1>
    <h2>28 Juillet 2018</h2>
  </div>
  <div id="audio">
    <!-- <audio autoplay src='mariage/son.mp3'></audio> -->
  </div>
</header>

<form id="SearchForm" class="form-inline" method="post">
  <div class="mute"></div>
<div class="form-group" style="width:30%">
    <div class="input-group">
      <input id="search" type="text" class="form-control" placeholder="Entrez Votre Prénom">
      <div class="input-group-addon" style="width:5%"><a><i class="fas fa-search"></i></a></div>
    </div>
    <ul id="resultSearch"></ul>
    <small id="small">Entrez votre prénom et/ou votre nom en minucule sans accents</small>
</div>
</form>

<body>
