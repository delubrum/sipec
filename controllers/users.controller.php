<?php
require_once 'models/users.php';
require_once 'models/init.php';

class UsersController{
  private $model;
  public function __CONSTRUCT(){
    $this->users = new Users();
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    if (in_array(1, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/users/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    if (in_array(1, $permissions)) {
      $a = 'Edit';
      require_once 'views/users/new.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Data(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(1, $permissions)) {
      $result[] = array();
      $i=0;
      foreach($this->init->list('*','users') as $r) {
        $result[$i]['Date'] = $r->createdAt;
        $result[$i]['Name'] = $r->username;
        $result[$i]['Email'] = $r->email;
        $result[$i]['Status'] = ($r->status != 1) ? 'Inactivo' : 'Activo';
        $button = ($r->status != 1) ? "<span type='button' class='text-danger float-right status mx-1' data-id='$r->id' data-status='1'> <i class='fas fa-2x fa-toggle-on'></i></i></span>" : "<span type='button' class='text-success float-right status mx-1' data-id='$r->id' data-status='0'> <i class='fas fa-2x fa-toggle-on'></i></i></span>";
        $result[$i]['Action'] = $button
        . "<a href='?c=Users&a=Profile&id=$r->id' class='btn btn-primary float-right mx-1'> <i class='fas fa-pen'></i></a>"
        ;
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->init->redirect();
    }
  }

  public function Profile(){
    require_once "middlewares/check.php";
    if (in_array(1, $permissions) and isset($_REQUEST["id"])){
      $filters = "and id = " . $_REQUEST['id'];
      $user = $this->init->get('*','users',$filters);
    } else {
      $filters = "and id = " . $_SESSION["id-SIPEC"];
      $user = $this->init->get('*','users',$filters);
    }
    $a = 'Profile';
    require_once 'views/layout/header.php';
    require_once 'views/users/profile.php';
  }

  public function Status(){
    require_once "middlewares/check.php";
    if (in_array(1, $permissions)) {
      $item = new stdClass();
      $item->status = $_REQUEST['status'];
      $this->init->update('users',$item,$_REQUEST['id']);
    } else {
      $this->init->redirect();
    }
  }

  public function Save(){
    require_once "middlewares/check.php";
    if (in_array(1, $permissions)) {
      $item = new stdClass();
      $item->username=$_REQUEST['name'];
      $item->email=$_REQUEST['email'];
      $item->lang='en';
      $item->password=$_REQUEST['newpass'];
      $cpass=$_REQUEST['cpass'];
      if ($cpass != '' and $cpass != $item->password) {
        echo "Las contraseñas no coinciden";
      } else {
        $item->password = password_hash($item->password, PASSWORD_DEFAULT);
        if (!empty($_REQUEST['userId'])) {
          $item->id = $_REQUEST['userId'];
          $this->init->update('users',$item,$_REQUEST['userId']);
          echo $item->id;
        } else {
          $id = $this->init->save('users',$item);
          echo $id;
        }
      }
    } else {
      $this->init->redirect();
    }
  }

  public function SavePermissions(){
    require_once "middlewares/check.php";
    if (in_array(1, $permissions)) {
      $item = new stdClass();
      $item->permissions = $_REQUEST['permissions'];
      $this->init->update('users',$item,$_REQUEST['userId']);
    }
  }

}