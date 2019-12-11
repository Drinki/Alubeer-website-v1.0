<?php
require_once("AccountStorage.php");

class AccountStorageStub implements AccountStorage{
  public function __construct(){
    $config = new DBConfig();
    $this->bd = $config->getDB();
  }

  public function checkAuth($email, $password){
    $data = $this->reqAccount();
    foreach ($data as $key => $value) {
      if($value->getEmail() == $email and password_verify($password, $value->getPassword())){
        return $data[$key];
      }else{
        return null;
      }
    }
  }

  public function reqAccount(){
    $req_account = $this->bd->prepare('SELECT * FROM account');
    $req_account->execute();
    $data_account = $req_account->fetchAll();

    $finData_account = array();
    for($i = 0; $i < count($data_account); $i++){
      $finData_account[$data_account[$i]['id']] = new Account($data_account[$i]['id'],
                                                $data_account[$i]['pseudo'],
                                                $data_account[$i]['email'],
                                                $data_account[$i]['password']);
    }

    return $finData_account;
  }
}
?>
