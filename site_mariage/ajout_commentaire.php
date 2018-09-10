<?php

if($_POST) {

    require_once ('fonctions.php');
    $connexion = getDB();

    $idPhoto = htmlSpecialChars(strip_tags($_POST['id_photo']));
    $username = htmlSpecialChars(strip_tags($_POST['name']));
    $content = htmlSpecialChars(strip_tags($_POST['commentary']));
    $timestamp = time();

    $sql = "INSERT INTO commentary (photo_id, username, content, timestamp) VALUES ('$idPhoto', '$username', '$content', '$timestamp')";
    $query = $connexion->prepare($sql);
    $query->execute();

    echo $username;
}

?>