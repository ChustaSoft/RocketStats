<?php
require_once 'models/database/BDDConexion.php';
require_once 'models/beans/Jugador.php';

class JugadoresBDD{
	
	private $SELECT_ALL = "SELECT id, codigo, nombre FROM jugadores";
	private $SELET_USER = "SELECT id, codigo, nombre, contra FROM jugadores WHERE codigo = ?";
	private $INSERT_USER = "INSERT INTO jugadores (codigo, nombre) VALUES (?, ?)";
		
	public function searchAll(){
		$user = null;
		$vector = array();
		$con = new BDDConexion();
		$resultado = $con->launchQuery($this->SELECT_ALL, $vector);
		
		if ($resultado != null) {
			foreach($resultado as $row){
				$user = new Jugador();
				$user->setId($row['id']);
				$user->setCodigo($row['codigo']);
				$user->setNombre($row['nombre']);
				
				array_push($vector, $user);
			}
		}
		
		return $vector;
	}
	
	public function searchUser($userName) {
		$user = new Jugador();
		$vector = array (
			$userName
		);
		$con = new BDDConexion();
		$resultado = $con->launchQuery($this->SELET_USER, $vector);
	
		if ($resultado != null) {
			foreach($resultado as $row){
				$user->setId($row['id']);
				$user->setCodigo($row['codigo']);
				$user->setNombre($row['nombre']);
				$user->setContra($row['contra']);
			}					
		}
		
		return $user;
	}
	
	public function insertUser($player){
		$vector = array (
			$player->getCodigo(),
			$player->getNombre()
		);
		$con = new BDDConexion();
		$con->executeQuery($this->INSERT_USER, $vector);
		
		return "OK";
	}
}

?>