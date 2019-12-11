<?php
class Beer{
  public function __construct($id, $name, $color, $alcohol, $flavor, $temp, $price, $desc, $id_user){
    $this->id = $id;
    $this->name = $name;
    $this->color = $color;
    $this->alcohol = $alcohol;
    $this->flavor = $flavor;
    $this->temp = $temp;
    $this->price = $price;
    $this->desc = $desc;
    $this->id_user = $id_user;
  }

  public function getId(){
    return $this->id;
  }

  public function getName(){
    return $this->name;
  }

  public function getColor(){
    return $this->color;
  }

  public function getAlcohol(){
    return $this->alcohol;
  }

  public function getFlavor(){
    return $this->flavor;
  }

  public function getTemp(){
    return $this->temp;
  }

  public function getPrice(){
    return $this->price;
  }

  public function getDesc(){
    return $this->desc;
  }

  public function getIdUser(){
    return $this->id_user;
  }
}
?>
