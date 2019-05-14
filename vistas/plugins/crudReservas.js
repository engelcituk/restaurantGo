/*======================================
=            ELIMINAR RESERVA            =
======================================*/
$(document).on("click", ".eliminarReserva", function(){	
	var idReserva = $(this).attr("idReserva");
	// console.log("idReserva", idReserva);
	swal({
		  title: "¡Atención!",
		  text: "¿Esta seguro de eliminar la reserva?",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  cancelButtonText: "Cancelar",
		  confirmButtonText: "Confirmar",
		  closeOnConfirm: false,
		  closeOnCancel: false
		},
		function(isConfirm) {
		  if (isConfirm) {
		//Si se confirma la eliminacion se ejecuta el reenvio al php encargado
		    window.location.href="index.php?ruta=administrar-reservas&idReserva="+idReserva;
		  } else {
		//Si se cancela se emite un mensaje
		    swal("Cancelado", "Ha cancelado la eliminacion de la reserva", "error");
		  }
		});
})
/*=====  FIN DE  ELIMINAR RESERVA   ======*/
/*======================================
= CARGAR DATOS PARA EL TICKET//desde el icono de imprimir del datatable=
======================================*/
 $(document).on("click", ".mostrarTicket", function(){ 	
 	var idReserva = $(this).attr("idReserva");
 	console.log("idReserva",idReserva);

 	var datos = new FormData();
 	datos.append("idReserva",idReserva);	

 	$.ajax({

		url:"ajax/reservas.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json
			// console.log("respuesta",respuesta);
			var cortarCadenaHora = respuesta["hora"];
					var inicio = 0;
					var fin = 8;
					var subCadenaHora=cortarCadenaHora.substring(inicio,fin);
			$("#reservaFecha").val(respuesta["fechaDeLaReserva"]); //le cargo en esos campos los resultados
			$("#reservaHora").val(subCadenaHora);
			$("#reservaApellido").val(respuesta["apellido"]);
			$("#reservaPax").val(respuesta["pax"]);
			$("#reservaMesa").val(respuesta["numeroMesa"]);
			$("#reservaHabitacion").val(respuesta["habitacion"]);
			$("#nombreRestauranteTicket").val(respuesta["nombreRestaurante"]);
			$("#reservaHotel").val(respuesta["reservaIdentificador"]);
			$("#reservaTicket").val(respuesta["ticket"]);

		}
	})
});
/*=====  FIN DE CARGAR DATOS PARA EL TICKET  ======*/
/*======================================
=PARA ENVIAR LOS DATOS DEL TICKET A IMPRIMIR = 
======================================*/
 $(document).on("click", ".obtenerDatosTicket", function(){
 	
 	//OBTENGO LOS VALORES DE LOS CAMPOS DEL MODAL QUE TIENE LOS DATOS PARA EL TICKET
 	var reservaFecha = $("#reservaFecha").val();
 	var reservaHora = $("#reservaHora").val();
 	var reservaApellido = $("#reservaApellido").val();
 	var reservaPax = $("#reservaPax").val();
 	var reservaHabitacion = $("#reservaHabitacion").val();
 	// var reservaMesa = $("#reservaMesa").val();
 	var nombreRestaurante = $("#nombreRestauranteTicket").val();
 	var reservaHotel = $("#reservaHotel").val();
 	var reservaTicketIdioma = $("#reservaTicket").val();
	var ipImpresora = $("#impresoras").val(); //obtengo la ipImpresora.. La ip.. valores que tengo en los value mi lista de opciones
	var esTermica = $("#esTermicaImpresora").val();
	//  console.log("esTermica", esTermica);
 
 	var enviarDatosTicket = new FormData(); 
	 	enviarDatosTicket.append("fechaDeLaReserva",reservaFecha);
	 	enviarDatosTicket.append("HoraDelaReserva",reservaHora);
	 	enviarDatosTicket.append("apellidoDeLaReserva",reservaApellido);
	 	enviarDatosTicket.append("paxDelaReserva",reservaPax);
	 	enviarDatosTicket.append("habitacionDelaReserva",reservaHabitacion);
	 	// enviarDatosTicket.append("mesaDelaReserva",reservaMesa);
	 	enviarDatosTicket.append("restauranteDelaReserva",nombreRestaurante);
	 	enviarDatosTicket.append("IdentificadorDelaReserva",reservaHotel);
	 	enviarDatosTicket.append("ticketIdiomaDelaReserva",reservaTicketIdioma);
		enviarDatosTicket.append("ticketIPdeLaImpresora",ipImpresora);
	  enviarDatosTicket.append("esTermica", esTermica);

	 	$.ajax({
				url:"extensiones/ticket.php", //enviamos a este archivo los datos para que lo procese
				method: "POST", //el envio es por POST
				data: enviarDatosTicket, //datos es la instancia de ajax por el que se envia el id
				cache: false,
				contentType: false,
				processData: false,
				dataType:"json", //los datos son de tipo json
				success:function(respuesta){ //obtengo una respuesta tipo json
					
					 console.log("respuesta",respuesta);
		}
	})
});
/*=====  FIN DE ENVIAR LOS DATOS DEL TICKET A IMPRIMIR  ======*/
//para obtener el numero de las impresoras si son termicas o no y ponerlos en un campo oculto
$("#impresoras").change(function () {
	var siEsTermica = $("option:selected", this).attr("termica");
	$("#esTermicaImpresora").val(siEsTermica);
})

/*==============================================
	CAPTURAR valor idRestaurante Y LO MANDO POR GET PARA 
	GENERA LA LISTA DE RESERVAS	
 ===================================*/
$("#lstSelectRest").change(function(){ //lstSelectRest es lista Select de restaurantes
	
	var idRestaurante = $("#lstSelectRest").val();
	localStorage.setItem("idRestauranteLST", idRestaurante);

	var nombreRestaurante = $("option:selected",this).text(); //obtengo el texto que tengo en la lista
	localStorage.setItem("nombreRestauranteLST", nombreRestaurante);

	window.location="index.php?ruta=administrar-reservas&idRest="+idRestaurante+"&nomRest="+nombreRestaurante;	
	
})
 /*===============FIN=================*/
 /*==============================================
	CAPTURAR valor idRestaurante por localshtorage Y LO MANDO POR GET PARA 
	GENERA LA LISTA DE RESERVAS, así como la fecha del filtro 
 ===================================*/
$("#fechaFiltro").change(function(){ //lstSelectRest es lista Select de restaurantes
	
	var idRestaurante=localStorage.getItem("idRestauranteLST");
	var nombreRestaurante=localStorage.getItem("nombreRestauranteLST");
	var fechaFiltro = $("#fechaFiltro").val();

	if (idRestaurante != ''){       		 
		window.location="index.php?ruta=administrar-reservas&idRest2="+idRestaurante+"&nomRest2="+nombreRestaurante+"&fechaFiltro="+fechaFiltro;
	 }else {
		   swal ( "Oops","Elija un restaurante", "error");                
	 }
			
})
 /*===============FIN=================*/
 /*======================================
= CARGAR DATOS DE LA RESERVA EN EL MODAL PARA EDITAR LA INFORMACION
======================================*/
 $(document).on("click", ".editarReserva", function(){
 	
 	$("#nuevaFecha").val("");
 	$("#horarioReserva").val("");
 	$("#nuevoPax").val("");
 	$("#enviarNuevaRsv").attr("disabled",true);
 	$("#nuevoHorario").addClass("hidden");
	$("#espacioPax").addClass("hidden");

 	var idReserva = $(this).attr("idReserva");
 	// console.log(idReserva);
 	$("#idDeLaReserva").val(idReserva);

 	var datos = new FormData();
 	datos.append("idReserva",idReserva);	
 	$.ajax({

		url:"ajax/reservas.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json
			// console.log("respuesta",respuesta);
			
			var cortarCadenaHora = respuesta["hora"];
					var inicio = 0;
					var fin = 8;
					var subCadenaHora=cortarCadenaHora.substring(inicio,fin);
					$("#fechaElaboracion").val(respuesta["fechaElaboracion"]); //le cargo en esos campos los resultados
					$("#fechaDeLaReserva").val(respuesta["fechaDeLaReserva"]);
					var fechaLimite=respuesta["fechaLimite"];
					var tieneFechaLimite = fechaLimite == null ? "SIN FECHA LIMITE" : fechaLimite;
					$("#fechaLimiteMax").val(tieneFechaLimite);
					$("#reserva").val(respuesta["reservaIdentificador"]);
					$("#nombreRestaurante").val(respuesta["nombreRestaurante"]);
					$("#apellido").val(respuesta["apellido"]);
					$("#pax").val(respuesta["pax"]);
					$("#observaciones").val(respuesta["observaciones"]);
					$("#habitacion").val(respuesta["habitacion"]);			
					$("#hora").val(subCadenaHora);

					var idhotel= respuesta["idHotel"];
					var idRestaurante= respuesta["idRestaurante"];

					localStorage.setItem("idHotelEditLS", idhotel);	//guardo en LocalStorage idhotel
					localStorage.setItem("idRestauranteEditLS", idRestaurante);	//guardo en LS idRestaurante
					localStorage.setItem("nuevoPaxLS", respuesta["pax"]);
		}					
	})


});
/*=====  FIN DE cargar reserva en el modal para editar la informacion  ======*/

/*======================================
= PARA QUE NO DEJE VACIO EL SELECT DE RESTAURANTE
y capturar el id del hotel y del restaurante
======================================*/
$("#lstSelectRestEdit").change(function(){   
    
    var idHotel = $("option:selected",this).attr("idhoteleditar");
    var idRestaurante = $("option:selected",this).attr("idrestauranteeditar");         
		var fechaLimiteMax = $("#fechaLimiteMax").val();
		var horaCierreRestaurante = $("option:selected", this).attr("horaCierre");
    // var nombreRestaurante= $("#lstSelectRestEdit option:selected").text();

    localStorage.setItem("idHotelEditNuevoLS", idHotel);//guardo en LocalStorage idhotel
		localStorage.setItem("idRestauranteNuevoLS", idRestaurante);//guardo en LS 
		localStorage.setItem("hcierreRestLST", horaCierreRestaurante);
		localStorage.setItem("fechaLimiteRSVLST", fechaLimiteMax);
    
	if (idRestaurante != '' && idRestaurante != undefined){       
      //  console.log("idRestaurante",idRestaurante); 
			//  console.log("idHotel",idHotel); 
			//  console.log("fechaLimiteRSV", fechaLimiteMax); 
			 activarRangoFechas();//ejecuto la funcion para mostrar la notificacion de los horarios de cierre
       $("#nuevaFecha").removeAttr("readonly");
    }
    else
         {
          swal ( "Oops","Elija un restaurante", "error");
					$("#nuevaFecha").attr("readonly",true); 
					$("#nuevoHorario").addClass("hidden");
          $("#nuevaFecha").val("");                  
    }              
})
// funcion para trabajar con las horas de cierre
function activarRangoFechas() {
	var horaCierreRestaurante = localStorage.getItem("hcierreRestLST");//obtengo el horario de cierre
	var fechaLimiteMax = localStorage.getItem("fechaLimiteRSVLST");//obtengo el horario de cierre

	var horaActual = obtenerHoraActual();
	var fechaHoy = obtenerFechaHoy();
	var fechaManana = obtenerFechaManana();

	if (horaCierreRestaurante == "SIN HORARIO") {	
		var fechaMinimoCal = horaCierreRestaurante == "SIN HORARIO" ? fechaHoy : fechaManana;
		var fechaMaximoCal = fechaLimiteMax == "SIN FECHA LIMITE" ? "" : fechaLimiteMax;
		$("#nuevaFecha").attr({ "min": fechaMinimoCal, "max": fechaMaximoCal });

		$.notify({
			message: '<i class="fas fa-sun"></i> <strong>Nota:</strong> Este restaurante no tiene definido un horario de cierre, puede hacer reservas para hoy ' + fechaHoy +' sin restricciones '  
		}, {
				type: 'info',
				z_index: 2000,
				delay: 5000
			});		
	} else {
			if (horaCierreRestaurante >= horaActual) {
				var fechaMinimoCal = horaCierreRestaurante >= horaActual ? fechaManana : fechaHoy;
				var fechaMaximoCal = fechaLimiteMax == "SIN FECHA LIMITE" ? "" : fechaLimiteMax;
				$("#nuevaFecha").attr({ "min": fechaMinimoCal, "max": fechaMaximoCal });
				var fechaMostrar = fechaHoy;
			} else {
				var fechaMostrar = fechaManana;
				var fechaMinimoCal = horaCierreRestaurante == "SIN HORARIO" ? fechaHoy : fechaManana;
				var fechaMaximoCal = fechaLimiteMax == "SIN FECHA LIMITE" ? "" : fechaLimiteMax;
				$("#nuevaFecha").attr({ "min": fechaMinimoCal, "max": fechaMaximoCal });
			}		
		$.notify({
			message: '<i class="fas fa-clock"></i> <strong>Nota:</strong> Este restaurante tiene horario definido de cierre, las reservas para hoy lo tiene que hacer antes de las ' + horaCierreRestaurante 
		}, {
				type: 'warning',
				z_index: 2000,
				delay: 5000
			});
		}
	}	

 /*======================================
= PARA QUE NO DEJE VACIO EL SELECT DE RESTAURANTE
======================================*/

/*======================================
= AL SELECCIONAR LA FECHA SE TRAE EL SEATING DE ESE DIA
estoy guardando los 
======================================*/
$("#nuevaFecha").change(function(){
	
	$("#enviarNuevaRsv").attr("disabled",true); //deshabilito boton de enviar aun si hay fecha seleccionada	

	var nuevaFecha = $("#nuevaFecha").val();	
	//obtengo de localStorage el id del restaurante y el nombre para el informe
	var idHotel = localStorage.getItem("idHotelEditNuevoLS");
 	var idRestaurante = localStorage.getItem("idRestauranteNuevoLS");
 	var nuevoPaxCampo = localStorage.getItem("nuevoPaxLS");
	
	var datos = new FormData();
	datos.append("fechaReservaObtenida",nuevaFecha);
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
			// console.log("respuesta",respuesta);			
			listaHorarios = "<span class='input-group-addon' id='basic-addon1'><i class='fas fa-clock'></i></span><select class='form-control horarioReserva' name='horarioReserva' id='horarioReserva'><option value=''></option>"
				for (i =0;  i<respuesta.length; i++) {
					var cortarCadenaHora = respuesta[i][4];
					var inicio = 0;
					var fin = 8;
					var subCadenaHora=cortarCadenaHora.substring(inicio,fin);
					listaHorarios+= "<option horaSeatingEdit="+respuesta[i][4]+" paxMaximo="+respuesta[i][5]+" reservaMaximas="+respuesta[i][6]+"  value="+subCadenaHora+">"+subCadenaHora+"</option>";
			}
			listaHorarios+="</select>";
			$("#nuevoHorario").html(listaHorarios);
			$("#nuevoPax").val(nuevoPaxCampo);							
			$("#nuevoHorario").removeClass("hidden");		
		}
	})

})
/*======================================
= fin
======================================*/
/*======================================
= HABILITAR BOTON de enviar SI campo horario esta lleno 
de paso muestro mensajes al usuario de la cantidad de pax y reservas
que se pueden hacer en la hora seleccionada de una fecha
previamene elegida.
======================================*/
$("#nuevoHorario").change(function(){

	$(".alert").remove(); 
	$("#saltoAlertaError").remove(); 
	$("#saltoAlertaWarning").remove();
	$("#espacioPax").removeClass("hidden");
	//Obtengo los pax maximo o cantida de reservas que puede hacer durante esa hora
	var reservaMaximas = $("option:selected",this).attr("reservaMaximas");
	var paxMaximo = $("option:selected",this).attr("paxMaximo");
	var paxStorage = localStorage.getItem("nuevoPaxLS");

	//guardo en localstorage las reservas y pax maximas
	localStorage.setItem("reservaMaximasLS", reservaMaximas);
	localStorage.setItem("paxMaximoLS", paxMaximo);

	$("#enviarNuevaRsv").attr("disabled",true);
	var valorHora= $("#nuevoHorario option:selected").val();	
	if (valorHora === '') {                    
	    $("#enviarNuevaRsv").attr("disabled",true); 
	    $("#nuevoPax").attr("readonly",true);
	    $("#nuevoPax").val(paxStorage);
	    $.notify({							
			message: '<i class="fas fa-exclamation-triangle"></i> <strong>Advertencia: </strong> Elige una hora del listado' 
			},{
			// settings
			type: 'error',
			z_index: 2000,
			delay: 6000
		});
	    $("#numReservasMax").val("");
	    $("#numDePaxMaxima").val("");

	   } else {         
	  $("#enviarNuevaRsv").removeAttr("disabled");
	  $("#nuevoPax").removeAttr("readonly");
	  $("#nuevoPax").val(paxStorage);
	  $.notify({							
		message: '<i class="fas fa-thumbs-up"></i> <strong>Nota:</strong> Para este día y hora se puede cubrir un limite de '+paxMaximo+' pax.' 
			},{
			// settings
			type: 'success',
			z_index: 2000,
			delay: 6000
		});		
	    $("#numReservasMax").val(reservaMaximas);
	    $("#numDePaxMaxima").val(paxMaximo);
	    
	}		
})
/*======================================
= HABILITAR BOTON de enviar SI campo horario esta lleno
======================================*/
$(".nuevoHorario").change(function(){

	var fechaDeLaReserva = $("#nuevaFecha").val();
	var horaDelSeating = $("option:selected",this).attr("horaSeatingEdit");
	//obtengo las variables desde localstorage
	var idRestaurante = localStorage.getItem("idRestauranteEditLS");
	var numReservasMax = localStorage.getItem("reservaMaximasLS");
	var numDePaxMaxima = localStorage.getItem("paxMaximoLS");
	
	var datos = new FormData();

	datos.append("fechaDeLaReserva",fechaDeLaReserva);
	datos.append("horaDelSeating",horaDelSeating);
	datos.append("idRestauranteSeating",idRestaurante);
	// console.log();	
		$.ajax({
			url: "ajax/reservasRestaurantes.ajax.php", //enviamos a este archivo para que lo procese
			method: "POST", //el envio es por POST
			data: datos, //datos es la instancia de ajax por el que se envia 
			cache: false,
			contentType: false,
			processData: false,
			dataType: "json", //los datos son de tipo json
			success: function (respuesta) {
				console.log("respuestaF", respuesta);
				var totalReservas = respuesta[0];
				var sumaPax = respuesta[1];

				if (sumaPax === null || totalReservas === null) {
					totalReservas = 0;
					sumaPax = 0;
				} else {
					totalReservas = respuesta[0];
					sumaPax = respuesta[1];
				}

				localStorage.setItem("totalReservasLS", totalReservas);
				localStorage.setItem("sumaPaxLS", sumaPax);

				$("#totalReservasHechas").val(totalReservas);
				$("#totalPaxAcumulados").val(sumaPax);

				if (numReservasMax === totalReservas || numDePaxMaxima === sumaPax) {
					$("#enviarNuevaRsv").attr("disabled", true);
					swal({
						title: "¡Error!",
						text: "Llegó al limite de pax/reservas que puede cubrir para esta hora, se ha hecho " + totalReservas + " reserva(s). Numero de pax: " + sumaPax + "",
						type: "error",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
					},
						function (isConfirm) {
							if (isConfirm) {
								window.location = "administrar-reservas"
							}
						});

				} else {
					var reservasPorHacer = numReservasMax - totalReservas;
					var paxFaltantes = numDePaxMaxima - sumaPax;
					var numReservasMax = localStorage.getItem("reservaMaximasLS");
					var numDePaxMaxima = localStorage.getItem("paxMaximoLS");
					var totalReservasHechas = localStorage.getItem("totalReservasLS");
					var totalPaxAcumulados = localStorage.getItem("sumaPaxLS");

					var a = numReservasMax;
					var ab = parseInt(a);
					var c = numDePaxMaxima;
					var cd = parseInt(c);

					var e = totalReservasHechas;
					var ef = parseInt(e);
					var g = totalPaxAcumulados;
					var gh = parseInt(g);

					var numRsvQuedan = ab - ef;
					var numPaxQuedan = cd - gh;
					var valorHora = $(".nuevoHorario option:selected").val();

					//sino elige hora del listado
					if (valorHora === '') {
						// $("#editarFechaHoraPax").before('<div class="alert alert-warning"><strong>Advertencia:</strong> Elige una hora del listado para poder hacer los calculos</div>');
						$.notify({
							message: '<i class="fas fa-exclamation-triangle"></i> <strong>Advertencia:</strong> Elige una hora del listado para poder hacer los calculos'
						}, {
								// settings
								type: 'warning',
								z_index: 2000,
								delay: 6000
							});

						$("#totalReservasHechas").val("");
						$("#totalPaxAcumulados").val("");
					} else {

						$.notify({
							message: '<i class="fas fa-clock"></i> <strong>Nota</strong> Para esta fecha tiene ' + totalReservas + ' reserva(s), con un total de ' + sumaPax + ' pax. Tiene espacio para un total de ' + numPaxQuedan + ' pax.'
						}, {
								// settings
								type: 'info',
								z_index: 2000,
								delay: 6000
							});

						$("#totalReservasHechas").val(totalReservas);
						$("#totalPaxAcumulados").val(sumaPax);
					}
				}
			}
		})
	  	
})
/*======================================
= CON ESTO NO PERMITO EL INGRESO DE ELEMENTOS QUE NO SEAN NUMERICOS en campo pax
======================================*/
$(document).on("input", "#nuevoPax", function(){
	this.value = this.value.replace(/[^0-9]/g,'');
})
/*======================================
= PARA VALIDAR QUE EN EL CAMPO PAX SOLO SE INGRESEN NUMEROS
======================================*/
 $("#nuevoPax").change(function(){ 	
 	var nuevoPax = $("#nuevoPax").val(); 	
 	var soloDigitos = this.value.replace(/[^0-9]/g,'');
 	
	    if(soloDigitos > 0 && soloDigitos < 100 && nuevoPax !=''){
	        // console.log("CORRECTO");
	        $("#enviarNuevaRsv").removeAttr("disabled");	        
	    }else{
	        swal ( "Oops" ,  "Ingrese un valor válido" ,  "error" )
	        $("#nuevoPax").val("");
	        $("#enviarNuevaRsv").attr("disabled",true);
	        $(".alert").remove();
	    }	 
 })

 /*======================================
= PARA el campo de observaciones
======================================*/
 $("#observaciones").change(function(){ 	
 	var campoObservaciones= $("#observaciones").val();	
	if (campoObservaciones === '') {                    
	    $("#enviarNuevaRsv").attr("disabled",true);	   	  
	   } else {        
	  $("#enviarNuevaRsv").removeAttr("disabled");	 
	}	 	
 })
/*===============================================
=         PARA ACTIVAR/DESACTIVAR UNA RESERVA  =
===============================================*/
$(document).on("click", ".btnActivarRSV", function(){

	var activarIdReserva = $(this).attr("idRsv");
	var activarEstadoReserva = $(this).attr("estadoRsv");

	var datos = new FormData();
	datos.append("activarIdReserva", activarIdReserva);
	datos.append("activarEstadoReserva", activarEstadoReserva);

	$.ajax({
		url:"ajax/reservas.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json					
		// console.log("respuesta",respuesta)				
		}
	})		
	if (activarEstadoReserva == 0) {

			$(this).removeClass('btn-success');
			$(this).addClass('btn-danger');
			$(this).html('Desactivado');
			$(this).attr('estadoRsv', 1);
		}
		else {
			$(this).removeClass('btn-danger');
			$(this).addClass('btn-success');
			$(this).html('Activado');
			$(this).attr('estadoRsv', 0);
		}

})
