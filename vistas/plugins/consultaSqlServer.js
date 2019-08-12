/*======================================
=            BUSCAR HABITACION            =
======================================*/
 $(document).on("click", ".buscarReserva", function(){
	 // ^--cuando se le da clic a la clase (buscarReserva) obtengo el atributo id
	 	var hab = $("#campoBuscaHabitacion").val();
	 	var numHabitacion = hab.trim(); //elimino espacios a principio y final
		var horaCierreRestaurante = localStorage.getItem("horaCierreRestauranteLST");
		var idHotel = localStorage.getItem("idHotelLST");
		var idRestaurante = localStorage.getItem("idRestauranteLST");
		var nombreRestaurante = localStorage.getItem("nombreRestauranteLST");
		
  	if (numHabitacion != '') {
	  $("#idHotel2").val(idHotel);  
      $("#idRestaurante2").val(idRestaurante);
	  $("#campoNombreRestaurante").val(nombreRestaurante);
	  		$("#paxAdultos").val("");
			$("#paxCuna").val("");
			$("#paxJunior").val("");
			$("#paxNinio").val("");
			$("#paxSenior").val("");
      //Objeto formdata para transmitir los datos obtenidos
		var datos = new FormData();
		datos.append("numHabitacion", numHabitacion); 
		$.ajax({
			url:"ajax/reservasHuesped.ajax.php", //enviamos a este archivo numHabitacion para que lo procese
			method: "POST", //el envio es por POST
			data: datos, //datos es la instancia de ajax por el que se envia numHabitacion
			cache: false,
			contentType: false, 
			processData: false,
			dataType:"json", //los datos son de tipo json
			success:function(respuesta){ //obtengo una respuesta tipo json
				longitudRespuesta = respuesta.length;
				if (longitudRespuesta>0) { //si obtengo resultados muestro datos
					// console.log("respuesta", respuesta);
					var sumaPax=0;
					for (i = 0; i < respuesta.length; i++) {						
						sumaPax += parseInt(respuesta[i]["Ocupantes"]);
						var tipoPersona = respuesta[i]["TipoPersona"];
						if (tipoPersona =="AD"){
							$("#paxAdultos").val(respuesta[i]["Ocupantes"]);						
						} else if (tipoPersona == "CU"){
							$("#paxCuna").val(respuesta[i]["Ocupantes"]);
						} else if (tipoPersona == "JR") {
							$("#paxJunior").val(respuesta[i]["Ocupantes"]);
						} else if (tipoPersona == "NI") {
							$("#paxNinio").val(respuesta[i]["Ocupantes"]);
						} else if (tipoPersona == "SE") {
							$("#paxSenior").val(respuesta[i]["Ocupantes"]);
						}												
					}					
					var fecha = respuesta[0].FechaSalida;
					fechaMinima = localStorage.getItem("fechaMinimoLS");
					fechaMaxima = fecha.substring(0,10);//corto resto de cadena que sobra para la fecha MAxima
					// console.log("fechaMinimaLS",fechaMinima);
					$("#numHabitacion").val(respuesta[0]["Habitacion"])//le cargo en esos campos los resultados				
					$("#fechaReserva").attr({ "min": fechaMinima, "max": fechaMaxima });
					$("#fechaMaximaRSV").val(fechaMaxima);
					$('#datosHuesped').removeClass("hidden");
					$("#apellido").val(respuesta[0]["Apellido"]);
					$("#reserva").val(respuesta[0]["Reserva"]);
					$("#noches").val(respuesta[0]["Noches"]);
					$("#ocupantes").val(sumaPax);
					// $("#numeroDePax").val(sumaPax);
					$("#numHabitacion").val(respuesta[0]["Habitacion"]);
					$("#pax").val(sumaPax);
					$("#mensajeAlerta").hide();
					$("#mensajeAlerta").hide();
					$('#camposParaLaReserva').removeClass("hidden");

					//recorro los inpus, si estos estan vacios les pongo 0
					$('.paxDesglose').each(function () {
						if ($(this).val() == "") {
							$(this).val(0);
						}
					})
					//muestro las alertas de los horarios
					mostrarAlertasHorarios(horaCierreRestaurante);
					
					
				} else { 				
					$("#rowMensajeResultados").after('<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>¡Alerta! </strong> No se encontraron datos con el numero de habitacion proporcionado. Indique otro numero</div>');
					//limpio por si acaso
					$('#datosHuesped').addClass("hidden");
					$("#apellido").val("");
					$("#reserva").val("");
					$("#noches").val("");
					$("#ocupantes").val("");
					$("#numHabitacion").val("");
					$("#pax").val("");				
					setTimeout("location.href='hacer-reservas'", 2800);
				}						
			}
		})  
    }
    else
         {
          swal ( "Oops","No dejes el campo vacío de numero de habitación", "error");             
    }   		  
})
/*=====  FIN DE BUSCAR HABITACION  ======*/
function mostrarAlertasHorarios(horaCierreRestaurante){
	
	if(horaCierreRestaurante=="SIN HORARIO"){												
		$.notify({							
			message: '<i class="fas fa-sun"></i> <strong>Nota:</strong> Este restaurante no tiene definido un horario de cierre, puede hacer reservas para hoy sin restricciones' 
			},{								
				type: 'info',
				delay: 5000
			});
	}else{							
		$.notify({							
			message: '<i class="fas fa-clock"></i> <strong>Nota:</strong> Este restaurante tiene horario definido de cierre, las reservas para hoy lo tiene que hacer antes de las '+horaCierreRestaurante+'' 
			},{								
				type: 'warning',
				delay: 5000
			});						
	}
}
