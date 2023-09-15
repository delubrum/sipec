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

    public function log($query) {
        // if(!isset($_SESSION)) { 
        //     session_start(); 
        // }
        // $userId = $_SESSION["id-SIPEC"];
        // $query = addslashes($query);
        // $query = trim(preg_replace( "/\r|\n/", "", $query));
        // $query = preg_replace('/\s+/', ' ', $query);
        // try {
        //     $sql = "INSERT INTO log (query,userId) VALUES (
        //         '$query',
        //         '$userId'
        //     )";
		// 	$this->pdo->prepare($sql)->execute();
        // }
        //     catch (Exception $e) {
        //     die($e->getMessage());
        // }    
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
            $id = $this->pdo->lastInsertId();
            $this->log($sql);
            return $id;
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
            $this->log($sql);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function delete($table,$filters) {
        try {
            $sql = "DELETE FROM $table 
            WHERE $filters
            ";
            $this->pdo->prepare($sql)->execute();
            $this->log($sql);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function list($fields,$table,$filters = '',$joins = '') {
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

    public function get($fields,$table,$filters = '',$joins = '') {
        try {
            $sql = "SELECT $fields
            FROM $table
            $joins
            WHERE 1=1
            $filters
            ";
            $stm = $this->pdo->prepare($sql);
            $stm->execute();
            return $stm->fetch(PDO::FETCH_OBJ);
        }
            catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function redirect() {
        header("location: 403.php");
    }
    
}