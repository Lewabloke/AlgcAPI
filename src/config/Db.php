<?php
include 'dbconfig.php';

class Db {

	private $host =    DB_HOST;
	private $db_user = DB_USER;
	private $db_pass = DB_PASS;
	private $db_name = DB_NAME;

	private $dbh;
	private $error;
	private $stmt;

	public function __construct(){

		$dsn = 'mysql:host='. $this->host .';dbname='. $this->db_name;
		$options = array(
			PDO::ATTR_ERRMODE => 'ERRMODE_EXCEPTION',
			PDO::ATTR_PERSISTENT => true
		);

		try {
			$this->dbh = new PDO($dsn,$this->db_user,$this->db_pass, $options);	
		} catch (PDOException $e) {
			$this->error = $e->getMessage();	
		}
	}

	public function query($query){
		$this->stmt = $this->dbh->prepare($query);
	}

	public function bind($param,$value,$type = null){
		if(is_null($type)){
			switch (true) {
				case is_int($value):
					$type = PDO::PARAM_INT;
					break;
				case is_bool($value):
					$type = PDO::PARAM_BOOL;
					break;
				case is_null($value):
					$type = PDO::PARAM_NULL;
					break;
				
				default:
					$type = PDO::PARAM_STR;
					break;
			}
		}

		$this->stmt->bindValue($param,$value,$type);
	}

	public function execute(){
		return $this->stmt->execute();
	}

	public function resultset(){
		$this->execute();
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	public function single(){
		$this->execute();
		return $this->stmt->fetch(PDO::FETCH_ASSOC);
	}

	public function rowCount(){
		return $this->stmt->rowCount();
	}

	public function lastInsertId(){
		return $this->stmt->lastInsertId();
	}

	public function beginTransaction(){
		return $this->dbh->beginTransaction();
	}

	public function endTransaction(){
		return $this->dbh->commit();
	}

	public function cancelTransaction(){
		return $this->dbh->rollBack();
	}

	public function debugDumpParams(){
		return $this->dbh->debugDumpParams();
	}

}