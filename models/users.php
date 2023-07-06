<?php
class Users {
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

    public function PermissionsList($category) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM permissions
            WHERE category = ?
            ORDER BY sort,name ASC");
            $stm->execute(array($category));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function PermissionsTitleList() {
        try {
            $stm = $this->pdo->prepare("SELECT DISTINCT(category)
            FROM permissions
            ORDER BY sort,category ASC");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }
}