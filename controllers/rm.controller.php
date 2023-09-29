<?php
require_once 'models/model.php';

class RMController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Model();
  }

  public function Index(){
    require_once "middlewares/check.php";
    !empty($_POST) ? $filters = '' : $filters = " and a.status <> 'Cerrado'";
    (!empty($_POST['id'])) ? $filters .= " and a.id =" . $_POST['id']: $filters .= "";
    (!empty($_POST['clientId'])) ? $filters .= " and a.clientId ='" . $_POST['clientId']."'": $filters .= "";
    (!empty($_POST['productId'])) ? $filters .= " and a.productId ='" . $_POST['productId']."'": $filters .= "";
    (!empty($_POST['status'])) ? $filters .= " and a.status ='" . $_POST['status'] . "'" : $filters .= "";
    (!empty($_POST['from'])) ? $filters .= " and a.createdAt  >='" . $_POST['from']."'": $filters .= "";
    (!empty($_POST['to'])) ? $filters .= " and a.createdAt <='" . $_POST['to']." 23:59:59'": $filters .= "";
    if (in_array(3, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/rm/index.php';
    } else {
      $this->model->redirect();
    }
  }

  public function New(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      require_once 'views/rm/new.php';
    } else {
      $this->model->redirect();
    }
  }

  public function ClientProducts(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $arr = array();
      $i = 0;
      $filters = "and type = 'Cliente' and id = " . $_REQUEST['client'];
      foreach(json_decode($this->model->get('products','users',$filters)->products) as $r) {
        $arr[$i]['id'] = $r;
        $filter = "and id = " . $r;
        $arr[$i]['name'] = $this->model->get('name','products',$filter)->name;
        $i++;
      }
      echo json_encode($arr);
    } else {
      $this->model->redirect();
    }
  }

  public function Data(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $result[] = array();
      $i=0;
      $filters = $_REQUEST['filters'];
      foreach($this->model->list('a.id,a.date,a.status,a.invoice,d.username,b.company as clientname, c.name as productname','rm a',$filters,'LEFT JOIN users b ON a.clientId = b.id LEFT JOIN products c ON a.productId = c.id LEFT JOIN users d ON a.userId = d.id') as $r) {
        $result[$i]['id'] = $r->id;
        $result[$i]['date'] = $r->date;
        $result[$i]['user'] = $r->username;
        $result[$i]['client'] = $r->clientname;
        $result[$i]['product'] = $r->productname;
        $result[$i]['status'] = $r->status;
        if ($r->status == 'Cerrado') {
          $result[$i]['invoice'] = $r->invoice;
        }
        $button = ($r->status != 'Cerrado') ? "<button type='button' data-id='$r->id' data-status='$r->status' class='btn btn-primary mb-1 action'> <i class='fas fa-pen'></i> Editar</button><br>" : "";
        $rm = ($r->status != 'Terminar R.M.' and $r->status != 'Registrando') ? "<a href='?c=RM&a=Detail&id=$r->id' type='button' target='_blank' class='btn btn-primary mb-1'><i class='fas fa-file'></i> Recibo de Material</a><br>" : "";
        $bc = ($r->status == 'Facturación' || $r->status == 'Cerrado') ? "<a href='?c=BC&a=Detail&id=$r->id' type='button' target='_blank' class='btn btn-primary mb-1'><i class='fas fa-file'></i> Bitácora</a><br>" : "";
        $pd = ($r->status == 'Facturación' || $r->status == 'Cerrado') ? "<a href='?c=RM&a=PD&id=$r->id' type='button' target='_blank' class='btn btn-primary'><i class='fas fa-file'></i> Paquete Despacho</a><br>" : "";

        $result[$i]['action'] = "$button $rm $bc $pd";
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->model->redirect();
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
      $id = $this->model->save('rm',$item);
      echo $id;
    } else {
      $this->model->redirect();
    }
  }

  public function RM(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.id = " . $_REQUEST['id'];
      $id = $this->model->get('a.*,b.company as clientname, c.name as productname, b.city','rm a',$filters,'LEFT JOIN users b ON a.clientId = b.id LEFT JOIN products c ON a.productId = c.id');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->model->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      $status = $_REQUEST['status'];
      require_once 'views/rm/rm.php';
    } else {
      $this->model->redirect();
    }
  }

  public function ItemsData(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $result[] = array();
      $filters = "and id = " . $_REQUEST['id'];
      echo $this->model->get('data','rm',$filters)->data;
    } else {
      $this->model->redirect();
    }
  }

  public function UpdateData(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $item->data = json_encode($_REQUEST['data']);
      $id = $this->model->update('rm',$item,$_REQUEST['id']);
      // print_r($item);
    } else {
      $this->model->redirect();
    }
  }

  public function Update(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      if (isset($_REQUEST['status']) and $_REQUEST['status'] == 'Facturación') {
        $item->status = 'Cerrado';
        $item->invoice = $_REQUEST['invoice'];
        $item->invoiceAt = date("Y-m-d H:i:s");
        $this->model->update('rm',$item,$_REQUEST['id']);
      }
      if (isset($_REQUEST['field'])) {
        $item->{$_REQUEST['field']} = $_REQUEST['value'];
        $filters = "and rmId = " . $_REQUEST['id'];
        $this->model->update('rm',$item,$_REQUEST['id']);
      }
      if (isset($_REQUEST['status']) and $_REQUEST['status'] == 'Terminar R.M.') {
        $item->rmAt = date("Y-m-d H:i:s");
        $itemb = new stdClass();
        $itemb->rmId = $_REQUEST['id'];
        $items = new stdClass();
        $this->model->save('bc',$itemb);
        $item->status = 'Producción';
        $this->model->update('rm',$item,$_REQUEST['id']);
        $id = $_REQUEST['id'];
        foreach(json_decode($this->model->get("data","rm","and id = $id")->data) as $r) {
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
          $this->model->save('rm_items',$items);
        }
      }
    } else {
      $this->model->redirect();
    }
  }

  public function Detail(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.id = " . $_REQUEST['id'];
      $id = $this->model->get('a.*,d.username as operatorname,b.company as clientname, c.name as productname, b.city','rm a',$filters,'LEFT JOIN users b ON a.clientId=b.id LEFT JOIN products c ON a.productId = c.id LEFT JOIN users d ON a.operatorId=d.id');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->model->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      require_once 'views/reports/rm.php';
    } else {
      $this->model->redirect();
    }
  }

  public function PD(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.id = " . $_REQUEST['id'];
      $id = $this->model->get('a.*,b.company as clientname, b.username as contactname, c.name as productname, b.city, d.id as bcId, d.mud, d.distilled, d.evaporation, d.mud_dist, d.evaporation','rm a',$filters,'LEFT JOIN users b ON a.clientId=b.id LEFT JOIN products c ON a.productId = c.id LEFT JOIN bc d ON a.id = d.rmId');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->model->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      $kg = $this->model->get('SUM(kg) as total','rm_items',$filters)->total;
      $tara = $this->model->get('SUM(tara) as total','rm_items',$filters)->total;

      require_once 'views/reports/pd.php';
    } else {
      $this->model->redirect();
    }
  }

  

}