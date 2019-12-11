<div class="container">
  <div class="collection">
    <hr class="hr_small">
    <h1>Formulaire</h1>
    <h3>inscription</h3>
    <hr class="hr_small">
  </div>
  <form method="POST">
    <table class="form">
      <!--PSEUDO-->
      <tr>
        <td>
          <input type="text" placeholder="Pseudo" name="pseudo" class="input">
        </td>
      </tr>

      <!--DATE DE NAISSANCE-->
      <tr>
        <td>
          <input type="number" name="birthdate" class="input" placeholder="Age">
        </td>
      </tr>

      <!--MAIL-->
      <tr>
        <td>
          <input type="email" placeholder="Mail" name="email" class="input">
        </td>
      </tr>

      <!--CONFIRMATION MAIL-->
      <tr>
        <td>
          <input type="email" placeholder="Confirmation mail" name="c_email" class="input">
        </td>
      </tr>

      <!--MOT DE PASSE-->
      <tr>
        <td>
          <input type="password" placeholder="Mot de passe (8 caractères min)" name="password" class="input">
        </td>
      </tr>

      <!--SUB-->
      <tr>
        <td>
          <input type="submit" class="input_sub" name="register" value="S'inscrire">
        </td>
      </tr>
    </table>
  </form>
</div>
