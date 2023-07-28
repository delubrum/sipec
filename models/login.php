<?php
class Login {
  private $pdo;
  private $user;
  private $password;

  public function __CONSTRUCT() {
    try	{
      $this->pdo = Database::Conectar();
    }
    catch(Exception $e)	{
      die($e->getMessage());
    }
  }

  public function getUserByEmail($email) {
    try {
      $stm = $this->pdo->prepare("SELECT id,password,lang FROM users WHERE email = ? and status = 1");
      $stm->execute(array($email));
      return $stm->fetch(PDO::FETCH_OBJ);
    }
    catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function getTokenByEmail($email,$expired) {
    try {
      $stm = $this->pdo->prepare("SELECT * FROM tokenAuth WHERE email = ? and is_expired = ?");
      $stm->execute(array($email,$expired));
      return $stm->fetch(PDO::FETCH_OBJ);
    }
    catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function markAsExpired($tokenId) {
    try {
      $sql = "UPDATE tokenAuth SET is_expired = 1 WHERE id = ?";
      $this->pdo->prepare($sql)->execute(array($tokenId));
      return true;
    }
      catch (Exception $e) {
      die($e->getMessage());
    }
  }

  public function insertToken($email, $random_password_hash, $random_selector_hash, $expiry_date) {
    try {
      $sql = "INSERT INTO tokenAuth (email, password_hash, selector_hash, expiry_date) values (?,?,?,?)";
      $this->pdo->prepare($sql)->execute(array($email, $random_password_hash, $random_selector_hash, $expiry_date));
      return true;
    }
      catch (Exception $e) {
      die($e->getMessage());
    }
  }

}