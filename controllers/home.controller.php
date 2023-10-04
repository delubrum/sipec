<?php
require_once 'models/model.php';

class HomeController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Model();
  }

  public function Index(){
    require_once "middlewares/auth.php";
    if ($isLoggedIn) {
      $_REQUEST['c'] = 'Home';
      require_once "middlewares/check.php";
      require_once 'views/layout/header.php';
      require_once 'views/layout/page.php';
    } else {
      require_once 'views/layout/login.php';
    }
  }

  public function Login(){
		require_once "middlewares/auth.php";
		if (isset($_REQUEST['pass']) and $_REQUEST['pass'] <> '') {
			$isAuthenticated = false;
			$password=strip_tags($_REQUEST['pass']);
			$email=strip_tags($_REQUEST['email']);
			if ($this->model->get('id,password,lang','users',"and email = '$email' and status = 1")) {
				$user = $this->model->get('id,password,lang','users',"and email = '$email' and status = 1");
				if (password_verify($password, $user->password)) {
						$isAuthenticated = true;
				}
				if ($isAuthenticated) {
					session_start();
					$_SESSION["id-SIPEC"] = $user->id;
					session_write_close();
					setcookie("user_login", $email, $cookie_expiration_time);
					$random_password = $this->model->getToken(16);
					setcookie("random_password", $random_password, $cookie_expiration_time);
					$random_selector = $this->model->getToken(32);
					setcookie("random_selector", $random_selector, $cookie_expiration_time);
					$random_password_hash = password_hash($random_password, PASSWORD_DEFAULT);
					$random_selector_hash = password_hash($random_selector, PASSWORD_DEFAULT);
					$expiry_date = date("Y-m-d H:i:s", $cookie_expiration_time);
					// mark existing token as expired
					$userToken = $this->model->get('*','tokenAuth',"and email = '$email' and is_expired = 0");
					if (! empty($userToken->id)) {
						$item = new stdClass();
						$item->is_expired = 1;
						$this->model->update('tokenAuth',$item,$userToken->id);
					}
					// Insert new token
					$item = new stdClass();
					$item->email = $email;
					$item->password_hash = $random_password_hash;
					$item->selector_hash = $random_selector_hash;
					$item->expiry_date = $expiry_date;
					$this->model->save('tokenAuth',$item);
					echo "ok";
				} else {
					echo "Error";
				}
			} else {
				echo "Error";
			}
		}
	}

  public function Logout() {
    session_start();
    $_SESSION["id-SIPEC"] = "";
    session_destroy();
    $this->model->clearAuthCookie();
    header('Location: ?c=Home&a=Index');
  }

  public function SessionRefresh(){
    session_start();
    if (isset($_SESSION['id-SIPEC'])) {
      $_SESSION['id-SIPEC'] = $_SESSION['id-SIPEC'];
    }
  }

  public function DeleteFile() {
    unlink($_REQUEST["file"]);
  }

  public function DeleteFolder() {
    $dir = $_REQUEST["folder"];
    if (is_dir($dir)) {
      $objects = scandir($dir);
      foreach ($objects as $object) {
        if ($object != "." && $object != "..") {
          if (filetype($dir."/".$object) == "dir") 
             rrmdir($dir."/".$object); 
          else unlink   ($dir."/".$object);
        }
      }
      reset($objects);
      rmdir($dir);
    }
   }

}