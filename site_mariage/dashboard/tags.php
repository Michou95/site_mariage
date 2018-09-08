<?php
//----- Récupération des photos non taguées -----//
$not_tagged = getPhotoNotTaggued();

//----- Comptage des photos non taguées -----//
$nb_not_tagged = count($not_tagged);
if(isset($_GET['tag']) && $_GET['tag'] == "success"){
  echo '<div class="col-md-12 alert alert-success text-center">Photo Taguée avec Succès</div>';
} ?>
<h1>Tagguer des invités</h1>
<?php if($nb_not_tagged > 0){ ?>
<h2>Vous avez <?php echo $nb_not_tagged; ?> photos non taguées</h2>
<?php


//----- Récupération de la première photos du lot non taguée -----//
$photo_tag = array();
for ($i=0; $i < 1 ; $i++) {
  foreach ($not_tagged[$i] as $key => $value) {

    if($key == "id_photo"){
      $photo_tag['id_photo'] = $value;
    }
    if($key == "url"){
      $photo_tag['url'] = $value;
    }

  }
}

} //end if($nb_not_tagged > 0)

 //----- Definition de l'url et de l'id de la photo à taguer -----//
$url_photo = $photo_tag['url'];
$id_photo = $photo_tag['id_photo'];
if($nb_not_tagged > 0){
 ?>
   <div class="col-md-12">
     <div class="col-md-12">
       <img src="../<?php echo $url_photo ?>" alt="Photo à taguer" style="width: 500px; height: 400px;">
     </div>
     <div class="col-md-5">
       <h6>Photo à Taguer: <?php echo $url_photo ?></h6>
       <div id="affichage_id" class="text-center alert alert-info" style="min-height: 50px; border-radius: 5px;">Aucun invité tagué</div>
     </div>
   </div>
<form method="post" action="treatment_tag_form.php">
  <div class="form-group">
    <input type="hidden" name="id_photo" class="form-control" value="<?php echo $id_photo ?>">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Selectionnez les invités à Tagguer</label>
    <select multiple class="form-control" id="select" onchange="fillText(this.value)" style="height: 300px;">
      <?php
      $invites = getAllInvites();
      for ($i=0; $i < count($invites); $i++) {
        echo '<option value="'.$invites[$i]['id_invite'].'|">'.$invites[$i]['id_invite'].' - '.ucfirst($invites[$i]['prenom']).' '.ucfirst($invites[$i]['nom']).'</option>';
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <input type="hidden" name="id_invites" id="textarea" value="">
    <!--<label for="textarea">id des invités à tagguer</label>-->
    <!--<textarea class="form-control" id="textarea" name="id_invites" rows="3"></textarea>-->
  </div>
  <div class="form-group col-md-12">
    <button type="button" onclick="undoText()" class="btn btn-warning col-md-3">Annuler dernier tag</button>
    <button type="submit" name="submit" class="form-control btn btn-primary col-md-3">Valider & Enregistrer</button>
    <a href="treatment_tag_form.php?ignore=true&id=<?php echo $id_photo; ?>" type="button" class="btn btn-danger col-md-3">Ignorer Cette Photo</a>
  </div>
</form>

<script type="text/javascript">

  function fillText(value){
    var value = $('#select').val();
    var textarea = $('#textarea').val();
    var value2 = textarea + value;
    $('#textarea').val(value2);
    value = value2.replace(/\|/g, " - ");
    $('#affichage_id').html(value);
  }

  function undoText(){
    var textarea = $('#textarea').val();
    var length = $('#textarea').val().split("|");
    length.splice(length.length-2 ,1);
    var string = length.toString();
    var value = string.replace(/\,/g, "|");
    $('#textarea').val(value);
    value2 = value.replace(/\|/g, " - ");
    $('#affichage_id').html(value2);
  }

</script>
<?php
}
else{ ?>
  <div class="col-md-12">
    <div class="alert alert-success">
      <h1>Toutes les photos sont taguées</h1>
    </div>
  </div>
<?php
}
?>
