<?php

class Init {
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

    public function navTitleList() {
        try {
            $stm = $this->pdo->prepare("SELECT DISTINCT id, title, c, icon
            FROM permissions
            WHERE type = 'menu'
            GROUP BY title
            ORDER BY sortm ASC");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function navSubtitleList($title) {
        try {
            $stm = $this->pdo->prepare("SELECT *
            FROM permissions
            WHERE type = 'menu'
            AND title = ?
            ORDER BY sort ASC");
            $stm->execute(array($title));
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function save($table,$item) {
        $keys = '';
        $vals = '';
        foreach ($item as $k => $v) {
            $vals .= "'$v" . "',";
            $keys .= $k .',';
        }
        $keys = rtrim($keys, ",");
        $vals = rtrim($vals, ",");
        try {
            $sql = "INSERT INTO $table ($keys) VALUES ($vals)";
			$this->pdo->prepare($sql)->execute();
            return $this->pdo->lastInsertId();
        }
            catch (Exception $e) {
            die($e->getMessage());
        }    
    }

    public function update($table,$item,$id) {
        $vals = '';
        foreach ($item as $k => $v) {
            $vals .= $k . " = '$v" . "',";
        }
        $vals = rtrim($vals, ",");
        try {
            $sql = "UPDATE $table 
                SET $vals 
                WHERE id = '$id'";
            $this->pdo->prepare($sql)->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function updateField($table,$field,$value,$id) {
        try {
            $stm = $this->pdo->prepare("UPDATE $table 
                SET $field = '$value' 
                WHERE id = $id
                ");
            $stm->execute();
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function list($fields,$table,$joins = '',$filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT $fields
            FROM $table
            $joins
            WHERE 1=1
            $filters
            ");
            $stm->execute();
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function get($fields,$table,$id,$joins = '',$filters = '') {
        try {
            $stm = $this->pdo->prepare("SELECT $fields
            FROM $table
            $joins
            WHERE id = $id
            $filters
            ");
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }
    
}