<h1>Ajouter Des Photos</h1>

<form action="treatment_add_picture.php" required>
  <div class="form-group">
    <label for="exampleFormControlFile1">Choisissez Votre Photo</label>
    <input type="file" class="form-control-file" id="exampleFormControlFile1">
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Catégorie de la photo</label>
    <select class="form-control" required>
      <option value="Mairie">Mairie</option>
      <option value="vin_honneur">Vin d'honneur</option>
      <option value="salle">Salle des fêtes</option>
      <option value="photobooth">Photobooth</option>
    </select>
  </div>
  <div class="form-group">
    <label for="exampleFormControlSelect1">Qui à pris la photo ?</label>
    <select class="form-control" required>
      <option value="invites">Invités</option>
      <option value="charline">Charline</option>
      <option value="salle">Salle des fêtes</option>
      <option value="photobooth">Photobooth</option>
    </select>
  </div>

</form>
