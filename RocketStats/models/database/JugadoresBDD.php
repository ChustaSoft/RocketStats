<?php
require_once 'models/database/BDDConexion.php';
require_once 'models/beans/Jugador.php';

class JugadoresBDD{
	
	private $SELET_USER = "SELECT id, codigo, nombre, contra FROM jugadores WHERE codigo = ?";
	
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
}

?>