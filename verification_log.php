<?php
session_start();
session_destroy();

if($_POST){

  $password = strip_tags(trim($_POST['password']));

  if(!empty($password)){
    if($password === "Suce ma bite 2018!"){
      session_start();
      $_SESSION['user'] = 'allowed';
      $_SESSION['realname'] = $_POST['username'];
      $_SESSION['username'] = $_POST['username'];
      $_SESSION['id_invite'] = $_POST['id_invite'];
    }
    else{
      session_start();
      $_SESSION['user'] = 'forbidden';
    }
  }

  return true;
}
?>