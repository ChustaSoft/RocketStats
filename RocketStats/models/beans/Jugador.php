<?php

class Jugador{
	
	private $id;
	
	private $codigo;
	private $nombre;
	private $contra;
	
	public function __construct(){
		$this->codigo = "";
		$this->nombre = "";
		$this->contra = "";
	}
	
	public function createFromJsonObject($jugadorJsonObject){
		$this->codigo = $jugadorJsonObject->codigo;
		$this->nombre = $jugadorJsonObject->nombre;
	}

	public function setId($id){
		$this->id = $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setCodigo($codigo){
		$this->codigo = $codigo;
	}
	
	public function getCodigo(){
		return $this->codigo;
	}
	
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function setContra($contra){
		$this->contra = $contra;
	}
	
	public function getContra(){
		return $this->contra;
	}
	
	public function getMap() {
		$data = array();
		
		$data["id"]= $this->getId();
		$data["codigo"]= $this->getCodigo();
		$data["nombre"]= $this->getNombre();
		
		return $data;
	}
}

?>