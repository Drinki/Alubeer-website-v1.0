<?php

class View{
  private $title;
  private $content;
  private $header;

  public function __construct(){
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
  * Créer la page de la liste des produits pour les non-utilisateurs (page individuelles pas accessible)
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
      <div class="list_beer">';

    foreach($beerTab as $key => $value){
      $this->content .=
      '<div class="beer '. $value->getColor() .'">
        <img src=upload/'. $value->getId() .'.jpg alt='. $value->getId() .'>
        <div class=info_beer>
          <p class=unuser_link><a href=index.php?login>Connectez-vous</a>
          ou <a href=index.php?register>Inscrivez-vous</a><br /> pour voir les
          produits
          </p>
        </div>
      </div>';
    }
    $this->content .= '</div></div>';
  }

  /**
  * Créer le header des pages pour les non-utilisateurs
  */
  public function makeHeader(){
    $this->header .= file_get_contents("src/view/squelette/squelette_header.php");
  }

  /**
  * Créer une page d'erreur si une bière n'existe pas
  */
  public function makeUnknownBeerPage(){
    $this->title .= " | Erreur!";
    $this->content = file_get_contents("src/view/squelette/squelette_unknownBeer.php");
  }

  /**
  * Créer une page si vous êtes pas connecté sur une page où cela doit être le cas
  */
  public function makeErrorLoginPage(){
    $this->title .= " | Erreur connexion!";
    $this->content .= file_get_contents("src/view/squelette/squelette_errorLogin.php");
  }

  /**
  * Créer la page de connexion des utilisateurs
  */
  public function makeLoginPage(){
    $this->title .= " | Connexion";
    $this->content = file_get_contents("src/view/squelette/squelette_login.php");
  }

  /**
  * Créer la page de d'inscription pour les utilisateurs
  */
  public function makeRegisterPage(){
    $this->title .= " | Inscription";
    $this->content = file_get_contents("src/view/squelette/squelette_register.php");
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
