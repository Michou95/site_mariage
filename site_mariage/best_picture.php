<?php require_once ('fonctions.php'); ?>

<div class="photo_title">
  <h2>Vos Photo Favorites</h2>
</div>

<div class="col-xs-12">
  <p class="text-center alert-success">Ici son regroupées les photos ayant reçu le + de like. N'hésitez pas à clicker sur le bouton like lorsqu'une photo vous plait! Le classement changera en fonction des likes obtenus par les photos.</p>
</div>
<?php
  $best_photo = getBestPhotos();
  for ($i=0; $i < count($best_photo) ; $i++) {
    echo '<div class="col-md-4 col-sm-6 col-xs-12 overflowHidden">
            <a id="photo_'.$i.'" data-url-photo="'.$best_photo[$i]['url'].'" class="photo col-xs-12">
              <img src="' . $best_photo[$i]['url_miniature'] . '">
            </a>
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
