<?php
require_once 'models/beans/Jugador.php';

class JugadoresService{
	
	public function validarUsuario($user1, $user2){
		if($user1->getCodigo() == $user2->getCodigo() && $user1->getContra() == $user2->getContra()){
			return true;
		}
		else return false;
	}
}

?>