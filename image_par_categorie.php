<?php
require_once ('fonctions.php');
//--------------------------------------------------//
// Récupérer les photos en fonction de la catégorie //
//--------------------------------------------------//

$categorie = strip_tags(trim($_POST['categorie']));

var_dump($categorie);

function getPhotoByCategory(string $category):array{
  $connexion = getDB();
  if($category == "mairie" || $category == "vin_honneur" || $category == "salle"){
    $sql = "SELECT url FROM photos WHERE categorie = ?;"; 
    $query = $connexion->prepare($sql);
    $query->execute(array($category));
    $resultat = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
  }
  else{
    $error[] = "Erreur: la categorie doit être 'mairie', 'vin_honneur' ou 'salle'";
    return $error;
  }
} //end function getPhotoByCategory()

echo json_encode(getPhotoByCategory($categorie));
