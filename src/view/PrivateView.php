<?php
require_once("View.php");

class PrivateView extends View{
  private $title;
  private $content;
  private $header;

  public function __construct($user){
    $this->user = $user;

    $this->title = "ALUBEER";
    $this->content = "";
    $this->header = "";
  }

  public function setContent($p){
    $this->content .= $p;
  }

  /**
  * Renvoie le rendu de la page avec le content et le title
  */
  public function render(){
    require_once("squelette/squelette_base.php");
  }

  /**
  * Créer la page de la liste des produits pour les utilisateurs (page individuelles accessible)
  */
  public function makeListPage($beerTab){
    $this->title .= " | Home";
    $this->content .=
    '<div class="container">
      <div class="collection">
        <hr class="hr_small">
        <h1>Liste des bières</h1>
        <hr class="hr_small">
      </div>
      <div class="access_beer">
        <a href="index.php?add" class="add">Ajouter une bière</a>
      </div>
      <div class="list_beer">';

    foreach($beerTab as $key => $value){
      $this->content .=
      '<div class="beer '. $value->getColor() .'">
        <a href=index.php?id=' . ($key) . '>
          <img src=upload/'. $value->getId() .'.jpg alt='. $value->getId() .'>
          <div class=info_beer>
            <h1>' . $value->getName() . '</h1>
            <p class="color">' . $value->getColor() . '</p>
            <p class="price">' . $value->getPrice() . '€</p>
          </div>
        </a>
      </div>';
    }
    $this->content .= '
    <div class="access_beer">
      <a href="index.php?add" class="add">Ajouter une bière</a>
    </div>
    </div>
    </div>';
  }

  /**
  * Créer le header des pages pour les utilisateurs
  */
  public function makeHeader(){
    $this->header .=
    '<div class="navbar">
      <p class="pseudo">Bonjour '. $this->user->getPseudo() .'</p>
      <div class="dropdown">
        <button class="dropbtn"><img src="images/icon_user.svg" alt="Icon User"></button>
        <div class="dropdown-content">
          <a href="index.php?logout">Deconnexion</a>
        </div>
      </div>
      <a href="index.php?add" class="icon_add"><img src="images/icon_add.svg" alt="Icon Add"></a>
      <a href="index.php" class="icon_add"><img src="images/icon_home.svg" alt="Icon Home"></a>
    </div>

    <div class="logo">
      <a href="index.php"><img src="images/logo.svg" alt="Logo"></a>
    </div>';
  }

  /**
  * Créer la page d'une bière en particulié (modifiable)
  */
  public function makeAccessBeerPage($beer){
    $this->title .= " | " . $beer->getName();
    $this->content .= '<div class="container">
      <div class="display_info">
        <div class="display_image '. $beer->getColor() .'_m">
          <img src="upload/'. $beer->getId() .'.jpg" class="beer_image" alt='. $beer->getId() .'>
        </div>

        <table>
          <tr class="first_step">
            <td>
              <h1 class="beer_name">'. $beer->getName() . '</h1>
              <p class="beer_color">'. $beer->getColor() .'</p>
            </td>
          </tr>

          <tr>
            <td><p class="beer_alcohol">Taux d\'alcool : '. $beer->getAlcohol() . '%</p></td>
          </tr>

          <tr>
            <td><h3 class="beer_price">'. $beer->getPrice() . '€</h3></td>
          </tr>

          <tr>
            <td><p class="beer_flavor">'. $beer->getFlavor() . '</p><td>
          </tr>

          <tr>
            <td><p class="beer_temp">Température de déguistation : '. $beer->getTemp() . '°C</p></td>
          </tr>

          <tr>
            <td><p class="beer_description">'. $beer->getDesc() . '</td>
          </tr>
        </table>
      </div>

      <div class="access_beer">
        <a href="index.php?id=' . $beer->getId() . '&editbeer" class="edit">Editer</a>
        <a href="index.php?id=' . $beer->getId() . '&deletebeer" class="trash">Supprimer</a>
      </div>
    </div>';
  }

  /**
  * Créer la page d'une bière en particulié (non-modifiable)
  */
  public function makeNoAccessBeerPage($beer){
    $this->title .= " | " . $beer->getName();
    $this->content .= '<div class="container">
      <div class="display_info">
        <div class="display_image '. $beer->getColor() .'_m">
          <img src="upload'. $beer->getId() .'.jpg" class="beer_image" alt='. $beer->getId() .'>
        </div>

        <table>
          <tr class="first_step">
            <td>
              <h1 class="beer_name">'. $beer->getName() . '</h1>
              <p class="beer_color">'. $beer->getColor() .'</p>
            </td>
          </tr>

          <tr>
            <td><p class="beer_alcohol">Taux d\'alcool : '. $beer->getAlcohol() . '%</p></td>
          </tr>

          <tr>
            <td><h3 class="beer_price">'. $beer->getPrice() . '€</h3></td>
          </tr>

          <tr>
            <td><p class="beer_flavor">'. $beer->getFlavor() . '</p><td>
          </tr>

          <tr>
            <td><p class="beer_temp">Température de déguistation : '. $beer->getTemp() . '°C</p></td>
          </tr>

          <tr>
            <td><p class="beer_description">'. $beer->getDesc() . '</td>
          </tr>
        </table>
      </div>
    </div>';
  }

  /**
  * Créer la page d'ajout de bière pour les authentifié
  */
  public function makeAddBeerPage(){
    $this->title .= " | Ajout d'une bière";
    $this->content = file_get_contents("src/view/squelette/squelette_addBeer.php");
  }

  /**
  * Créer la page de modification d'une bière
  */
  public function makeEditBeerPage($beer){
    $this->title .= " | Edition de la bière";
    $this->content .=
    '<div class="container">
      <div class="collection">
        <hr class="hr_small">
        <h1>Edition de la bière</h1>
        <hr class="hr_small">
      </div>
      <form method="POST" enctype="multipart/form-data">
        <table class="form">

          <!--Nom-->
          <tr>
            <td>
              <input type="text" placeholder="Nom" name="name"  class="input" value="'. $beer->getName() .'">
            </td>
          </tr>

          <!--Couleur-->
          <tr>
            <td>
              <select name="color" class="input">
                <option value ="'. $beer->getColor() .'" selected>'. $beer->getColor() .'</option>
                <option value="Blonde">Blonde</option>
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
              <input type="number" placeholder="Taux d\'aclool" step="0.1" name="alcohol" class="input" value="'. $beer->getAlcohol() .'">
            </td>
          </tr>

          <!--Saveur-->
          <tr>
            <td>
              <input type="text" placeholder="Saveur" name="flavor" class="input" value="'. $beer->getFlavor() .'">
            </td>
          </tr>

          <!--Température-->
          <tr>
            <td>
              <input type="number" placeholder="Température de dégustation" name="temp" class="input" value="'. $beer->getTemp() .'">
            </td>
          </tr>

          <!--Prix-->
          <tr>
            <td>
              <input type="textarea" placeholder="Prix" step="0.01" name="price" class="input" value="'. $beer->getPrice() .'">
            </td>
          </tr>

          <!--Description-->
          <tr>
            <td>
              <textarea placeholder="Description..." name="description" rows="5" cols="33">'. $beer->getDesc() .'</textarea>
            </td>
          </tr>

          <!--Image-->
          <tr>
            <td>
              <p class="info_upload_image">Il est conseillé d\'utiliser une image de dimension 290x470px</p>
              <input type="file" name="editImageBeer">
            </td>
          </tr>


          <!--AJOUTER-->
          <tr>
            <td>
              <input type="submit" name="edit" value="Modifier" class="input_sub">
            </td>
          </tr>
        </table>
      </form>
    </div>';
  }

  /**
  * Créer une page d'erreur si une bière n'existe pas
  */
  public function makeUnknownBeerPage(){
    $this->title .= " | Erreur!";
    $this->content = file_get_contents("src/view/squelette/squelette_unknownBeer.php");
  }

  /**
  * Créer la page à propos
  */
  public function makeAproposPage(){
    $this->title .= " | A propos";
    $this->content = file_get_contents("src/view/squelette/squelette_apropos.php");
  }
}
?>
