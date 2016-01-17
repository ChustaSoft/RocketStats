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
	
	/*
	 * Obtiene un jugador por su userName (id de steam)
	 */
	public function getJugador($userName){
		return $this->jugadoresDb->searchUser($userName);
	}
	
	/*
	 * Recibirá un usuario y contraseña, recuperará mediante el código dicho usuario y comparará si
	 * el login es correcto
	 */
	public function validarJugador($userName, $userPassword){
		$originalUser = new Jugador();
		$originalUser->setCodigo($userName);
		$originalUser->setContra(md5($userPassword));
		$obtainedUser = $this->getJugador($userName);
		
		$flag = $this->jugadoresService->validarUsuario($originalUser, $obtainedUser);
		
		if($flag)
			return $obtainedUser;
		else{
			$originalUser->setId(-1);
			return $originalUser;
		}
	}
	
	public function addJugador($jugadorJsonObject){
		$jugadorNuevo = new Jugador();
		$jugadorNuevo->createFromJsonObject($jugadorJsonObject);
		
		return $this->jugadoresDb->insertUser($jugadorNuevo);
	}
	
	public function obtenerTodosJugadores(){
		return $this->jugadoresDb->searchAll();
	}
	
}


?>