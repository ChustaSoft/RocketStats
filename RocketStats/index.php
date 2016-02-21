<?php
require_once ("views/CargadorVistas.php");
session_start ();

$cargadorVistas = new CargadorVistas();

$action = 1;

if( isset($_SESSION["sessionUserName"]) ){
	$action = 2;
}

if( isset($_GET["action"]) ){
	$action = $_GET["action"];
}

switch( $action ){
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
		if(isset($_SESSION ["sessionUserName"] ))
			echo $cargadorVistas->logout();
		else
			echo $cargadorVistas->main();
		break;

	case 4:
		//Cargar vista de jugadores
		if(isset($_SESSION ["sessionUserName"] ))
			echo $cargadorVistas->setJugadoresView();
		else
			echo $cargadorVistas->main();
		break;

	case 5:
		//Cargar vista de estadisticas
		if(isset($_SESSION ["sessionUserName"] ))
			echo $cargadorVistas->setEstadisticasView();
		else
			echo $cargadorVistas->main();
		break;
}