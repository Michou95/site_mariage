<?php 
require_once ('fonctions.php');
$array_accent = array(' ','@','À','Á','Â','Ã','Ä','Å','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ò','Ó','Ô','Õ','Ö','Ù','Ú','Û','Ü','Ý','à','á','â','ã','ä','å','ç','è','é','ê','ë','ì','í','î','ï','ð','ò','ó','ô','õ','ö','ù','ú','û','ü','ý','ÿ');
$array_replace = array('','a','A','A','A','A','A','A','C','E','E','E','E','I','I','I','I','O','O','O','O','O','U','U','U','U','Y','a','a','a','a','a','a','c','e','e','e','e','i','i','i','i','o','o','o','o','o','o','u','u','u','u','y','y');

$saisie = strip_tags(trim($_POST['saisie']));
//$saisie = str_replace(' ','',$saisie);
$saisie = str_replace($array_accent,$array_replace,$saisie);

//--------------------------------//
// Recupere l'id du user concerné //
//--------------------------------//
function getIdInviteBySearch(string $saisie):array{
  $connexion = getDB();
  if(isset($saisie) && !empty($saisie)){
    $sql = "SELECT * FROM invites WHERE (prenom LIKE '".$saisie."%' OR nom LIKE '".$saisie."%' OR CONCAT(prenom,nom) LIKE '".$saisie."%');";
    $query = $connexion->prepare($sql);
    $query->execute(array($saisie));
    $resultat = $query->fetchAll(PDO::FETCH_ASSOC);
    return $resultat;
  }
  else{
    $error[] = "Erreur: Aucun résultat pour cette saisie";
    return $error;
  }
}

echo json_encode(getIdInviteBySearch($saisie));