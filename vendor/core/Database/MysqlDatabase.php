<?php
namespace Core\Database;
use \PDO;

/**
* connexion a la base de donnée
*/
class MysqlDatabase extends Database
{
	
	private $db_name;
	private $db_user;
	private $db_pass;
	private $db_host;
	private $pdo;


	function __construct($db_name, $db_user='root', $db_pass='', $db_host='localhost')
	{
			$this->db_name= $db_name;
			$this->db_user= $db_user;
			$this->db_pass= $db_pass;
			$this->db_host= $db_host;
	}

	private function getPdo(){
		if($this->pdo === null){
		 	$pdo = new PDO('mysql:dbname='.$this->db_name.';host='.$this->db_host.';charset=UTF8',
		 	 			$this->db_user,
		 	 			$this->db_pass);

  			$pdo->setAttribute(	PDO::ATTR_ERRMODE,
  								PDO::ERRMODE_EXCEPTION);
  			$this->pdo = $pdo;
  		}
  		return $this->pdo;
	}

	public function query(	$statement,
	 						$class_name = null,
	 						$one= false){

		$req = $this->getPdo()->query($statement);
		if (
			strpos($statement, 'UPDATE') === 0 ||
			strpos($statement, 'INSERT') === 0 ||
			strpos($statement, 'DELETE') === 0
			) {
			return $req;
		}
		if (is_null($class_name)) {
			$req->setFetchMode(PDO::FETCH_OBJ);
		}else{
			$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
		}
		if ($one===false){
			$datas= $req->fetchAll();
		}else{
			$datas= $req->fetch();
		}
		return $datas;
	}
	public function prepare(
					$statement,
					$parametre, 
					$class_name = null, 
					$one = false){
		
		$req = $this->getPdo()->prepare($statement);
		$res = $req->execute($parametre);
		if (
			strpos($statement, 'UPDATE') === 0 ||
			strpos($statement, 'INSERT') === 0 ||
			strpos($statement, 'DELETE') === 0
			) {
			return $res;
		}
		if (is_null($class_name)) {
			$req->setFetchMode(PDO::FETCH_OBJ);
		}else{
			$req->setFetchMode(PDO::FETCH_CLASS, $class_name);
		}
		if ($one===false){
			$datas= $req->fetchAll();
		}else{
			$datas= $req->fetch();
		}
		return $datas;
	}
}