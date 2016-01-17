<?php
require_once ("views/CargadorVistas.php");
session_start ();

$cargadorVistas = new CargadorVistas();

if (isset ( $_GET ["action"]) ){
	
	switch ($_GET ["action"]) {
		
		case 1:
			//Establecer login
			echo $cargadorVistas->validateForm();
			break;
		
		case 2:
			//Validar usuario del login
			echo $cargadorVistas->validateUser();
			break;
		
		case 3:
			//Cerrar sesión activa
			if(isset($_SESSION ["autenticate"] ))
				echo $cargadorVistas->logout();
			else
				echo $cargadorVistas->main();
			break;
			
		case 4:
			//Cargar vista de jugadores
			if(isset($_SESSION ["autenticate"] ))
				echo $cargadorVistas->setJugadoresView();
			else
				echo $cargadorVistas->main();
			break;
			
		case 5:
			//Cargar vista de estadisticas
			if(isset($_SESSION ["autenticate"] ))
				echo $cargadorVistas->setEstadisticasView();
			else
				echo $cargadorVistas->main();
			break;		
		
	}
} 
else {
	echo $cargadorVistas->main();
}

?>