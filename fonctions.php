<?php

//--------------------------------//
// Connexion à la Base de Données //
//--------------------------------//
function getDb(){
  try {
      $connexion = new PDO('mysql:host=localhost; dbname=mariage', 'root', '');
      $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $connexion;
    }
    catch(exception $e) {
      die('Erreur '.$e->getMessage());
    }
}

//----------------------------------------//
// Récupérer toutes les photos de la base //
//----------------------------------------//
function getAllPhotos():array{
  $connexion = getDB();
  $sql = "SELECT url FROM photos;";
  $response = $connexion->query($sql);
  $resultat = $response->fetchAll(PDO::FETCH_ASSOC);
  return $resultat;
} //end function getAllPhotos()


//----------------------------------------------------//
// Récupération des photos en fonction du photographe //
//----------------------------------------------------//
function getPhotoByPhotographe(string $photographe):array{
  $connexion = getDB();
  if($photographe == "charline" || $photographe == "invites"){
    $sql = "SELECT url FROM photos WHERE prise_par = '" . $photographe . "';";
    $response = $connexion->query($sql);
    $resultat = $response->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
  }
  else{
    $error[] = "erreur: le photographe ne peut être que 'charline' ou 'invites'.";
  }
} //end fucntion getPhotoByPhotographe()


//-----------------------------------------------------------------------//
// Récupération des photos en fonction de la catégorie et du photographe //
//-----------------------------------------------------------------------//
function getPhotoByPhotographeAndCategory(string $photographe, string $category):array{
  $connexion = getDB();
  if(($category == "mairie" || $category == "vin_honneur" || $category == "salle") && ($photographe == "charline" || $photographe == "invites")){
    $sql = "SELECT url FROM photos WHERE categorie = '" . $category . "';";
    $response = $connexion->query($sql);
    $resultat = $response->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
  }
  else{
    $error[] = "Erreur: le photographe ne peut être que 'charline' ou 'invites'.";
    $error[] = "Erreur: la categorie doit être 'mairie', 'vin_honneur' ou 'salle'";
    return $error;
  }
} //end function getPhotoByPhotographeAndCategory()


//--------------------------------------//
// Recupere les photos du user concerné //
//--------------------------------------//
function getPhotoByInvite(int $id_invite) :array{
  $connexion = getDB();
  if(!isNaN($id_invite)){
    $sql = "SELECT p.url FROM photos p, invite_photo i WHERE i.id_photo = p.id_photo AND i.id_invite = '" .$id_invite . "';";
    $query = $connexion->query($sql);
    $resultat = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
  }
  else{
    $error[] = "Erreur: l'id renseigné doit être un INT() correspondant à l'invité ciblé (1 à 90)";
    return $error;
  }
}
