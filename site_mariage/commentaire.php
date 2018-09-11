<?php
  if ($_POST) {
    require_once ('fonctions.php');
    $data = '';

    $connexion = getDB();
    $id_photo = $_POST['id_photo'];
    $url_photo = $_POST['url_photo']; 
  
    $sql = "SELECT * FROM commentary WHERE photo_id = $id_photo ORDER BY id";
    $query = $connexion->prepare($sql);
    $query->execute();
    $resultats = $query->fetchAll(PDO::FETCH_ASSOC);
    if (empty($resultats)) {
      $data .= "<div class='no_commentary alert-info'>Aucun commmentaire sur cette photo.</div>";
    } else {
      $data .= "<div class='nb_commentary'><span class='redNumber'>".count($resultats)."</span> commentaire(s) sur cette photo</div>";
      $data .= "<div id='only_commentarys'>";

      foreach ($resultats as $resultat) {
        $date = getDateByTimestamp($resultat['timestamp']);

        $data .= "<div class='commentary'>
                    <div class='username'>
                      ".$resultat['username']."
                    </div>
                    <div class='content'>
                      ".$resultat['content']."
                    </div>
                    <div class='date_time'>
                      ".$date."
                    </div>
                  </div>";
      }
      
      $data .= "</div>";
    }

    $data .= "<div class='add_commentary'>
                <div id='error'></div>
                <form class='form_commentary' method='POST' action=''>
                  <label for='username'>Votre Nom / Prénom / Pseudo :</label>
                  <input type='text' id='username' name='username' autofocus placeholder='Dite nous qui vous êtes !' />
                  <label for='content'>Votre commentaire :</label>
                  <textarea id='content' name='content' placeholder='Taper votre commentaire ...' rows='4'></textarea>
                  <input type='submit' class='submit btn btn-primary' value='Envoyer' />
                </form>
              </div>";

    $data .= '<div class="barre_modal-btn">
                <a data-id-photo="'.$id_photo.'" class="btn-custom-modal btn-like like">
                  <i class="fas fa-heart"></i>
                </a>
                <span class="text-info">J\'aime</span>
                <span class="text-info">Télécharger</span>
                <a class="btn-custom-modal btn-download" href="'.$url_photo.'" download>
                  <i class="fas fa-download"></i>
                </a>
              </div>';
  }

  echo $data;
?>