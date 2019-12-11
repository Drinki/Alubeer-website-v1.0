<?php
require_once("src/model/AuthentificationManager.php");
require_once("src/model/BeerManager.php");

class Controller{
  public $view;

  public function __construct($view, $beerTab){
    $this->view = $view;
    $this->beerTab = $beerTab;

    //Manageur des utilisateurs inscriptions/connexion/deconnexion
    $this->authManager = new AuthentificationManager();

    //Builder des bières ajout/modification/suppression
    $this->beerManager = new BeerManager();
  }

  /**
  * Affiche le header (haut de page)
  */
  public function showHeader(){
    $this->view->makeHeader();
  }

  /**
  * Affiche la page de la listes des bières
  */
  public function showListPage(){
    $this->view->makeListPage($this->beerTab);
  }

  /**
  * Affiche la page de la bière voulu ($id)
  */
  public function showBeerPage($id, $access){
    if(array_key_exists($id, $this->beerTab) and $id >= 0){
      $beer = $this->beerTab[$id];
    }else{
      $beer = null;
    }

    if($this->authManager->isConnect() and $access == false and $beer != null){
      $this->view->makeNoAccessBeerPage($beer);
    }else if($this->authManager->isConnect() and $access == true and $beer != null){
      $this->view->makeAccessBeerPage($beer);
    }else if(!$this->authManager->isConnect() and $beer != null){
      $this->view->makeErrorLoginPage();
    }else{
      $this->view->makeUnknownBeerPage();
    }
  }

  /**
  * Affiche la page de connexion
  */
  public function showLoginPage($conf){
    if($conf){
      $this->view->makeLoginPage();
      if(isset($_POST['login'])){
        $this->authManager->login();
        $this->view->setContent("<p class=error>" . $this->authManager->getError() . "</p>");
      }
    }else{
      $this->view->makeUnknownBeerPage();
    }
  }

  /**
  * Affiche la page d'inscription
  */
  public function showRegisterPage($conf){

    if($conf){
      $this->view->makeRegisterPage();
      if(isset($_POST['register'])){
        $this->authManager->register();
        $this->view->setContent("<p class=error>" . $this->authManager->getError() . "</p>");
      }
    }else{
      $this->view->makeUnknownBeerPage();
    }
  }

  /**
  * Deconnexion
  */
  public function Logout(){;
    $this->authManager->logout();
  }

  /**
  * Affiche la page d'ajout de bière
  */
  public function showAddBeerPage(){
    if($this->authManager->isConnect()){
      $this->view->makeAddBeerPage();
      if(isset($_POST['add'])){
        $this->beerManager->add();
        $this->view->setContent("<p class=error>" . $this->beerManager->getError() . "</p>");
      }
    }else{
      $this->view->makeErrorLoginPage();
    }
  }

  /**
  * Suppression de la bière
  */
  public function deleteBeer($id){
    $this->beerManager->delete($id);
  }

  /**
  * Edition de la bière
  */
  public function showEditBeer($id){
    if(array_key_exists($id, $this->beerTab) and $id >= 0){
      $beer = $this->beerTab[$id];
    }else{
      $beer = null;
    }

    if($this->authManager->isConnect()){
      $this->view->makeEditBeerPage($beer);
      if(isset($_POST['edit'])){
        $this->beerManager->edit($id);
        $this->view->setContent("<p class=error>" . $this->beerManager->getError() . "</p>");
      }
    }else{
      $this->view->makeErrorLoginPage();
    }
  }

  /**
  * Affiche la page a propos
  */
  public function showAproposPage(){
    $this->view->makeAproposPage();
  }
}
?>
