<?php
//----- connexion a la bdd -----//
try {
    $connexion = new PDO('mysql:host=localhost; dbname=mariage', 'root', '');
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }
  catch(exception $e) {
    die('Erreur '.$e->getMessage());
  }

//----- Requete selection photos personnalise -----//
  $sql = "SELECT p.url, p.prise_par, p.categorie FROM photos p, invite_photo i WHERE i.id_photo = p.id_photo AND i.id_invite = 84;";
  $query = $connexion->query($sql);
  $response = $query->fetchAll(PDO::FETCH_ASSOC);

//----- test affichage photo personnalise -----//
for ($i=0; $i < count($response); $i++) {
  $url = $response[$i]['url'];
  echo '<img src="' . $url . '" alt ="photo" style="max-width: 500px; max-height=300px;"><br>';
}

//----- le petit die() qui vient tout niquer -----//
  die();

//-----------------------------------------------------------------------------------------//
//--------- Traitement des photos renommage des fichiers insertion en BDD -----------------//
// ATTENTION NE PAS MANIPULER SI ON SAIS PAS CE QU'ON FAIT SOUS PEINE DE NIQUER LA BDD !!! //
//-----------------------------------------------------------------------------------------//

// $i = 1;
echo "<hr><h1>Mairie_invites</h1><hr>";
$photo_mairie = scandir("mariage/mairie");

// echo "<pre>";
// var_dump($photo_mairie);
// echo "</pre>";

foreach ($photo_mairie as $key => $value) {
  if($key > 1){
    // echo $value . ' => ' . $i . '<br>';
    //rename("mariage/mairie/" . $value, "mariage/mairie/" . $i . ".jpg");
    // $i++;
    // $sql = "INSERT INTO photos (url, prise_par, categorie) VALUES ('mariage/mairie/". $value ."', 'invites', 'mairie');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}

echo "<hr><h1>VH_invites</h1><hr>";
$photo_vh = scandir('mariage/vin_honneur');


foreach ($photo_vh as $key => $value) {
  if($key > 1){
    // echo $value . ' => ' . $i . '<br>';
    //rename('mariage/vin_honneur/' . $value, 'mariage/vin_honneur/' . $i . ".jpg");
    // $i++;
    // $sql = "INSERT INTO photos (url, prise_par, categorie) VALUES ('mariage/vin_honneur/". $value ."', 'invites', 'vin_honneur');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}

echo "<hr><h1>Salle_invites</h1><hr>";
$photo_salle = scandir('mariage/salle');
// echo "<pre>";
// var_dump($photo_salle);
// echo "</pre>";


foreach ($photo_salle as $key => $value) {
  if($key > 1){
    // echo $value . ' => ' . $i . '<br>';
    //rename('mariage/salle/' . $value, 'mariage/salle/' . $i . ".jpg");
    // $i++;
    // $sql = "INSERT INTO photos (url, prise_par, categorie) VALUES ('mariage/salle/". $value ."', 'invites', 'salle');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}

echo "<hr><h1>Mairie_charline</h1><hr>";
$photo_mairie_ch = scandir('mariage/photos_charline/mairie');


foreach ($photo_mairie_ch as $key => $value) {
  if($key > 1){
    // echo $value . ' => ' . $i . '<br>';
    //rename('mariage/photos_charline/mairie/' . $value, 'mariage/photos_charline/mairie/' . $i . ".jpg");
    // $i++;
    // $sql = "INSERT INTO photos (url, prise_par, categorie) VALUES ('mariage/photos_charline/mairie/". $value ."', 'charline', 'mairie');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}

echo "<hr><h1>VH_charline</h1><hr>";
$photo_vh_ch = scandir('mariage/photos_charline/vin_honneur');

foreach ($photo_vh_ch as $key => $value) {
  if($key > 1){
    // echo $value . '<br>';
    //rename('mariage/photos_charline/vin_honneur/' . $value, 'mariage/photos_charline/vin_honneur/' . $i . ".jpg");
    // $i++;
    // $sql = "INSERT INTO photos (url, prise_par, categorie) VALUES ('mariage/photos_charline/vin_honneur/". $value ."', 'charline', 'vin_honneur');";
    // $query = $connexion->prepare($sql);
    // $query->execute();
  }
}
