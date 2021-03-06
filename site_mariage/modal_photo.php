<?php
session_start();
if ($_POST) {
  if ($_POST['action'] == 'setUsername') {
    if ($_SESSION['username'] == $_POST['username']) {
      $username = $_SESSION['username'];
    } else {
      $_SESSION['username'] = $_POST['username'];
      $username = $_SESSION['username'];
    }
    echo $username;
  }
}
if(isset($_GET['urlPhoto']) && !empty($_GET['urlPhoto'])){
  $numPhoto = explode('_', $_GET['photoClick']);  //Stockage du num de la photo

?>
<div class="modal-body col-lg-8">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">X</button>
  <div id="paginate_left"><i class="fas fa-chevron-left fa-3x"></i></div>

  <div id="divPhotoModal"><img id="photoModal" src="<?php echo $_GET['urlPhoto'] ?>"></div>

  <div  id="paginate_right"><i class="fas fa-chevron-right fa-3x"></i></div>
  <div id="charline"><a href="https://www.charlinevideau.com/" target="_blank">Photo par Charline Videau - Photographe</a></div>

</div>
<div class="commentarys col-lg-4"></div>

<script>
$(function(){

  // Récupération de l'idPhoto
  var idPhoto = $('input[name=<?php echo $_GET['photoClick'] ?>]').val();
  var url_photo = '<?php echo $_GET['urlPhoto'] ?>';
  refreshCommentary(idPhoto);
  var numPhoto = <?php echo $numPhoto[1]; ?>// index 0 : la clé de l'id (photo) - index 1 : le numéro de la photo
  //On alloue l'url des photo au bouton suivant précédent
  var photoPrecedente = $('#photo_'+(numPhoto-1)).attr('data-url-photo');
  var photoSuivante = $('#photo_'+(numPhoto+1)).attr('data-url-photo');
  var charline = $('#photo_'+(numPhoto)).attr('data-photo-charline');

  //Vérifie si la photo existe pour afficher la touche de pagination au premier chargement
  if(photoPrecedente == undefined){
    $('#paginate_left').css('display','none');
  }
  if(photoSuivante == undefined){
    $('#paginate_right').css('display','none');
  }

  // Ajoute un lien vers le site de Accubens... PUTAIN c'est vraiment pour être fair play !
  if(charline == "false"){
    $('#charline').css('display', 'none');
  }
  else{
    $('#charline').css('display', 'block');
  }

//Pagination
  $('#paginate_left, #paginate_right').click(function(){
    //On modifie la valeur de l'id en fonction de si le click est sur précédent ou suivant
    if($(this).attr('id') == 'paginate_right'){
      numPhoto++;
      idPhoto = $('input[name="photo_'+numPhoto+'"]').val();
      refreshCommentary(idPhoto);
      $('#divPhotoModal').html('<img id="photoModal" src="'+photoSuivante+'">');
      charline = $('#photo_'+(numPhoto)).attr('data-photo-charline');
    }
    else{
      numPhoto--;
      idPhoto = $('input[name="photo_'+numPhoto+'"]').val();
      refreshCommentary(idPhoto);
      $('#divPhotoModal').html('<img id="photoModal" src="'+photoPrecedente+'">');
      charline = $('#photo_'+(numPhoto)).attr('data-photo-charline');
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

    // Ajoute un lien vers le site de Accubens... PUTAIN c'est vraiment pour être fair play !
    if(charline == "false"){
      $('#charline').css('display', 'none');
    }
    else{
      $('#charline').css('display', 'block');
    }

  });
  //------------ AJAX SELECTION ET AFFICHAGE DES COMMENTAIRES ----------------//
    function refreshCommentary(idPhoto, usernameExist = ''){
      if (usernameExist.length == 0) {
          usernameExist = $('input[name=userName]').val();
      }

      var request = $.ajax({
              url: "commentaire.php",
              method: "POST",
              dataType : "json",
              data: {
                      id_photo : idPhoto,
                      url_photo : url_photo,
                    }
          });
          request.done(function( data ) {
            $('.commentarys').html('');
            $('.commentarys').html(data.content)

            if ($('#only_commentarys').length > 0) {
              document.getElementById('only_commentarys').scrollTo(0, document.getElementById('only_commentarys').scrollHeight);

              if (data.nbCom >= 4) {
                $('#goToBottom').css('display', 'block');
              }

              $('#only_commentarys').scroll(function () {
                if ((this.scrollTop + this.clientHeight - this.scrollHeight) == 0) {
                  $('#goToBottom').css('display', 'none');
                } else {
                  $('#goToBottom').css('display', 'block');
                }
              })

            } else {
              $('#goToBottom').css('display', 'none');
            }

            eventListenerModal(); //reboot des event sur les bouton de la modal
            var request = $.ajax({
              url: "modal_photo.php",
              method: "POST",
              data: {
                      action : 'setUsername',
                      username : usernameExist
                    }
            });
            request.done(function( data ) {
              $('#username').val(data);
              $('input[name=userName]').val('');
              $('input[name=userName]').val(data);
              formCommentary(idPhoto);
            })
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
          request.done(function() {
            refreshCommentary(idPhoto, username);
          });
          request.fail(function( jqXHR, textStatus ) {
              alert( "Request failed: " + textStatus );
          });
      } else {
        $('#error').html(details);
      }
    })
  }
  //---------------- ECOUTEUR D'EVENEMENT SUR LES BOUTONS DE LA MODAL ---------//
  function eventListenerModal(){
    if (window.matchMedia("(min-width: 420px)").matches) {
      $('.btn-custom-modal').mouseenter(function(){
        if($(this).hasClass('btn-like'))
            $(this).next().show("fast");

        if($(this).hasClass('btn-download'))
            $(this).prev().show("fast");
      });

      $('.btn-custom-modal').mouseleave(function(){

        if($(this).hasClass('btn-like'))
            $(this).next().hide();

        if($(this).hasClass('btn-download'))
            $(this).prev().hide();
      });
    }    

    stateLikeModal('PAS NULL');

    $('.like-modal').click(function(){
      likePhotoModal($(this));
    });
    $('#goToBottom').click(function () {
      $('#only_commentarys').animate( { scrollTop: document.getElementById('only_commentarys').scrollHeight }, 'speed' )
    })
  }
  // ----------------- FONCTION POUR AJOUTER UN LIKE A LA PHOTO ----------------//
   function likePhotoModal(element){
        //----- Recuperation valeur dans data-id-photo
        var id_photo = $(element).attr('data-id-photo');

        var request = $.ajax({
            url: "vote_photo.php",
            method: "POST",
            data: {
                    id_photo : id_photo,
                  }
        });

        request.done(function( data ) {
                  if (data == 'true') {
                    $(element).data('state-like', 'dislike');
                    stateLikeModal();
                  } else {
                    $(element).data('state-like', 'like');
                    stateLikeModal();
                  }
                });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });
    }

  //------------ MISE A JOUR DU STATUS DU LIKE SUR LES PHOTOS -----------------//
  function stateLikeModal(stateLike = 'NULL') {
    var self = $('.like-modal');
    var idPhotoModal = $('.like-modal').data('id-photo');
    // si on modifie l'état du like depuis la modal
    if (stateLike == 'NULL') {
      // depuis la modal on modifie l'etat de la miniature
      var countLike = $('.like-mini');
      for (var i = 0; i < countLike.length; i++) {
          var idPhoto = $(countLike[i]).data('id-photo');
          // si les 2 idPhoto correspondent on est sur la bonne miniature
          if (idPhotoModal == idPhoto) {
            // On récupère l'état du like modal
            var like = $('.like-modal').data('state-like');
            // on l'applique sur la miniature
            if (like == "like") {
                $(countLike[i]).removeClass('dislike');
                $(countLike[i]).addClass('addToLike');
            } else {
                $(countLike[i]).removeClass('addToLike');
                $(countLike[i]).addClass('dislike');
            }
          }
      }
      var like = $('.like-modal').data('state-like');
      if (like == "like") {
          self.removeClass('dislike');
          self.addClass('addToLike');
      } else {
          self.removeClass('addToLike');
          self.addClass('dislike');
      }
    } else { // Si on vient d'arriver sur la modal

      var idPhotoModal = $('.like-modal').data('id-photo');
      // depuis la modal on cherche l'etat de la miniature
      var countLike = $('.like-mini');
      for (var i = 0; i < countLike.length; i++) {
          var idPhoto = $(countLike[i]).data('id-photo');
          // si les 2 idPhoto correspondent on est sur la bonne miniature
          if (idPhotoModal == idPhoto) {
            // On récupère l'état du like miniature
            var like = $(countLike[i]).data('state-like');
            // on l'applique sur la modal
            if (like == "like") {
                $('.like-modal').removeClass('dislike');
                $('.like-modal').addClass('addToLike');
            } else {
                $('.like-modal').removeClass('addToLike');
                $('.like-modal').addClass('dislike');
            }
          }
      }
    }
  }
});
</script>

<?php } ?>
