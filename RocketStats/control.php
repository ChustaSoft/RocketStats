<?php 
session_start();

require_once 'controllers/ControladorJugadores.php';
require_once 'controllers/ControladorEstadisticas.php';

$params = array();
foreach ($_REQUEST as $n => $v){
	$params[$n] = $v;
}

if (isset($params['action'])){
	
	switch ($params['action']){
		case 6:
			//Añadir nuevo jugador
			if(isset($_SESSION ["autenticate"] )){
				$controlador = new ControladorJugadores();
				$jugadorJsonObject = json_decode(stripslashes($params['JSONData']));
				echo $controlador->addJugador($jugadorJsonObject);
			}
			break;
			
		case 7:
			//Obtener todos los jugadores
			if(isset($_SESSION ["autenticate"] )){
				$controlador = new ControladorJugadores();
				
				$users = $controlador->obtenerTodosJugadores();
				$usersArray = array();
				foreach($users as $user){
					$usersArray[] = $user->getMap();
				}
				
				echo json_encode($usersArray);
			}
			break;

		default:
			echo "Action not correct";
			break;
	}
}

?>