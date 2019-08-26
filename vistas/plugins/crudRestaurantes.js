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
});
/*======================================
=            EDITAR RESTAURANTE            =
======================================*/
function cierreRestaurante(idRestaurante,nombreRestaurante, idHotel){ 
	// ^--cuando se le da clic a la clase (editRestaurante) obtengo el atributo id
	// var idRestaurante = $(this).attr("idRstrnt");
	// var nombreRestaurante = $(this).attr("nRestaurante");
	$("#cierresRestaurante tbody").empty();//limpio la tabla para cargale lo que traigo por ajax
	getDatosHotel(idHotel);
	$("#nombreRestSpan").text(nombreRestaurante);	
	var datos = new FormData();
	datos.append("idRestauranteCierre", idRestaurante);	
	$.ajax({
		url: "ajax/restaurantes.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json", //los datos son de tipo json
		success: function (respuesta) { //obtengo una respuesta tipo json						
			var longitud = Object.keys(respuesta).length;			
			if (longitud>0){
				// console.log("si tiene respuesta exitossa", longitud);				 
				for (i = 0; i < longitud; i++) {
					var idFecha = respuesta[i]["id"];
					var fechaInicio = respuesta[i]["fechaInicio"];
					var fechafinal = respuesta[i]["fechaFin"];
					itemFechaCierre = "<tr id='fila"+idFecha+"'><td>" + fechaInicio + "</td><td>" + fechafinal + "</td><td><button type='button' class='btn btn-danger btnRemoveFecha' onclick='borrarFecha("+idFecha+")'><i class='fa fa-trash'></i></button></td></tr>";
					$("#cierresRestaurante tbody").append(itemFechaCierre);
					$("#add").attr("idRestaurante", idRestaurante); 
				}
			}else{
				itemFechaCierre = "<tr><td colspan='4'>Este restaurante no tiene fechas de cierre a mostrar</td></tr>";
				$("#cierresRestaurante tbody").append(itemFechaCierre);
				$("#add").attr("idRestaurante", idRestaurante);
			}
		}
	})
	
}
function getDatosHotel(idHotel) {
	var datos = new FormData();
	datos.append("idHotel", idHotel);
	$.ajax({
		url: "ajax/hoteles.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json", //los datos son de tipo json
		success: function (respuesta) { //obtengo una respuesta tipo json	
			var nombreHotel = respuesta["nombre"];
			$("#nombreHotelSpan").text(nombreHotel);			
		}
	})
}
//limpio los tr dinamicos al ocultal modal
$('#cierreRestaurante').on('hidden.bs.modal', function (e) {
	$("#fechaDinamica tbody").empty();//limpio la tabla para cargale lo que traigo por ajax
});
/*=====  FIN DE EDITAR restaurante  ======*/
$(document).ready(function () {
	var i = 0;
	$('#add').click(function () {
		var fechaHoy = fechaActual();
		var fechaSiguiente = fechaManiana();
		var idRestaurante = $("#add").attr("idRestaurante");
		i++;
		$('#fechaDinamica').append('<tr id="row' + i + '" class="dynamic-added"><td><input type="date" id="fechaInicio' + i + '" name="fechaInicio[]" min="' + fechaHoy + '" class="form-control" value="' + fechaHoy + '"/></td><td><input type="date" id="fechaFinal' + i + '" name="fechaFinal[]"  min="' + fechaHoy + '" class="form-control" value="' + fechaSiguiente + '"/></td><td><button type="button" name="remove" id="' + i + '" class="btn btn-danger btn_remove"><i class="fa fa-trash "></i></button></td><td><button type="button" name="save" id="' + i + '" class="btn btn-primary btn_save" onclick="validarFecha(' + idRestaurante+','+i+')"><i class="fas fa-save"></i></button></td></tr>');
	});
	//remover fila tabla
	$(document).on('click', '.btn_remove', function () {
		var button_id = $(this).attr("id");
		$('#row' + button_id).remove();
	});
});
//borrar fechas de cierre
function borrarFecha(idFecha){			
	swal({
		title: "Estás seguro?",
		text: "No podrás recuperar esta fecha",
		type: "warning",
		showCancelButton: true,
		confirmButtonColor: "#DD6B55",
		confirmButtonText: "Sí, Borrar!",
		cancelButtonText: "Cancelar",
		closeOnConfirm: false
	}, function (isConfirm) {
		if (!isConfirm) return;
		$.ajax({
			url: "restaurantes",
			type: "POST",
			data: {
				idFecha: idFecha
			},
			dataType: "html",
			success: function (respuesta) {
				swal("Exito!", "Su dato ha sido borrado exitosamente!", "success");
				$('#fila' + idFecha).remove();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				swal("Ocurrió un error!", "Por favor intente de nuevo", "error");
			}
		});
	});
}
function validarFecha(idRestaurante,idFila){
	var fechaInicio = $("#fechaInicio"+idFila).val();
	var fechaFin = $("#fechaFinal" + idFila).val();
	
	if (fechaInicio != '' && fechaFin != '') {
		if (fechaInicio <= fechaFin) {
			// hago la operacion aquí 
			var datos = new FormData();
			datos.append("idRestCierreAdd", idRestaurante);
			datos.append("fechaInicio", fechaInicio);
			datos.append("fechaFin", fechaFin);

			$.ajax({
				url: "ajax/restaurantes.ajax.php", //enviamos a este archivo el id para que lo procese
				method: "POST", //el envio es por POST
				data: datos, //datos es la instancia de ajax 
				cache: false,
				contentType: false,
				processData: false,
				dataType: "json", //los datos son de tipo json
				success: function (respuesta) { //obtengo una respuesta tipo json								
					var longitud = Object.keys(respuesta).length;
					if (longitud > 0) {						
						swal("Oops", "Ya existen datos iguales a la ingresada", "error");
						} else {
						//verifico si en el restaurante no hay reservas
						verificaSinoHayReservas(idRestaurante, fechaInicio, fechaFin, idFila);
					}
				}
			});

		} else if (fechaInicio > fechaFin) {
			swal("Oops", "La fecha de inicio "+ fechaInicio+" es mayor que la fecha final " + fechaFin, "error");
		}
	} else {
		swal("Oops", "No dejes campos de fecha vacios", "error");
	}
}
function verificaSinoHayReservas(idRestaurante, fechaInicio, fechaFin, idFila) {

	var nombreRestaurante = $("#nombreRestSpan").text();

	var datos = new FormData();
	datos.append("idRestCierre2", idRestaurante);
	datos.append("fechaInicio", fechaInicio);
	datos.append("fechaFin", fechaFin);

	$.ajax({
		url: "ajax/reservasRestaurantes.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json", //los datos son de tipo json
		success: function (respuesta) { //obtengo una respuesta tipo json
			var totalReservas = parseInt(respuesta["totalReservas"]);
			console.log("totalRsvs", totalReservas);
			if (totalReservas > 0) {				
				swal("Oops", "Existe(n) " + totalReservas +" reserva(s) creada(s) para el restaurante "+nombreRestaurante+" en las fechas seleccionadas. Favor de reagendar las reservas y/o cancelarlas antes de volver a intentar crear la fecha de cierre", "error");	
			} else {
				guardaFecha(idRestaurante, fechaInicio, fechaFin, idFila);
			}			
		}
	});
}
function guardaFecha(idRestaurante, fechaInicio, fechaFin, idFila){
	// hago la operacion aquí 
	var datos = new FormData();
	datos.append("idRestCerrarAdd", idRestaurante);
	datos.append("fechaInicioAdd", fechaInicio);
	datos.append("fechaFinAdd", fechaFin);

	$.ajax({
		url: "ajax/restaurantes.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType: "json", //los datos son de tipo json
		success: function (respuesta) { //obtengo una respuesta tipo json														
			console.log("respuesta backend",respuesta);
			if(respuesta=="OK"){
				swal("Exito!", "Se ha registrado exitosamente la información!", "success");
				$('#row'+ idFila).remove();
				cierreRestaurante(idRestaurante);//ejecuto la funcion que pinta la tabla de fechas
			}else{
				swal("Oops", "Ocurrió un error con la operacion, por favor intente de nuevo", "error");
			}
		}
	});
}
function fechaActual() {
	var d = new Date();

	var mes = d.getMonth() + 1;
	var dia = d.getDate();

	var salidaFecha = 
	d.getFullYear() + '-' +
	(('' + mes).length < 2 ? '0' : '') + mes + '-' +
	(('' + dia).length < 2 ? '0' : '') + dia;

	return salidaFecha;
}
function fechaManiana(){
		
	var tomorrow = new Date();
	tomorrow.setDate(tomorrow.getDate() + 7);

	var mes =tomorrow.getMonth() + 1;
	var dia =tomorrow.getDate();

	var salidaFecha =
		tomorrow.getFullYear() + '-' +
		(('' + mes).length < 2 ? '0' : '') + mes + '-' +
		(('' + dia).length < 2 ? '0' : '') + dia;

	return salidaFecha;
}