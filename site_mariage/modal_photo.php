
<?php
  if(isset($_GET['urlPhoto']) && !empty($_GET['urlPhoto'])){
?>
<div class="modal-body">
  <div id="photoModal"><img id="photoModal" src="<?php echo $_GET['urlPhoto'] ?>"></div>
</div>

<?php } ?>