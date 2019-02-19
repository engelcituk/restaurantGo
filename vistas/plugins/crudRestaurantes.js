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
			if(horaCierre != "SIN HORARIO"){
				$("#radioSIEdit").prop("checked", true);
				$("#horaDefault").val(horaCierre);
				$("#horaDefault").html(horaCierre);
			}else{					
				$("#radioNOEdit").prop("checked", true);
				$("#horaDefault").val(horaCierre);
				$("#horaDefault").html(horaCierre);
			}
			
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
	window.open("extensiones/tcpdf/pdf/listaRestaurantes.php?idHotelPdf="+idHotelPdf, "_blank");	
})
/*=====  con este cargo el id del hotel a registrar ======*/

//trabajo con los radios button para los horarios de cierre  de los restaurantes AL REGISTRAR O NO HORARIOS DE CIERRE
$('input[type=radio][name=horarioCierreRadio]').change(function() {
	if (this.value == 'SI') {
		$("#horarioCierreCatalogo").removeAttr("readonly");
		$('#horarioCierreCatalogo').prop('selectedIndex',4);	
	}
	else if (this.value == 'NO') {		
		$("#horarioCierreCatalogo").attr("readonly",true);
		$('#horarioCierreCatalogo').prop('selectedIndex',0);
	}
});
$("#horarioCierreCatalogo").change(function(){	
	var horaSeleccionada = $("option:selected",this).val();	
	if(horaSeleccionada != "SIN HORARIO"){
		$("#radioSI").prop("checked", true);
	}else{		
		$("#horarioCierreCatalogo").attr("readonly",true);
		$("#radioNO").prop("checked", true);
	}
})

//radios button para los horarios de cierre  de los restaurantes AL EDITAR O NO HORARIOS DE CIERRE
$('input[type=radio][name=horaCierreRadioEdit]').change(function() {
	if (this.value == 'SI') {
		$("#horarioCierreEdit").removeAttr("readonly");
		$('#horarioCierreEdit').prop('selectedIndex',3);	
	}
	else if (this.value == 'NO') {		
		$("#horaDefault").val("SIN HORARIO");
		$("#horaDefault").html("SIN HORARIO");
	}
});

$("#horarioCierreEdit").change(function(){	
	var horaSeleccionada = $("option:selected",this).val();	
	if(horaSeleccionada != "SIN HORARIO"){
		$("#radioSIEdit").prop("checked", true);
	}else{		
		$("#horarioCierreEdit").attr("readonly",true);
		$("#radioNOEdit").prop("checked", true);
	}
})