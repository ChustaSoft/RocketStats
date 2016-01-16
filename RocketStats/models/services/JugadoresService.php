<?php
require_once 'models/beans/Jugador.php';

class JugadoresService{
	/*
	 * Validará dos usuarios para el login 
	 */
	public function validarUsuario($user1, $user2){
		//TODO: Deben ser usuario original y recuperado. Si el recuperado tiene password null debe lanzar directamente un false (jugador sin user)
		if($user1->getCodigo() == $user2->getCodigo() && $user1->getContra() == $user2->getContra()){
			return true;
		}
		else return false;
	}
}

?>