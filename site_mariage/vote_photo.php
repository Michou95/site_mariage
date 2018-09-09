<?php
require_once ('fonctions.php');

$id_photo = strip_tags(trim($_POST['id_photo']));

//-----------------------------------------------------------------------//
//----- Incrémente de 1 le compteur de vote pour la photo concernée -----//
//-----------------------------------------------------------------------//
function addLike($id_photo){
  $connexion = getDb();
  $sql = "SELECT vote FROM photos WHERE id_photo = '" . $id_photo . "';";
  $query = $connexion->prepare($sql);
  $query->execute();
  $reslutat = $query->fetch(PDO::FETCH_ASSOC);
  var_dump($resultat);
  die();

  
} //end function addLike()
