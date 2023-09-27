<?php
require_once 'models/init.php';

class RMController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    isset($_REQUEST['id']) ? $filters = '' : $filters = " and status <> 'Cerrado'";
    (!empty($_REQUEST['id'])) ? $filters .= " and a.id =" . $_REQUEST['id']: $filters .= "";
    (!empty($_REQUEST['userId'])) ? $filters .= " and a.userId ='" . $_REQUEST['userId']."'": $filters .= "";
    (!empty($_REQUEST['priority'])) ? $filters .= " and a.priority ='" . $_REQUEST['priority']."'": $filters .= "";
    (!empty($_REQUEST['from'])) ? $filters .= " and a.createdAt  >='" . $_REQUEST['from']."'": $filters .= "";
    (!empty($_REQUEST['to'])) ? $filters .= " and a.createdAt <='" . $_REQUEST['to']." 23:59:59'": $filters .= "";
    (!empty($_REQUEST['status'])) ? $filters .= " and a.status ='" . $_REQUEST['status'] . "'" : $filters .= "";

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
      foreach($this->init->list('a.id,a.date,a.status,a.invoice,d.username,b.company as clientname, c.name as productname','rm a','','LEFT JOIN users b ON a.clientId = b.id LEFT JOIN products c ON a.productId = c.id LEFT JOIN users d ON a.userId = d.id') as $r) {
        $result[$i]['id'] = $r->id;
        $result[$i]['date'] = $r->date;
        $result[$i]['user'] = $r->username;
        $result[$i]['client'] = $r->clientname;
        $result[$i]['product'] = $r->productname;
        $result[$i]['status'] = $r->status;
        if ($r->status == 'Cerrado') {
          $result[$i]['invoice'] = $r->invoice;
        }
        $button = ($r->status != 'Cerrado') ? "<button type='button' data-id='$r->id' data-status='$r->status' class='btn btn-primary text-right mb-1 action'> <i class='fas fa-pen'></i> Editar</button><br>" : "";
        $rm = ($r->status != 'Terminar R.M.' and $r->status != 'Registrando') ? "<a href='?c=RM&a=Detail&id=$r->id' type='button' target='_blank' class='btn btn-primary mb-1'><i class='fas fa-file'></i> Recibo de Material</a><br>" : "";
        $bc = ($r->status == 'Facturación' || $r->status == 'Cerrado') ? "<a href='?c=BC&a=Detail&id=$r->id' type='button' target='_blank' class='btn btn-primary mb-1'><i class='fas fa-file'></i> Bitácora</a><br>" : "";
        $pd = ($r->status == 'Facturación' || $r->status == 'Cerrado') ? "<a href='?c=RM&a=PD&id=$r->id' type='button' target='_blank' class='btn btn-primary'><i class='fas fa-file'></i> Paquete Despacho</a><br>" : "";

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
      $arr = $_POST['data'];
      $data = array();
      parse_str($arr, $data);
      $item->clientId = $data['clientId'];
      $item->productId = $data['productId'];
      $item->date = $data['date'];
      $item->userId = $_SESSION["id-SIPEC"];
      $item->data = json_encode($_REQUEST['table'],true);
      $item->status = 'Terminar R.M.';
      // print_r($item);
      $id = $this->init->save('rm',$item);
      echo $id;
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
        $item->status = 'Terminar R.M.';
        $item->enteredAt = date("Y-m-d H:i:s");
        $this->init->update('rm',$item,$_REQUEST['id']);
      }
      if (isset($_REQUEST['status']) and $_REQUEST['status'] == 'Facturación') {
        $item->status = 'Cerrado';
        $item->invoice = $_REQUEST['invoice'];
        $item->invoiceAt = date("Y-m-d H:i:s");
        $this->init->update('rm',$item,$_REQUEST['id']);
      }
      if (isset($_REQUEST['field'])) {
        $item->{$_REQUEST['field']} = $_REQUEST['value'];
        $filters = "and rmId = " . $_REQUEST['id'];
        echo $this->init->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      }
      if (isset($_REQUEST['status']) and $_REQUEST['status'] == 'Terminar R.M.') {
        $item->rmAt = date("Y-m-d H:i:s");
        $itemb = new stdClass();
        $itemb->rmId = $_REQUEST['id'];
        $items = new stdClass();
        $this->init->save('bc',$itemb);
        $item->status = 'Producción';
        $this->init->update('rm',$item,$_REQUEST['id']);
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