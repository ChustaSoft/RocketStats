var usersList = new Array();
var estadisticasList = new Array();

$(document).ready(function (){
	
	$('#divNuevoPartido').dialog({
		autoOpen:false,
		modal:true,
		width: 'auto',
		height:'auto',
		resizable: true,
		hide: { effect: "fade", duration: 150 }
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
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("There has been an error while connecting to the server, try later");
			alert(xhr.status+"\n"+thrownError);
			console.log(xhr.status+"\n"+thrownError);
			return false;
		}		
	});
	return true;
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
		if(cargarJugadores())
			refrescarTablaJugadores();		
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
	$("#selectJugadoresDelPartido").empty();
	$("#tableJugadoresDelPartido").empty();
	$("#btnSendPartido").css("visibility", "hidden");
	
	var maxJugadores = 1;
	switch (parseInt(tipoSeleccionado)) {
		case 1: //Partido 1vs1			
			maxJugadores = 2;
			break;

		case 2: //Partido 2vs2			
			maxJugadores = 4;
			break;
			
		case 3: //Partido 3vs3
			maxJugadores = 6;
			break;
			
		case 4: //Partido 4vs4
			maxJugadores = 8;
			break;
			
		default:
			break;
	}
	
	for (var iMax = 1; iMax <= maxJugadores; iMax++) {
		var tmpSelect = $("<option></option>");
		tmpSelect.html(iMax);
		$("#selectJugadoresDelPartido").append(tmpSelect);
	}
	
	$("#selectJugadoresDelPartido").change(function (){
		refrescarTablaJugadoresPartido($("#selectJugadoresDelPartido option:selected").val());
	});
};

/*
 * En esta función realizamos lo siguiente:
 * 1. Vaciamos la tabla para que se refresque correctamente cada vez que cambiamos el número de jugadores
 * 2. Si no hubiera jugadores en la lista global, se cargan mediante la función cargarJugadores()
 * 3. Cargamos un template del servidor que contiene la vista básica para una estadística de un jugador
 * 4. Realizamos un callback una vez establecidos en el DOM los templates
 *    1. Este recorrerá todas las filas establecidas, indicando un id para cargar los datos correctamente más tarde
 *    2. Carga el select del jugador para cada línea
 * 5. Establece visible el botón de carga de datos
 */
function refrescarTablaJugadoresPartido(numJugadores){
	$("#tableJugadoresDelPartido").empty();
	
	if($.isEmptyObject(usersList))
		cargarJugadores();
	
	for (var iMax = 1; iMax <= numJugadores; iMax++) {
		var tmpRow = $("<tr></tr>");
		tmpRow.load("views/templates/estadisticas_jugador_partido.html", function(){
			$("td.rowJugador").each(function( index ) {
				$(this).attr("id", "estadisticasJugador" + (index + 1));
				for (var iUser = 0; iUser < usersList.length; iUser++) {
					var tmpOption = $("<option></option>");
					tmpOption.attr("id", usersList[iUser].getId());
					tmpOption.html(usersList[iUser].getCodigo());
					$(this).find($("select:last")).append(tmpOption);
				};
			});	
		});
		$("#tableJugadoresDelPartido").append(tmpRow);
	}	
	$("#btnSendPartido").css("visibility", "visible");
};

function enviarEstadisticasPartido(){
	var tmpNumJugadores = parseInt($("#selectJugadoresDelPartido option:selected").val());
	var tmpTipoPartido = $("input:radio[name=rgTipoPartido]:checked").val();
	var tmpPartido = new Partido();
	tmpPartido.construct(tmpTipoPartido);
	for (var iNumJugador = 1; iNumJugador <= tmpNumJugadores; iNumJugador++) {
		var tmpEstadisticaJugador = new EstadisticaJugador();

		if($("#estadisticasJugador" + iNumJugador).find($("input.isWinner")).is(':checked'))
			tmpEstadisticaJugador.setVictoria(true);
		else
			tmpEstadisticaJugador.setVictoria(false);
		
		if($("#estadisticasJugador" + iNumJugador).find($("input.isMvp")).is(':checked'))
			tmpEstadisticaJugador.setMvp(true);
		else
			tmpEstadisticaJugador.setMvp(false);
		
		tmpEstadisticaJugador.setIdJugador($("#estadisticasJugador" + iNumJugador).find($("select")).children(":selected").attr("id"));
		tmpEstadisticaJugador.setPuntaje($("#estadisticasJugador" + iNumJugador).find($("input.puntajeJugador")).val());
		tmpEstadisticaJugador.setGoles($("#estadisticasJugador" + iNumJugador).find($("input.golesJugador")).val());
		tmpEstadisticaJugador.setAsistencias($("#estadisticasJugador" + iNumJugador).find($("input.asistenciasJugador")).val());
		tmpEstadisticaJugador.setSalvadas($("#estadisticasJugador" + iNumJugador).find($("input.salvadasJugador")).val());
		tmpEstadisticaJugador.setTiros($("#estadisticasJugador" + iNumJugador).find($("input.tirosJugador")).val());
		
		tmpPartido.addEstadisticaJugador(tmpEstadisticaJugador);
	};
	
	var tmpOk = false;
	if(validarDatosDelPartido(tmpPartido))
		tmpOk = clasificarPartido(tmpPartido);
	else
		alert("Si juegas al Rocket igual que introduces usuarios, estamos acabados, ¡hay alguno repetido, revísalo!")
	
	if(tmpOk){
		$("#divNuevoPartido").dialog("close");
		alert("El partido ha sido clasificado correctamente, si has sido un paquete ya no hay marcha atrás, si has sido tramposo y te has puesto goles, te cazaremos friki");
	}
};

function validarDatosDelPartido(aPartido){
	var tmpFlag = true;
	$.each(aPartido.getEstadisticasJugador(), function(index, iEstadistica){
		for(var i = 0; i < aPartido.getEstadisticasJugador().length; i++){
			if(iEstadistica.getIdJugador() == aPartido.getEstadisticasJugador()[i].getIdJugador() && i != index)
				tmpFlag = false;
		}		
	});
	return tmpFlag;
};

function clasificarPartido(aPartido){
	var tmpFlag = false;
	$.ajax({
		url : 'control.php',
		type : "POST",
		data : {
			action : 8,
			JSONData : JSON.stringify(aPartido)					
		},
		async: false,
		success : function(responseText) {
			response = responseText;
			if(response == "OK"){
				tmpFlag = true;
				
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("Error en el servidor");
		}
    });
	return tmpFlag;
};

function iniciarTablaEstadisticasPorPartido(aTipoPartido){
	cargarEstadisticasPartido(aTipoPartido);
	cambiarOrdenEstadisticas(4);
	mostrarEstadisticasPartido();
}

function refrescarTablaTablaEstadisticasPorPartido(aTipoFiltro){
	cambiarOrdenEstadisticas(aTipoFiltro);
	mostrarEstadisticasPartido();
};

function cargarEstadisticasPartido(aTipoPartido){
	estadisticasList = new Array();
	$.ajax({
		url: "control.php",
		type: "POST",
		data : {
			action : 9,
			JSONData : JSON.stringify(aTipoPartido)					
		},
		dataType:"json",
		async: false,
		success: function (response) {
			var tmpEstadistica = null;
			$.each(response, function(index, iValue){
				tmpEstadistica = new ControlEstadisticasJugadores();
				tmpEstadistica.idJugador = iValue.idJugador;
				tmpEstadistica.totalPartidos = iValue.totalPartidos;
				tmpEstadistica.totalVictorias = iValue.totalVictorias;
				tmpEstadistica.totalMvps = iValue.totalMvps;
				tmpEstadistica.totalPuntaje = iValue.totalPuntaje;
				tmpEstadistica.mediaPuntaje = iValue.mediaPuntaje;
				tmpEstadistica.totalGoles = iValue.totalGoles;
				tmpEstadistica.mediaGoles = iValue.mediaGoles;
				tmpEstadistica.totalAsistencias = iValue.totalAsistencias;
				tmpEstadistica.mediaAsistencias = iValue.mediaAsistencias;
				tmpEstadistica.totalSalvadas = iValue.totalSalvadas;
				tmpEstadistica.mediaSalvadas = iValue.mediaSalvadas;
				tmpEstadistica.totalTiros = iValue.totalTiros;
				tmpEstadistica.mediaTiros = iValue.mediaTiros;
				
				estadisticasList.push(tmpEstadistica);
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("There has been an error while connecting to the server, try later");
			alert(xhr.status+"\n"+thrownError);
			console.log(xhr.status+"\n"+thrownError);
			return false;
		}		
	});
	return true;
};

function cambiarOrdenEstadisticas(aTipoFiltro){
	estadisticasList.sort(function(a, b){
		switch(parseInt(aTipoFiltro)){
		
		case 1:
			return parseFloat(b.totalVictorias) > parseFloat(a.totalVictorias);
			
		case 2:
			return parseFloat(b.totalMvps) > parseFloat(a.totalMvps);
			
		case 3:
			return parseFloat(b.totalPuntaje) > parseFloat(a.totalPuntaje);
		
		case 4:
			return parseFloat(b.mediaPuntaje) > parseFloat(a.mediaPuntaje);
		
		case 5:
			return parseFloat(b.totalGoles) > parseFloat(a.totalGoles);
			
		case 6:
			return parseFloat(b.mediaGoles) > parseFloat(a.mediaGoles);
			
		case 7:
			return parseFloat(b.totalAsistencias) > parseFloat(a.totalAsistencias);
		
		case 8:
			return parseFloat(b.mediaAsistencias) > parseFloat(a.mediaAsistencias);
			
		case 9:
			return parseFloat(b.totalSalvadas) > parseFloat(a.totalSalvadas);
			
		case 10:
			return parseFloat(b.mediaSalvadas) > parseFloat(a.mediaSalvadas);
			
		case 11:
			return parseFloat(b.totalTiros) > parseFloat(a.totalTiros);
		
		case 12:
			return parseFloat(b.mediaTiros) > parseFloat(a.mediaTiros);
			
		case 13:
			return parseFloat(b.totalPartidos) > parseFloat(a.totalPartidos);
		}
	});
};

function mostrarEstadisticasPartido(){
	$("#divEstadisticasView").empty();
	
	var tmpTable = generarEstructuraTablaEstadisticas();
	$.each(estadisticasList, function(index, iStat){
		var tmpRow = $("<tr></tr>");
		tmpRow.append("<td>" + getUsernameById(iStat.idJugador) + "</td>");
		tmpRow.append("<td>" + iStat.totalPartidos + "</td>");
		tmpRow.append("<td>" + iStat.totalVictorias + "</td>");
		tmpRow.append("<td>" + iStat.totalMvps + "</td>");
		tmpRow.append("<td>" + iStat.totalPuntaje + "</td>");
		tmpRow.append("<td>" + iStat.mediaPuntaje + "</td>");
		tmpRow.append("<td>" + iStat.totalGoles + "</td>");
		tmpRow.append("<td>" + iStat.mediaGoles + "</td>");
		tmpRow.append("<td>" + iStat.totalAsistencias + "</td>");
		tmpRow.append("<td>" + iStat.mediaAsistencias + "</td>");
		tmpRow.append("<td>" + iStat.totalSalvadas + "</td>");
		tmpRow.append("<td>" + iStat.mediaSalvadas + "</td>");
		tmpRow.append("<td>" + iStat.totalTiros + "</td>");
		tmpRow.append("<td>" + iStat.mediaTiros + "</td>");
		
		tmpTable.append(tmpRow);
	});
	
	$("#divEstadisticasView").append(tmpTable);
};

function generarEstructuraTablaEstadisticas(){
	var tmpTable = $("<table></table>");
	
	var tmpTh = $("<tr></tr>");
	tmpTh.append("<th>Jugador</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(13)'>Total jugados</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(1)'>Victorias</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(2)'>MVP's</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(3)'>Total puntos</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(4)'>Media puntos</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(5)'>Total goles</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(6)'>Media goles</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(7)'>Total asistencias</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(8)'>Media asistencias</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(9)'>Total salvadas</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(10)'>Media salvadas</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(11)'>Total tiros</th>");
	tmpTh.append("<th onclick='refrescarTablaTablaEstadisticasPorPartido(12)'>Media tiros</th>");
	
	tmpTh.addClass("rocketTableStatsHeader");
	tmpTable.append(tmpTh);
	
	return tmpTable;
}

function getUsernameById(anId){
	if($.isEmptyObject(usersList))
		cargarJugadores();
	var tmpUsername = "";
	$.each(usersList, function(index, iValue){
		if(iValue.getId() == anId){
			tmpUsername = iValue.getCodigo();
		}
	});
	return tmpUsername;
};