<?php require_once ('fonctions.php'); ?>
<?php include_once'head.php' ?>

<!-- Section rubrique clickables -->
      <div class="section_all">

        <div class="section col-md-4 col-xs-12">
          <a data-section="salle">
            <img src="mariage/photos_charline/mairie/413.jpg">
          </a>
          <div data-section="mairie" class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              Photos Mairie
            </h2>
          </div>
        </div>

        <div class="section col-md-4 col-xs-12">
          <a data-section="salle">
            <img src="mariage/photos_charline/vin_honneur/545.jpg">
          </a>
          <div data-section="vin_honneur" class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              Photos Vin D'honneur
            </h2>
          </div>
        </div>

        <div class="section col-md-4 col-xs-12">
          <a data-section="salle">
            <img src="mariage/photos_charline/vin_honneur/546.jpg">
          </a>
          <div data-section="salle" class="hover_section" style="display:none;">
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

<!-- Section affichage photo random -->
    <div class="container">
      <?php
        $random = getRandomPhoto();
        for ($i=0; $i < count($random) ; $i++) {
          echo '<div class="section col-md-4 col-xs-12 photo-random">
                  <img src="' . $random[$i]['url'] . '">
                </div>';
        }
       ?>
    </div>



<?php include_once'footer.php' ?>
