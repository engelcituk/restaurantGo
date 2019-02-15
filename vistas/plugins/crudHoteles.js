/*======================================
=CARGO LOS DATOS A UN MODAL PARA EDITAR EL HOTEL            =
======================================*/
$(document).on("click", ".editarHotel", function(){
 	// ^--cuando se le da clic a la clase (editarHotel) obtengo el atributo id
  	var idHotelEditar = $(this).attr("idHotelEditar");
  	console.log("idHotelEditar",idHotelEditar);
	var datos = new FormData();
	datos.append("idHotelEditar", idHotelEditar);

	$.ajax({
		url:"ajax/hoteles.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json
		 	// console.log("respuesta",respuesta);			
			$("#idhotelEditar").val(respuesta["id"]); //le cargo en esos campos los resultados
			$("#editarNombre").val(respuesta["nombre"]);
			$("#estadoHotel").val(respuesta["estado"]);
			$("#editarDescripcion").val(respuesta["descripcion"]);		
		 }
	})
})
/*=====  FIN DE CARGO LOS DATOS A UN MODAL PARA EDITAR EL HOTEL   ======*/

/*======================================
=            ELIMINAR HOTEL            =
======================================*/
$(document).on("click", ".eliminarHotel", function(){
	
	var idHotelBorrar = $(this).attr("idHotelBorrar");

	console.log("idHotelBorrar", idHotelBorrar);
	swal({
		  title: "¡Atención!",
		  text: "¿Esta seguro de eliminar el hotel?",
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
		    window.location.href="index.php?ruta=hoteles&idHotelBorrar="+idHotelBorrar;
		  } else {
		//Si se cancela se emite un mensaje
		    swal("Cancelado", "Usted ha cancelado la eliminacion del hotel", "error");
		  }
		});
})
/*=====  FIN DE  ELIMINAR HOTEL   ======*/
/*===============================================
=            PARA ACTIVAR EL HOTEL         =
===============================================*/
$(document).on("click", ".btnActivarHotel", function(){

	var idHotelEstado = $(this).attr("idHotelEstado");
	var estadoHotel = $(this).attr("estadoHotel");	

	var datos = new FormData();

	datos.append("idHotelEstado", idHotelEstado);
	datos.append("estadoHotel", estadoHotel);

	$.ajax({
		url:"ajax/hoteles.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json		
			
		}
	})
		
		if (estadoHotel == 0) {

			$(this).removeClass('btn-success');
			$(this).addClass('btn-danger');
			$(this).html('Desactivado');
			$(this).attr('estadoHotel', 1);
		}
		else {
			$(this).removeClass('btn-danger');
			$(this).addClass('btn-success');
			$(this).html('Activado');
			$(this).attr('estadoHotel', 0);
		}

})
/*=====  END OF PARA ACTIVAR EL HOTEL  ======*/
