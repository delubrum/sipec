<?php
require_once 'models/init.php';

class CertificateController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    if (in_array(5, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/certificate/index.php';
    } else {
      $this->init->redirect();
    }
  }

  public function Data(){
    header('Content-Type: application/json');
    require_once "middlewares/check.php";
    if (in_array(5, $permissions)) {
      $result[] = array();
      $i=0;
      foreach($this->init->list('MONTH(closedAt) as date','rm',"and clientId = $user->id and closedAt is not null GROUP BY MONTH(closedAt), YEAR(closedAt)",'') as $r) {
        if ((date('n') != $r->date) or (date("Y-m-l") < date("Y-m-d"))) {
          $date = date('Y-m-d', mktime(0, 0, 0, $r->date, 1));
          $result[$i]['date'] = date('Y-M', mktime(0, 0, 0, $r->date, 1));
          $result[$i]['action'] = "<a href='?c=Certificate&a=Certificate&date=$date' type='button' target='_blank' class='btn btn-info float-right mx-1'><i class='fas fa-eye'></i></a>";
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

  

}