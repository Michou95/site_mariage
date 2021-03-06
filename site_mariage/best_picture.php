<?php require_once ('fonctions.php'); ?>
<div class="photo_title">
  <h2>Vos Photo Favorites</h2>
</div>

<div class="col-xs-12">
  <p class="text-center alert-success">Ici son regroupées les photos ayant reçu le + de "J'aime". N'hésitez pas à clicker sur le bouton "J'aime" lorsqu'une photo vous plait! Le classement changera en fonction des "J'aime" obtenus par les photos.</p>
</div>
<?php
  $best_photo = getBestPhotos();
  for ($i=0; $i < count($best_photo) ; $i++) {
    $number = $i+1;
    $title = "Numéro " . $number;
    if($title == "Numéro 1")
      $title = "The Best Photo Ever !";
    echo '<div class="col-md-12 col-sm-12 col-xs-12 overflowHidden">
            <a id="photo_'.$i.'" data-url-photo="'.$best_photo[$i]['url'].'" class="photo col-md-offset-3 col-md-4 col-xs-12">
              <img src="' . $best_photo[$i]['url_miniature'] . '">
            </a>
            <h2 class="col-md-5">'. $title .'</h2>
            <div style="display:none" class="hover_photo">
              <i class="fas fa-search-plus fa-4x"></i>
              <div style="display:none" class="barre_miniature_hover col-xs-12">
                  <span class="text-info">J\'aime</span>
                  <a data-id-photo="'.$best_photo[$i]['id_photo'].'" class="btn-custom btn-like like">
                    <i class="fas fa-heart"></i>
                  </a>
                  <span class="text-info">Télécharger</span>
                  <a class="btn-custom btn-download" href="'.$best_photo[$i]['url'].'">
                    <i class="fas fa-download"></i>
                  </a>
              </div>
            </div>
          </div>';
  }
 ?>
<style media="screen">
  p{
    font-family: 'allura', verdana, arial, sans-serif;
    font-size: 2em;
  }
</style>
