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
      $date_today = date('Y-m-d');
      $last_hour = date('G:i:s', strtotime('-1 hour'));


      //----------------------------------------------------------------//
      // Récupération de la date et de l'heure de la derniere connexion //
      //----------------------------------------------------------------//
      $date_complete = explode(" ", $resultat[0]['date_et_heure']);

      if($resultat[0]['ip'] == $ip){

        if($date_complete[0] >= $date_today && $date_complete[1] > $last_hour){

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
