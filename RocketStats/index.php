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
			//Login
			echo $cargadorVistas->validateUser();
			break;
		
		case 3:
			//Cerrar sesión
			if(isset($_SESSION ["autenticate"] ))
				echo $cargadorVistas->logout();
			else
				echo $cargadorVistas->main();
			break;
						
	}
} 
else {
	echo $cargadorVistas->main();
}

?>