/*===============================================
=PARA ACTIVAR/DESACTIVAR UNA CONFIGURACION DE
DE RESERVAS POR NOCHES DE ESTANCIA =
===============================================*/
$(document).on("click", ".btnActivarPermiso", function(){

	var idPermiso = $(this).attr("idPermiso");
	var estadoPermiso = $(this).attr("attrEstadoPermiso");

	// console.log("idPermiso",idPermiso);
	// console.log("estadoPermiso",estadoPermiso);
	var datos = new FormData();
	datos.append("idPermiso", idPermiso);
	datos.append("estadoPermiso", estadoPermiso);

	$.ajax({
		url:"ajax/permisos.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json	

		// console.log("respuesta",respuesta);			
		}
	})		
	if (estadoPermiso == 0) {
			$(this).removeClass('btn-success');
			$(this).addClass('btn-danger');
			$(this).html('Desactivado');
			$(this).attr('attrEstadoPermiso', 1);
		}
		else {
			$(this).removeClass('btn-danger');
			$(this).addClass('btn-success');
			$(this).html('Activado');
			$(this).attr('attrEstadoPermiso', 0);
		}

})

/*======================================
=   ELIMINAR  PERMISOS          =
======================================*/
$(document).on("click", ".eliminarPermiso", function(){
	
	var idPermiso = $(this).attr("idPermiso");

	console.log("idPermiso", idPermiso);
	swal({
		  title: "¡Atención!",
		  text: "¿Esta seguro de eliminar este permiso?",
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
		    window.location.href="index.php?ruta=permisos&idPermiso="+idPermiso;
		  } else {
		//Si se cancela se emite un mensaje
		    swal("Cancelado", "Usted ha cancelado la eliminacion del registro", "error");
		  }
		});
})
/*=====  FIN DE  ELIMINAR PERMISOS  ======*/
/*================================================================
=            PARA VALIDAR QUE UN PERMISO NO SE REPITA            =
================================================================*/
$("#regNombrePermiso").change(function(){
	$(".alert").remove();
	var valorPermiso = $(this).val();
	// console.log("Nombre Permiso",valorPermiso);	
	if (valorPermiso != '') { 
		var datos = new FormData();
		datos.append("valorPermiso",valorPermiso);

		$.ajax({
			url:"ajax/permisos.ajax.php", //enviamos a este archivo el nombreUsuario para que lo procese
			method: "POST", //el envio es por POST
			data: datos, //datos es la instancia de ajax por el que se envia el id
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json", //los datos son de tipo json
			success:function(respuesta){ //obtengo una respuesta tipo json					
				// console.log("respuesta",respuesta);
				if (respuesta){ //si respuesta es true (si me trae resultados)..
					$("#nombreValidoMensaje").after('<div class="alert alert-warning">Est permiso ya existe en la base de datos, intente con otro nombre.</div>');
					$("#regNombrePermiso").val(""); //se limpia el value #regNombrePermiso
					$("#btnPermisoGuardar").attr("disabled",true);			
				}else {
					$("#nombreValidoMensaje").after('<div class="alert alert-success"><strong>Permiso disponible para ocupar</strong></div>');
					$("#btnPermisoGuardar").removeAttr("disabled");
					
				}
			}
		})
	}else
		 {
		  swal ( "Oops","No dejes el campo vacio", "error");
		  $("#btnPermisoGuardar").attr("disabled",true);
	}	
})
/*=====  END OF PARA VALIDAR QUE UN PERMISO NO SE REPITA  ======*/

/*======================================
= CARGAR DATOS DEL PERMISO EN EL MODAL PARA EDITAR LA INFORMACION
======================================*/
 $(document).on("click", ".editPermiso", function(){
 	 	
 	var idPermisoEditar = $(this).attr("idPermiso"); 	
 	$("#idPermisoEdit").val(idPermisoEditar);

 	console.log("idPermisoEditar",idPermisoEditar);
 	
 	var datos = new FormData();
 	datos.append("idPermisoEditar",idPermisoEditar);	
 	$.ajax({

		url:"ajax/permisos.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json	
			// console.log("respuesta",respuesta);								
			$("#nombrePermisoSpan").html(respuesta["nombrePermiso"]);						
		}					
	})

});
/*=====  FIN DE CARGAR INFORMAICON DE PERMISO EN MODAL PARA EDITAR ======*/

/*================================================================
=            PARA DESHABILITAR BOTÓN DE GUARDAR
AL EDITAR PERMISO EN EL MODAL           =
================================================================*/
$("#nuevoNombrePermiso").change(function(){	
	var nuevoValorPermiso = $(this).val();
	// console.log("Nombre Permiso",nuevoValorPermiso);
	if (nuevoValorPermiso != '') {

		$("#btnNuevoPermisoEdit").removeAttr("disabled"); 

	}else
		 {
		  swal ( "Oops","No dejes el campo vacio", "error")
		  $("#btnNuevoPermisoEdit").attr("disabled",true);		  	
	}	
})
/*=====  END OF PARA VALIDAR QUE UN PERMISO NO SE REPITA  ======*/
