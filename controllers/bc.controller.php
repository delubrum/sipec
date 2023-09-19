<?php
require_once 'models/init.php';

class BCController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
  }

  public function BC(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.rmId = " . $_REQUEST['id'];
      $id = $this->init->get('a.*, b.paste, b.reactor, c.company as clientname, d.name as productname','bc a',$filters,'LEFT JOIN rm b ON a.rmId = b.id LEFT JOIN users c ON b.clientId = c.id LEFT JOIN products d ON b.productId = d.id');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->init->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      $qty = $net - $id->paste;
      $status = $_REQUEST['status'];
      require_once 'views/rm/bc.php';
    } else {
      $this->init->redirect();
    }
  }

  public function UpdateData(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $item->{$_REQUEST['field']} = json_encode($_REQUEST['data']);
      $id = $this->init->update('bc',$item,$_REQUEST['id']);
      // print_r($item);
    } else {
      $this->init->redirect();
    }
  }

  public function TurnsData(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $result[] = array();
      $i=0;
      $filters = "and id = " . $_REQUEST['id'];
      echo $this->init->get('turns','bc',$filters)->turns;
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
      $filters = "and id = " . $_REQUEST['id'];
      echo $this->init->get('data','bc',$filters)->data;
    } else {
      $this->init->redirect();
    }
  }

  public function ItemsDatab(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $result[] = array();
      $i=0;
      $filters = "and bcId = " . $_REQUEST['id'];
      foreach($this->init->list('*','bc_items',$filters) as $r) {
        $index = ($i == 0) ? 'Cabeza' : $i;
        $net = ($i == 0) ? '' : "<input class='input' data-id='$r->id' data-field='net' type='number' step='0.01' min='0' value='$r->net' required>";
        $drum = ($i == 0) ? '' : "<input class='input' data-id='$r->id' data-field='drum' type='number' step='1' min='0' value='$r->drum' required>";
        $result[$i]['index'] = "<b class='text-primary'>" . $index . "</b>";
        $result[$i]['date'] = "<input class='input' data-id='$r->id' data-field='date' type='date' onfocus='this.showPicker()' value='$r->date' required>";
        $result[$i]['net'] = $net;
        $result[$i]['drum'] = $drum;
        $result[$i]['start'] = "<input class='input' data-id='$r->id' data-field='start' type='time' onfocus='this.showPicker()' value='$r->start' required>";
        $result[$i]['end'] = "<input class='input' data-id='$r->id' data-field='end' type='time' onfocus='this.showPicker()' value='$r->end' required>";
        $result[$i]['t0'] = "<input class='input' data-id='$r->id' data-field='t_0' type='number' step='0.01' min='0' value='$r->t_0' required>";
        $result[$i]['t1'] = "<input class='input' data-id='$r->id' data-field='t_1' type='number' step='0.01' min='0' value='$r->t_1' required>";
        $result[$i]['boilerTime'] = "<input class='input' data-id='$r->id' data-field='boiler_time' type='time' onfocus='this.showPicker()' value='$r->boiler_time' required>";
        $result[$i]['boilerT'] = "<input class='input' data-id='$r->id' data-field='boiler_t' type='number' step='0.01' min='0' value='$r->boiler_t' required>";
        $options = "<option value=''></option>";
        foreach ($this->init->list("*","users"," and type = 'Operario' and status = 1") as $u) {  
          $check = ($r->userId == $u->id) ? 'selected' : '';
          $options .= "<option value='$u->id' $check> $u->username </option>";
        }
        $result[$i]['user'] = "<select class='input' data-id='$r->id' data-field='userId' required> $options </select>";
        $result[$i]['action'] = "<button class='btn btn-danger delete' data-id='$r->id'><i class='fas fas fa-trash'></i></button>";
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
      $item->bcId = $_REQUEST['id'];
      $id = $this->init->save('bc_items',$item);
      echo $id;
    } else {
      $this->init->redirect();
    }
  }

  public function SaveTurn(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $item->bcId = $_REQUEST['id'];
      $id = $this->init->save('bc_turns',$item);
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
      $this->init->delete('bc_items',$filters);
    } else {
      $this->init->redirect();
    }
  }

  public function DeleteTurn(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $filters = "id = " . $_REQUEST['id'];
      $this->init->delete('bc_turns',$filters);
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
      $this->init->update('bc_items',$item,$id);
      print_r($item);
    } else {
      $this->init->redirect();
    }
  }

  public function UpdateTurn(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $id = $_REQUEST['id'];
      $item->{$_REQUEST['field']} = $_REQUEST['value'];
      $this->init->update('bc_turns',$item,$id);
      print_r($item);
    } else {
      $this->init->redirect();
    }
  }

  public function Update(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      $itemb = new stdClass();
      if (isset($_REQUEST['field'])) {
        $item->{$_REQUEST['field']} = $_REQUEST['value'];
      } else {
        $item->closedAt = date("Y-m-d H:i:s");
        $itemb->bcAt = date("Y-m-d H:i:s");
        $bcId = $_REQUEST['id'];
        $rmId = $this->init->get("*","bc"," and id = $bcId")->rmId;
        $this->init->update('rm',$itemb,$rmId);
      }
      $this->init->update('bc',$item,$_REQUEST['id']);
    } else {
      $this->init->redirect();
    }
  }

  public function Detail(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $filters = "and a.rmId = " . $_REQUEST['id'];
      $id = $this->init->get('a.*, b.paste, b.reactor, c.company as clientname, d.name as productname','bc a',$filters,'LEFT JOIN rm b ON a.rmId = b.id LEFT JOIN users c ON b.clientId = c.id LEFT JOIN products d ON b.productId = d.id');
      $filters = "and rmId = " . $_REQUEST['id'];
      $net = $this->init->get('SUM(kg-tara) as total','rm_items',$filters)->total;
      $qty = $net - $id->paste;
      $status = "Bitacora";
      require_once 'views/reports/bc.php';
    } else {
      $this->init->redirect();
    }
  }

  

}