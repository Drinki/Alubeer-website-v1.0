<?php
session_start();

require_once("view/View.php");
require_once("view/PrivateView.php");
require_once("control/Controller.php");
require_once("model/BeerStorageStub.php");

class Router{
  /**
  * Fonction principal du site
  */
  public function main(){
    $id = $this->getIdBeer();

    //Instance de la vue
    if(isset($_SESSION['id'])){
      $view = new PrivateView($this->getUserAccount());
    }else{
      $view = new View();
    }

    //Instance de la base de données des bières
    $dbBeer = new BeerStorageStub();
    $beerTab = $dbBeer->reqBeer();

    //Liste des bières avec autorisation d'acces
    $accessBeerTab = $this->getAccessBeerUser($beerTab);

    //Instance du controlleur
    $control = new Controller($view, $beerTab);

    //Le header
    $control->showHeader();

    //Les pages
    if(array_key_exists('deletebeer', $_GET)){
      $control->deleteBeer($id);
    }else if(array_key_exists('editbeer', $_GET)){
      $control->showEditBeer($id);
    }else if(array_key_exists('id', $_GET)){
      if(in_array($id, $accessBeerTab)){
        $control->showBeerPage($id, true);
      }else{
        $control->showBeerPage($id, false);
      }
    }else if(array_key_exists('login', $_GET)){
      $control->showLoginPage(true);
    }else if(array_key_exists('register', $_GET)){
      $control->showRegisterPage(true);
    }else if(array_key_exists('logout', $_GET)){
      $control->Logout();
    }else if(array_key_exists('add', $_GET)){
      $control->showAddBeerPage();
    }else if(array_key_exists('apropos', $_GET)){
      $control->showAproposPage();
    }else{
      $control->showListPage();
    }
    $view->render();

    //Le footer

  }

  /**
  * Renvoe L'url avec l'id du produit en paramètre d'url
  */
  public function getURL($id){
    return "index.php?id=$id";
  }

  /**
  * Renvoie l'id de la bière qui est en paramètre d'URL
  */
  public function getIdBeer(){
    if(isset($_GET['id']) and $_GET['id'] != null){
      return $_GET['id'];
    }else{
      return null;
    }
  }

  /**
  * Renvoie la liste des bières dont l'utilisateur à les droits d'acces
  */
  public function getAccessBeerUser($beerTab){
    $accessBeerTab = array();
    foreach ($beerTab as $key => $value) {
      if(isset($_SESSION['id'])){
        if($value->getIdUser() == $_SESSION['id']){
          array_push($accessBeerTab, $value->getId());
        }
      }
    }
    return $accessBeerTab;
  }

  /*
  * Renvoie l'utilisateur connecté
  */
  public function getUserAccount(){
    if(isset($_SESSION['id'])){
      $dbUser = new AccountStorageStub();
      $dataUser = $dbUser->reqAccount();
      $user = null;
      foreach ($dataUser as $key => $value) {
        if($value->getId() == $_SESSION['id']){
          $user = $value;
        }
      }
    }
    return $user;
  }
}

?>
