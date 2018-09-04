<?php
session_start();
if(isset($_SESSION)){
  if($_SESSION['user'] === "admin"){

    include_once'header.php';
    require_once ('../fonctions.php');

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

    } // end if(isset($_GET['section']))

   include_once'footer.php';

 } // end if($_SESSION['user'] === "admin")
 else{
   session_destroy();
   header('Location: ../../index.php');
 }
} //end if(isset($_SESSION))
else{
  session_destroy();
  header('Location: ../../index.php');
}
