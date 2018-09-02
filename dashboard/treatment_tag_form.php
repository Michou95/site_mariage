<?php
require_once ('../fonctions.php');

if(isset($_GET['ignore'])){
  if(!empty($_GET['ignore']) && $_GET['ignore'] == "true"){
    if(isset($_GET['id']) && !empty($_GET['id'])){
      $id_photo = strip_tags(trim($_GET['id']));
      setPhotoToTagged($id_photo);
      header('Location: dashboard.php?section=tags');
      die();
    }
    else{
      header('Location: dashboard.php?section=tags');
    }
  }
  else{
    header('Location: dashboard.php?section=tags');
  }
}
elseif(isset($_POST)){
  if(isset($_POST['id_invites']) && isset($_POST['id_photo'])){
    if(!empty($_POST['id_invites']) && !empty($_POST['id_photo'])){

      $id_invites = strip_tags(trim($_POST['id_invites']));
      $id_photo = strip_tags(trim($_POST['id_photo']));

      $id_invites = explode("|", $id_invites);
      foreach ($id_invites as $key => $value) {
        if($value != ""){
          addTag($value, $id_photo);
        }
      }

      setPhotoToTagged($id_photo);
      header('Location: dashboard.php?section=tags&tag=success');

    }
    else{
      header('Location: dashboard.php?section=tags');
    }
  }
  else{
    header('Location: dashboard.php?section=tags');
  }
}
else{
  header('Location: dashboard.php?section=tags');
}

 ?>
