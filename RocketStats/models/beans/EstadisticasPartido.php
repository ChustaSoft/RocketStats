<?php
require_once 'models/beans/EstadisticasJugador.php';
	
class EstadisticasPartido{
	
	private $id;
	private $tipo;
		
	private $listaEstadisticasJugadores = array();
	
	public function createFromJsonObject($partidoJsonObject){
		$this->tipo = $partidoJsonObject->tipo;
		
		foreach ($partidoJsonObject->estadisticasJugadores as $estadisticaJugadorJson){
			$estadisticaJugador = new EstadisticasJugador();
			$estadisticaJugador->createFromJsonObject($estadisticaJugadorJson);
			array_push($this->listaEstadisticasJugadores, $estadisticaJugador);
		}
		
	}
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}
	
	public function getTipo(){
		return $this->tipo;
	}

	public function setEstadisticas($estadisticas){
		$this->listaEstadisticasJugadores = $estadisticas;
	}
	
	public function getEstadisticas(){
		return $this->listaEstadisticasJugadores;
	}
	
}

?>