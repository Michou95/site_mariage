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

//-----------------------------------------------------//
// Récupère le nom + prenom invité en fonction de l'id //
//-----------------------------------------------------//
function getInviteById(int $id):array{
  $connexion = getDB();
  $sql = "SELECT prenom, nom FROM invites WHERE id_invite = '". $id ."';";
  $query = $connexion->query($sql);
  $resultat = $query->fetchAll(PDO::FETCH_ASSOC);

  return $resultat;
}

function getPhotoTaggued(){
  $connexion = getDB();
  $sql = "SELECT id_photo FROM invite_photo;";
  $query = $connexion->query($sql);
  $resultat = $query->fetchAll(PDO::FETCH_ASSOC);

  return $resultat;
}

//---------------------------------------//
// Récupère la liste de tous les invités //
//---------------------------------------//
function getAllInvites():array{
  $connexion = getDB();
  $sql = "SELECT * FROM invites;";
  $query = $connexion->query($sql);
  $resultat = $query->fetchAll(PDO::FETCH_ASSOC);

  return $resultat;
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

//-------------------------------------------//
// Récupérer toutes les id photos de la base //
//-------------------------------------------//
function getAllIdPhotos(){
  $connexion = getDB();
  $sql = "SELECT id_photo FROM photos;";
  $response = $connexion->query($sql);
  $resultat = $response->fetchAll(PDO::FETCH_ASSOC);
  return $resultat;
}

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


//-----------------------------------------------//
// Récupère le nombre d'association photo Invite //
//-----------------------------------------------//
function getAllTags(){
  $connexion = getDB();
  $sql = "SELECT * FROM invite_photo;";
  $query = $connexion->query($sql);
  $resultat = $query->fetchAll(PDO::FETCH_ASSOC);

  return $resultat;
} //end function getAllTags()


//--------------------------------//
// Récupérer le nombre de visites //
//--------------------------------//
function getAllVisites():string{

  $connexion = getDB();
  $sql = "SELECT compteur FROM visites WHERE id_nb_visites;";
  $query = $connexion->query($sql);
  $resultat = $query->fetchAll(PDO::FETCH_ASSOC);

  $compteur = $resultat[0]['compteur'];

  return $compteur;
}


//---------------------------------------------------------------------//
// Recupere l'utilisateur en fonction de ce qui est ecrit dans le form //
//---------------------------------------------------------------------//
// function getInviteByInputForm(string $value){
//   $connexion = getDB();
//   $sql "SELECT i.prenom, i.nom FROM"
// }

//------------------------------//
// Recupere 12 photos en random //
//------------------------------//
function getRandomPhoto():array{
  $connexion = getDB();
  $sql = "SELECT url FROM photos ORDER BY RAND() LIMIT 0, 12;";
  $response = $connexion->query($sql);
  $resultat = $response->fetchAll(PDO::FETCH_ASSOC);

  return $resultat;
}
