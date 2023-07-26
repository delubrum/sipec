<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/users.php';
require_once 'models/init.php';
require_once 'middlewares/util.php';

class UsersController{
  private $model;
  public function __CONSTRUCT(){
    $this->users = new Users();
    $this->init = new Init();
    $this->util = new Util();
  }

  public function Index(){
    require_once "middlewares/check.php";
    $list = $this->init->list('*','users');
    if (in_array(1, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/users/index.php';
    } else {
      require_once '403.php';
    }
  }

  public function Profile(){
    require_once "middlewares/check.php";
    $a = 'Profile';
    $b = 'User';
    $userPermissions = json_decode($this->init->get('permissions','users',$user->id)->permissions);
    require_once 'views/layout/header.php';
    require_once 'views/users/profile.php';
  }

  public function UserForm(){
    require_once "middlewares/check.php";
    $a = 'Edit';
    require_once 'views/users/new.php';
  }

  public function UserEdit(){
    require_once "middlewares/check.php";
    $a = 'Profile';
    $b = 'Edit';
    require_once 'views/users/profile.php';
  }

  public function Deactivate(){
    $this->init->updateField('users','cancelledAt',date("Y-m-d m:i:s"),$_REQUEST['id']);
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();

  }

  public function PermissionsSave(){
    require_once "middlewares/check.php";
    if (in_array(1, $permissions)) {
      $item = new stdClass();
      $item->userId=$_REQUEST['userId'];
      $item->permissions=json_encode($_REQUEST['permissions']);
      $this->users->userPermissionsSave($item);
    }
  }

}