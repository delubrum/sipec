<?php
require_once 'models/init.php';

class CertificateController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
  }

  public function Month(){
    require_once "middlewares/check.php";
    if (in_array(5, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/certificates/month.php';
    } else {
      $this->init->redirect();
    }
  }

  public function MonthData(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(5, $permissions)) {
      $result[] = array();
      $i=0;
      foreach($this->init->list('MONTH(closedAt) as date','rm',"and clientId = $user->id and closedAt is not null GROUP BY MONTH(closedAt), YEAR(closedAt)",'') as $r) {
        if ((date('n') != $r->date) or (date("Y-m-l") < date("Y-m-d"))) {
          $date = date('Y-m-d', mktime(0, 0, 0, $r->date, 1));
          $result[$i]['date'] = date('Y-M', mktime(0, 0, 0, $r->date, 1));
          $result[$i]['action'] = "<a href='?c=Certificate&a=Certificate&date=$date' type='button' target='_blank' class='btn btn-primary float-right mx-1'><i class='fas fa-eye'></i></a>";
        }
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->init->redirect();
    }
  }

  public function Certificate(){
    require_once "middlewares/check.php";
    if (in_array(5, $permissions)) {
      require_once 'views/reports/certificate.php';
    } else {
      $this->init->redirect();
    }
  }

  public function PD(){
    require_once "middlewares/check.php";
    if (in_array(8, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/certificates/pd.php';
    } else {
      $this->init->redirect();
    }
  }

  public function PDData(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(8, $permissions)) {
      $result[] = array();
      $i=0;
      foreach($this->init->list('a.*,b.company as clientname, c.name as productname','rm a'," and clientId = $user->id and a.status = 'Cerrado'",'LEFT JOIN users b ON a.clientId = b.id LEFT JOIN products c ON a.productId = c.id') as $r) {
        $result[$i]['id'] = $r->id;
        $result[$i]['date'] = $r->date;
        $result[$i]['product'] = $r->productname;
        $pd = "<a href='?c=RM&a=PD&id=$r->id' type='button' target='_blank' class='btn btn-primary float-right m-1'><i class='fas fa-eye'></i> Ver</a>";
        $result[$i]['action'] = "$pd";
        $i++;
      }
      echo json_encode($result);
    } else {
      $this->init->redirect();
    }
  }

  

}