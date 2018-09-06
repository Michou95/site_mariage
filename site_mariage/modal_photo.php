
<?php
  if(isset($_GET['urlPhoto']) && !empty($_GET['urlPhoto'])){
?>


<div class="modal-body">
  <div id="paginate_left"><i class="fas fa-chevron-left fa-3x"></i></div>

  <div style="transition: all 0.5s ease;" id="divPhotoModal"><img id="photoModal" src="<?php echo $_GET['urlPhoto'] ?>"></div>

  <div  id="paginate_right"><i class="fas fa-chevron-right fa-3x"></i></div>
</div>

<script>
$(function(){
  var photoSuivante = $('#photo_2').attr('data-url-photo');
  var photoPrecedente = $('#photo_0').attr('data-url-photo');
  
  if(photoPrecedente == undefined){
    $('#paginate_left').css('display','none');
  }
  if(photoSuivante == undefined){
    $('#paginate_right').css('display','none');
  }

  console.log(photoSuivante);

//Pagination précédent
  $('#paginate_left').click(function(){
    if(photoPrecedente.length > 0){
      $('#divPhotoModal').html('<img id="photoModal" src="'+photoPrecedente+'">');
    }
  });

//Pagination suivant
  $('#paginate_right').click(function(){
    console.log(photoSuivante.length);
    if(photoSuivante.length > 0){
      $('#divPhotoModal').html('<img id="photoModal" src="'+photoSuivante+'">');
    }
  });

});
</script>

<?php } ?>