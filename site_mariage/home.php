<?php
session_start();

if($_SESSION['user'] == "allowed"){
 ?>
<?php require_once ('fonctions.php'); ?>
<?php include_once'head.php'; ?>

<!-- Section rubrique clickables -->
      <div class="section_all">

        <div class="section col-md-4 col-xs-12">
          <a data-section="salle">
            <img src="mariage/photos_charline/mairie/413-compressor.jpg">
          </a>
          <div data-mode="mairie" class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              Photos Mairie
            </h2>
          </div>
        </div>

        <div class="section col-md-4 col-xs-12">
          <a data-section="salle">
            <img src="mariage/photos_charline/vin_honneur/544-compressor.jpg">
          </a>
          <div data-mode="vin_honneur" class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              Photos Vin D'honneur
            </h2>
          </div>
        </div>

        <div class="section col-md-4 col-xs-12">
          <a data-section="salle">
            <img src="mariage/photos_charline/vin_honneur/546-compressor.jpg">
          </a>
          <div data-mode="salle" class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              Photos Salle des fêtes
            </h2>
          </div>
        </div>
      </div>

<!-- Barre de scroll -->
    <div id="go_to_photo" class="col-cs-12 text-center scroll_barre">
      <i class="fas fa-chevron-down fa-3x"></i>
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
          echo '<a onclick="$(\'#myModal .modal-content\').load(\'modal_photo.php?urlPhoto='.$random[$i]['url'].'\',function(){$(\'#myModal\').modal(\'show\');});" class="section col-md-4 col-xs-12 photo-random">
                  <img src="' . $random[$i]['url_miniature'] . '">
                </a>';
        }
       ?>
    </div>



<?php include_once'footer.php';
}
else{
  header('Location: index.php');
}
?>
