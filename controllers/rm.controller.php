<?php
require_once 'models/init.php';

class RMController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/rm/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      require_once 'views/rm/new.php';
    } else {
      $this->init->redirect();
    }
  }

  public function ClientProducts(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $arr = array();
      $i = 0;
      $filters = "and type = 'Cliente' and id = " . $_REQUEST['client'];
      foreach(json_decode($this->init->get('products','users',$filters)->products) as $r) {
        $arr[$i]['id'] = $r;
        $filter = "and id = " . $r;
        $arr[$i]['name'] = $this->init->get('name','products',$filter)->name;
        $i++;
      }
      echo json_encode($arr);
    } else {
      $this->init->redirect();
    }
  }

  public function Data(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $result[] = array();
      $i=0;
      foreach($this->init->list('a.*,b.company as clientname, c.name as productname','rm a','','LEFT JOIN users b ON a.clientId = b.id LEFT JOIN products c ON a.productId = c.id') as $r) {
        $result[$i]['id'] = $r->id;
        $result[$i]['date'] = $r->date;
        $result[$i]['client'] = $r->clientname;
        $result[$i]['product'] = $r->productname;
        switch (true) {
            case (!$r->enteredAt):
              $status = 'Registrando';
              break;
            case ($r->enteredAt and !$r->closedAt):
              $status = 'Pendiente';
              break;
            case ($r->closedAt and !$r->bcAt):
              $status = 'Bitacora';
              break;
            case ($r->bcAt):
              $status = 'Cerrado';
              break;
        }
        $result[$i]['status'] = $status;
        $button = ($status != 'Cerrado') ? "<button type='button' data-id='$r->id' data-status='$status' class='btn btn-primary float-right mx-1 action'> <i class='fas fa-pen'></i></button>" : "";
        $rm = ($status != 'Pendiente' and $status != 'Registrando') ? "<a href='?c=RM&a=Detail&id=$r->id' type='button' target='_blank' class='btn btn-primary float-right mx-1'>RM</a>" : "";
        $bc = ($status == 'Cerrado') ? "<a href='?c=BC&a=Detail&id=$r->id' type='button' target='_blank' class='btn btn-primary float-right mx-1'>BC</a>" : "";
        $pd = ($status == 'Cerrado') ? "<a href='?c=RM&a=PD&id=$r->id' type='button' target='_blank' class='btn btn-primary float-right mx-1'>PD</a>" : "";

        $result[$i]['action'] = "$button $rm $bc $pd";
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->init->redirect();
    }
  }

  public function Save(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      foreach($_POST as $k => $val) {
        if (!empty($val)) {
          $item->{$k} = $val;
        }
      }
      $item->data = '[]';
      $id = $this->init->save('rm',$item);
      echo json_encode(array("id" => $id, "status" => "Registrando"));
    } else {
      $this->init->redirect();
    }
  }

  public function RM(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.id = " . $_REQUEST['id'];
      $id = $this->init->get('a.*,b.company as clientname, c.name as productname, b.city','rm a',$filters,'LEFT JOIN users b ON a.clientId = b.id LEFT JOIN products c ON a.productId = c.id');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->init->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      $status = $_REQUEST['status'];
      require_once 'views/rm/rm.php';
    } else {
      $this->init->redirect();
    }
  }

  public function ItemsData(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $result[] = array();
      $filters = "and id = " . $_REQUEST['id'];
      echo $this->init->get('data','rm',$filters)->data;
    } else {
      $this->init->redirect();
    }
  }

  public function UpdateData(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $item->data = json_encode($_REQUEST['data']);
      $id = $this->init->update('rm',$item,$_REQUEST['id']);
      // print_r($item);
    } else {
      $this->init->redirect();
    }
  }

  public function Update(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      if (isset($_REQUEST['status']) and $_REQUEST['status'] == 'Registrando') {
        $item->enteredAt = date("Y-m-d H:i:s");
      }
      if (isset($_REQUEST['field'])) {
        $item->{$_REQUEST['field']} = $_REQUEST['value'];
        $filters = "and rmId = " . $_REQUEST['id'];
        echo $this->init->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      }
      if (isset($_REQUEST['status']) and $_REQUEST['status'] == 'Pendiente') {
        $item->closedAt = date("Y-m-d H:i:s");
        $itemb = new stdClass();
        $itemb->rmId = $_REQUEST['id'];
        $itemb->turns = '[]';
        $itemb->data = '[]';
        $items = new stdClass();
        $this->init->save('bc',$itemb);
        $id = $_REQUEST['id'];
        foreach(json_decode($this->init->get("data","rm","and id = $id")->data) as $r) {
          $items->rmId = $id;
          $items->kg = $r[0];
          $items->kg_client = $r[1];
          $items->tara = $r[2];
          $items->tara_client = $r[3];
          $items->status = $r[6];
          $car = ($r[7] == "true") ? 'Vehículo' : '';
          $bucket = ($r[8] == "true") ? 'Caneca' : '';
          $plant = ($r[9] == "true") ? 'Planta' : '';
          $items->spills = "$car $bucket $plant";
          $this->init->save('rm_items',$items);
        }
      }
      $this->init->update('rm',$item,$_REQUEST['id']);
    } else {
      $this->init->redirect();
    }
  }

  public function Detail(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.id = " . $_REQUEST['id'];
      $id = $this->init->get('a.*,b.company as clientname, c.name as productname, b.city','rm a',$filters,'LEFT JOIN users b ON a.clientId=b.id LEFT JOIN products c ON a.productId = c.id');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->init->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      require_once 'views/reports/rm.php';
    } else {
      $this->init->redirect();
    }
  }

  public function PD(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.id = " . $_REQUEST['id'];
      $id = $this->init->get('a.*,b.company as clientname, b.username as contactname, c.name as productname, b.city, d.id as bcId, d.mud, d.distilled, d.evaporation, d.mud_dist, d.evaporation','rm a',$filters,'LEFT JOIN users b ON a.clientId=b.id LEFT JOIN products c ON a.productId = c.id LEFT JOIN bc d ON a.id = d.rmId');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->init->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      $kg = $this->init->get('SUM(kg) as total','rm_items',$filters)->total;
      $tara = $this->init->get('SUM(tara) as total','rm_items',$filters)->total;

      require_once 'views/reports/pd.php';
    } else {
      $this->init->redirect();
    }
  }

  

}