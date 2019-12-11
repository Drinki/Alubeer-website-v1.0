<?php
require_once("DBConfig.php");
require_once("AccountStorageStub.php");

class AuthentificationManager{
  private $error;

  public function __construct(){
    $config = new DBConfig();
    $this->bd = $config->getDB();
    $this->error = "";
    $this->accountStorage = new AccountStorageStub();
  }

  /**
  * Renvoie le message d'erreur
  */
  public function getError(){
    return $this->error;
  }

  /**
  * Renvoie l'age avec une date
  */
  public function getAge($date){
    return (int) ((time() - strtotime($date)) / 3600 / 24 / 365);
  }

 /**
 * Inscription
 */
  public function register(){
    if(isset($_POST['register'])){
      $pseudo = htmlspecialchars($_POST['pseudo']);
      $age = htmlspecialchars($_POST['birthdate']);
      $email = htmlspecialchars($_POST['email']);
      $c_email = htmlspecialchars($_POST['c_email']);
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

      if(!empty($pseudo) && !empty($age) && !empty($email) && !empty($c_email) && !empty($password)){
        $pseudoLength = iconv_strlen($pseudo);
        $emailLength = iconv_strlen($email);
        $passwordLength = iconv_strlen($password);
        if($age >= 18){
          if($pseudoLength <= 255){
            if($emailLength <= 255){
              if($passwordLength >= 8){
                if($c_email == $email){
                  if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                    $reqEmail = $this->bd->prepare("SELECT * FROM account WHERE email = ?");
                    $reqEmail->execute(array($email));
                    $emailExist = $req_email->rowCount();
                    if($emailExist == 0){
                      $insert = $this->bd->prepare("INSERT INTO account(pseudo, age, email, password) VALUES(?, ?, ?, ?)");
                      $insert->execute(array($pseudo, $age, $email, $password));
                      header("Location: index.php?login");
                    }else{
                      //email déja utilisé
                      $this->error = "Le mail utilisé correspond déjà à un compte existant !";
                    }
                  }else{
                    //email invalide
                    $this->error = "Le mail utilisé est invalide !";
                  }
                }else{
                  //email et c_email diff
                  $this->error = "La confirmation du mail ne correspond pas au mail !";
                }
              }else{
                //mdp trop court
                $this->error = "Le mot de passe doit faire minimum 8 caractères !";
              }
            }else{
              //email trop long
              $this->error = "Votre mail dépasse les 255 caractères !";
            }
          }else{
            //pseudo trop long
            $this->error = "Votre pseudo dépasse les 255 caractères !";
          }
        }else{
          //trop jeune
          $this->error = "Il faut être majeur pour accéder au contenu de ce site !";
        }
      }else{
        //toute les cases ne sont pas remplit
        $this->error = "Toute les champs doivent être remplit !";
      }
    }
  }

  /**
  * Connexion
  */
  public function login(){
    if(isset($_POST['login'])){
      $email = htmlspecialchars($_POST['email']);
      $password = $_POST['password'];

      if(!empty($email) && !empty($password)){
        $dataUser = $this->accountStorage->checkAuth($email, $password);

        if($dataUser != null){
          $_SESSION['id'] = $dataUser->getId();
          $_SESSION['pseudo'] = $dataUser->getPseudo();
          header("Location: index.php");
        }else{
          //Compte inexistant
          $this->error = "Mot de passe ou mail incorrect !";
        }
      }else{
        //case manquante
        $this->error = "Toute les instructions ne sont pas remplit !";
      }
    }
  }

  /**
  * Deconnexion
  */
  public function logout(){
	  session_destroy();
	  header("Location: index.php");
  }

  /**
  * Vérifie si l'uti est connecté
  */
  public function isConnect(){
    if(isset($_SESSION['id'])){
      return true;
    }else{
      return false;
    }
  }

  /**
  * Renvoie l'id de l'utilisateur
  */
  public function getIdUser(){
    return $_SESSION['id'];
  }
}
?>
