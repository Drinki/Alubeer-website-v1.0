<?php
class Account{
  public function __construct($id, $pseudo, $email, $password){
    $this->id = $id;
    $this->pseudo = $pseudo;
    $this->email = $email;
    $this->password = $password;
  }

  public function getId(){
    return $this->id;
  }

  public function getPseudo(){
    return $this->pseudo;
  }

  public function getEmail(){
    return $this->email;
  }

  public function getPassword(){
    return $this->password;
  }
}
?>
