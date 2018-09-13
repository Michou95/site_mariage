<?php
session_start();
session_destroy();

if(isset($_POST['password'])){

  $password = strip_tags(trim($_POST['password']));

  if(!empty($password)){
    if($password === "Suce ma bite 2018!"){
      session_start();
      $_SESSION['user'] = 'allowed';

      header('Location: site_mariage/home.php');
    }
    else{
      session_start();
      $_SESSION['user'] = 'forbidden';
      header('Location: index.php?password=false');
    }
  }
  else{
    header('Location: index.php?password=false');
  }

}
?>