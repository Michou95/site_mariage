<?php
//----- connexion a la bdd -----//
try {
    $connexion = new PDO('mysql:host=localhost; dbname=mariage', 'root', '');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(exception $e) {
    die('Erreur '.$e->getMessage());
  }

//-----------------------------------------------------------------------------------------//
//--------- Traitement des photos renommage des fichiers insertion en BDD -----------------//
// ATTENTION NE PAS MANIPULER SI ON SAIS PAS CE QU'ON FAIT SOUS PEINE DE NIQUER LA BDD !!! //
//-----------------------------------------------------------------------------------------//

echo "<hr><h1>Mairie_invites</h1><hr>";
$photo_mairie = scandir("mariage/mairie");
$photo_mairie_min = scandir("mariage_miniature/mairie");

// echo "<pre>";
// var_dump($photo_mairie);
// echo "</pre>";

foreach ($photo_mairie as $key => $value) {
  if($key > 1){
    $url_min = $photo_mairie_min[$key];
    // echo $url_min . "<br>";

    // $sql = "INSERT INTO photos (url_miniature, url, prise_par, categorie, statut) VALUES ('mariage_miniature/mairie/$url_min', 'mariage/mairie/$value', 'invites', 'mairie', 'not_tagged');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}

echo "<hr><h1>VH_invites</h1><hr>";
$photo_vh = scandir('mariage/vin_honneur');
$photo_vh_min = scandir('mariage_miniature/vin_honneur');


foreach ($photo_vh as $key => $value) {
  if($key > 1){
    $url_min = $photo_vh_min[$key];
    // echo $url_min . "<br>";

    // $sql = "INSERT INTO photos (url_miniature, url, prise_par, categorie, statut) VALUES ('mariage_miniature/vin_honneur/$url_min', 'mariage/vin_honneur/$value', 'invites', 'vin_honneur', 'not_tagged');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}

echo "<hr><h1>Salle_invites</h1><hr>";
$photo_salle = scandir('mariage/salle');
$photo_salle_min = scandir('mariage_miniature/salle');
// echo "<pre>";
// var_dump($photo_salle_min);
// echo "</pre>";


foreach ($photo_salle as $key => $value) {
  if($key > 1){
    $url_min = $photo_salle_min[$key];
    // echo $url_min . "<br>";

    // $sql = "INSERT INTO photos (url_miniature, url, prise_par, categorie, statut) VALUES ('mariage_miniature/salle/$url_min', 'mariage/salle/$value', 'invites', 'salle', 'not_tagged');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}

echo "<hr><h1>Mairie_charline</h1><hr>";
$photo_mairie_ch = scandir('mariage/photos_charline/mairie');
$photo_mairie_ch_min = scandir('mariage_miniature/photos_charline/mairie');


foreach ($photo_mairie_ch as $key => $value) {
  if($key > 1){
    $url_min = $photo_mairie_ch_min[$key];
    // echo $url_min . "<br>";

    // $sql = "INSERT INTO photos (url_miniature, url, prise_par, categorie, statut) VALUES ('mariage_miniature/photos_charline/mairie/$url_min', 'mariage/photos_charline/mairie/$value', 'charline', 'mairie', 'not_tagged');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}

echo "<hr><h1>VH_charline</h1><hr>";
$photo_vh_ch = scandir('mariage/photos_charline/vin_honneur');
$photo_vh_ch_min = scandir('mariage_miniature/photos_charline/vin_honneur');

foreach ($photo_vh_ch as $key => $value) {
  if($key > 1){
    $url_min = $photo_vh_ch_min[$key];
    // echo $url_min . "<br>";

    // $sql = "INSERT INTO photos (url_miniature, url, prise_par, categorie, statut) VALUES ('mariage_miniature/photos_charline/vin_honneur/$url_min', 'mariage/photos_charline/vin_honneur/$value', 'charline', 'vin_honneur', 'not_tagged');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}
