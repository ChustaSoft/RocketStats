<?php
require_once 'models/beans/Jugador.php';
require_once 'models/database/JugadoresBDD.php';
require_once 'models/services/JugadoresService.php';

class ControladorJugadores{
	
	private $jugadoresDb;
	private $jugadoresService;
	
	public function __construct(){
		$this->jugadoresDb = new JugadoresBDD();
		$this->jugadoresService = new JugadoresService();
	}
	
	public function getJugador($userName){
		return $this->jugadoresDb->searchUser($userName);
	}
	/*
	 * Recibir� un usuario y contrase�a, recuperar� mediante el c�digo dicho usuario y comparar� si
	 * el login es correcto
	 */
	public function validarJugador($userName, $userPassword){
		$originalUser = new Jugador();
		$originalUser->setCodigo($userName);
		$originalUser->setContra(md5($userPassword));
		$user = $this->getJugador($userName);
		
		$flag = $this->jugadoresService->validarUsuario($originalUser, $user);
		
		if($flag)
			return $user;
		else{
			$originalUser->setId(-1);
			return $originalUser;
		}
	}
	
}


?>