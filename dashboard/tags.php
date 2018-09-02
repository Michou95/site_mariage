<h1>Tagguer des invités</h1>

<form>
  <div class="form-group">
    <label for="exampleFormControlInput1">Email address</label>
    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Selectionnez les invités à Tagguer</label>
    <select multiple class="form-control" id="select" onchange="fillText(this.value)">
      <?php
      $invites = getAllInvites();
      for ($i=0; $i < count($invites); $i++) {
        echo '<option value="'.$invites[$i]['id_invite'].'|">'.ucfirst($invites[$i]['prenom']).' '.ucfirst($invites[$i]['nom']).'</option>';
      }
      ?>
    </select>
    <?php
    $mes_photos_tag = getPhotoNotTaggued();
    var_dump($mes_photos_tag);
    die();
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
