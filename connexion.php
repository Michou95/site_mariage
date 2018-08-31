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
