/*======================================
=            BUSCAR HABITACION            =
======================================*/
 $(document).on("click", ".buscarReserva", function(){
 	// ^--cuando se le da clic a la clase (buscarReserva) obtengo el atributo id
  	var numHabitacion =$("#campoBuscaHabitacion").val();
  	if (numHabitacion != '') {              
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
				if (respuesta) { //si obtengo resultados muestro datos
					console.log("respuesta",respuesta);
					// $("#numHabitacion").val(respuesta["Habitacion"])//le cargo en esos campos los resultados
					$('#datosHuesped').removeClass("hidden");
					$("#apellido").val(respuesta["Apellido"]);
					$("#reserva").val(respuesta["Reserva"]);
					$("#noches").val(respuesta["Noches"]);
					$("#ocupantes").val(respuesta["Ocupantes"]);
					$("#numHabitacion").val(respuesta["Habitacion"]);
					$("#pax").val(respuesta["Ocupantes"]);
					$("#mensajeAlerta").hide();
					$("#mensajeAlerta").hide();
					$('#camposParaLaReserva').removeClass("hidden");

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
