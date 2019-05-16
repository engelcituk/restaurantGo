/*==============================================
	PARA CARGAR LA LISTA DE RESTAURANTES DE ACUERDO AL HOTEL SELECCIONADO desde el dropdown
 ===================================*/
 $(document).on("click", ".listaHotel", function(){
 	// ^--cuando se le da clic a la clase (listaHotel) obtengo el atributo id  	  	
	var idHotel= $(this).attr('idHotel');
	var nombreHotel = $(this).attr('nombreHotel'); 
		window.location="index.php?ruta=restaurantes&idHotel="+idHotel+"&nomHotel="+nombreHotel;	
	
})
 /*===============FIN=================*/
/*======================================
= con este cargo el id del hotel a registrar
======================================*/
$("#hotelElige").change( function(){ // al cambiar el foco se ejecuta ajax 
	var idDelHotel = $(this).val();
	// console.log("idDelHotel",idDelHotel);
	$("#idHotelReg").val(idDelHotel);
	
})
/*=====  con este cargo el id del hotel a registrar ======*/

 /*======================================
=            EDITAR RESTAURANTE            =
======================================*/
 $(document).on("click", ".editRestaurante", function(){
 	// ^--cuando se le da clic a la clase (editRestaurante) obtengo el atributo id
  	var idRestaurante = $(this).attr("idRstrnt");
  	//console.log("idRestaurante",idRestaurante);

	var datos = new FormData();
	datos.append("idRstrnt", idRestaurante);

	$.ajax({
		url:"ajax/restaurantes.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json

		success:function(respuesta){ //obtengo una respuesta tipo json
			// console.log("respuesta",respuesta);			
			$("#idRstrntEditar").val(respuesta["id"]); //le cargo en esos campos los resultados
			$("#editarNombre").val(respuesta["nombre"]);			
			$("#estadoRestaurante").val(respuesta["estado"]);//Siendo option ponemos eso en el html
			$("#editarEspecialidad").val(respuesta["especialidad"]);
			var horaCierre= respuesta["horaCierre"];
			$("#horaCierreResult").val(horaCierre);
			$("#noModificarHorarioEdit").val(horaCierre);
			$("#paxMaximoDiaEditar").val(respuesta["paxMaximoDia"]);
			localStorage.setItem("horaCierreEditLS", horaCierre);		
			
		}
	})
})
/*=====  FIN DE EDITAR restaurante  ======*/
/*======================================
=            ELIMINAR RESTAURANTE            =
======================================*/
$(document).on("click", ".eliminarRestaurante", function(){
	
	var idRestaurante = $(this).attr("idRstrnt");

	console.log("idRestaurante", idRestaurante);
	swal({
		  title: "¡Atención!",
		  text: "¿Esta seguro de eliminar el restaurante?",
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
		    window.location.href="index.php?ruta=restaurantes&idRestaurante="+idRestaurante;
		  } else {
		//Si se cancela se emite un mensaje
		    swal("Cancelado", "Ha cancelado la eliminacion del restaurante", "error");
		  }
		});
})
/*=====  FIN DE  ELIMINAR RESTAURANTE   ======*/
/*===============================================
=            PARA ACTIVAR EL restaurante         =
===============================================*/
$(document).on("click", ".btnActivarRstrnt", function(){

	var idRstrt = $(this).attr("idRstrnt");
	var estadoRstrt = $(this).attr("estadoRstrt");

	console.log("idRestaurante",idRstrt);	
	console.log("estadoRestaurante",estadoRstrt);

	var datos = new FormData();

	datos.append("idRestaurante", idRstrt);
	datos.append("estadoRestaurante", estadoRstrt);

	$.ajax({
		url:"ajax/restaurantes.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json			

			console.log("respuesta",respuesta);
		}
	})
		
		if (estadoRstrt == 0) {

			$(this).removeClass('btn-success');
			$(this).addClass('btn-danger');
			$(this).html('Desactivado');
			$(this).attr('estadoRstrt', 1);
		}
		else {
			$(this).removeClass('btn-danger');
			$(this).addClass('btn-success');
			$(this).html('Activado');
			$(this).attr('estadoRstrt', 0);
		}

})
/*=====  END OF PARA ACTIVAR EL HOTEL  ======*/

 /*==============================================
	PARA imprimir pdf de RESTAURANTES DE ACUERDO AL HOTEL SELECCIONADO desde el dropdown
 ===================================*/
 $(document).on("click", ".listaHotelPdf", function(){
 	// ^--cuando se le da clic a la clase (editarUsuario) obtengo el atributo id  	  	
    var idHotePdf= $(this).attr('idHotelPdf');   
	//envio por la variable get el id del hotel
})
 /*===============FIN=================*/

 
 /*======================================
= con este cargo el id del hotel a registrar 
======================================*/
$("#hotelElige2").change( function(){ // al cambiar el foco se ejecuta ajax 
	var idHotelPdf = $(this).val();
	if(idHotelPdf>0){
		window.open("extensiones/tcpdf/pdf/listaRestaurantes.php?idHotelPdf="+idHotelPdf, "_blank");	
	}else{
		idHotelPdf="null";
		window.open("extensiones/tcpdf/pdf/listaRestaurantes.php", "_blank");	
		// console.log();
	}
})
/*=====  con este cargo el id del hotel a registrar ======*/

//trabajo con los radios button para los horarios de cierre  de los restaurantes AL REGISTRAR O NO HORARIOS DE CIERRE
$('input[type=radio][name=horarioCierreRadio]').change(function() {
	if (this.value == 'SI') {
		// $("#horarioCierre").removeAttr("readonly");
		$('#horarioCierre').val("");
		$('#horarioCierre').removeClass('hidden');
		$("#horarioCierre").attr("name", "horarioCierre");
		$("#horarioCierre").prop("required", true);		
		$('#sinHorario').removeAttr('required');
		$('#sinHorario').removeAttr('name');	
		$('#sinHorario').addClass('hidden');
	}
	else if (this.value == 'NO') {		
		// $("#horarioCierre").attr("readonly",true);
		// $('#horarioCierre').prop('selectedIndex',0);
		$('#sinHorario').removeClass('hidden');
		$("#sinHorario").attr("name", "horarioCierre")
		$("#sinHorario").prop("required", true);		
		$('#horarioCierre').removeAttr('required');	
		$('#horarioCierre').removeAttr('name');
		$('#horarioCierre').addClass('hidden');
	}
});
$("#horarioCierre").change(function(){	
	var horaSeleccionada = $("#horarioCierre").val();
	// console.log("horaSeleccionada", horaSeleccionada);
	if(horaSeleccionada != ""){
		$("#radioSI").prop("checked", true);
	}else{				
		$("#radioNO").prop("checked", true);
	}
})

//radios button para los horarios de cierre  de los restaurantes AL EDITAR O NO HORARIOS DE CIERRE
$('input[type=radio][name=horaCierreRadioEdit]').change(function() {
	if (this.value == 'SI') {		
		$('#horarioCierreEdit').val("");
		$('#horarioCierreEdit').removeClass('hidden');
		$("#horarioCierreEdit").attr("name", "horarioCierreEdit");
		$("#horarioCierreEdit").prop("required", true);
		$('#noModificarHorarioEdit').removeAttr('required');
		$('#noModificarHorarioEdit').removeAttr('name');
		$('#noModificarHorarioEdit').addClass('hidden');
		$('#sinHorarioCierreNuevo').removeAttr('required');
		$('#sinHorarioCierreNuevo').removeAttr('name');
		$('#noModificarHorarioEdit').removeAttr('readonly');		
		$('#sinHorarioCierreNuevo').addClass('hidden');
	}
	else if (this.value == 'NO') {
		
		var valorCierre = localStorage.getItem("horaCierreEditLS");
		$('#noModificarHorarioEdit').val(valorCierre);
		$('#noModificarHorarioEdit').removeClass('hidden');
		$("#noModificarHorarioEdit").attr("name", "horarioCierreEdit")
		$("#noModificarHorarioEdit").prop("required", true);
		$('#horarioCierreEdit').removeAttr('required');
		$('#horarioCierreEdit').removeAttr('name');
		$('#horarioCierreEdit').addClass('hidden');
		$('#noModificarHorarioEdit').removeAttr('required');	
		$('#sinHorarioCierreNuevo').addClass('hidden');
	}
	else if (this.value == 'SIN HORARIO') {

		var valorCierre = localStorage.getItem("horaCierreEditLS");
		$('#sinHorarioCierreNuevo').val("SIN HORARIO");
		$('#sinHorarioCierreNuevo').removeClass('hidden');
		$("#sinHorarioCierreNuevo").attr("name", "horarioCierreEdit")
		$("#sinHorarioCierreNuevo").prop("required", true);
		$('#horarioCierreEdit').removeAttr('required');
		$('#horarioCierreEdit').removeAttr('name');
		$('#horarioCierreEdit').addClass('hidden');
		$('#noModificarHorarioEdit').removeAttr('required');
		$('#noModificarHorarioEdit').removeAttr('name');
		$('#noModificarHorarioEdit').addClass('hidden');
	}
});

/*para no permitir otros caracteres que no sean numeros en el campo paxMaximoDia de  Registrar Nuevo Restaurante*/
$(document).on("input", "#paxMaximoDia", function () {
	this.value = this.value.replace(/[^0-9]/g, '');
})
/**para validar que se ingresen numeros que cumplen las condiciones 
= PARA VALIDAR QUE EN EL CAMPO paxMaximoDia SOLO SE INGRESEN NUMEROS
======================================*/
$("#paxMaximoDia").change(function () {
	var paxMaximoDia = $("#paxMaximoDia").val();
	var soloDigitos = this.value.replace(/[^0-9]/g, '');
	if (soloDigitos > 0 && paxMaximoDia != '') {
		console.log("todo ok");
	} else {		
		$("#paxMaximoDia").val("");
		swal("Oops", "Ingrese un valor válido", "error")
	}
})

/*para no permitir otros caracteres que no sean numeros en el campo paxMaximoDia de  Editar Restaurante*/
$(document).on("input", "#paxMaximoDiaEditar", function () {
	this.value = this.value.replace(/[^0-9]/g, '');
})
/**para validar que se ingresen numeros que cumplen las condiciones 
= PARA VALIDAR QUE EN EL CAMPO paxMaximoDiaEditar SOLO SE INGRESEN NUMEROS
======================================*/
$("#paxMaximoDiaEditar").change(function () {
	var paxMaximoDiaEditar = $("#paxMaximoDiaEditar").val();
	var soloDigitos = this.value.replace(/[^0-9]/g, '');
	if (soloDigitos > 0 && paxMaximoDiaEditar != '') {
		console.log("todo ok");
	} else {
		$("#paxMaximoDiaEditar").val("");
		swal("Oops", "Ingrese un valor válido", "error")
	}
})