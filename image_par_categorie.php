<?php
require_once ('fonctions.php');
//--------------------------------------------------//
// Récupérer les photos en fonction de la catégorie //
//--------------------------------------------------//
//traitement du post et stockage dans variable

if(isset($_POST['mode']) && !empty($_POST['mode']))
  $mode = strip_tags(trim($_POST['mode']));
else
  return false;

if(isset($_POST['page']) && !empty($_POST['page']))
  $page = strip_tags(trim($_POST['page']));
else
  $page = 1;

//---------------------------------------
// FONCTION DE PAGINATION ET MISE EN PAGE
//---------------------------------------

function addPhotoAndPaginate($tabPhoto,$mode,$page,$id_invite = null){
  $id = ($id_invite != null) ? 'data-id="'.$id_invite.'"' : '' ;
  $html = '';//init rendu html
  $nbrPage = floor(count($tabPhoto) / 12); //compte du nombre de page

  for($i = (($page-1)*12); $i < ((int)(($page-1)*12)+12) ; $i++){ //construction des div et intégration des photos en fonction de la page
      $html .= '<a href="'. $tabPhoto[$i]['url'] . '" download id="'.$i.'" class="section col-md-4 col-xs-12 photo-random"><img src="' . $tabPhoto[$i]['url'] . '"></a>';
  }

  //Si les résultat nécéssite plus d'une page, on met une âgination
  if($nbrPage > 1){
    //On met le bouton précédent si on est pas sur la page 1
    if($page > 1)
      $html .= '<div class="col-xs-12 text-center"><a class="paginate_link btn btn-default" data-mode="' . $mode . '" data-page="'. ($page - 1) .'"' . $id . '> < </a>';
    else
      $html .= '<div class="col-xs-12 text-center">';

      //Incrémentation des pages en fonction du nombre de résultats (on remet la catégorie et le mode pour relancer la même fonction ajax)
      for($j = 0; $j < $nbrPage; $j++){
          $html .= ' <a data-mode="' . $mode . '" data-page="'. ($j+1) .'"' . $id . ' class="paginate_link btn btn-default ';
          $html .= (($j+1) == $page) ? 'active' : '' ; //On met ou non la class active si c'est la page en cours
          $html .= '"> ' . ($j+1) . '</a> ';
      }

    //Bouton suivant si on est pas sur la dernière page
    if($page != $nbrPage)
      $html .= '<a class="paginate_link btn btn-default" data-mode="' . $mode . '" data-page="'. ($page+1) .'"' . $id . '> > </a></div>';
    else
      $html .= '</div>';
  }

 return $html;

}

//--------------------------
// FONCTION DE SELECTION BDD
//--------------------------

//Merci michou je te laisse commenter si besoin :P
function getPhotoByCategory(string $mode):array{
  $connexion = getDB();
  if($mode == "mairie" || $mode == "vin_honneur" || $mode == "salle"){
    $sql = "SELECT id_photo, url FROM photos WHERE categorie = ?;";
    $query = $connexion->prepare($sql);
    $query->execute(array($mode));
    $resultat = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
  }
  else{
    $error[] = "Erreur: la categorie doit être 'mairie', 'vin_honneur' ou 'salle'";
    return $error;
  }
} //end function getPhotoByCategory()


// Recupere les photos du user concerné //
function getPhotoByInvite(int $id_invite):array{
  $connexion = getDB();
  if(!is_nan($id_invite)){
    $sql = "SELECT p.url FROM photos p, invite_photo i WHERE i.id_photo = p.id_photo AND i.id_invite = '" .$id_invite . "';";
    $query = $connexion->prepare($sql);
    $query->execute(array($id_invite));
    $resultat = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
  }
  else{
    $error[] = "Erreur: l'id renseigné doit être un INT() correspondant à l'invité ciblé (1 à 90)";
    return $error;
  }
}

//-----------------------
// SELECTION FONCTION BDD
//-----------------------

//choix de la requete en fonction du mode de recherche
switch ($mode){
  case 'vin_honneur' :
  case 'mairie' :
  case 'salle' :
    $photoResult = getPhotoByCategory($mode);
    $resultHtml = addPhotoAndPaginate($photoResult,$mode,$page);
    break;

  case 'personne' :
    if(isset($_POST['id_invite']) && !empty($_POST['id_invite']))
      $id_invite = strip_tags(trim((int)$_POST['id_invite']));
    else
      return false;

      $photoResult = getPhotoByInvite($id_invite);
      $resultHtml = addPhotoAndPaginate($photoResult,$mode,$page,$id_invite);
    break;
}


echo $resultHtml;die();
