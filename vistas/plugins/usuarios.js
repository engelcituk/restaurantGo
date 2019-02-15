/*===================================================
=            VALIDAR CONTRASEÑA DE USUARIO            =
===================================================*/
$(document).ready(function() {
	//variables
	var rowPasword = $('[name=regPassword]');
	var regPassword2 = $('[name=regPassword2]');
	var confirmacion = "Las contraseñas si coinciden";
	var longitud = "La contraseña (en ambos campos) debe estar formada entre 6-10 carácteres";
	var negacion = "No coinciden las contraseñas";
	var vacio = "La contraseña no puede estar vacía";
	//oculto por defecto el elemento span
	var span = $('<div></div>').insertAfter(rowPasword);
	// var span2 = $('<div></div>').insertAfter(regPassword);
	


	span.hide();
	//función que comprueba las dos contraseñas
	function coincidePassword(){
		var valor1 = rowPasword.val();
		var valor2 = regPassword2.val();
		//muestro el span
		span.show().removeClass();
		//condiciones dentro de la función
		if(valor1 != valor2){
			span.text(negacion).addClass('alerta negacion');
		}
		if(valor1.length==0 || valor1==""){
			span.text(vacio).addClass('alerta negacion');	
		}
		if(valor1.length<6 || valor1.length>10){
			span.text(longitud).addClass('alerta negacion');
		}
		if(valor1.length!=0 && valor1==valor2){
			span.text(confirmacion).removeClass("alerta negacion").addClass('alerta confirmacion');
		}
	}
		//ejecuto la función al soltar la tecla
		regPassword2.keyup(function(){
		coincidePassword();
		});


});
/*=====  END OF VALIDAR CONTRASEÑA DE USUARIO  ======*/

/*================================================
=    VALIDAR DATOS DE USUARIO  QUE SE REGISTRAN =
================================================*/

function registroUsuario(){

	$(".alert").remove(); //REMUEVO LA ALERTA PARA CUANDO ESCRIBA OTRA VEZ EN LOS INPUT
/*================================================
=    VALIDAR NOMBRE DEL USUARIO =
================================================*/
	var nombre = $("#regUsuario").val();
	if (nombre != "") {
		var expresion = /^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/;
		if (!expresion.test(nombre)){

			$("#mnsjUsuarioMensajeError").before('<div class="alert alert-danger"><strong>Error!</strong> No se permite numero ni carácteres especiales para el nombre completo.</div>')
		return false;
		}
	} else {

		$("#mnsjUsuarioMensajeError").before('<div class="alert alert-danger"><strong>Atencion!</strong> Este campo es obligatorio.</div>')

		return false;
	}
	
	/*================================================
		=    VALIDAR regNombreUsuario DEL USUARIO =
	================================================*/
	var regNombreUsuario = $("#regNombreUsuario").val();
	if (regNombreUsuario != "") {
		var expresion = /^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/;
		if (!expresion.test(regNombreUsuario)){

			$("#regNombreUsuario").parent().before('<div class="alert alert-danger"><strong>Error!</strong>Escriba Un nombre de usuario correcto.</div>')
		return false;

		}
	} else {

		$("#regNombreUsuario").parent().before('<div class="alert alert-danger"><strong>Atencion!</strong> Este campo es obligatorio.</div>')

		return false;
	}
	/*================================================
		=    VALIDAR PASSWORD DEL USUARIO =
	================================================*/
	var password = $("#regPassword").val();
	if (password != "") {
		var expresion = /^[a-zA-Z]*$/;
		if (!expresion.test(password)){

			$("#regPassword").parent().before('<div class="alert alert-danger"><strong>Error!</strong>Escriba correctamente la constraseña. Solo letras</div>')
		return false;

		}
	} else {

		$("#regPassword").parent().before('<div class="alert alert-danger"><strong>Atencion!</strong> Este campo es obligatorio.</div>')

		return false;
	}
	
	return true;
}
/*=====  END OF VALIDAR DATOS DE USUARIO QUE SE REGISTRAN ======*/
