<?php

class EstadisticasJugador{
	
	private $id;

	private $tipoPartido;
	private $jugadorId;
	private $victoria;
	private $mvp;
	private $puntaje;
	private $goles;
	private $asistencias;
	private $salvadas;
	private $tiros;
	
	public function createFromJsonObject($estadisticaJsonObject){
		$this->jugadorId = $estadisticaJsonObject->idJugador;
		$this->victoria = $estadisticaJsonObject->victoria;
		$this->mvp = $estadisticaJsonObject->mvp;
		$this->puntaje = $estadisticaJsonObject->puntaje;
		$this->goles = $estadisticaJsonObject->goles;
		$this->asistencias = $estadisticaJsonObject->asistencias;
		$this->salvadas = $estadisticaJsonObject->salvadas;
		$this->tiros= $estadisticaJsonObject->tiros;
	}	
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setTipoPartido($tipoPartido){
		$this->tipoPartido = $tipoPartido;
	}
	
	public function getTipoPartido(){
		return $this->tipoPartido;
	}
	
	public function setJugador($jugadorId){
		$this->jugadorId = $jugadorId;
	}
	
	public function setVictoria($victoria){
		$this->victoria = $victoria;
	}
	
	public function getVictoria(){
		return $this->victoria;
	}
	
	public function getJugador(){
		return $this->jugadorId;
	}
	
	public function setMvp($mvp){
		$this->mvp = $mvp;
	}
	
	public function getMvp(){
		return $this->mvp;
	}
	
	public function setPuntaje($puntaje){
		$this->puntaje = $puntaje;
	}
	
	public function getPuntaje(){
		return $this->puntaje;
	}
	
	public function setGoles($goles){
		$this->goles = $goles;
	}
	
	public function getGoles(){
		return $this->goles;
	}
	
	public function setAsistencias($asistencias){
		$this->asistencias = $asistencias;
	}
	
	public function getAsistencias(){
		return $this->asistencias;
	}
	
	public function setSalvadas($salvadas){
		$this->salvadas = $salvadas;
	}
	
	public function getSalvadas(){
		return $this->salvadas;
	}
	
	public function setTiros($tiros){
		$this->tiros = $tiros;
	}
	
	public function getTiros(){
		return $this->tiros;
	}
}

?>