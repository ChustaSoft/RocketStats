<?php
require_once "modela/beans/Partido";
require_once "modela/beans/Jugador";

class EstadisticasJugador{
	
	private $id;
	
	private $jugador;
	private $mvp;
	private $puntaje;
	private $goles;
	private $asistencias;
	private $salvadas;
	private $tiros;
	
	public function setId($id){
		$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setJugador($jugador){
		$this->jugador = $jugador;
	}
	
	public function getJugador(){
		return $this->jugador;
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