<?php
require_once("DBConfig.php");
require_once("BeerStorage.php");

class BeerStorageStub implements BeerStorage{

  public function __construct(){
    $config = new DBConfig();
    $this->bd = $config->getDB();
  }

  public function reqBeer(){
    $req_beer = $this->bd->prepare('SELECT * FROM beer_can');
    $req_beer->execute();
    $data_beer = $req_beer->fetchAll();

    $finData_beer = array();
    for($i = 0; $i < count($data_beer); $i++){

      $finData_beer[$data_beer[$i]['id']] = new Beer($data_beer[$i]['id'],
                                         $data_beer[$i]['name'],
                                         $data_beer[$i]['color'],
                                         $data_beer[$i]['alcohol'],
                                         $data_beer[$i]['flavor'],
                                         $data_beer[$i]['temp'],
                                         $data_beer[$i]['price'],
                                         $data_beer[$i]['description'],
                                         $data_beer[$i]['id_user']);
    }

    return $finData_beer;
  }
}
?>
