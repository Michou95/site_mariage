<?php
require_once ('fonctions.php');

if(isset($_POST)){
  if(isset($_POST['id_photo'])){
    $id_photo = strip_tags(trim($_POST['id_photo']));
    addLike($id_photo);
  }
  else{
    echo "erreur de reception id_photo";
    die();
  }

}
else{
  echo "erreur de reception POST";
  die();
}

//-----------------------------------------------------------------------//
//----- Incrémente de 1 le compteur de vote pour la photo concernée -----//
//-----------------------------------------------------------------------//
function addLike($id_photo){
  $connexion = getDb();
  $sql = "SELECT vote FROM photos WHERE id_photo = '" . $id_photo . "';";
  $query = $connexion->prepare($sql);
  $query->execute();
  $resultat = $query->fetch(PDO::FETCH_ASSOC);

  $like = $resultat['vote'] + 1;
  $sql = "UPDATE photos SET vote = '" . $like . "' WHERE id_photo = '" . $id_photo . "';";
  $query = $connexion->prepare($sql);
  $query->execute();
  die();

} //end function addLike()
