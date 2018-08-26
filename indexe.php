<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Notre Mariage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css"/>
  </head>
  <body>
    <!-- <audio autoplay>
      <source src="son.mp3">
    </audio> -->
    <header>
      <div class="title">
        <h1>Mickael & Jennifer</h1>
        <h2>28 Juillet 2018</h2>
      </div>
    </header>
    <form action="test.html" method="post">
      <div class="form_row">
          <label for="name">Votre nom</label>
            <input class="name" type="text" name="name" value="">
          <input class="submit" type="submit" name="submit" value="Envoyer">
      </div>
    </form>
    <a href="index.php?accubens">Photos Charline</a>
    <a href="index.php">Photos de tout le monde</a>
    <div class="container">
      <?php

        if(isset($_GET['i'])){
          $i = $_GET['i'];
        }else{
          $i = 0;
        }

        $beggin = $i;
        $end = $i+29;

        if(isset($_GET['accubens'])){
          $files = scandir("mariage/photos_mariage");
          $nb_files = count($files);

          foreach ($files as $key => $value) {
            if($key > 1){
              if($key > $beggin && $key < $end){
                $i = $key;
                echo '
                <a class="image">
                  <img src="mariage/photos_mariage/' . $value . '" alt="Photo '.$value.'">
                  <i class="fas fa-download telecharger"> Télécharger</i>
                </a>';
                }
              } //end if($key > 1)
            } //end foreach

            if($i < $nb_files){
              if($i>55){
                $i2 = $i-56;
                echo '<a class="button" href="index.php?accubens&i=' . $i2 . '">PRECEDENT</a>';
              }
              echo '<a class="button" href="index.php?accubens&i=' . $i . '">SUIVANT</a>';
            } //end if($i < $nb_files)
        }
        else{

          $files = scandir("mariage/");
          $nb_files = count($files);

          foreach ($files as $key => $value) {
            if($key > 1){
              if($key > $beggin && $key < $end){

                $i = $key;
                if($value != "photos_mariage"){
                  echo '
                  <a class="image" href="mariage/' . $value . '" download="' . $value . '">
                    <img src="mariage/' . $value . '" alt="Photo '.$value.'"/>
                    <i class="fas fa-download telecharger"> Télécharger</i>
                  </a>';
                }
                else{
                  echo '<a class="image" href="index.php?accubens&nb=1">Photo Accubens</a>';
                }
              }
            } //end if($key > 1)
          } //end foreach

          if($i < $nb_files){
            if($i>55){
              $i2 = $i-56;
              echo '<a class="button" href="index.php?i=' . $i2 . '">PRECEDENT</a>';
            }
            echo '<a class="button" href="index.php?i=' . $i . '">SUIVANT</a>';
          } //end if($i < $nb_files)
          else{
            $i = $nb_files;
            echo "<h1>Toi tu joue trop avec L'url #Mr Cessac ou #Mr Youx...</h1>";
          }

        } //end else for if(isset($_GET['accubens']))
       ?>
    </div>
    <footer>
      &copy; Mickael Régent tout droit réservé
    </footer>
  </body>
</html>
