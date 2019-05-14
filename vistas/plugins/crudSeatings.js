/*==============================================
CARGAR LA LISTA DE RESTAURANTES DE ACUERDO AL HOTEL SELECCIONADO DESDE EL SELECT
---OCUPADO para filtrar datos CON el datatable 
 ===================================*/
 $("#lstSelectHotel").change(function(){
 	// ^--cuando se le da clic a (lstSelectHotel) obtengo el atributo id  	
 	var idhotelLstSeating = $("option:selected",this).attr("idhotelLstSeating");
	var nombreHotel = $("option:selected",this).text();
	localStorage.setItem("nombreHotelLS",nombreHotel);
   	// console.log(idhotelLstSeating);
	var datos = new FormData();
	datos.append("idHotel",idhotelLstSeating);

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
			listaRestaurante = "<select class='form-control' required><option value=''>Elige Restaurante</option>"
				for (i =0;  i<respuesta.length; i++) {
					listaRestaurante+= "<option nr="+respuesta[i][2]+" idRestaurante="+respuesta[i][0]+" value="+respuesta[i][0]+">"+respuesta[i][2]+"</option>";
				} 
			listaRestaurante+="</select>";
			 $("#lstSeatingRestaurante").html(listaRestaurante);												
		}
	})
})
 /*===============FIN=================*/
 /*==============================================
CARGAR LA LISTA DE RESTAURANTES DE ACUERDO AL HOTEL SELECCIONADO DESDE un SELECT
OCUPADO EN EL MODAL EN LA CREACION DE NUEVOS SEATINGS
 ===================================*/
 $("#lstHotelNuevoSeating").change(function(){
 	// ^--cuando se le da clic a (lstSelectHotel) obtengo el atributo id  	
 	var idhotelLstSeating = $("option:selected",this).attr("idhotelLstSeating");
	var nombreHotel = $("option:selected",this).text();
	//CON localStorage GUARDO EL ID DEL HOTEL
   	localStorage.setItem("idHotelSeatingLS", idhotelLstSeating);
   	$("#idHotelfield").val(idhotelLstSeating);

   	$(".alert").remove();

   	if (nombreHotel === '') {                    
	    swal ( "Oops" ,  "Elija un hotel de la lista" ,  "error" );   	  
	}

	var datos = new FormData();
	datos.append("idHotel",idhotelLstSeating);

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
					listaRestaurante+= "<option nr="+respuesta[i][2]+" idRestaurante="+respuesta[i][0]+" value="+respuesta[i][0]+">"+respuesta[i][2]+"</option>";
				}
			listaRestaurante+="</select>";
			 $("#lstNuevoSeatingRest").html(listaRestaurante);						 				
		}
	})
})
 /*===============FIN=================*/
 /*==============================================
CARGAR LA LISTA DE RESTAURANTES DE ACUERDO AL HOTEL SELECCIONADO desde el dropdown
 ===================================*/
 $("#lstSeatingRestaurante").change(function(){
 	// ^--cuando se le da clic a la clase (editarUsuario) obtengo el atributo id  	
	var nombreRestaurante = $("option:selected",this).text();
	$("#migaRestauranteSeating").html(nombreRestaurante);	
})
 /*===============FIN=================*/

 /*===============================================
=         PARA ACTIVAR/DESACTIVAR UNA SEAting  =
===============================================*/
$(document).on("click", ".btnActivarSeating", function(){

	var activarIdSeating = $(this).attr("idSeating");
	var activarEstadoSeating = $(this).attr("estadoSeating");	

	var datos = new FormData();
	datos.append("activarIdSeating", activarIdSeating);
	datos.append("activarEstadoSeating", activarEstadoSeating);

	$.ajax({
		url:"ajax/seatings.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json					
		console.log("respuesta",respuesta)				
		}
	})		
	if (activarEstadoSeating == 0) {

			$(this).removeClass('btn-success');
			$(this).addClass('btn-danger');
			$(this).html('Desactivado');
			$(this).attr('estadoSeating', 1);
		}
		else {
			$(this).removeClass('btn-danger');
			$(this).addClass('btn-success');
			$(this).html('Activado');
			$(this).attr('estadoSeating', 0);
		}

})

/*======================================
= CARGAR DATOS del seating en el modal para editar la informacion
======================================*/
 $(document).on("click", ".editarSeating", function(){
 	 	
 	var idSeatingEditar = $(this).attr("idSeatingEditar");
 	console.log(idSeatingEditar);
 	
 	var datos = new FormData();
 	datos.append("idSeatingEditar",idSeatingEditar);	
 	$.ajax({

		url:"ajax/seatings.ajax.php", //enviamos a este archivo el id para que lo procese
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
			$("#idSeating").val(respuesta["idSeating"]);			
			$("#nombreHotel").html(respuesta["nomHotel"]); 
			$("#nombreRestaurante").html(respuesta["nomRestaurante"]);
			$("#diaSeating").html(respuesta["diaSemana"]);
			$("#horaSeating").html(subCadenaHora);
			$("#numeroPax").html(respuesta["pm"]);
			$("#numeroReservas").html(respuesta["rm"]);

			localStorage.setItem("paxMaximasLS", respuesta["pm"]);
			localStorage.setItem("rsvMaximasLS", respuesta["rm"]);	
		}					
	})


});
/*=====  FIN DE cargar seating en el modal para editar la informacion  ======*/

/*======================================
= CON ESTO NO PERMITO INGRESAR ELEMENTOS QUE NO SEAN
 NUMEROS A LOS CAMPOS PAX Y RESERVA
======================================*/ 
$(document).on("input", "#numPaxEditar", function(){
	this.value = this.value.replace(/[^0-9]/g,'');
})

$(document).on("input", "#numRsvEditar", function(){
	this.value = this.value.replace(/[^0-9]/g,'');
})
/*======================================
=fin  NO PERMITO INGRESAR ELEMENTOS QUE NO SEAN
 NUMEROS A LOS CAMPOS PAX Y RESERVA
======================================*/
/*======================================
= PARA VALIDAR QUE EN EL CAMPO PAX SOLO SE INGRESEN NUMEROS
mayores a cero
======================================*/
 $("#numPaxEditar").change(function(){ 	
 	var numPaxEditar = $("#numPaxEditar").val(); 	
 	var soloDigitos = this.value.replace(/[^0-9]/g,'');
 	
	    if(soloDigitos > 0 && soloDigitos < 100 && numPaxEditar !=''){
	        // console.log("CORRECTO");
	        $("#regNuevoSeating").removeAttr("disabled");	        
	    }else{
	        swal ( "Oops" ,  "Ingrese un valor válido" ,  "error" )
	        $("#numPaxEditar").val("");
	        $("#regNuevoSeating").attr("disabled",true);
	        
	    }	 
 })
 /*======================================
= PARA VALIDAR QUE EN EL CAMPO NUMERO DE RESERVAS
 SOLO SE INGRESEN NUMEROS
mayores a cero
======================================*/
 $("#numRsvEditar").change(function(){ 	
 	var numRsvEditar = $("#numRsvEditar").val(); 	
 	var soloDigitos = this.value.replace(/[^0-9]/g,'');
 	
	    if(soloDigitos > 0 && soloDigitos < 30 && numRsvEditar !=''){
	        // console.log("CORRECTO");
	        $("#enviarNuevoSeating").removeAttr("disabled");	        
	    }else{
	        swal ( "Oops" ,  "Ingrese un valor válido" ,  "error" )
	        $("#numRsvEditar").val("");
	        $("#enviarNuevoSeating").attr("disabled",true);	        
	    }	 
 }) 

 /*==============================================
	PARA MOSTRAR SOLO LOS RESTAURANTES REQUERIDOS
	DE ACUERDO AL SELECT ELEGIDO	
 ===================================*/
$("#lstSeatingRestaurante").change(function(){ //lstSeatingRestaurante es lista Select de restaurantes	
	var idRestaurante = $("#lstSeatingRestaurante").val();
	var nombreRestaurante = $("option:selected",this).text(); //obtengo el texto que tengo en la lista	
	console.log("idRestaurante",idRestaurante);
		
		nombreHotelLS=localStorage.getItem("nombreHotelLS");
		window.location="index.php?ruta=configuracion-seatings&idRestaurante="+idRestaurante+"&nomHotel="+nombreHotelLS+"&nomRest="+nombreRestaurante;
		$("#migaHotelSeating").html(nombreHotelLS);
	
	console.log("nombreHotelLS",nombreHotelLS);
})
 /*===============FIN=================*/
 /*======================================
= PARA MOSTRAR LA LISTA DE HORARIOS
SI HAY UN RESTAURANT ELEGIDO
======================================*/
 $("#lstNuevoSeatingRest").change(function(){
 	$(".alert").remove();
 	var lstNuevoSeatingRest = $("#lstNuevoSeatingRest").val();
	var idRestaurante = $("option:selected",this).attr("idrestaurante");
 	//CON localStorage GUARDO EL ID DEL RESTAURANTE
   	localStorage.setItem("idRestauranteSeatingLS", idRestaurante);
   	var idHotelLS = localStorage.getItem("idHotelSeatingLS");

   	$("#idHotelfield").val(idHotelLS);
 	$("#idRestaurantefield").val(idRestaurante);

 	if (lstNuevoSeatingRest === '') {                    
	    $("#lstHoraSeating").addClass("hidden");
	    swal ( "Oops" ,  "Elija un restaurante" ,  "error" )
	   } else {        
	  $("#lstHoraSeating").removeClass("hidden");	 
	}		
 })
 /*======================================
= PARA TRABAJAR CON LA LISTA DE HORARIOS
EVITAR QUE UN HORARIO YA TOMADO SE REPITA
DENTRO DE LOS SEATINGS--Validar seatings
======================================*/
$("#catalogoHorarios").change(function(){
	$(".alert").remove();
	var horaElegida = $("#catalogoHorarios").val();
	/*======================================
	obtengo los valores guardados en localstorage
	(el id del hotel y restaurante)
	======================================*/
 	var idHotelLS = localStorage.getItem("idHotelSeatingLS");
 	var idRestauranteLS = localStorage.getItem("idRestauranteSeatingLS");
 	//los id: (idHotelLS idRestauranteLS) los envío a unos campos ocultos para 
 	//tomarlos en php para hacer el registro a php
 	$("#idHotelfield").val(idHotelLS);
 	$("#idRestaurantefield").val(idRestauranteLS);

 	// console.log(idHotelLS);
 	// console.log(idRestauranteLS);
 	if (horaElegida != '') {                    	     	   	 	
	  	 var datos = new FormData();
		 datos.append("idHotelVS",idHotelLS);
		 datos.append("idRestauranteVS",idRestauranteLS);
		 datos.append("horaElegidaVS",horaElegida);

		 $.ajax({
			url:"ajax/seatings.ajax.php", //enviamos a este archivo el nombreUsuario para que lo procese
			method: "POST", //el envio es por POST
			data: datos, //datos es la instancia de ajax por el que se envia el id
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json", //los datos son de tipo json
			success:function(respuesta){ //obtengo una respuesta tipo json							
				//si se regresa un array con valores
				if (respuesta.length>0) {
					$(".alert").remove();
					$("#mensajeHoraDisponible").after('<div class="alert alert-warning"><strong>Horario ocupado</strong></div>');
					// swal("Oops", "Horario ocupado", "error");
					$("#campoPaxModal").addClass("hidden");
		  			$("#campoPaxRSV").addClass("hidden");
		  			$("#catalogoHorarios").val("");		  			
		  			$("#btnNuevoSeating").attr("disabled",true);
		  			$("#numPaxModal").val("");
					$("#numRSVModal").val("");

				}else{
					$(".alert").remove();				
					$("#mensajeHoraDisponible").after('<div class="alert alert-success"><strong>Horario disponible</strong> </div>');
					$("#campoPaxModal").removeClass("hidden");
					$("#campoPaxRSV").removeClass("hidden");
				}			
			}
		})
	}
	else
		 {
		  swal ( "Oops","Elija un horario", "error");		  
		  $("#campoPaxModal").addClass("hidden");
		  $("#campoPaxRSV").addClass("hidden");
	}		
})


/*======================================
= CON ESTO NO PERMITO INGRESAR ELEMENTOS QUE NO SEAN
 NUMEROS A LOS CAMPOS PAX Y RESERVA EN EL MODAL DE 
 NUEVO SEATING
======================================*/ 
$(document).on("input", "#numPaxModal", function(){
	this.value = this.value.replace(/[^0-9]/g,'');
})
$(document).on("input", "#numRSVModal", function(){
	this.value = this.value.replace(/[^0-9]/g,'');
})
/*======================================
= PARA VALIDAR QUE EN EL CAMPO PAX SOLO SE INGRESEN NUMEROS
MAYORES A CERO EN EL MODAL DE NUEVO SEATING
======================================*/
 $("#numPaxModal").change(function(){ 	
 	var numPaxModal = $("#numPaxModal").val(); 	
 	var soloDigitos = this.value.replace(/[^0-9]/g,''); 	
	    if(soloDigitos > 0 && soloDigitos < 100 && numPaxModal !=''){	       
	        $("#btnNuevoSeating").removeAttr("disabled");	        
	    }else{
	        $("#btnNuevoSeating").attr("disabled",true);	        
	        $("#numPaxModal").val("");
	        swal ( "Oops" ,  "Ingrese un valor válido" ,  "error" )
	    }	 
 })

/*======================================
= PARA VALIDAR QUE EN EL CAMPO CANTIDAD
DE RESERVAS SOLO SE INGRESEN NUMEROS
MAYORES A CERO EN EL MODAL DE NUEVO SEATING
======================================*/
 $("#numRSVModal").change(function(){ 	
 	var numRSVModal = $("#numRSVModal").val(); 	
 	var soloDigitos = this.value.replace(/[^0-9]/g,'');
 	
	    if(soloDigitos > 0 && soloDigitos < 30 && numRSVModal !=''){	       
	        $("#btnNuevoSeating").removeAttr("disabled");	        
	    }else{
	        $("#btnNuevoSeating").attr("disabled",true);
	        $("#numRSVModal").val("");
	        swal ( "Oops" ,  "Ingrese un valor válido" ,  "error" )
	        
	    }	 
 })
