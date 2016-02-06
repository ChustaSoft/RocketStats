<?php
require_once 'models/beans/EstadisticasJugador.php';
require_once 'models/beans/EstadisticasPartido.php';

class EstadisticasBDD{
	
	private $INSERT_INTO_ESTADISTICAS_PARTIDOS = "INSERT INTO estadisticas_partido (tipo_partido, id_jugador, victoria, mvp, puntaje, goles, asistencias, salvadas, tiros) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	
	public function insertPartido($partido){
		$arrayVectorData = array();
		
		foreach ($partido->getEstadisticas() as $estadisticaPartido){
			$tmpVector = array(
				$partido->getTipo(),
				$estadisticaPartido->getJugador(),
				$estadisticaPartido->getVictoria(),
				$estadisticaPartido->getMvp(),
				$estadisticaPartido->getPuntaje(),
				$estadisticaPartido->getGoles(),
				$estadisticaPartido->getAsistencias(),
				$estadisticaPartido->getSalvadas(),
				$estadisticaPartido->getTiros()
			);
			
			array_push($arrayVectorData, $tmpVector);
		}
		
		$con = new BDDConexion();
		$con->executeMultipleQueries($this->INSERT_INTO_ESTADISTICAS_PARTIDOS, $arrayVectorData);

		return "OK";
	}
		
}


?>