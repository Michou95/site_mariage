<?php
session_start();

if($_SESSION['user'] == "allowed" || $_SESSION['user'] == "admin"){
 ?>
<?php require_once ('fonctions.php'); ?>
<?php include_once'head.php'; ?>

<!-- Section rubrique clickables -->
      <div class="section_all">

        <div class="section col-md-2 col-sm-4 col-xs-6">
          <a data-section="salle">
            <img src="mariage/photos_categories/mairie.jpg">
          </a>
          <div data-mode="mairie" class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              Mairie
            </h2>
          </div>
        </div>

        <div class="section col-md-2 col-sm-4 col-xs-6">
          <a data-section="salle">
            <img src="mariage/photos_categories/vin_honneur.jpg">
          </a>
          <div data-mode="vin_honneur" class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              Vin D'honneur
            </h2>
          </div>
        </div>

        <div class="section col-md-2 col-sm-4 col-xs-6">
          <a data-section="salle">
            <img src="mariage/photos_categories/salle.jpg">
          </a>
          <div data-mode="salle" class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              Salle des fêtes
            </h2>
          </div>
        </div>

        <div class="section col-md-2 col-sm-4 col-xs-6">
          <a data-section="salle">
            <img src="mariage/photos_categories/photobooth.jpg">
          </a>
          <div data-mode="photobooth" class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              Photobooth
            </h2>
          </div>
        </div>

        <div class="section col-md-2 col-sm-4 col-xs-6">
          <a data-section="salle">
            <img src="mariage/photos_categories/videos.jpg">
          </a>
          <div class="photo_section" id="videos" style="display:none;">
            <h2 class="title_section_hover">
              Vidéos
            </h2>
          </div>
        </div>

        <div class="section col-md-2 col-sm-4 col-xs-6">
          <a data-section="salle">
            <img src="mariage/photos_categories/a_propos.jpg">
          </a>
          <div class="photo_section" id="best_picture" data-mode="best_photos" style="display:none;">
            <h2 class="title_section_hover">
              Vos photos favorites
            </h2>
          </div>
        </div>

      </div>


<!-- Barre de scroll -->
    <div id="go_to_photo" class="col-xs-12 text-center scroll_barre">
      <i class="fas fa-chevron-down fa-2x"></i>
    </div>

    <!-- Section titre photos random -->
    <div class="photo_title">
      <h2>La sélection aléatoire</h2>
    </div>


<!-- Section affichage photo random -->
    <div class="container">
      <?php
        $random = getRandomPhoto();
        for ($i=0; $i < count($random) ; $i++) {
          echo '<div class="col-md-4 col-sm-6 col-xs-12 overflowHidden">
                  <input type="hidden" name="photo_'.$i.'" value="'.$random[$i]['id_photo'].'" />
                  <a id="photo_'.$i.'" data-url-photo="'.$random[$i]['url'].'" class="photo col-xs-12">
                    <img src="' . $random[$i]['url_miniature'] . '">
                  </a>
                  <div style="display:none" class="hover_photo">
                    <i class="fas fa-search-plus fa-4x"></i>
                    <div style="display:none" class="barre_miniature_hover col-xs-12">
                      <a data-id-photo="'.$random[$i]['id_photo'].'" class="btn-custom btn-like like">
                        <i class="fas fa-heart"></i>
                      </a>
                      <span class="text-info">J\'aime</span>
                      <span class="text-info">Télécharger</span>
                      <a class="btn-custom btn-download" href="'.$random[$i]['url'].'" download>
                        <i class="fas fa-download"></i>
                      </a>
                    </div>
                  </div>
                </div>';
        }
       ?>
    </div>



<?php include_once'footer.php';
}
else{
  header('Location: ../index.php');
}
?>
