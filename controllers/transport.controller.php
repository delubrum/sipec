<?php
require_once 'models/model.php';

class TransportController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Model();
  }

  public function Index(){
    require_once "middlewares/check.php";
    if (in_array(9, $permissions)) {
      $filters = '';
      (!empty($_POST['id'])) ? $filters .= " and rm =" . $_POST['id']: $filters .= "";
      (!empty($_POST['invoice'])) ? $filters .= " and invoice =" . $_POST['invoice']: $filters .= "";
      (!empty($_POST['user'])) ? $filters .= " and user ='" . $_POST['user'] ."'": $filters .= "";
      $datenow = date('Y-m-d');// date now
      $mon = date('Y-m-01', strtotime($datenow));
      $sun = date('Y-m-t', strtotime($datenow));
      (!empty($_REQUEST['from'])) ? $filters .= " and createdAt  >='" . $_REQUEST['from']."'": $filters .= " and createdAt  >= '$mon'";
      (!empty($_REQUEST['to'])) ? $filters .= " and createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= " and createdAt  <= '$sun 23:59:59'";
      $result = $this->model->get('SUM(price) as total', 'transport', $filters);
      $total = $result && isset($result->total) ? number_format($result->total) : 0;
      require_once 'views/layout/header.php';
      require_once 'views/transport/index.php';
    } else {
      $this->model->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    if (in_array(9, $permissions)) {
      require_once 'views/transport/new.php';
    } else {
      $this->model->redirect();
    }
  }

  public function Save(){
    require_once "middlewares/check.php";
    if (in_array(9, $permissions)) {
      $item = new stdClass();
      $table = 'transport';
      foreach($_POST as $k => $val) {
        if (!empty($val)) {
          if($k != 'id') {
            $item->{$k} = $val;
          }
        }
      }
      $item->price = preg_replace('/[^0-9]+/', '', $_REQUEST['price']);
      $id = $this->model->save($table,$item);
      echo $id;
    } else {
      $this->model->redirect();
    }
  }

  public function Data(){
    require_once "middlewares/check.php";
    if (in_array(9, $permissions)) {
      header('Content-Type: application/json');
      $result[] = array();
      $i=0;
      $filters = $_REQUEST['filters'];
      foreach($this->model->list('*','transport',$filters) as $r) {
        $result[$i]['date'] = $r->createdAt;
        $result[$i]['user'] = $r->user;
        $result[$i]['start'] = $r->start;
        $result[$i]['end'] = $r->end;
        $result[$i]['rm'] = $r->rm;
        $result[$i]['qty'] = $r->qty;
        $result[$i]['kg'] = $r->kg;
        $result[$i]['invoice'] = $r->invoice;
        $result[$i]['price'] = number_format($r->price);
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->model->redirect();
    }
  }

}