<?php

function setUsernameSession() {
  if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
  } else {
    $username = '';
  }

  return $username;
}
if(isset($_GET['urlPhoto']) && !empty($_GET['urlPhoto'])){
  $numPhoto = explode('_', $_GET['photoClick']);  //Stockage du num de la photo
?>
<div class="modal-body col-lg-8">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
  <div id="paginate_left"><i class="fas fa-chevron-left fa-3x"></i></div>

  <div id="divPhotoModal"><img id="photoModal" src="<?php echo $_GET['urlPhoto'] ?>"></div>

  <div  id="paginate_right"><i class="fas fa-chevron-right fa-3x"></i></div>
</div>
<div class="commentarys col-lg-4"></div>

<script>

$(function(){
  // Récupération de l'idPhoto
  var idPhoto = $('input[name=<?php echo $_GET['photoClick'] ?>]').val();
  refreshCommentary(idPhoto);

  var numPhoto = <?php echo $numPhoto[1]; ?>// index 0 : la clé de l'id (photo) - index 1 : le numéro de la photo
  
  //On alloue l'url des photo au bouton suivant précédent
  var photoPrecedente = $('#photo_'+(numPhoto-1)).attr('data-url-photo');
  var photoSuivante = $('#photo_'+(numPhoto+1)).attr('data-url-photo');

  //Vérifie si la photo existe pour afficher la touche de pagination au premier chargement
  if(photoPrecedente == undefined){
    $('#paginate_left').css('display','none');
  }
  if(photoSuivante == undefined){
    $('#paginate_right').css('display','none');
  }

//Pagination 
  $('#paginate_left, #paginate_right').click(function(){

    //On modifie la valeur de l'id en fonction de si le click est sur précédent ou suivant
    if($(this).attr('id') == 'paginate_right'){
      numPhoto++;
      idPhoto = $('input[name="photo_'+numPhoto+'"]').val();
      refreshCommentary(idPhoto);
      $('#divPhotoModal').html('<img id="photoModal" src="'+photoSuivante+'">');
    }
    else{
      numPhoto--;
      idPhoto = $('input[name="photo_'+numPhoto+'"]').val();
      refreshCommentary(idPhoto);
      $('#divPhotoModal').html('<img id="photoModal" src="'+photoPrecedente+'">');
    }

    //On modifie les url en fonction de la photo actuel
    photoPrecedente = $('#photo_'+(numPhoto-1)).attr('data-url-photo');
    photoSuivante = $('#photo_'+(numPhoto+1)).attr('data-url-photo');

    //On affiche ou non la pagination si la photo existe 
    if(photoPrecedente == undefined){
      $('#paginate_left').hide();
    }else if(photoPrecedente != undefined && !($('#paginate_left').is(':visible')) ){
      $('#paginate_left').show();
    }

    if(photoSuivante == undefined){
      $('#paginate_right').hide();
    }else if(photoSuivante != undefined && !($('#paginate_right').is(':visible')) ){
      $('#paginate_right').show();
    }

  });

  //------------ AJAX SELECTION ET AFFICHAGE DES COMMENTAIRES ----------------//

    function refreshCommentary(idPhoto){
      var request = $.ajax({
              url: "commentaire.php",
              method: "POST",
              data: {
                      id_photo : idPhoto,
                    }
          });
    
          request.done(function( data ) {
            $('.commentarys').html('');
            $('.commentarys').html(data)
            if ($('#only_commentarys').length > 0) {
              var autoScroll = document.getElementById('only_commentarys');
              autoScroll.scrollTo(0, autoScroll.scrollHeight);
              // document.getElementById('only_commentarys').scrollTop = document.getElementById('only_commentarys').scrollHeight;
            }

            <?php $username = setUsernameSession(); ?>
            $('input[name=username]').val(<?= $username ?>);

            formCommentary(idPhoto);
          });
    
          request.fail(function( jqXHR, textStatus ) {
              alert( "Request failed: " + textStatus );
          });
    }

  //------------ AJAX INSERTION ET RAFFRAICHISSEMENT DES COMMENTAIRES + GESTION "SECURITE" FORMULAIRE ----------------//
  function formCommentary(idPhoto) {
    $('.form_commentary .submit').click(function(e) {
      e.preventDefault();
      var error = 0;
      var details = '<div class="errorFormCommentary alert-danger">';

      if ($('#username').val().length === 0) {
        error = 1;
        details += 'Veuillez nous dire qui vous êtes<br/>';
      }

      if ($('#content').val().length === 0) {
        error = 1;
        details += 'Veuillez saisir un commentaire';
      }

      details += '</div>';

      if (error === 0) {
        $('#error').html('');
        var username = $('#username').val();
        var content = $('#content').val();

        var request = $.ajax({
              url: "ajout_commentaire.php",
              method: "POST",
              data: {
                      id_photo : idPhoto,
                      name : username,
                      commentary : content,
                    }
          });
    
          request.done(function( data ) {
            refreshCommentary(idPhoto);
          });
    
          request.fail(function( jqXHR, textStatus ) {
              alert( "Request failed: " + textStatus );
          });
      } else {
        $('#error').html(details);
      }
    })
  }

});
</script>

<?php } ?>