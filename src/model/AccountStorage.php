<?php
require_once("Account.php");

interface AccountStorage{
  public function checkAuth($email, $password);
  public function reqAccount();
}
?>
