/*======================================
= PARA QUE NO DEJE VACIO EL SELECT DE RESTAURANTE
======================================*/
$("#lstRestaurantesExt").change(function(){   
    // $(".alert").remove();
	var idHotel= $("#idHotelVar").val();
	$("#fechaReservaExternos").val("");
	var idRestaurante= $("option:selected",this).attr("idrestauranteexternos");	
	var horaCierre = $("option:selected", this).attr("horaCierre");	
    var nombreRestaurante= $("#lstRestaurantesExt option:selected").text();
	//guardo en localstorage el id del hotel y restaurante, nombre restaurante
	// console.log("idHotel", idHotel);
    localStorage.setItem("idHotelLST", idHotel);
    localStorage.setItem("idRestauranteLST", idRestaurante);
    localStorage.setItem("nombreRestauranteLST", nombreRestaurante);
	

	if (idRestaurante != '' && nombreRestaurante !="Elija Restaurante"){       
        $("#idRestauranteVar").val(idRestaurante);
        $("#nombreCompleto").removeAttr("readonly");                
		$("#idRestauranteEx").val(idRestaurante);
		var fechaMinimaMostrar = verificaSiHayHoraCierre(horaCierre);//obtengo la fecha que se debe mostrar
		$("#fechaReservaExternos").attr({ "min": fechaMinimaMostrar });
		// console.log("fechaMinimaMostrar", fechaMinimaMostrar);     
    }
    else
         {
          swal ( "Oops","Elija un restaurante", "error")
		  $("#idRestauranteEx").val("");
		  $("#nombreCompleto").val("");
		  $("#nombreCompleto").attr("readonly",true);
		  $("#fechaReservaExternos").val("");
		  $("#fechaReservaExternos").attr("readonly",true);
		  $("#paxExternos").val("");
		  $("#paxExternos").attr("readonly",true);
		  $("#horarioReservaExternos").html("<div class='input-group-addon'><i class='fas fa-clock'></i></div><select class='form-control'><option></option></select>");            
    }              
})
/*verifica si tiene horario de cierre*/
function verificaSiHayHoraCierre(horaCierre) {
	horaCierreRestaurante = horaCierre;
	var fechaHoy = obtenerFechaHoy(); 

	if (horaCierreRestaurante == "SIN HORARIO") {
		$.notify({
			message: '<i class="fas fa-clock"></i> <strong>Nota:</strong> Este restaurante no tiene definido un horario de cierre, puede hacer reservas para hoy ' + fechaHoy   
		}, {
			type: 'info',
			z_index: 2000,
			delay: 6000
		});
		var valorFechaMinimo = fechaHoy;
	}else{
		$.notify({
			message: '<i class="fas fa-clock"></i> <strong>Nota:</strong> Este restaurante tiene horario definido de cierre, las reservas para hoy lo tiene que hacer antes de las ' + horaCierreRestaurante 
		}, {
			type: 'warning',
			z_index: 2000,
			delay: 6000
		});
		var valorFechaMinimo=procesarHoraCierre(horaCierre); //si tiene horaCierre verifico si poner fecha de hoy o de mañana
	}
	return valorFechaMinimo;
}
// funcion para controlar la fecha minimo de las reservas
function procesarHoraCierre(horaCierre){

	var horaActual = obtenerHoraActual();
	var fechaHoy = obtenerFechaHoy();
	var fechaManana = obtenerFechaManana();
	horaCierreRestaurante = horaCierre;

	if (horaCierreRestaurante >= horaActual) {		
		var valorFechaMinimo = fechaHoy;
		
	} else {
		var valorFechaMinimo = fechaManana;
	}
	return valorFechaMinimo;
}
/*======================================
= PARA QUE NO DEJE VACIO nombreCompleto
del modal "Ingrese los datos del cliente" 
======================================*/
$("#nombreCompleto").change(function(){       
    var nombreClienteExterno= $("#nombreCompleto").val();
        
    if (nombreClienteExterno != ''){       
		$("#fechaReservaExternos").removeAttr("readonly");
    } else{
		  swal ( "Oops","Escriba el nombre del cliente", "error");
		  $("#fechaReservaExternos").val("");
		  $("#fechaReservaExternos").attr("readonly",true);                            
    }              
})
// para verificar que el restaurante no este  cerrado
function restauranteAbiertoExternos(){
	var fechaReserva = $("#fechaReservaExternos").val();
	var idRestaurante = localStorage.getItem("idRestauranteLST");

	if (fechaReserva != '') {
		// console.log("vas bien", fechaReserva);
		var datos = new FormData();
		datos.append("idRestCierre", idRestaurante);
		datos.append("fechaRestOpen", fechaReserva);

		$.ajax({
			url: "ajax/reservasRestaurantes.ajax.php",
			method: "POST",
			data: datos,
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json",
			success: function (respuesta) {
				var conteo = parseInt(respuesta[0]["totalFechas"]);
				if (conteo == 0) {  //si restaurante no esta cerrado, traigo su lista de seatings
					getListadoSeatingsParaExternos();					
				} else {
					swal("Oops", "Para esta fecha el restaurante está cerrado, intente con otra fecha o restaurante", "error");
					resetearListaSeatingsExternos();
				}
			}
		});
	} else {
		swal("Oops", "Por favor indique una fecha para la reserva", "error");
	}
}
/*======================================================
= PARA CAPTURAR LA FECHA ELEGIDA Y TRAER EL HORARIO
DE ESE DÍA Y DE PASO TRAER LOS PAXMAXIMO O RESERVASMAXIMAS (QUE PONGO EN ATRIBUTOS QUE yo
ME INVENTO)
======================================================*/
function getListadoSeatingsParaExternos(){	
	var fechaReservaObtenida = $("#fechaReservaExternos").val();
	var idHotel = localStorage.getItem("idHotelLST");
	var idRestaurante = localStorage.getItem("idRestauranteLST");
	localStorage.setItem("fechaReservaObtenidaLS", fechaReservaObtenida);

    var datos = new FormData();
	datos.append("fechaReservaObtenida",fechaReservaObtenida);
	datos.append("idHotelCampo",idHotel);
	datos.append("idRestaurantCampo",idRestaurante);

	$.ajax({
		url:"ajax/reservasRestaurantes.ajax.php", 
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia fechaReservaObtenida
		cache: false,
		contentType: false, 
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json					
			//  console.log("respuesta",respuesta);		 
			listaHorarios = "<div class='input-group-addon'><i class='fas fa-clock'></i></div><select class='form-control horarioReservaExternos' name='horarioReservaExternos' id='horarioReservaExternos' required><option value=''></option>"
				for (i =0;  i<respuesta.length; i++) {
					var cortarCadenaHora = respuesta[i][4];
					var inicio = 0;
					var fin = 8;
					var subCadenaHora=cortarCadenaHora.substring(inicio,fin);
					listaHorarios+= "<option horaSeating="+respuesta[i][4]+" paxMaximo="+respuesta[i][5]+" reservaMaximas="+respuesta[i][6]+"  value="+respuesta[i][4]+">"+subCadenaHora+"</option>";
				}
			listaHorarios+="</select>";
			$("#horarioReservaExternos").html(listaHorarios);
			// $("#numeroDePax").val(numOcupantes);					
		}
	});
}
function resetearListaSeatingsExternos(){
	listaHorarios = "<div class='input-group-addon'><i class='fas fa-clock'></i></div><select class='form-control horarioReservaExternos' name='horarioReservaExternos' id='horarioReservaExternos' required><option value=''></option></select>";
	$("#horarioReservaExternos").html(listaHorarios);
}
/*=====  END OF PARA CAPTURAR LA FECHA ELEGIDA  ======*/

$("#horarioReservaExternos").change(function(){       
    var valorHorario = $("option:selected",this).text();
	//obtengo el valor de los atributos que me serviran para hacer calculos
	var paxMaximo = $("option:selected",this).attr("paxMaximo"); 
	var reservaMaximas = $("option:selected",this).attr("reservaMaximas");
	var idRestauranteExternos = localStorage.getItem("idRestauranteLST");
	var fechaReservaExternos = localStorage.getItem("fechaReservaObtenidaLS");
	       
    if (valorHorario != ''){       
		$("#paxExternos").removeAttr("readonly");

		localStorage.setItem("paxMaximoLST",paxMaximo);
		localStorage.setItem("reservaMaximaLS",reservaMaximas);

		var datos = new FormData();
		datos.append("fechaDeLaReserva",fechaReservaExternos);
		datos.append("horaDelSeating",valorHorario);	
		datos.append("idRestauranteSeating",idRestauranteExternos);

		$.ajax({
			url:"ajax/reservasRestaurantes.ajax.php", //enviamos a este archivo para que lo procese
			method: "POST", //el envio es por POST
			data: datos, //datos es la instancia de ajax por el que se envia 
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json", //los datos son de tipo json
			success:function(respuesta){
				// console.log("respuestaF",respuesta);
				var totalReservas = respuesta[0];
				var sumaPax = respuesta[1];			
	
				if (sumaPax===null || totalReservas===null) {
					totalReservas= 0;
					sumaPax = 0;
				} else {
					totalReservas=respuesta[0];
					sumaPax=respuesta[1];
				}
				localStorage.setItem("totalReservasLST", totalReservas);
				localStorage.setItem("sumaPaxLST", sumaPax);													
				
				var numReservasMax = localStorage.getItem("reservaMaximaLS"); //para hacer calculos
				var numDePaxMaxima = localStorage.getItem("paxMaximoLST"); // para hacer calculos
				var totalReservasHechas = localStorage.getItem("totalReservasLST");
				var totalPaxAcumulados = localStorage.getItem("sumaPaxLST"); 
	
				var a=numReservasMax;
				var ab=parseInt(a);
				var c=numDePaxMaxima;
				var cd=parseInt(c);
	
				var e=totalReservasHechas;
				var ef=parseInt(e);
				var g=totalPaxAcumulados;
				var gh=parseInt(g);
					// var numRsvQuedan = ab - ef;
				var numPaxQuedan = cd - gh;
																								
				if(/*numReservasMax===totalReservas ||*/ numDePaxMaxima===sumaPax){
					$.notify({							
						message: '<i class="fas fa-times"></i> <strong>Nota 1:</strong> Ya alcanzó el numero maximo de pax que puede cubrir para esta fecha y hora. Tiene un total de  '+totalReservas+' reserva(s). Numero de pax: '+sumaPax+' '
						},{						
						type: 'danger',
						z_index: 2000,
						delay: 4000
					});
					// setTimeout("location.href='hacer-reservas'", 5000);
				}else{
					
					$.notify({							
						message: '<i class="fas fa-table"></i> <strong>Nota 1:</strong> Para esta hora y día puede cubrir un total de '+numDePaxMaxima+' pax. Tiene '+totalReservas+' reserva(s), con un total de '+sumaPax+' pax. Tiene espacio para '+numPaxQuedan+' pax.'
						},{						
						type: 'info',
						z_index: 2000,
						delay: 6000
					});
					$("#numDePaxmAximo").val(numDePaxMaxima);
					$("#sumaPaxExternos").val(sumaPax);
				}																					
			}							
		})	  
	} else{
		swal ( "Oops","Elija un horario de la lista", "error");
		$("#paxExternos").attr("readonly",true); 	                             
	}              
});
function getPaxAcumuladosDia() {
	sumarPaxDesglosadosExternos();
	var fecha = $("#fechaReservaExternos").val(); 
	var idRestaurante = $("option:selected", "#lstRestaurantesExt").attr("idRestauranteExternos");
	var paxMaximoDia = $("option:selected", "#lstRestaurantesExt").attr("paxMaximoDia");
	var paxMaximoSeatingRstExt = $("option:selected", "#horarioReservaExternos").attr("paxMaximo"); 
	var rsvMaximoSeatingRstExt = $("option:selected", "#horarioReservaExternos").attr("reservaMaximas"); 
	var pax = $("#paxExternos").val(); 
	// console.log("fecha: " + fecha + " idRestaurante: " + idRestaurante+" paxMAximoDia: "+paxMaximoDia+" pax: "+pax+" paxMaximoSeatingRstExt: "+paxMaximoSeatingRstExt);
	if (fecha != "" && idRestaurante !=""){
		var datos = new FormData();
		datos.append("fechaDeLaReservaDia", fecha);
		datos.append("idRestauranteSeatingDia", idRestaurante);
		$.ajax({
			url: "ajax/reservasRestaurantes.ajax.php",
			method: "POST", //el envio es por POST
			data: datos, //datos es la instancia de ajax por el que se envia idHotel
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json", //los datos son de tipo json
			success: function (respuesta) { //obtengo una respuesta tipo json                               
				console.log("respuesta", respuesta);
				// console.log("respuestaPaxRest", respuesta["sumaPax"]);			
				if (respuesta["sumaPax"] == null) {
					sumaPaxDia = 0;
				} else {
					sumaPaxDia = respuesta["sumaPax"];
				} 
				localStorage.setItem("fechaReservaExt", fecha);
				localStorage.setItem("idRestauranteExt", idRestaurante);
				localStorage.setItem("paxMaximoDiaRstExt", paxMaximoDia);
				localStorage.setItem("paxMaximoSeatingRstExt", paxMaximoSeatingRstExt);
				localStorage.setItem("rsvMaximoSeatingRstExt", rsvMaximoSeatingRstExt);
				localStorage.setItem("paxAcumuladoDiaRstExt", sumaPaxDia);
				localStorage.setItem("paxExt", pax);				
			}
		})
	} else{
		swal("Oops", "Tiene que tener seleccionado un restaurante y fecha", "error");
	}
	
}


$(document).on("click", "#btnClienteExternoGuardar", function () {	
	sumarPaxDesglosadosExternos();
	getPaxAcumuladosDia();
	var paxHuesped = parseInt(localStorage.getItem("paxExt"));
	var paxAcumuladoDia = parseInt(localStorage.getItem("paxAcumuladoDiaRstExt"));//por dia del restaurante
	var paxMaximoDiaRstExt = parseInt(localStorage.getItem("paxMaximoDiaRstExt"));//por dia del restaurante
	var numDePaxMaximaRestaurante = parseInt(localStorage.getItem("paxMaximoSeatingRstExt"));//por el seating
	var numDeRSVMaximaRestaurante = parseInt(localStorage.getItem("rsvMaximoSeatingRstExt"));//por el seating

	//var numDePaxMaxima = parseInt(localStorage.getItem("paxMaximoLST"));//por seating del restaurante
	var totalPaxAcumulados = parseInt(localStorage.getItem("sumaPaxLST"));//por seating del restaurante
	var totalRSVAcumulados = parseInt(localStorage.getItem("totalReservasLST"));
	var valorRSVHuesped = 1;
// localStorage.getItem("sumaPaxLST");
	var paxAcumuladosMasPaxHuesped = parseInt(totalPaxAcumulados + paxHuesped);
	var paxAcumuladosDiaMasPaxHuesped = parseInt(paxAcumuladoDia + paxHuesped);
	var rsvAcumuladosMasRsvHuesped = parseInt(totalRSVAcumulados + valorRSVHuesped);
	if (paxAcumuladosMasPaxHuesped > numDePaxMaximaRestaurante) {
		swal("Oops", "Los pax acumulados más la que indica su reserva supera el limite de pax que puede cubrir para esta hora", "error");
		return false;
	} else if (paxAcumuladosDiaMasPaxHuesped > paxMaximoDiaRstExt) {
		swal("Oops", "Los pax acumulados del día más la que indica su reserva supera el limite para este dia", "error");
		return false;
	} else if (rsvAcumuladosMasRsvHuesped > numDeRSVMaximaRestaurante) {
		swal("Oops", "Las reservas acumuladas para esta hora de este día supera el limite establecido para este seating", "error");
		return false;
	}  else {
		return true;
	} 
})
//funcion para ver si campo pax coinciden con los pax desglosados
function sumarPaxDesglosadosExternos(){		
	var sumaPax=0;	
	$('.paxDesgloseExt').each(function () {
		if ($(this).val() == "") {
			$(this).val(0);
		}
		sumaPax += parseInt($(this).val());
	})
	$("#paxExternos").val(sumaPax); 
}
/*======================================
= CON ESTO NO PERMITO EL INGRESO DE ELEMENTOS
 QUE NO SEAN NUMERICOS en campo paxExternos
 Del modal Ingrese los datos del cliente 
======================================*/
$(document).on("input", "#paxExternos", function(){
	this.value = this.value.replace(/[^0-9]/g,'');
})
/*======================================
= PARA VALIDAR QUE EN EL CAMPO paxExternos
 SOLO SE INGRESEN NUMEROS
  Del modal Ingrese los datos del cliente
======================================*/
$("#paxExternos").change(function(){ 	
	var numeroPAx = $("#paxExternos").val(); 	
	var soloDigitos = this.value.replace(/[^0-9]/g,'');
	
	   if(soloDigitos > 0  && numeroPAx !=''){
		   console.log("CORRECTO");		   	        
	   }else{
		   swal ( "Oops" ,  "Ingrese un valor válido" ,  "error" );
		   $("#paxExternos").val(""); 		   		    
	   }	 
})
//para el desglose de pax
$("#paxCunaExt").change(function () {
	var numeroPax = $("#paxCunaExt").val();
	var soloDigitos = this.value.replace(/[^0-9]/g, '');

	if (soloDigitos >= 0 && numeroPax != '') {
		console.log("CORRECTO");
	} else {
		swal("Oops", "Ingrese un valor válido", "error");
		$("#paxCunaExt").val(0);
	}
}) 
$("#paxNinioExt").change(function () {
	var numeroPax = $("#paxNinioExt").val();
	var soloDigitos = this.value.replace(/[^0-9]/g, '');

	if (soloDigitos >= 0 && numeroPax != '') {
		console.log("CORRECTO");
	} else {
		swal("Oops", "Ingrese un valor válido", "error");
		$("#paxNinioExt").val(0);
	}
})
$("#paxJuniorExt").change(function () {
	var numeroPax = $("#paxJuniorExt").val();
	var soloDigitos = this.value.replace(/[^0-9]/g, '');

	if (soloDigitos >= 0 && numeroPax != '') {
		console.log("CORRECTO");
	} else {
		swal("Oops", "Ingrese un valor válido", "error");
		$("#paxJuniorExt").val(0);
	}
})
$("#paxAdultosExt").change(function () {
	var numeroPax = $("#paxAdultosExt").val();
	var soloDigitos = this.value.replace(/[^0-9]/g, '');

	if (soloDigitos >= 0 && numeroPax != '') {
		console.log("CORRECTO");
	} else {
		swal("Oops", "Ingrese un valor válido", "error");
		$("#paxAdultosExt").val(0);
	}
})
$("#paxSeniorExt").change(function () {
	var numeroPax = $("#paxSeniorExt").val();
	var soloDigitos = this.value.replace(/[^0-9]/g, '');

	if (soloDigitos >= 0 && numeroPax != '') {
		console.log("CORRECTO");
	} else {
		swal("Oops", "Ingrese un valor válido", "error");
		$("#paxSeniorExt").val(0);
	}
})

