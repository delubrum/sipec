<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/init.php';
require_once 'models/users.php';

class InitController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
    $this->users = new Users();
  }

  public function Index(){
    require_once "middlewares/check.php";
    require_once 'views/layout/header.php';
    require_once 'views/layout/page.php';
  }

  public function SessionRefresh(){
    session_start();
    if (isset($_SESSION['id-CRB'])) {
      $_SESSION['id-CRB'] = $_SESSION['id-CRB'];
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