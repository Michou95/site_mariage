<?php
require_once ('fonctions.php');
//--------------------------------------------------//
// Récupérer les photos en fonction de la catégorie //
//--------------------------------------------------//


if(isset($_POST['categorie']) && !empty($_POST['categorie']))
  $categorie = strip_tags(trim($_POST['categorie']));
else
  return false;

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

function addPhotoAndPaginate($tabPhoto,$mode,$page,$categorie){
  $html = '';
  $nbrPage = floor(count($tabPhoto) / 12); //compte du nombre de page
  var_dump(count($tabPhoto));
  
 for($i = (($page-1)*12); $i < ((int)(($page-1)*12)+12) ; $i++){
     $html .= '<div id="'.$i.'" class="section col-md-4 col-xs-12 photo-random"><img src="' . $tabPhoto[$i]['url'] . '"></div>';
 }

  if($nbrPage > 1){
    //pagination
    if($page > 1)
      $html .= '<div><a class="paginate_link" data-categorie="' . $categorie . '" data-mode="' . $mode . '" data-page="'. ($page - 1) .'"> < </a>';
    else 
      $html .= '<div class="paginate">';

      for($j = 0; $j < $nbrPage; $j++){
          $html .= ' <a data-categorie="' . $categorie . '" data-mode="' . $mode . '" data-page="'. ($j+1) .'" class="';
          $html .= ($j == $page) ? 'paginate_link active' : 'paginate_link' ; //On met ou non la class active si c'est la page en cour
          $html .= '"> ' . ($j+1) . '</a>';   
      }
    
    if($page != $nbrPage)
      $html .= '<a class="paginate_link" data-categorie="' . $categorie . '" data-mode="' . $mode . '" data-page="'. ($j+2) .'"> > </a></div>';
    else 
      $html .= '</div>';
  }

 return $html;
 
}

//--------------------------
// FONCTION DE SELECTION BDD 
//--------------------------

function getPhotoByCategory(string $category):array{
  $connexion = getDB();
  if($category == "mairie" || $category == "vin_honneur" || $category == "salle"){
    $sql = "SELECT id_photo, url FROM photos WHERE categorie = ?;"; 
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

//-----------------------
// SELECTION FONCTION BDD
//-----------------------


//choix de la requete en fonction du mode de recherche
switch ($mode){
  case 'categorie' : 
    $photoResult = getPhotoByCategory($categorie);
    $resultHtml = addPhotoAndPaginate($photoResult,$mode,$page,$categorie);
    break;
}


echo $resultHtml;die();





  

