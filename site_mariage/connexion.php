<?php

class Connexion{

  private $white_list;

  //-----------------------------------------------------------//
  // Déclaration de l'array() contenant les ip de la whitelist //
  //-----------------------------------------------------------//
  public function __construct(){
    $this->white_list = array(
      "::1"
    );
  } //end function __construct()


  //---------------------------------------------------------//
  // Récupération de l'ip de la machine qui demande une page //
  //---------------------------------------------------------//
  public function getIp():string{
    $ip = $_SERVER['REMOTE_ADDR'];

    return $ip;
  } //end function getIp()

  //---------------------------------------//
  // Incrémentation du compteur de visites //
  //---------------------------------------//
  function addCountVisites($ip){

    $connexion = getDB();
    $sql = "SELECT * FROM visites;";
    $query = $connexion->query($sql);
    $resultat = $query->fetchAll(PDO::FETCH_ASSOC);

    if(count($resultat) > 0){
      //----------------------------------------------------------------------------------------//
      // Récupération de la date du jour et de l'heure précédente par rapport àl'heure actuelle //
      //----------------------------------------------------------------------------------------//
      $day_today = date('d');
      $month_actually = date('m');
      $year_actually = date('Y');
      $last_hour = date('G', strtotime('-1 hour'));


      //----------------------------------------------------------------//
      // Récupération de la date et de l'heure de la derniere connexion //
      //----------------------------------------------------------------//
      $date_complete = explode(" ", $resultat[0]['date_et_heure']);
      $date_day = explode("-", $date_complete[0]);
      $year = $date_day[0];
      $day = $date_day[2];
      $month = $date_day[1];
      $date_hour = explode(":", $date_complete[1]);
      $hour = $date_hour[0];


      //-----------------------------------------------//
      // Attention L'algo de ouf qui fait mal au crane //
      // En gros ca enregistre une nouvelle visite si  //
      // la derniere à eu lieu il y a plus d'une heure //
      // (avec la meme ip sinon ca enregistre direct   //
      // une nouvelle visite)                          //
      //-----------------------------------------------//
      if($resultat[0]['ip'] == $ip){
        if($year == $year_actually){
          if($month == $month_actually){
            if($day == $day_today){
              if($hour < $last_hour){


                $compteur = $resultat[0]['compteur'];
                $compteur = $compteur + 1;
                $sql = "UPDATE visites SET ip = '" . $ip . "', compteur = '" . $compteur . "' WHERE id_nb_visites = 1;";
                $query = $connexion->query($sql);

              }
            }
            if($day < $day_today){

              $compteur = $resultat[0]['compteur'];
              $compteur = $compteur + 1;
              $sql = "UPDATE visites SET ip = '" . $ip . "', compteur = '" . $compteur . "' WHERE id_nb_visites = 1;";
              $query = $connexion->query($sql);

            }
          }
          if($month < $month_actually){

            $compteur = $resultat[0]['compteur'];
            $compteur = $compteur + 1;
            $sql = "UPDATE visites SET ip = '" . $ip . "', compteur = '" . $compteur . "' WHERE id_nb_visites = 1;";
            $query = $connexion->query($sql);

          }
        }
        if($year < $year_actually){

          $compteur = $resultat[0]['compteur'];
          $compteur = $compteur + 1;
          $sql = "UPDATE visites SET ip = '" . $ip . "', compteur = '" . $compteur . "' WHERE id_nb_visites = 1;";
          $query = $connexion->query($sql);

        }
      }
      else{

        $compteur = $resultat[0]['compteur'];
        $compteur = $compteur + 1;
        $sql = "UPDATE visites SET ip = '" . $ip . "', compteur = '" . $compteur . "' WHERE id_nb_visites = 1;";
        $query = $connexion->query($sql);

      }
    }
    else{
      $sql = "INSERT INTO visites (ip, compteur) VALUES ('" . $ip . "', 1);";
      $query = $connexion->query($sql);
    }

  } //end function addCountVisites()



  //---------------------------------------------//
  // Confirme si l'ip fait parti de la whitelist //
  //---------------------------------------------//
  public function isAllowedIp($ip):bool{
    //----- Déclaration array() de checkage -----//
    $allowed_ip = array();

    //----- On parcour le tableau contenant les ip whitelistées -----//
    foreach ($this->white_list as $key => $value) {
      if($ip === $value){
        $allowed_ip[] = "check";
      }
    } //end foreach


    if(!empty($allowed_ip)){
      return true;
    }
    else{
      return false;
    }

  } //end fucntion isAllowedIp()


} //end class
