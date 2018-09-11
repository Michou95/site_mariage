<?php

if($_POST) {

    require_once ('fonctions.php');
    $connexion = getDB();

    $idPhoto = htmlSpecialChars(addslashes(strip_tags($_POST['id_photo'])));
    $username = htmlSpecialChars(addslashes(strip_tags($_POST['name'])));
    $content = htmlSpecialChars(addslashes(strip_tags($_POST['commentary'])));
    $timestamp = time();

    $sql = "INSERT INTO commentary (photo_id, username, content, timestamp) VALUES ('$idPhoto', '$username', '$content', '$timestamp')";
    $query = $connexion->prepare($sql);
    $query->execute();

    return true;
}

?>