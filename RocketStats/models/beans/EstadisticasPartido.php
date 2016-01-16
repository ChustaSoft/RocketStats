<?php
	
class EstadisticasPartido{
	
	private $id;
	
	private $tipo;
	private $victoria;
	
	private $listaEstadisticasJugadores;
	
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
		return $tipo;
	}
	
	public function setVictoria($victoria){
		$this->victoria = $victoria;
	}
	
	public function getVictoria(){
		return $victoria;
	}
	
	public function setEstadisticas($estadisticas){
		$this->listaEstadisticasJugadores = $estadisticas;
	}
	
	public function getEstadisticas(){
		return $this->listaEstadisticasJugadores;
	}
	
}

?>