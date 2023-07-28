<?php
require_once 'models/users.php';
require_once 'models/init.php';

class OperatorsController{
  private $model;
  public function __CONSTRUCT(){
    $this->users = new Users();
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    if (in_array(5, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/operators/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    if (in_array(5, $permissions)) {
      if (!empty($_REQUEST['id'])) {
        $filters = "and id = " . $_REQUEST['id'];
        $id = $this->init->get('*','operators', $filters);
      }
      require_once 'views/operators/new.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Data(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(5, $permissions)) {
      $result[] = array();
      $i=0;
      foreach($this->init->list('*','operators') as $r) {
        $result[$i]['Name'] = $r->name;
        $result[$i]['Status'] = ($r->status != 1) ? 'Inactivo' : 'Activo';
        $button = ($r->status != 1) ? "<span type='button' class='text-danger float-right status mx-1' data-id='$r->id' data-status='1'> <i class='fas fa-2x fa-toggle-on'></i></i></span>" : "<span type='button' class='text-success float-right status mx-1' data-id='$r->id' data-status='0'> <i class='fas fa-2x fa-toggle-on'></i></i></span>";
        $result[$i]['Action'] = $button
        . "<button class='btn btn-primary float-right mx-1 new' data-id='$r->id'> <i class='fas fa-pen'></i></button>"
        ;
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->init->redirect();
    }
  }

  public function Status(){
    require_once "middlewares/check.php";
    if (in_array(1, $permissions)) {
      $item = new stdClass();
      $item->status = $_REQUEST['status'];
      $this->init->update('operators',$item,$_REQUEST['id']);
    } else {
      $this->init->redirect();
    }
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $table = 'operators';
    foreach($_POST as $k => $val) {
      if (!empty($val)) {
        if($k != 'id') {
          $item->{$k} = $val;
        }
      }
    }
    empty($_POST['id'])
    ? $this->init->save($table,$item)
    : $this->init->update($table,$item,$_POST['id']);
  }

}