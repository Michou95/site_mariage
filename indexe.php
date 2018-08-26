<?php require_once ('fonctions.php'); ?>
<?php include_once'head.php' ?>

<!-- Section titre rubriques -->
    <div class="row">
      <div class="selection">
        <h2>Les rubriques</h2>
      </div>
    </div>

<!-- Section rubrique clickables -->
    <div class="row">
      <div class="section_all">

        <div class="section col-md-4 col-xs-12">
          <a data-section="salle">
            <img src="mariage/photos_charline/mairie/413.jpg">
          </a>
          <div class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              PHOTOS MAIRIE
            </h2>
          </div>
        </div>

        <div class="section col-md-4 col-xs-12">
          <a data-section="salle">
            <img src="mariage/photos_charline/vin_honneur/545.jpg">
          </a>
          <div class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              PHOTOS VIN D'HONNEUR
            </h2>
          </div>
        </div>

        <div class="section col-md-4 col-xs-12">
          <a data-section="salle">
            <img src="mariage/photos_charline/vin_honneur/546.jpg">
          </a>
          <div class="hover_section" style="display:none;">
            <h2 class="title_section_hover">
              PHOTOS SALLE
            </h2>
          </div>
        </div>
      </div>
    </div>

<!-- Section titre photos random -->
    <div class="row">
      <div class="random-title">
        <h2>La sélection aléatoire</h2>
      </div>
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
