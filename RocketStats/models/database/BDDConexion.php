<?php

class BDDConexion{
	
	//Atributos
	private $connectionString="mysql:host=localhost;dbname=rocketstat";
	private $user="chustasoft";
	private $password = "chustaK4";
	private $db;
	
	private function connect(){
		
		$flag=true;
		try{
			$this->db = new PDO($this->connectionString, $this->user, $this->password);
		}
		catch(PDOException $e) {
			$flag=false;
		}
		return $flag;
	}
	
	private function disconnect(){
		$this->db=null;
	}
	
	public function executeQuery($sql, $vector){
		if($this->connect()){
			$sentencia = $this->db->prepare($sql);
			$sentencia->execute($vector);
			$cuenta = $sentencia->rowCount();
			$this->disconnect();
		}
		else{
			$cuenta=-1;
		}
		return $cuenta;
	}
	
	public function launchQuery($sql, $vector){
		if($this->connect()){
			$sentencia = $this->db->prepare($sql);
			$sentencia->execute($vector);
			$this->disconnect();
		}else{
			$sentencia=null;
		}
		return $sentencia;		
	}
	
	public function executeMultipleQueries($sql, $vectorArray){
		if($this->connect()){
			$cuenta = 0;
			
			for($i=0; $i < sizeof($vectorArray); $i++){
				$sentencia = $this->db->prepare($sql);
				$sentencia->execute($vectorArray[$i]);
				$cuenta += $sentencia->rowCount();
			}
			$this->disconnect();
		}
		else{
			$cuenta=-1;
		}
		return $cuenta;		
	}
	
	public function getLastIdTable($table){
		$tmpSql = "SELECT max(id) AS LASTID FROM " . $table;
		$tmpEmptyArray = array();
		
		$resultado = $this->launchQuery($tmpSql, $tmpEmptyArray);
		
		$retrivedId =  -1;
		foreach($resultado as $row)
			$retrivedId = $row['LASTID'];
		
		return $retrivedId;
	}
	
}

?>