<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'models/users.php';
require_once 'models/init.php';

class RMController{
  private $model;
  public function __CONSTRUCT(){
    $this->users = new Users();
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
      $filters = "and id = " . $_REQUEST['client'];
      foreach(json_decode($this->init->get('products','clients',$filters)->products) as $r) {
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
      foreach($this->init->list('a.*,b.company as clientname, c.name as productname','rm a','','LEFT JOIN clients b ON a.clientId=b.id LEFT JOIN products c ON a.productId = c.id') as $r) {
        $result[$i]['Date'] = $r->date;
        $result[$i]['Client'] = $r->clientname;
        $result[$i]['Product'] = $r->productname;
        switch (true) {
            case (!$r->enteredAt):
                $status = 'Registrando';
                break;
            case ($r->enteredAt):
              $status = 'Pendiente';
              break;
        }
        $result[$i]['Status'] = $status;
        $result[$i]['Action'] = "<button type='button' data-id='$r->id' data-status='$status' class='btn btn-primary float-right mx-1 action'> <i class='fas fa-pen'></i></a>";
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
      $id = $this->init->get('a.*,b.company as clientname, c.name as productname','rm a',$filters,'LEFT JOIN clients b ON a.clientId=b.id LEFT JOIN products c ON a.productId = c.id');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->init->get('SUM(net) as total','rm_items',$filters)->total;
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
      $i=0;$kg=0;$kg_client=0;$tara=0;$tara_client=0;$net=0;$net_client=0;
      $filters = "and rmId = " . $_REQUEST['id'];

      foreach($this->init->list('*','rm_items',$filters) as $r) {
        $result[$i]['Index'] = "<b class='text-primary'>" . $i+1 . "</b>";
        $disabled = ($_REQUEST['status'] != 'Registrando') ? 'disabled' : 'required';
        $disabledb = ($_REQUEST['status'] == 'Registrando') ? '' : 'required';

        $kg += $r->kg;
        $result[$i]['kg'] = "<input class='input' data-id='$r->id' data-field='kg' type='number' step='0.01' min='0' value='$r->kg' $disabled>";
        $kg_client += $r->kg_client;
        $result[$i]['kg_client'] = "<input class='input' data-id='$r->id' data-field='kg_client' type='number' step='0.01' min='0' value='$r->kg_client' $disabledb>";

        
        if($_REQUEST['status'] != 'Registrando') {
          $tara += $r->tara;
          $result[$i]['tara'] = "<input class='input' data-id='$r->id' data-field='tara' type='number' step='0.01' min='0' value='$r->tara' required>";
          $tara_client += $r->tara_client;
          $result[$i]['tara_client'] = "<input class='input' data-id='$r->id' data-field='tara_client' type='number' step='0.01' min='0' value='$r->tara_client' required>";
          $net += $r->net;
          $result[$i]['net'] = "<input class='input' data-id='$r->id' data-field='net' type='number' step='0.01' min='0' value='$r->net' required>";
          $net_client += $r->net_client;
          $result[$i]['net_client'] = "<input class='input' data-id='$r->id' data-field='net_client' type='number' step='0.01' min='0' value='$r->net_client' required>"; 
        }

        
        $si = ($r->status == 'Bueno') ? 'selected' : '';
        $no = ($r->status == 'Malo') ? 'selected' : '';
        $result[$i]['Status'] = "<select class='input' data-id='$r->id' data-field='status' $disabled>
          <option></option>
          <option $si>Bueno</option>
          <option $no>Malo</option>
        </select>";
        $si = ($r->leaks == 'Si') ? 'selected' : '';
        $no = ($r->leaks == 'No') ? 'selected' : '';
        $result[$i]['Leaks'] ="<select class='input' data-id='$r->id' data-field='leaks' $disabled>
          <option></option>
          <option $si>Si</option>
          <option $no>No</option>
        </select>";
        $spills = ($r->spills) ? $r->spills : '[]';
        $carro = (in_array('Vehículo',json_decode($spills))) ? 'btn-info' : 'btn-secondary';
        $caneca = (in_array('Caneca',json_decode($spills))) ? 'btn-info' : 'btn-secondary';
        $plantab = (in_array('Planta',json_decode($spills))) ? 'btn-info' : 'btn-secondary';
        $planta = ($_REQUEST['status'] != 'Registrando') ? "<label type='button' class='btn $plantab btn-sm spills input'>Planta</label>" : "";
        $result[$i]['Spills'] = "<div data-id='$r->id'>
        <label type='button' class='btn $carro btn-sm spills input'>Vehículo</label>
        <label type='button' class='btn $caneca btn-sm spills input'>Caneca</label>
        $planta
        </div>
        ";
        $result[$i]['Action'] = "<i type='button' class='text-danger fas fa-trash delete' data-id='$r->id'>";
        $i++;
      }

      $result[$i]['Index'] = "<b class='text-primary'>Σ</b>";
      $result[$i]['kg'] = "<b class='text-primary'>$kg</b>";
      $result[$i]['kg_client'] = "<b class='text-primary'>$kg_client</b>";
      if($_REQUEST['status'] != 'Registrando') {
        $result[$i]['tara'] = "<b class='text-primary'>$tara</b>";
        $result[$i]['tara_client'] = "<b class='text-primary'>$tara_client</b>";
        $result[$i]['net'] = "<b class='text-primary' id='net'>$net</b>";
        $result[$i]['net_client'] = "<b class='text-primary'>$net_client</b>";
      }
      $result[$i]['Status']='';
      $result[$i]['Leaks']='';
      $result[$i]['Spills']='';
      $result[$i]['Action'] = "";



      echo json_encode($result);
    } else {
      $this->init->redirect();
    }
  }

  public function SaveItem(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $item->rmId = $_REQUEST['id'];
      $id = $this->init->save('rm_items',$item);
      echo $id;
    } else {
      $this->init->redirect();
    }
  }

  public function DeleteItem(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $filters = "id = " . $_REQUEST['id'];
      $this->init->delete('rm_items',$filters);
    } else {
      $this->init->redirect();
    }
  }

  public function UpdateItem(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $id = $_REQUEST['id'];
      $item->{$_REQUEST['field']} = $_REQUEST['value'];
      $this->init->update('rm_items',$item,$id);
      print_r($item);
    } else {
      $this->init->redirect();
    }
  }

  public function Update(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      if ($_REQUEST['status'] == 'Registrando') {
        $item->enteredAt = date("Y-m-d H:i:s");
      }
      $this->init->update('rm',$item,$_REQUEST['id']);
      echo $_REQUEST['id'];
    } else {
      $this->init->redirect();
    }
  }

  

}