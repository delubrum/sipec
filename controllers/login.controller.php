<?php
require_once 'models/login.php';
require_once 'middlewares/util.php';

class LoginController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Login();
    $this->util = new Util();
  }

  public function Index(){
    require_once "middlewares/auth.php";
    if ($isLoggedIn) {
      header('Location: ?c=Init&a=Index');
    } else {
      require_once 'views/login/index2.php';
    }
  }

  public function Login(){
    require_once "middlewares/auth.php";
    if (isset($_REQUEST['pass']) and $_REQUEST['pass'] <> '') {
      $isAuthenticated = false;
      $password=strip_tags($_REQUEST['pass']);
      $email=strip_tags($_REQUEST['email']);
      if ($this->model->getUserByEmail($email)) {
      $user = $this->model->getUserByEmail($email);
      if (password_verify($password, $user->password)) {
        $isAuthenticated = true;
      }
      if ($isAuthenticated) {
        session_start();
        $_SESSION["id-CRB"] = $user->id;
        session_write_close();
        setcookie("user_login", $email, $cookie_expiration_time);
        $random_password = $this->util->getToken(16);
        setcookie("random_password", $random_password, $cookie_expiration_time);
        $random_selector = $this->util->getToken(32);
        setcookie("random_selector", $random_selector, $cookie_expiration_time);
        $random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
        $random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
        $expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
        // mark existing token as expired
        $userToken = $this->model->getTokenByEmail($email, 0);
        if (! empty($userToken->id)) {
          $this->model->markAsExpired($userToken->id);
        }
        // Insert new token
        $this->model->insertToken($email, $random_password_hash, $random_selector_hash, $expiry_date);
        echo "ok";
      } else {
        echo "Invalid Password";
      }
      } else {
        echo "User not found";
      }
    }
  }

  public function Logout() {
    session_start();
    $_SESSION["id-CRB"] = "";
    session_destroy();
    $this->util->clearAuthCookie();
    header('Location: ?c=Login&a=Index');
  }

}