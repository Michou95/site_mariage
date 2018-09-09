<h1>Ajouter Des Photos</h1>

<form method="post" action="treatment_add_picture.php" enctype="multipart/form-data" required>
  <div class="form-group">
    <label for="picture">Choisissez Votre Photo</label>
    <input type="file" id="picture" class="form-control-file">
  </div>
  <div class="form-group">
    <label for="category">Catégorie de la photo</label>
    <select class="form-control" name="categorie" id="category" required>
      <option value="Mairie">Mairie</option>
      <option value="vin_honneur">Vin d'honneur</option>
      <option value="salle">Salle des fêtes</option>
      <option value="photobooth">Photobooth</option>
    </select>
  </div>
  <div class="form-group">
    <label for="photographer">Qui à pris la photo ?</label>
    <select class="form-control" name="prise_par" id="photographer" required>
      <option value="invites">Invités</option>
      <option value="charline">Charline</option>
      <option value="salle">Salle des fêtes</option>
      <option value="photobooth">Photobooth</option>
    </select>
  </div>
<button type="submit" name="button" class="btn btn-primary">Ajouter</button>
</form>
