<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/clients.php';
require_once 'models/users.php';
require_once 'models/init.php';


class ClientsController{
  private $model;
  public function __CONSTRUCT(){
    $this->clients = new Clients();
    $this->users = new Users();
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    if (in_array(2, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/clients/index.php';
    } else {
      require_once '403.php';
    }
  }
  
  public function New(){
    isset($_REQUEST['id']) ? $id = $this->clients->get($_REQUEST['id']) : '';
    require_once 'views/clients/new.php';
  }

  public function Save(){
    $item = new stdClass();
    $item->name=$_REQUEST['name'];
    $item->company=$_REQUEST['company'];
    $item->email=$_REQUEST['email'];
    $item->tel1=$_REQUEST['tel1'];
    $item->tel2=$_REQUEST['tel2'];
    $item->city=$_REQUEST['city'];
    if (!empty($_REQUEST['clientId'])) {
      $item->clientId = $_REQUEST['clientId'];
      $this->clients->update($item);
    } else {
      $this->clients->save($item);
    }
  }

}