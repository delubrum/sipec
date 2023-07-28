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
      $i=0;
      $filters = "and rmId = " . $_REQUEST['id'];
      foreach($this->init->list('*','rm_items',$filters) as $r) {
        $result[$i]['Index'] = $i+1;
        $result[$i]['kg'] = "<input class='kg' type='number' step='0.01' min='0' value='$r->kg' tabindex='$i+1+1'>";
        $result[$i]['Status'] = "<select>
          <option></option>
          <option>Bueno</option>
          <option>Malo</option>
        </select>";
        $result[$i]['Leaks'] = "<select>
        <option></option>
        <option>Si</option>
        <option>No</option>
        </select>";
        $spills = ($r->spills) ? $r->spills : '[]';
        $button = (in_array('Vehículo',json_decode($spills))) ? 'btn-info' : 'btn-secondary';
        $disabled = (in_array('Vehículo',json_decode($spills))) ? '' : 'disabled';
        $planta = ($_REQUEST['status'] != 'Registrando') 
        ? "<label type='button' class='btn $button btn-sm m-0 spills'>
        Planta
        <input type='hidden' name='spills[$r->id][]'' value='Vehículo' $disabled>
        </label>  
        " : "";
        $result[$i]['Spills'] = "<label type='button' class='btn $button btn-sm m-0 spills'>
          Vehículo
          <input type='hidden' name='spills[$r->id][]'' value='Vehículo' $disabled>
        </label>
        <label type='button' class='btn $button btn-sm m-0 spills'>
          Caneca
          <input type='hidden' name='spills[$r->id][]'' value='Vehículo' $disabled>
        </label>
        $planta
        ";
        $result[$i]['Action'] = "<i type='button' class='text-danger fas fa-trash delete' data-id='$r->id'>";
        $i++;
      }
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

  

}