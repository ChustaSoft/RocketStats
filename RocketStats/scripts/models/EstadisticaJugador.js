/**
 * 
 */
function EstadisticaJugador(){
	
	this.id;
	this.victoria;
	this.mvp;
	this.puntaje;
	this.goles;
	this.asistencias;
	this.salvadas;
	this.tiros;

	this.construct = function(aVictoria, aMvp, aPuntaje, aGoles, anAsistencias, aSalvadas, aTiros){
		this.victoria = aVictoria;
		this.mvp = aMvp;
		this.puntaje = aPuntaje;
		this.goles = aGoles;
		this.asistencias = anAsistencias;
		this.salvadas = aSalvadas;
		this.tiros = aTiros;
	};
	
	this.getId = function(){
		return this.id;
	};
	
	this.setId = function(id){
		this.id = id;
	};
	
	this.setPuntaje = function(puntaje){
		this.puntaje = puntaje;
	};
	
	this.getPuntaje = function(){
		return this.puntaje;
	};
	
	this.setGoles = function(goles){
		this.goles = goles;
	};
	
	this.getGoles = function(){
		return this.goles;
	};
	
	this.setAsistencias = function(asistencias){
		this.asistencias = asistencias;
	};
	
	this.getAsistencias = function(){
		return this.asistencias;
	};
	
	this.setSalvadas = function(salvadas){
		this.salvadas = salvadas;
	};
	
	this.getSalvadas = function(){
		return this.salvadas;
	};
	
	this.setTiros = function(id){
		this.tiros = tiros;
	};
	
	this.getTiros = function(){
		return this.tiros;
	};
	
	this.setMvp = function(mvp){
		this.mvp = mvp;
	};
	
	this.getMvp = function(){
		return this.mvp;
	};
	
	this.setVictoria = function(victoria){
		this.victoria = victoria;
	};
	
	this.getVictoria = function(){
		return this.victoria;
	};
	
};