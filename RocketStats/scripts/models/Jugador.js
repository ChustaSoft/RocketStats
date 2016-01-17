/**
 * 
 */
function Jugador(){
	
	this.id;
	this.codigo;
	this.nombre;

	this.construct = function(codigo, nombre){
		this.codigo = codigo;
		this.nombre = nombre;
	};
	
	this.getId = function(){
		return this.id;
	}
	
	this.setId = function(id){
		this.id = id;
	};
	
	this.getCodigo = function(){
		return this.codigo;
	}
	
	this.setCodigo = function(codigo){
		this.codigo = codigo;
	};
	
	this.getNombre = function(){
		return this.nombre;
	}
	
	this.setNombre = function(nombre){
		this.nombre = nombre;
	};	
	
	this.toString = function(){
		return "id="+this.getId()+" codigo="+this.getCodigo()+" nombre="+this.getNombre();
	};	

};