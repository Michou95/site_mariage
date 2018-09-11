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
function addPhotoAndPaginate($tabPhoto,$mode,$page,$id_invite = null, $nom_invite = null){
  $nom = ($nom_invite != null) ? 'data-nom-invite="'.$nom_invite.'" ' : '' ;
  $id = ($id_invite != null) ? 'data-id="'.$id_invite.'" ' : '' ;
  $html = '';//init rendu html
  $nbrPage = ceil(count($tabPhoto) / 12); //compte du nombre de page au supérieur si il y a plus de photo que de page
  for($i = (($page-1)*12); $i < ((int)(($page-1)*12)+12) ; $i++){ //construction des div et intégration des photos en fonction de la page
    if(isset($tabPhoto[$i])){
      if($tabPhoto[$i]['prise_par'] == "charline"){
        $html .= '<div class="col-md-4 col-sm-6 col-xs-12 overflowHidden"><input type="hidden" name="photo_'.$i.'" value="'.$tabPhoto[$i]["id_photo"].'" /><a id="photo_'.$i.'" data-url-photo="'.$tabPhoto[$i]['url'].'" data-photo-charline="true" class="photo col-xs-12"><img src="' . $tabPhoto[$i]['url_miniature'] . '"></a><div style="display:none" class="hover_photo"><i class="fas fa-search-plus fa-4x"></i><div style="display:none" class="barre_miniature_hover col-xs-12">
        <a data-id-photo="'.$tabPhoto[$i]['id_photo'].'" class="btn-custom btn-like like"><i class="fas fa-heart"></i></a><span class="text-info">J\'aime</span><span class="text-info">Télécharger</span><a class="btn-custom btn-download" href="'.$tabPhoto[$i]['url'].'" download><i class="fas fa-download"></i></a></div></div></div>';
      }
      else{
        $html .= '<div class="col-md-4 col-sm-6 col-xs-12 overflowHidden"><input type="hidden" name="photo_'.$i.'" value="'.$tabPhoto[$i]["id_photo"].'" /><a id="photo_'.$i.'" data-url-photo="'.$tabPhoto[$i]['url'].'" data-photo-charline="false" class="photo col-xs-12"><img src="' . $tabPhoto[$i]['url_miniature'] . '"></a><div style="display:none" class="hover_photo"><i class="fas fa-search-plus fa-4x"></i><div style="display:none" class="barre_miniature_hover col-xs-12">
        <a data-id-photo="'.$tabPhoto[$i]['id_photo'].'" class="btn-custom btn-like like"><i class="fas fa-heart"></i></a><span class="text-info">J\'aime</span><span class="text-info">Télécharger</span><a class="btn-custom btn-download" href="'.$tabPhoto[$i]['url'].'" download><i class="fas fa-download"></i></a></div></div></div>';
      }
    }
  }
  //Stockage du tableau de résultat en cour d'affichage dans la session
  //Si les résultat nécéssite plus d'une page, on met une pagination
  if($nbrPage > 1){
    //On met le bouton précédent si on est pas sur la page 1
    if($page > 1)
      $html .= '<div class="col-xs-12 text-center"><a class="paginate_link btn btn-default" data-mode="' . $mode . '" data-page="'. ($page - 1) .'"' . $id . $nom .'> < </a>';
    else
      $html .= '<div class="col-xs-12 text-center">';
      //Incrémentation des pages en fonction du nombre de résultats (on remet la catégorie et le mode pour relancer la même fonction ajax)
      for($j = 0; $j < $nbrPage; $j++){
          $html .= ' <a data-mode="' . $mode . '" data-page="'. ($j+1) .'"' . $id . $nom .' class="paginate_link btn btn-default ';
          $html .= (($j+1) == $page) ? 'active' : '' ; //On met ou non la class active si c'est la page en cours
          $html .= '"> ' . ($j+1) . '</a> ';
      }
    //Bouton suivant si on est pas sur la dernière page
    if($page != $nbrPage)
      $html .= '<a class="paginate_link btn btn-default" data-mode="' . $mode . '" data-page="'. ($page+1) .'"' . $id . $nom .'> > </a></div>';
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
  if($mode == "mairie" || $mode == "vin_honneur" || $mode == "salle" || $mode == "photobooth"){
    $sql = "SELECT id_photo, url, url_miniature, prise_par FROM photos WHERE categorie = ?;";
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
// Recupere les photos du user concerné -- YOUX CA BUGG POUR CERTAINES PERSONNES AU NIVEAU DE LA RECUP PHOTOBOOTH !!!//
// Expemple pour stephane ferrand ca recup 32 photos mais ca en affiche que 24 en front //
function getPhotoByInvite(int $id_invite):array{
  $connexion = getDB();
  if(!is_nan($id_invite)){
    $sql = "SELECT p.url, p.url_miniature, p.prise_par, p.id_photo FROM photos p, invite_photo i WHERE i.id_photo = p.id_photo AND i.id_invite = '" .$id_invite . "';";
    $query = $connexion->prepare($sql);
    $query->execute(array($id_invite));
    $resultat = $query->fetchAll(PDO::FETCH_ASSOC);
    //----- Debug pour probleme affichage de toutes les photos -----//
    // echo "<pre>";
    // var_dump($resultat);
    // echo "</pre>";
    // die();
    //--------------------------------------------------------------//
    return $resultat;
  }
  else{
    $error[] = "Erreur: l'id renseigné doit être un INT() correspondant à l'invité ciblé (1 à 90)";
    return $error;
  }
}
//------------------------//
// SELECTION FONCTION BDD //
//------------------------//
//choix de la requete en fonction du mode de recherche
switch ($mode){
  case 'vin_honneur' :
  case 'mairie' :
  case 'salle' :
  case 'photobooth' :
    $photoResult = getPhotoByCategory($mode);
    $resultHtml = addPhotoAndPaginate($photoResult,$mode,$page);
    break;
  case 'personne' :
    if(isset($_POST['id_invite']) && !empty($_POST['id_invite']) && isset($_POST['nom_invite']) && !empty($_POST['nom_invite'])){
      $id_invite = strip_tags(trim((int)$_POST['id_invite']));
      $nom_invite = strip_tags(trim($_POST['nom_invite']));
    }
    else
      return false;
      $photoResult = getPhotoByInvite($id_invite);
      $resultHtml = addPhotoAndPaginate($photoResult,$mode,$page,$id_invite,$nom_invite);
    break;
  case 'best_photos' :
      $photoResult = getBestPhotos();
      $resultHtml = addPhotoAndPaginate($photoResult, $mode, 1);
    break;
}
echo $resultHtml;die();
