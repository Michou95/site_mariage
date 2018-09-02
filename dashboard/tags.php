<h1>Tagguer des invités</h1>

<form>
  <div class="form-group">
    <label for="exampleFormControlInput1">Email address</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Example select</label>
    <select multiple class="form-control" id="select" onchange="fillText(this.value)">
      <option value="none">--------------------</option>
      <?php
      $invites = getAllInvites();
      for ($i=0; $i < count($invites); $i++) {
        echo '<option value="'.$invites[$i]['id_invite'].'|">'.$invites[$i]['prenom'].' '.$invites[$i]['nom'].'</option>';
      }
      ?>
    </select>
    <?php
    // $mes_photos_tag = getPhotoTaggued();
    // $photo = getAllIdPhotos();
    // var_dump($mes_photos_tag);
    // var_dump($photo);
    // die();
    // for ($i=0; $i < count($mes_photos_tag) ; $i++) {
    //   if($mes_photos_tag[$i]['id_photo'] != $photo[$i]['id_photo']){
    //     $photo_not_tag[] =
    //   }
    // }
    ?>
  </div>
  <div class="form-group">
    <label for="exampleFormControlTextarea1">id des invités à tagguer</label>
    <textarea class="form-control" id="textarea" rows="3"></textarea>
  </div>
</form>
<script type="text/javascript">

  function fillText(value){
    var value = $('#select').val();
    var textarea = $('#textarea').val();
    var value2 = textarea + value;
    $('#textarea').val(value2);
  }

</script>
