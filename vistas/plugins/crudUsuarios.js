/*======================================
=            EDITAR USUARIO 
para traer datos en campos           =
======================================*/
 $(document).on("click", ".editarUsuario", function(){
 	// ^--cuando se le da clic a la clase (editarUsuario) obtengo el atributo id
  	var idUsuario = $(this).attr("idUsuario");

	var datos = new FormData();
	datos.append("idUsuario", idUsuario);

	$.ajax({
		url:"ajax/usuarios.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json

		success:function(respuesta){ //obtengo una respuesta tipo json
			// console.log("respuesta",respuesta);			
			$("#idUsuarioEditar").val(respuesta["id"]); //le cargo en esos campos los resultados
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarPerfil").html(respuesta["perfil"]);//Siendo option ponemos eso en el html
			$("#editarPerfil").val(respuesta["perfil"]);//Siendo option ponemos eso en el html
			$("#editarNombreDeUsuario").val(respuesta["nombreDeUsuario"]);
			$("#passwordActual").val(respuesta["password"]);

		}
	})
})
/*=====  FIN DE EDITAR USUARIO  ======*/
/*======================================
=            EDITAR USUARIO  
PARA TRABAJAR CON LOS INPUTS DE TIPO CHECK 
 para permisos acciones        =
======================================*/
 $(document).on("click", ".editarUsuario", function(){
 	// ^--cuando se le da clic a la clase (editarUsuario) obtengo el atributo id
  	var idUsuario = $(this).attr("idUsuario");

	var datos = new FormData();
	datos.append("idUsuario", idUsuario);

	$.ajax({
		url:"ajax/userPermisos.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json			
			// console.log("respuesta",respuesta);				
			lstCheckPermisos = "<div class='row'>"

				for (i =0;  i<respuesta.length; i++) {
					var idPermiso=respuesta[i][0];
					var nombrePermiso =respuesta[i][1];
					var idUser= respuesta[i][3];					
					var checked = (idUser != null ? 'checked':'');//operador ternario

					lstCheckPermisos+= "<div class='col-md-4 col-xs-6'><input type='checkbox' "+checked+" name='permiso[]' value="+idPermiso+"> "+nombrePermiso+"</div>";
				}
			lstCheckPermisos+="</div>";
			$("#listaChecksPermisos").html(lstCheckPermisos);                    
		}
	})
})
/*=====  FIN DE EDITAR USUARIO INPUTS DE TIPO CHECK 
 para permisos acciones  ======*/

 /*======================================
=            EDITAR USUARIO  
PARA TRABAJAR CON LOS INPUTS DE TIPO CHECK 
 para permisos accesos hotel        =
======================================*/
 $(document).on("click", ".editarUsuario", function(){
 	// ^--cuando se le da clic a la clase (editarUsuario) obtengo el atributo id
  	var idUsuario = $(this).attr("idUsuarioHotel");

	var datos = new FormData();
	datos.append("idUsuarioHotel", idUsuario);

	$.ajax({
		url:"ajax/userPermisos.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json			
			// console.log("respuesta",respuesta);				
			lstCheckPermisos = "<div class='row'>"
				for (i =0;  i<respuesta.length; i++) {
					var idPermiso=respuesta[i][0];
					var nombrePermiso =respuesta[i][1];
					var idUser= respuesta[i][3];					
					var checked = (idUser != null ? 'checked':'');//operador ternario

					lstCheckPermisos+= "<div class='col-md-4 col-xs-6'><input type='checkbox' "+checked+" name='permisoHotelEditar[]' value="+idPermiso+"> "+nombrePermiso+"</div>";
				}
			lstCheckPermisos+="</div>";
			$("#listaChecksPermisosHotel").html(lstCheckPermisos);                    
		}
	})
})
/*=====  FIN DE EDITAR USUARIO INPUTS DE TIPO CHECK 
 para permisos accesos hotel  ======*/

/*======================================
=            ELIMINAR USUARIO            =
======================================*/
$(document).on("click", ".eliminarUsuario", function(){
	
	var idUsuario = $(this).attr("idUsuario");
	//console.log("IdUsuario", idUsuario)
	swal({
		  title: "Atención!!!",
		  text: "¿Esta seguro de eliminar al usuario?!",
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
		//Si SE confirma la eliminacion se ejecuta el reenvio al php encargado
		    window.location.href="index.php?ruta=usuarios&idUsuario="+idUsuario;
		  } else {
		//Si se cancela se emite un mensaje
		    swal("Cancelado", "Usted ha cancelado la eliminacion del usuario", "error");
		  }
		});
})
/*=====  FIN DE ELIMINAR USUARIO  ======*/

/*======================================
= EVITAR LA REPETICIÓN DE UN USUARIO || para validar si este usuario existe   =
======================================*/
$("#regNombreUsuario").change( function(){ // al cambiar el foco se ejecuta ajax 
	
	$(".alert").remove();//si cambia el input, si hay mensajes de alerta, estas se remueven
	var nombreUsuario = $(this).val();
	console.log("nombreUsuario", nombreUsuario);
 
	var datos = new FormData();
	datos.append("nombreUsuario",nombreUsuario);

	$.ajax({
		url:"ajax/usuarios.ajax.php", //enviamos a este archivo el nombreUsuario para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json			
			console.log("respuesta",respuesta);
			if (respuesta){ //si respuesta es true (si me trae resultados).. se ejecuta una consulta
			//coloco una alerta despues del elemento con el regNombreUsuario en su elemento padre.
				$("#mnsjUsuarioValido").after('<div class="alert alert-warning"><strong>Este Usuario!</strong> Ya existe en la base de datos, intente con otro nombre de usuario.</div>');
				$("#regNombreUsuario").val(""); //inmediatamente limpiamos el value con el identificador regNombreUsuario
			}else {
				$("#mnsjUsuarioValido").after('<div class="alert alert-success"><strong>¡Usuario válido!</strong></div>');
			}
		}
	})
})
/*=====  FIN DE LA REPETICIÓN DE UN USUARIO ======*/
/*===============================================
=            PARA ACTIVAR AL USUARIO            =
===============================================*/
$(document).on("click", ".btnActivarUsuario", function(){

	var idUsuario = $(this).attr("idUsuario");
	var estadoUsuario = $(this).attr("estadoUsuario");

	var datos = new FormData();
	datos.append("activarId", idUsuario);
	datos.append("activarUsuario", estadoUsuario);

	$.ajax({
		url:"ajax/usuarios.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json			
		
		}
	})
	if (estadoUsuario == 0) {

		$(this).removeClass('btn-success');
		$(this).addClass('btn-danger');
		$(this).html('Desactivado');
		$(this).attr('estadoUsuario', 1);
	}
	else {
		$(this).removeClass('btn-danger');
		$(this).addClass('btn-success');
		$(this).html('Activado');
		$(this).attr('estadoUsuario', 0);
	}

})
/*=====  END OF PARA ACTIVAR AL USUARIO  ======*/
// $(document).on("click", ".validaCheck", function(){

//     if ($('input[name="permisohotel[]"]').is(':checked')) {
//         console.log('OK');       
//     } else {
//         swal ( "Oops","Elige por lo menos un Hotel", "error")
//         return false;
//     }
// })
/*======================================================================
=            PARA QUE AL MENOS UN PERMISO (check) ESTE SELECCIONADO            =
======================================================================*/ 
$(document).on("click", ".validaCheck", function(){

    if ($('input[name="permiso[]"]').is(':checked')) {
        console.log('OK');       
    } else {
        swal ( "Oops","Elige por lo menos un permiso", "error")
        return false;
    }
})
/*=====  END OF PARA QUE AL MENOS UN PERMISO ESTE SELECCIONADO  ======*/
