<?php
require_once 'models/model.php';

class IPController{
  private $model;
  public function __CONSTRUCT(){
    $this->model = new Model();
  }

  public function IP(){
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
      require_once 'views/rm/ip.php';
    } else {
      $this->model->redirect();
    }
  }

  public function Update(){
    require_once "middlewares/check.php";
    if (in_array(3, $permissions)) {
      $item = new stdClass();
      foreach($_POST as $k => $val) {
        if (!empty($val)) {
          if($k != 'id') {
            $item->{$k} = $val;
          }
        }
      }
      $item->ipAt = date("Y-m-d H:i:s");
      $item->status = 'Facturación';
      $bcId = $_REQUEST['id'];
      $rmId = $this->model->get("*","bc"," and id = $bcId")->rmId;
      $this->model->update('rm',$item,$rmId);
    } else {
      $this->model->redirect();
    }
  }

}