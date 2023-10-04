<?php
require_once 'models/model.php';

class BCController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Model();
  }

  public function BC(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.rmId = " . $_REQUEST['id'];
      $id = $this->model->get('a.*, b.paste, b.reactor, c.company as clientname, d.name as productname','bc a',$filters,'LEFT JOIN rm b ON a.rmId = b.id LEFT JOIN users c ON b.clientId = c.id LEFT JOIN products d ON b.productId = d.id');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->model->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      $qty = $net - $id->paste;
      $recovered =  $this->model->get('SUM(net) as total','bc_items'," and type = 'Ingreso' and bcid = $id->id")->total;
      $pr = number_format($recovered/$qty*100);
      $status = $_REQUEST['status'];
      require_once 'views/rm/bc.php';
    } else {
      $this->model->redirect();
    }
  }

  public function NewItem(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $id = $_REQUEST['id'];
      require_once 'views/rm/new-item.php';
    } else {
      $this->model->redirect();
    }
  }

  public function SaveItem(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $rm = new stdClass();
      foreach($_POST as $k => $val) {
        if (!empty($val)) {
          $item->{$k} = $val;
        }
      }
      $item->userId = $_SESSION["id-SIPEC"];
      $bcId = $_REQUEST['bcId'];
      $rmId = $this->model->get("*","bc","and id = $bcId")->rmId;
      if (empty($this->model->get("*","bc_items","and bcId = $bcId")->id)) {
        $rm->start = date("Y-m-d H:i:s");
        $rm->status = 'Iniciado';
        $this->model->update('rm',$rm,$rmId);
      }
      $id = $this->model->save('bc_items',$item);


      echo $this->model->get('SUM(net) as total','bc_items'," and type = 'Ingreso' and bcid = $bcId")->total;

    } else {
      $this->model->redirect();
    }
  }

  public function ItemsData(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $result[] = array();
      $i=0;
      $filters = "and bcId = " . $_REQUEST['id'] . " and a.type='Ingreso'";
      foreach($this->model->list('a.*,b.username','bc_items a',$filters,'LEFT JOIN users b on a.userId = b.id') as $r) {
        $result[$i]['date'] = $r->createdAt;
        $result[$i]['net'] = $r->net;
        $result[$i]['drum'] = $r->drum;
        $result[$i]['temp'] = $r->temp;
        $result[$i]['notes'] = $r->notes;
        $result[$i]['user'] = $r->username;
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->model->redirect();
    }
  }

  public function ItemsBData(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $result[] = array();
      $i=0;
      $filters = "and bcId = " . $_REQUEST['id'] . " and a.type='Caldera'";
      foreach($this->model->list('a.*,b.username','bc_items a',$filters,'LEFT JOIN users b on a.userId = b.id') as $r) {
        $result[$i]['date'] = $r->createdAt;
        $result[$i]['temp'] = $r->temp;
        $result[$i]['notes'] = $r->notes;
        $result[$i]['user'] = $r->username;
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->model->redirect();
    }
  }

  public function Update(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      if (isset($_REQUEST['field'])) {
        $item = new stdClass();
        $item->{$_REQUEST['field']} = $_REQUEST['value'];
        $this->model->update('bc',$item,$_REQUEST['id']);
      } else {
        $itemb = new stdClass();
        $itemb->bcAt = date("Y-m-d H:i:s");
        $itemb->status = 'Facturación';
        $bcId = $_REQUEST['id'];
        $rmId = $this->model->get("*","bc"," and id = $bcId")->rmId;
        $this->model->update('rm',$itemb,$rmId);
      }
    } else {
      $this->model->redirect();
    }
  }

  public function Detail(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.rmId = " . $_REQUEST['id'];
      $id = $this->model->get('a.*, b.paste, b.reactor, c.company as clientname, d.name as productname','bc a',$filters,'LEFT JOIN rm b ON a.rmId = b.id LEFT JOIN users c ON b.clientId = c.id LEFT JOIN products d ON b.productId = d.id');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->model->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      $qty = $net - $id->paste;
      $status = "Bitacora";
      require_once 'views/reports/bc.php';
    } else {
      $this->model->redirect();
    }
  }

  public function IV(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $id = $_REQUEST['id'];
      $status = $_REQUEST['status'];
      require_once 'views/rm/iv.php';
    } else {
      $this->model->redirect();
    }
  }

  

}