
<?php
  if(isset($_GET['urlPhoto']) && !empty($_GET['urlPhoto'])){
?>


<div class="modal-body">
  <div id="paginate_left"><i class="fas fa-chevron-left fa-3x"></i></div>

  <div id="photoModal"><img id="photoModal" src="<?php echo $_GET['urlPhoto'] ?>"></div>

  <div  id="paginate_right"><i class="fas fa-chevron-right fa-3x"></i></div>
</div>

<script>

</script>

<?php } ?>