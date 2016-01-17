var usersList = new Array();

$(document).ready(function (){
	

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
			alert(response);			
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("There has been an error while connecting to the server, try later");
			console.log(xhr.status+"\n"+thrownError);
		}
    });
};

function cargarJugadores(){
	var outPutData = new Array();
	$.ajax({
		url: "control.php",
		type: "POST",
		data: "action=7",
		dataType:"json",
		async: false,
		success: function (response) {
			outPutData = response;
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert("There has been an error while connecting to the server, try later");
			alert(xhr.status+"\n"+thrownError);
			console.log(xhr.status+"\n"+thrownError);
		}		
	});
	
//	$.each(usersList, function( index, value ){
//	    alert(value);
//	});
	
//	if (outPutData[0])
//	{
//		for (var i = 0; i < outPutData[1].length; i++)
//		{
//			var tmpUser = new userObj();
//			tmpUser.construct(outPutData[1][i].id, outPutData[1][i].roleId, outPutData[1][i].username, outPutData[1][i].password, outPutData[1][i].name, outPutData[1][i].phone, outPutData[1][i].email, outPutData[1][i].address, outPutData[1][i].startDate, outPutData[1][i].endDate);
//			this.usersList.push(tmpUser);				
//		}	
//	}
//	else showErrors(outPutData[1]);	
};
