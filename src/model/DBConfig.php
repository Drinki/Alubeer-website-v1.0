<?php
class DBConfig{
  /**
  * Renvoie l'instance pdo de la db
  */
  public function getDB(){
    return new PDO('mysql:host=mysql.info.unicaen.fr;port=3306;dbname=21706521_0;charset=utf8', '21706521', 'aoY9eingie5uuVei');
  }
}
?>
