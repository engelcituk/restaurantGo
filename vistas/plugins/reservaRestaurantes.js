/*======================================
= PARA QUE NO DEJE VACIO EL SELECT DE RESTAURANTE
======================================*/
$("#lstRestaurantes").change(function(){   
    // $(".alert").remove();
    var idHotel= $("#idHotelVar").val();
    var idRestaurante= $("#lstRestaurantes option:selected").val();
    var nombreRestaurante= $("#lstRestaurantes option:selected").text();
    //guardo en localstorage el id del hotel y restaurante, nombre restaurante
    localStorage.setItem("idHotelLST", idHotel);
    localStorage.setItem("idRestauranteLST", idRestaurante);
    localStorage.setItem("nombreRestauranteLST", nombreRestaurante);

    if (idRestaurante != ''){       
        $("#idRestauranteVar").val(idRestaurante);
        $("#campoBuscaHabitacion").removeAttr("readonly");
        $("#btnBuscarReserva").attr("disabled",true);
        $("#idHotel2").val(idHotel);
        $("#idRestaurante2").val(idRestaurante);
        $("#campoNombreRestaurante").val(nombreRestaurante);
    }
    else
         {
          swal ( "Oops","Elija un restaurante", "error")
          $("#idRestauranteVar").val("");
          $("#campoBuscaHabitacion").val("");
          $("#campoBuscaHabitacion").attr("readonly",true);
          $("#btnBuscarReserva").attr("disabled",true);
          $("#idHotel2").val(idHotel);
	      $("#idRestaurante2").val(idRestaurante);
	      $("#campoNombreRestaurante").val(nombreRestaurante);            
    }              
})
 /*======================================
= PARA QUE NO DEJE VACIO EL SELECT DE RESTAURANTE
======================================*/
/*======================================
= PARA QUE NO DEJE VACIO EL CAMPO DE NUMERO DE HABITACION
Y CON ELLO HABILITAR O DESHABILITAR BOTON DE BUSQUEDA DE
HABITACION
======================================*/
$("#campoBuscaHabitacion").change(function(){    
    // $(".alert").remove();
    var numDeHabitacion= $("#campoBuscaHabitacion").val();       
    if (numDeHabitacion != '') {              
        $("#btnBuscarReserva").removeAttr("disabled");
    }
    else
         {
          swal ( "Oops","Indique número de habitación", "error")          
          $("#btnBuscarReserva").attr("disabled",true);
          //limpio por si acaso
          $('#datosHuesped').addClass("hidden");
			$("#apellido").val("");
			$("#reserva").val("");
			$("#noches").val("");
			$("#ocupantes").val("");
			$("#numHabitacion").val("");
			$("#pax").val("");          
    }              
})
 /*======================================
= PARA QUE NO DEJE VACIO EL CAMPO DE NUMERO DE HABITACION
Y CON ELLO HABILITAR O DESHABILITAR BOTON DE BUSQUEDA DE
HABITACION
======================================*/

/*==============================================
	PARA CARGAR LA LISTA DE RESTAURANTES DEL HOTEL SELECCIONADO	
 ===================================*/
$("#hotelElige").change(function(){
	var idHotel= $("#hotelElige option:selected").val(); //obtener el value de un select
	var nombreHotel = $("option:selected",this).attr("nombreHotel");
	$("#idHotel").val(idHotel);
	$("#idHotel2").val(idHotel);
	$("#idRestauranteQ").val(" ");
	// console.log("idHotel", nombreHotel);

	var datos = new FormData();
	datos.append("idHotel",idHotel);

	$.ajax({
		url:"ajax/reservasRestaurantes.ajax.php", 
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia idHotel
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json								
			// console.log("respuesta",respuesta);
			listaRestaurante = "<select class='form-control' required><option value=''></option>"
				for (i =0;  i<respuesta.length; i++) {
					listaRestaurante+= "<option nr="+respuesta[i][2]+" idRestaurante="+respuesta[i][0]+" value="+respuesta[i][2]+">"+respuesta[i][2]+"</option>";
				}
			listaRestaurante+="</select>";
			$("#listaRestaurante").html(listaRestaurante);
			$("#nombreHotel").text(nombreHotel);
			$("#tituloNomHotel").text(nombreHotel);
			
		}
	})
})
 /*===============FIN=================*/

/*==============================================
	PARA capturar el id del restaurante	
 ===================================*/
$("#listaRestaurante").change(function(){
	//var idRestauranteQ = $("#listaRestaurante option:selected").val(); //obtener el atributo de un select
	var idRestauranteQ = $("option:selected",this).attr("idRestaurante");
	var nombreRestaurante = $("option:selected",this).text(); //obtengo el texto que tengo en la lista
	$("#idRestauranteQ").val(idRestauranteQ);
	$("#idRestaurante2").val(idRestauranteQ);
	$("#nombreRestaurante").text(nombreRestaurante);
	$("#campoNombreRestaurante").val(nombreRestaurante);
	localStorage.setItem("idRestauranteLS", idRestauranteQ);	
})
 /*===============FIN=================*/

/*==============================================
PARA TRAER LA CANTIDAD DE RESERVAS QUE LE CORRESPONDE AL HUESPED
	DE ACUERDO A SUS NOCHES DE ESTANCIA
	PARA MANDAR EL MENSAJE DE ALERTA
 ===================================*/
$("#fechaReserva").change(function(){
	$(".alert").remove();
	var nochesDeEstancia = $("#noches").val();	
	//recupero id hotel
	var idHotel2 = localStorage.getItem("idHotelLST");
	
	// console.log("idHotel",idHotel2);
	var datos = new FormData();
	datos.append("nochesDeEstancia",nochesDeEstancia);
	datos.append("idHotel2",idHotel2);
	
	$.ajax({
		url:"ajax/reservasRestaurantes.ajax.php", //enviamos a este archivo nochesDeEstancia para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json
		console.log("respuesta",respuesta);									
			var numMaxRsvHuesped = respuesta["numeroMaxDeReservas"];
			var nochesEstancia = respuesta["nochesEstancia"];
			var nochesEstanciaFalse = " No se encontró una configuración para las noches de estancia";
			var numMaxRsvHuespedFalse = "sin limite";

			if (respuesta) {
				$.notify({							
					message: '<i class="fas fa-moon"></i> <strong>Nota:</strong> El huesped tiene ' +nochesEstancia+' noches de estancia, por lo tanto puede hacer un máximo de '+numMaxRsvHuesped+' reserva(s).' 
					},{
						// settings
						type: 'info',
						delay: 6000
					});
				localStorage.setItem("numMaxRsvHuespedLST", numMaxRsvHuesped);//num. max. de reservas que puede hacer el huespd			
				$("#maxRsvHuesped").val(numMaxRsvHuesped);
			} else {
				$.notify({							
					message: '<i class="fas fa-moon"></i> <strong>Nota:</strong>' +nochesEstanciaFalse+' del huesped, puede hacer reservas '+numMaxRsvHuespedFalse+' .' 
					},{
						// settings
						type: 'info',
						delay: 6000
					});
				localStorage.setItem("numMaxRsvHuespedLST", numMaxRsvHuespedFalse);
				$("#maxRsvHuesped").val(numMaxRsvHuespedFalse);
				
			}									
		}
	})
})

/*======================================================
= PARA CAPTURAR LA FECHA ELEGIDA Y TRAER EL HORARIO 
DE ESE DÍA Y DE PASO TRAER LOS PAXMAXIMO O RESERVASMAXIMAS (QUE PONGO EN ATRIBUTOS QUE yo
ME INVENTO) 
======================================================*/
$("#fechaReserva").change(function(){
	
	var fechaReservaObtenida = $("#fechaReserva").val();
	var idHotel = localStorage.getItem("idHotelLST");
	var idRestaurante = localStorage.getItem("idRestauranteLST");
	var numOcupantes =$("#ocupantes").val();

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
			 console.log("respuesta",respuesta);
			 

			listaHorarios = "<div class='input-group-addon'><i class='fas fa-clock'></i></div><select class='form-control horarioReserva' name='horarioReserva' id='horarioReserva' required><option value=''></option>"
				for (i =0;  i<respuesta.length; i++) {
					var cortarCadenaHora = respuesta[i][4];
					var inicio = 0;
					var fin = 8;
					var subCadenaHora=cortarCadenaHora.substring(inicio,fin);
					listaHorarios+= "<option horaSeating="+respuesta[i][4]+" paxMaximo="+respuesta[i][5]+" reservaMaximas="+respuesta[i][6]+"  value="+respuesta[i][4]+">"+subCadenaHora+"</option>";
				}
			listaHorarios+="</select>";
			$("#horarioReserva").html(listaHorarios);
			$("#numeroDePax").val(numOcupantes);					
		}
	})
 })

/*=====  END OF PARA CAPTURAR LA FECHA ELEGIDA  ======*/

/*==============================================
	PARA TRAER LAS MESAS DISPONIBLES y mostrar mensaje() reservas/pax que se pueden hace)
 ===================================*/
$("#horarioReserva").change(function(){
	$(".alert").remove();
	var idRestaurante = localStorage.getItem("idRestauranteLST");
	var valueHorario = $("option:selected",this).text();
	//obtengo el valor de los atributos que me serviran para hacer calculos
	//los enviaré a campos ocultos
	var paxMaximo = $("option:selected",this).attr("paxMaximo"); 
	var reservaMaximas = $("option:selected",this).attr("reservaMaximas");
	// console.log("paxMaximo",paxMaximo);
	// console.log("reservaMaximas",reservaMaximas);
	if (valueHorario != '') {
		var datos = new FormData();
		datos.append("idRestauranteQ",idRestaurante);
			$.ajax({
				url:"ajax/reservasRestaurantes.ajax.php", //enviamos a este archivo idRestaurante para que lo procese
				method: "POST", //el envio es por POST
				data: datos, //datos es la instancia de ajax por el que se envia el id
				cache: false,
				contentType: false,
				processData: false,
				dataType:"json", //los datos son de tipo json
				success:function(respuesta){ 
					// console.log("RespuestaMesas", respuesta);
					localStorage.setItem("reservaMaximasLST", reservaMaximas);
					localStorage.setItem("paxMaximoLST", paxMaximo);

					$("#numReservasMax").val(reservaMaximas);
					$("#numDePaxMaxima").val(paxMaximo);
					
					// $("#msjPaxYReservasMax").after("<div class='alert alert-info alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a></div>");
					$.notify({							
						message: '<i class="fas fa-clock"></i><strong> Nota 2:</strong> Para este día y hora se puede cubrir un limite de '+paxMaximo+' pax..' 
						},{
						// settings
						type: 'info',
						delay: 6000
					});
			}	
		})                    	     	   	 
		  	
	}
	else
		 {
		  swal ( "Oops","Elija un horario por favor", "error")		
	}	
})
 /*===============FIN=================*/
 /*==================================================================
 =traigo el NUMERO DE PAX O TOTAL DE RESERVAS ya realizados en ese seating 
 ==================================================================*/
$("#horarioReserva").change(function(){
	var valueHorario2 = $("option:selected",this).text();
	//capturo la fecha y la hora elegida
	var fechaDeLaReserva = $("#fechaReserva").val();
	var horaDelSeating = $("option:selected",this).attr("horaSeating"); 

	var numReservasMax = $("#numReservasMax").val(); //obtengo estos valores para hacer calculos
	var numDePaxMaxima = $("#numDePaxMaxima").val(); //obtengo estos valores para hacer calculos
	var idRestauranteSeat = localStorage.getItem("idRestauranteLS");			

  	var datos = new FormData();
	datos.append("fechaDeLaReserva",fechaDeLaReserva);
	datos.append("horaDelSeating",horaDelSeating);	
	datos.append("idRestauranteSeating",idRestauranteSeat);
	
  	$.ajax({
  		url:"ajax/reservasRestaurantes.ajax.php", //enviamos a este archivo para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia 
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){
			console.log("respuestaF",respuesta);
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

			$("#totalReservasHechas").val(totalReservas);
			$("#totalPaxAcumulados").val(sumaPax);
	
			if (numReservasMax===totalReservas || numDePaxMaxima===sumaPax) {
				mensaje = "<div class='alert alert-danger alert-dismissible'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><strong>Error!</strong> Ya alcanzó el numero maximo de reservas que puede realizar para esta fecha y hora,  se ha hecho "+totalReservas+" reserva(s). Numero de pax: "+sumaPax+"</div>";
					$("#msjReservasHechasSeating").html(mensaje);
					setTimeout("location.href='hacer-reservas'", 4000);

			} else {
				var reservasPorHacer = numReservasMax-totalReservas;
				var paxFaltantes = numDePaxMaxima-sumaPax;
				
				var numReservasMax = localStorage.getItem("reservaMaximasLST"); //para hacer calculos
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

			  	var numRsvQuedan = ab - ef;
			  	var numPaxQuedan = cd - gh;	

			  	console.log("numRsvQuedan",numRsvQuedan);
			  	console.log("numPaxQuedan",numPaxQuedan);										
				
				if (valueHorario2 != '') {	             
		             $.notify({							
						message: '<i class="fas fa-table"></i> <strong>Nota 3:</strong> Para esta fecha y hora tiene '+totalReservas+' reserva(s), con un total de '+sumaPax+' pax.' 
						},{
						// settings
						type: 'info',
						delay: 12000
						});				
						$.notify({							
							message: '<i class="fas fa-users"></i> <strong>Nota 4:</strong> Tiene espacio para cubrir un total de '+numPaxQuedan+' pax.' 
							},{
							// settings
							type: 'info',
							delay: 18000
						});       	     	   	 		  
					}else{
					  		console.log("o.O elija horario");	
				}						
			}				
		}
  	})	  		  	
})

 /*=====  FIN VALIDAR SI AL INTENTAR RESERVAR NO SE PASA DEL NUMERO DE PAX O TOTAL DE RESERVAS DEL SEATING CONFIGURADO ======*/

 /*==================================================================
 =            VALIDAR QUE EL HUESPED PUEDA HACER RESERVA
 TRAIGO LA CANTIDA DE RESERVAS QUE HA HECHO EL HUESPED            =
 ==================================================================*/
  $("#ticketElige").change(function(){

  	//traigo el identificador de la reserva del hotel y max de reservas que el huesped puede hacer
  	var idReservaHotel = $("#reserva").val();
  	var ticketIdioma = $("option:selected",this).text();

  	console.log("ticketIdioma",ticketIdioma);

  	var maxRsvHuesped = localStorage.getItem("numMaxRsvHuespedLST"); 

  	if (ticketIdioma != '') {
  		var datos = new FormData();
		datos.append("idReservaHotel",idReservaHotel);

	  	$.ajax({
			url:"ajax/reservasRestaurantes.ajax.php", //enviamos a este archivo idReservaHotel para que lo procese
			method: "POST", //el envio es por POST
			data: datos, //datos es la instancia de ajax por el que se envia idReservaHotel
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json", //los datos son de tipo json
			success:function(respuesta){ 

			console.log("reservashuesped",respuesta);
			
				 totalRsvHuesped = respuesta[0];
				 //convierto los valores string que recibo, para poder hacer operaciones como numeros 
				 var valorMaxRsvHuesped=maxRsvHuesped;
				 var numeroMaxRsvHuesped=parseInt(valorMaxRsvHuesped);

				 var valorTotalRsvHuesped=totalRsvHuesped;
				 var numeroTotalRsvHuesped=parseInt(valorTotalRsvHuesped);
					
				 rsvDisponibles = numeroMaxRsvHuesped - numeroTotalRsvHuesped;		
															
				if(numeroMaxRsvHuesped > numeroTotalRsvHuesped) {								
					$.notify({							
						message: '<i class="fas fa-file-signature"></i><strong> Nota 5:</strong> Esta persona ha hecho '+totalRsvHuesped+' reserva(s). Le quedan '+rsvDisponibles+' disponible(s).' 
						},{
						// settings
						type: 'success',
						delay: 6000
					});
					
				}
				else if(numeroMaxRsvHuesped == numeroTotalRsvHuesped) {					
					$.notify({							
						message: '<i class="fas fa-times"></i> <strong>Error :(!</strong> Ya alcanzó el numero maximo de reservas que puede realizar para esta persona,  ha hecho '+totalRsvHuesped+' reserva(s). Le quedan '+rsvDisponibles+' disponible(s)' 
						},{
						// settings
						type: 'danger',
						delay: 4000
					});
					setTimeout("location.href='hacer-reservas'", 4000);
				}
				else if (maxRsvHuesped = "sin limites"){								
					
					$.notify({							
						message: '<i class="fas fa-times"></i> <strong>Nota!</strong> Esta persona ha hecho '+totalRsvHuesped+' reserva(s). Puede hacer reservas sin limite.' 
						},{
						// settings
						type: 'success',
						delay: 6000
					});				
					// setTimeout("location.href='hacer-reservas'", 4000);
				}
			}
		})

	}else{
		swal ( "Oops","Elija el idioma para el ticket", "error");	
	}
	  	
 })
  /*=====  END OF VALIDAR QUE EL HUESPED PUEDA HACER RESERVA  ======*/


