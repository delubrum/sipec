<?php

class Purchases {
    private $pdo;
    public function __CONSTRUCT() {
        try {
            $this->pdo = Database::Conectar();
            $pdo = null;
        }
            catch(Exception $e) {
            die($e->getMessage());
        }
    }
    
    public function getQty($productId){
        try {
            $stm = $this->pdo->prepare("SELECT sum(qty) as total
            FROM purchases
            WHERE productId = '$productId'
            AND cancelledAt is null
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }


}