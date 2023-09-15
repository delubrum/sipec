<?php
require_once 'models/init.php';

class ProductsController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    if (in_array(4, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/products/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    if (in_array(4, $permissions)) {
      if (!empty($_REQUEST['id'])) {
        $filters = "and id = " . $_REQUEST['id'];
        $id = $this->init->get('*','products', $filters);
      }
      require_once 'views/products/new.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Data(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(4, $permissions)) {
      $result[] = array();
      $i=0;
      foreach($this->init->list('*','products') as $r) {
        $result[$i]['name'] = $r->name;
        $result[$i]['status'] = ($r->status != 1) ? 'Inactivo' : 'Activo';
        $button = ($r->status != 1) ? "<span type='button' class='text-gray float-right status mx-1' data-id='$r->id' data-status='1'> <i class='fas fa-2x fa-toggle-off'></i></i></span>" : "<span type='button' class='text-black float-right status mx-1' data-id='$r->id' data-status='0'> <i class='fas fa-2x fa-toggle-on'></i></i></span>";
        $result[$i]['action'] = $button
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
      $this->init->update('products',$item,$_REQUEST['id']);
    } else {
      $this->init->redirect();
    }
  }

  public function Save(){
    require_once "middlewares/check.php";
    $item = new stdClass();
    $table = 'products';
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