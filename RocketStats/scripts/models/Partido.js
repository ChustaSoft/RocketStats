/**
 * 
 */
function Partido(){
	
	this.id;
	this.tipo;
	this.estadisticasJugadores;

	this.construct = function(aTipo){
		this.estadisticasJugadores = new Array();
		this.tipo = aTipo;
	};
	
	this.getId = function(){
		return this.id;
	}
	
	this.setId = function(id){
		this.id = id;
	};
	
	this.getTipo = function(){
		return this.tipo;
	};
	
	this.setTipo = function(tipo){
		this.tipo = tipo;
	};
	
	this.addEstadisticaJugador = function(aEstadisticaJugador){
		this.estadisticasJugadores.push(aEstadisticaJugador);
	};

};