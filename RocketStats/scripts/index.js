var usersList = new Array();

$(document).ready(function (){
	
//	$("#btnIntroducirPartido").button();
	
	$('#divNuevoPartido').dialog({
		autoOpen:false,
		modal:true,
		width:800,
		height:'auto'
	});
	
	$(".ui-dialog-titlebar").hide();
	
	$("#btnIntroducirPartido").click(function(){
		$("#divNuevoPartido").dialog("open");
	});
	
	$("input:radio[name=rgTipoPartido]").click(function(){
		var tmpValueClicked = $("input:radio[name=rgTipoPartido]:checked").val();
		establecerJugadoresPorPartido(tmpValueClicked);
	});

});

function crearJugador(){
	var steamId = $("#userSteamId").val();
	var userName = $("#userRealName").val();
	
	var nuevoJugador = new Jugador();
	nuevoJugador.construct(steamId, userName);
	
	$.ajax({
		url : 'control.php',
		type : "POST",
		data : {
			action : 6,
			JSONData : JSON.stringify(nuevoJugador)					
		},
		async: false,
		success : function(responseText) {
			response = responseText;
			if(response == "OK"){
				//TODO recuperar el ID en vez del OK hacerlo bien
				usersList.push(nuevoJugador);
				refrescarTablaJugadores();
			}			
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("There has been an error while connecting to the server, try later");
			console.log(xhr.status+"\n"+thrownError);
		}
    });
};

function cargarJugadores(){
	usersList = new Array();
	$.ajax({
		url: "control.php",
		type: "POST",
		data: "action=7",
		dataType:"json",
		async: false,
		success: function (response) {
			var tmpUser = null;
			$.each(response, function(index, iValue){
				tmpUser = new Jugador();
				tmpUser.construct(iValue.codigo, iValue.nombre);
				tmpUser.setId(iValue.id);
				usersList.push(tmpUser);
			});
			refrescarTablaJugadores();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("There has been an error while connecting to the server, try later");
			alert(xhr.status+"\n"+thrownError);
			console.log(xhr.status+"\n"+thrownError);
		}		
	});
};

function refrescarTablaJugadores(){
	usersList.sort(function(a, b) { 
		return a.codigo > b.codigo; 
	});
	$("#jugadoresTabla").empty();
	var tmpHeader = $("<tr></tr>");
	tmpHeader.append($("<th></th>").html("Id Steam"));
	tmpHeader.append($("<th></th>").html("Nombre real"));
	$("#jugadoresTabla").append(tmpHeader);
	
	$.each(usersList, function(index, iUser) {
		tmpRow = $("<tr></tr>");
		
		tmpRow.append($("<td></td>").html(iUser.codigo));
		tmpRow.append($("<td></td>").html(iUser.nombre));
		  
		$("#jugadoresTabla").append(tmpRow);
	});
};

function visibilidadTablaJugadores(aFlag){
	if(aFlag && $.isEmptyObject(usersList)){
		$("#jugadoresTablaDiv").css("visibility", "visible");
		$("#jugadoresTablaButtonCollapse").css("visibility", "visible");
		cargarJugadores();
	}
	else if(aFlag && !$.isEmptyObject(usersList)){
		$("#jugadoresTablaDiv").css("visibility", "visible");
		$("#jugadoresTablaButtonCollapse").css("visibility", "visible");
	}
	else{
		$("#jugadoresTablaDiv").css("visibility", "hidden");
		$("#jugadoresTablaButtonCollapse").css("visibility", "hidden");
	}
};

function establecerJugadoresPorPartido(tipoSeleccionado){
	//TODO: Establecer el máximo de jugadores para un partido en #selectJugadoresDelPartido dependiendo del partido seleccinado
	alert("Check: " + tipoSeleccionado);
};
