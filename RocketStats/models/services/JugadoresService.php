<?php
require_once 'models/beans/Jugador.php';

class JugadoresService{
	/*
	 * Validará dos usuarios para el login 
	 */
	public function validarUsuario($originalUser, $obtainedUser){
		if($originalUser->getCodigo() == $obtainedUser->getCodigo() && $originalUser->getContra() == $obtainedUser->getContra()){
			return true;
		}
		else return false;
	}
}

?>