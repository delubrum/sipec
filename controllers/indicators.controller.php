<?php
require_once 'models/init.php';

class IndicatorsController{
  private $model;
  public function __CONSTRUCT(){
    $this->init = new Init();
  }

  public function Index(){
    require_once "middlewares/check.php";
    if (in_array(5, $permissions)) {
      require_once 'views/layout/header.php';
      require_once 'views/reports/indicators.php';
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
      for ($i = 0; $i < 12; $i++) {
        $result[$i]['date'] = date('M', mktime(0, 0, 0, $i+1, 1));
        $result[$i]['cd'] = 22000;
        $result[$i]['ce'] = 22000;
        $result[$i]['ct'] = $result[$i]['cd'] + $result[$i]['ce'];
        $result[$i]['pd'] = 22000;
        $result[$i]['ppd'] = $result[$i]['pd']/$result[$i]['cd']*100 . " %";
        $result[$i]['pe'] = 22000;
        $result[$i]['ppe'] = $result[$i]['pe']/$result[$i]['ce']*100 . " %";
        $result[$i]['pt'] = $result[$i]['pd'] + $result[$i]['pe'];
        $result[$i]['ld'] = 22000;
        $result[$i]['pld'] = $result[$i]['ld']/$result[$i]['cd']*100 . " %";
        $result[$i]['le'] = 22000;
        $result[$i]['ple'] = $result[$i]['le']/$result[$i]['ce']*100 . " %";
        $result[$i]['lt'] = $result[$i]['ld'] + $result[$i]['le'];
      }
      echo json_encode($result);
    } else {
      $this->init->redirect();
    }
  } 

}