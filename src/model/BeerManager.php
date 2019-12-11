<?php
require_once("DBConfig.php");

define('TARGET', 'upload/');    // Repertoire cible
define('MAX_SIZE', 1000000);    // Taille max en octets du fichier
define('WIDTH_MAX', 1500);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 1500);    // Hauteur max de l'image en pixels

class BeerManager{
  private $error;

  public function __construct(){
    $config = new DBConfig();
    $this->bd = $config->getDB();
    $this->error = "";
  }

  /**
  * Renvoie le message d'erreur
  */
  public function getError(){
    return $this->error;
  }

  /**
  * Ajoute une bière à la liste
  */
  public function add(){
    if(isset($_POST['add'])){
      $name = htmlspecialchars($_POST['name']);
      $color = htmlspecialchars($_POST['color']);
      $alcohol = htmlspecialchars($_POST['alcohol']);
      $flavor = htmlspecialchars($_POST['flavor']);
      $temp = htmlspecialchars($_POST['temp']);
      $price = htmlspecialchars($_POST['price']);
      $description = htmlspecialchars($_POST['description']);
      $id_user = htmlspecialchars($_SESSION['id']);

      $image = $_FILES['imageBeer'];

      if(!empty($name) && !empty($color) && !empty($alcohol) && !empty($flavor) &&
      !empty($temp) && !empty($price) && !empty($description) && !empty($id_user) && !empty($image)){
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $tabExt = array('jpg', 'gif', 'png', 'jpeg');
        if(in_array(strtolower($ext), $tabExt)){
          $infoImg = getimagesize($image['tmp_name']);
          if($infoImg[2] >= 1 && $infoImg[2] <= 14){
            if(($infoImg[0] <= WIDTH_MAX) && ($infoImg[1] <= HEIGHT_MAX) && (filesize($image['tmp_name']) <= MAX_SIZE)){
              if(isset($image['error']) && UPLOAD_ERR_OK === $image['error']){
                //$image = imagecrop($image, ['x' =>  0, 'y' => 0, 'width' => 290, 'height' => 470]);
                $nameLength = iconv_strlen($name);
                $colorLength = iconv_strlen($color);
                if($nameLength <= 255 || $colorLength <= 255){
                  //insertion de la bière dans la base de données
                  $insert = $this->bd->prepare("INSERT INTO beer_can(name, color, alcohol, flavor, temp, price, description, id_user) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
                  $insert->execute(array($name, $color, $alcohol, $flavor, $temp, $price, $description, $id_user));

                  //Recupération du l'id pour le nom de l'image
                  $reqIdBeer = $this->bd->prepare("SELECT id FROM beer_can WHERE name = ?");
                  $reqIdBeer->execute(array($name));
                  $dataIdBeer = $reqIdBeer->fetch();

                  //Nom de l'image de la bière
                  $nameImage = $dataIdBeer['id'] . ".jpg";
                  if(move_uploaded_file($image['tmp_name'], TARGET.$nameImage)){
                    header("Location: index.php");
                  }else{
                    //problème d'upload
                    $this->error = "Problème lors de l'upload de l'image";
                  }
                }else{
                  //nom ou couleur trop long
                  $this->error = "Nom ou couleur de la bière dépasse les 255 caractères !";
                }
              }else{
                //Erreur trouvé
                $this->error = "Erreur pour l'upload";
              }
            }else{
              //taille invalide
              $this->error = "Dimension de l'image trop élévé";
            }
          }else{
            //Dimension trop élevé
            $this->error = "Taille de l'image trop élévé";
          }
        }else{
          //Extension invalide
          $this->error = "Le fichier de l'upload n'est pas une image";
        }
      }else{
        //remplir tout les champs
        $this->error = "Toute les champs doivent être remplit !";
      }
    }
  }

  /**
  * Modifie une bière de la liste
  */
  public function edit($id){
    if(isset($_POST['edit']) && isset($_SESSION['id'])){

      $name = htmlspecialchars($_POST['name']);

      foreach($_POST as $key => $value){
        if(!empty($_POST[$key])){
          if($key == 'name' || $key == 'color'){
            if(iconv_strlen($_POST[$key]) > 255){
              //nom ou couleur trop long
              $this->error = "Nom ou couleur de la bière dépasse les 255 caractères !";
            }else{
              $insert_beer = $this->bd->prepare("UPDATE beer_can SET id = ?, $key = ? WHERE id = ?");
              $insert_beer->execute(array($id, htmlspecialchars($_POST[$key]), $id));
            }
          }else{
            $insert_beer = $this->bd->prepare("UPDATE beer_can SET id = ?, $key = ? WHERE id = ?");
            $insert_beer->execute(array($id, htmlspecialchars($_POST[$key]), $id));
          }
        }
      }

      $image = $_FILES['editImageBeer'];

      if(!empty($image)){
        //trigger_error("None", E_USER_ERROR);
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $tabExt = array('jpg', 'gif', 'png', 'jpeg');
        if(in_array(strtolower($ext), $tabExt)){
          $infoImg = getimagesize($image['tmp_name']);
          if($infoImg[2] >= 1 && $infoImg[2] <= 14){
            if(($infoImg[0] <= WIDTH_MAX) && ($infoImg[1] <= HEIGHT_MAX) && (filesize($image['tmp_name']) <= MAX_SIZE)){
              if(isset($image['error']) && UPLOAD_ERR_OK === $image['error']){
                $reqIdBeer = $this->bd->prepare("SELECT id FROM beer_can WHERE name = ?");
                $reqIdBeer->execute(array($name));
                $dataIdBeer = $reqIdBeer->fetch();

                //Nom de l'image de la bière
                $nameImage = $dataIdBeer['id'] . ".jpg";
                if(move_uploaded_file($image['tmp_name'], TARGET.$nameImage)){
                  header("Location: index.php?id=$id");
                }
              }else{
                //Erreur trouvé
                $this->error = "Erreur pour l'upload";
              }
            }else{
              //taille invalide
              $this->error = "Dimension de l'image trop élévé";
            }
          }else{
            //Dimension trop élevé
            $this->error = "Taille de l'image trop élévé";
          }
        }else{
          //Extension invalide
          $this->error = "Le fichier de l'upload n'est pas une image";
        }
      }

      header("Location: index.php?id=$id");
    }
  }

  /**
  * Supprime une bière de la liste
  */
  public function delete($id){
    $del_beer = $this->bd->prepare("DELETE FROM beer_can WHERE id = ?");
    $del_beer->execute(array($id));
    header("Location: index.php");
  }
}
?>
