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

//------------------------------------------------------------------------//
// Récupère les photos de la BDD qui ne sont pas tagguée avec des invités //
//------------------------------------------------------------------------//
function getPhotoNotTaggued(){
  $connexion = getDB();
  $sql = "SELECT id_photo, url FROM photos WHERE statut = 'not_tagged';";
  $query = $connexion->query($sql);
  $resultat = $query->fetchAll(PDO::FETCH_ASSOC);

  return $resultat;
}

//-----------------------------------------------------------------------------------------------//
// Insère un tag invité associé à une photo et modifie le statut de la photo concernée à "tagged"//
//-----------------------------------------------------------------------------------------------//
function addTag(int $id_invite, int $id_photo){
  $connexion = getDB();
  $sql = "INSERT INTO invite_photo (id_invite, id_photo) VALUES ('" . $id_invite . "', '" . $id_photo . "');";
  $query = $connexion->prepare($sql);
  $query->execute();
}

//----------------------------------------------------//
// modifie le statut de la photo concernée à "tagged" //
//----------------------------------------------------//
function setPhotoToTagged(int $id_photo){
  $connexion = getDB();
  $sql = "UPDATE photos SET statut = 'tagged' WHERE id_photo = '" . $id_photo . "';";
  $query = $connexion->prepare($sql);
  $query->execute();
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
} //end function getAllVisites()


//------------------------------//
// Recupere 12 photos en random //
//------------------------------//
function getRandomPhoto():array{
  $connexion = getDB();
  $sql = "SELECT id_photo, url, url_miniature, prise_par FROM photos ORDER BY RAND() LIMIT 0, 12;";
  $response = $connexion->query($sql);
  $resultats = $response->fetchAll(PDO::FETCH_ASSOC);

  $realname = $_SESSION['realname'];

  for ($i = 0; $i < count($resultats); $i++) {
    $id_photo = $resultats[$i]['id_photo'];

    $sql = "SELECT COUNT(*) AS 'status' FROM invite_vote WHERE realname = ? AND id_photo = ?";
    $query = $connexion->prepare($sql);
    $query->execute(array($realname, $id_photo));
    $like = $query->fetch(PDO::FETCH_ASSOC);

    if ($like['status'] == 1) {
      $resultats[$i]['like'] = 'dislike';
    } else {
      $resultats[$i]['like'] = 'like';
    }
  }
  return $resultats;
} //end fucntion getRandomPhoto()


//------------------------------------------------------//
// Récupère les première photos ayant reçu le + de like //
//------------------------------------------------------//
function getBestPhotos():array{
  $connexion = getDb();
  $sql = "SELECT url_miniature, url, id_photo, prise_par FROM photos WHERE vote != 0 ORDER BY vote DESC LIMIT 0, 12;";
  $query = $connexion->query($sql);
  $resultats = $query->fetchAll(PDO::FETCH_ASSOC);

  $realname = $_SESSION['realname'];

  for ($i = 0; $i < count($resultats); $i++) {
    $id_photo = $resultats[$i]['id_photo'];

    $sql = "SELECT COUNT(*) AS 'status' FROM invite_vote WHERE realname = ? AND id_photo = ?";
    $query = $connexion->prepare($sql);
    $query->execute(array($realname, $id_photo));
    $like = $query->fetch(PDO::FETCH_ASSOC);

    if ($like['status'] == 1) {
      $resultats[$i]['like'] = 'dislike';
    } else {
      $resultats[$i]['like'] = 'like';
    }
  }
  return $resultats;
} //end function getBestPhotos()

//-------------------------------------------------------------//
// Récupère la date et la met au format  pour les commentaires //
//-------------------------------------------------------------//
function getDateByTimestamp($timestamp) {
  $month = [1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril', 5 => 'Mais', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août', 9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'];

  $jour = date('d', $timestamp);
  $mois = date('n', $timestamp);
  $mois_en_lettre = $month[$mois];
  $annee = date('Y', $timestamp);
  $heure = date('H', $timestamp);
  $minute = date('i', $timestamp);

  $result = "Ajouté le ".$jour." ".$mois_en_lettre." ".$annee." à ".$heure."h".$minute;

  return $result;
}
