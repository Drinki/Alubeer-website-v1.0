<div class="container">
  <div class="collection">
    <hr class="hr_small">
    <h1>Formulaire</h1>
    <h3>Ajout d'une bière</h3>
    <hr class="hr_small">
  </div>
  <form method="POST" enctype="multipart/form-data">
    <table class="form">

      <!--Nom-->
      <tr>
        <td>
          <input type="text" placeholder="Nom" name="name" class="input">
        </td>
      </tr>

      <!--Couleur-->
      <tr>
        <td>
          <select name="color" class="input">
            <option value="Blonde" selected>Blonde</option>
            <option value="Brune">Brune</option>
            <option value="Blanche">Blanche</option>
            <option value="Noir">Noir</option>
            <option value="Ambre">Ambree</option>
            <option value="Rouge">Rouge</option>
          </select>
        </td>
      </tr>

      <!--Alcool-->
      <tr>
        <td>
          <input placeholder="Taux d'alcool" type="number" step="0.1" name="alcohol" class="input">
        </td>
      </tr>

      <!--Saveur-->
      <tr>
        <td>
          <input type="text" placeholder="Saveur" name="flavor" class="input">
        </td>
      </tr>

      <!--Température-->
      <tr>
        <td>
          <input type="number" placeholder="Température de dégustation" name="temp" class="input">
        </td>
      </tr>

      <!--Prix-->
      <tr>
        <td>
          <input type="text" step="0.01" placeholder="Prix" name="price" class="input">
        </td>
      </tr>

      <!--Description-->
      <tr>
        <td>
          <textarea placeholder="Description..." name="description" rows="5" cols="33"></textarea>
        </td>
      </tr>

      <!--Image-->
      <tr>
        <td>
          <p class="info_upload_image">Il est conseillé d'utiliser une image de dimension 290x470px</p>
          <input type="file" name="imageBeer">
        </td>
      </tr>


      <!--AJOUTER-->
      <tr>
        <td>
          <input type="submit" name="add" value="Ajouter" class="input_sub">
        </td>
      </tr>
    </table>
  </form>
</div>
