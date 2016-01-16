<?php

class BDDConexion{
	
	//Atributos
	private $connectionString="mysql:host=localhost;dbname=rocketstat";
	private $user="root"; //usuario de la BBDD con permisos filtrados
	private $password = <<<'EOD'
Ma$t3r755
EOD;
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
	
}

?>