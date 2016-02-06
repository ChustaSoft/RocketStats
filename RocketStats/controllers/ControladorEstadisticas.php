<?php
require_once 'models/beans/EstadisticasJugador.php';
require_once 'models/beans/EstadisticasPartido.php';
require_once 'models/database/EstadisticasBDD.php';

class ControladorEstadisticas{
	
	private $estadisticasDb = null;
	
	public function __construct(){
		$this->estadisticasDb = new EstadisticasBDD();
	}
	
	public function addPartido($aJsonPartido){
		$partido = new EstadisticasPartido();
		$partido->createFromJsonObject($aJsonPartido);
		
		return $this->estadisticasDb->insertPartido($partido);
	}
	
	public function getEstadisticasJugadorByTipoPartido($tipoPartido){
		return $this->estadisticasDb->getEstadisticasPorTipoPartido($tipoPartido);
	}
	
}

?>