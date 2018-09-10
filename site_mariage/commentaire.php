<?php
  if ($_POST) {
    require_once ('fonctions.php');
    $data = '';

    $connexion = getDB();
    $id_photo = $_POST['id_photo'];
  
    $sql = "SELECT * FROM commentary WHERE photo_id = $id_photo ORDER BY id";
    $query = $connexion->prepare($sql);
    $query->execute();
    $resultats = $query->fetchAll(PDO::FETCH_ASSOC);
    if (empty($resultats)) {
      $data .= "<div class='no_commentary'>Aucun commmentaire sur cette photo.</div>";
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

    if (isset($_SESSION['username']) && !empty($_SESSION['username'])) {
      $username = $_SESSION['username'];
    } else {
      $username = "";
    }

    $data .= "<div class='add_commentary'>
                <form class='form_commentary' method='POST' action=''>
                  <label for='username'>Votre Nom / Prénom / Pseudo :</label>
                  <input type='text' id='username' name='username' value='".$username."' placeholder='Dite nous qui vous êtes !' />
                  <label for='content'>Votre commentaire :</label>
                  <textarea id='content' name='content' placeholder='Taper votre commentaire ...' rows='4'></textarea>
                  <input type='submit' class='btn btn-primary' value='Envoyer' />
                </form>
              </div>";
  }

  echo $data;
?>