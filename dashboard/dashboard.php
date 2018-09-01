<?php include_once'header.php';

if(isset($_GET['section'])){
  if($_GET['section'] == 'tags'){ ?>
    <div class="container">
      <?php include_once'tags.php'; ?>
    </div>
<?php
  }

  if($_GET['section'] == 'add'){ ?>
    <div class="container">
      <?php include_once'add_picture.php'; ?>
    </div>
<?php
  }
}


?>



<?php include_once'footer.php'; ?>
