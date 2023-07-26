<?php
class Clients {

    private $pdo;
    public function __CONSTRUCT() {
        try {
            $this->pdo = Database::Conectar();
            $pdo = null;
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }

    public function list($filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM clients
            WHERE 1=1
            $filters
            ORDER BY name ASC
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($id) {
        try {
            $stm = $this->pdo->prepare("SELECT * 
            FROM clients 
            WHERE id = ?");
            $stm->execute(array($id));
            return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($item) {
        try {
            $sql = "INSERT INTO clients (name,company,email,tel1,tel2,city) VALUES (?,?,?,?,?,?)";
			$this->pdo->prepare($sql)->execute(
                array(
                    $item->name,
                    $item->company,
                    $item->email,
                    $item->tel1,
                    $item->tel2,
                    $item->city
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function update($item) {
        try {
            $sql = "UPDATE clients SET name = ?,company = ?,email = ?,tel1 = ?,tel2 = ?,city = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(
                array(
                    $item->name,
                    $item->company,
                    $item->email,
                    $item->tel1,
                    $item->tel2,
                    $item->city,
                    $item->clientId
                )
            );
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

}