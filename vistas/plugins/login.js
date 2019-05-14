/*=================================================================
=            PARA ACTIVAR O DESACTIVAR CAMPOS ONCHANGE  ELIGEACCESOHOTEL          =
=================================================================*/
$("#eligeAccesoHotel").change(function(){
    $(".alert").remove();
    $("#ingNombreDeUsuario").val("");
    $("#btnLogin").attr("disabled",true);

	var idPermisoHotel = $("option:selected",this).attr("idHotel");
	// var valorValue = $("option:selected",this).val();	
	var hotelPermisoAcceso = $("option:selected",this).text(); 
	// var obtenerCadena = hotelPermisoAcceso.split(' ')[1]; 
    // console.log("idPermisoHotel",idPermisoHotel);
    // console.log("valorValue",valorValue);
    
    if (hotelPermisoAcceso != '') {
       // console.log("hotelPermisoAcceso",obtenerCadena);       
       $("#ingNombreDeUsuario").removeAttr("readonly");
       $("#ingPassword").val("");
       $("#ingPassword").attr("readonly",true);

       	var datos = new FormData();
		datos.append("idHotel", idPermisoHotel);

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
			 	var idHotelRespuesta = respuesta["id"];
			 	//guardo el id del hotel en localstorage para ocupar despues
			 	localStorage.setItem("idHotelLS", idHotelRespuesta);	
			 	localStorage.setItem("nombreHotelLS", hotelPermisoAcceso);
			 	// console.log("idHotelRespuest",idHotelRespuesta);	
					
			 }
		})
    }
    else
         {
          swal ( "Oops","Elija un hotel", "error")
          $("#ingNombreDeUsuario").val("");
          $("#ingPassword").val("");
          $("#ingNombreDeUsuario").attr("readonly",true);
          $("#ingPassword").attr("readonly",true);
          $("#btnLogin").attr("disabled",true);          
    }              
})

/*=====  END OF PARA ACTIVAR O DESACTIVAR CAMPOS ONCHANGE  ======*/

/*=================================================================
= PARA TRAER LA LISTA DE IMPRESORAS DE ACUERDO AL HOTEL QUE ELIJO  =
=================================================================*/
$("#eligeAccesoHotel").change(function(){    
	var idHotelParaImpresora = $("option:selected",this).attr("idHotel");
	var hotelNombre = $("option:selected",this).text(); 

    if (hotelNombre != '') {

    	// console.log("idHotelParaImpresora",idHotelParaImpresora);
    	var datos = new FormData();
		datos.append("idHotelImpresora",idHotelParaImpresora);

		$.ajax({
			url:"ajax/impresoras.ajax.php", 
			method: "POST", //el envio es por POST
			data: datos, //datos es la instancia de ajax por el que se envia idHotelParaImpresora
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json", //los datos son de tipo json
			success:function(respuesta){ //obtengo una respuesta tipo json	
				// console.log("respuesta",respuesta);
				listaImpresoras = "<select class='form-control' required>"
					for (i =0;  i<respuesta.length; i++) {
						listaImpresoras += "<option termica=" + respuesta[i][5]+" value="+respuesta[i][2]+">"+respuesta[i][3]+"</option>";
					}
				listaImpresoras+="</select>";
				$("#listaImpresoras").html(listaImpresoras);							
				$("#esTermica").val(respuesta[0][5]);
			}
		})
    }else
    	{
    	console.log("Esto es indefinido");
    	$("#listaImpresoras").html(" ");
    }              
})

//para obtener el numero de las impresoras si son termicas o no y ponerlos en un campo oculto
$("#listaImpresoras").change(function () {
	var siEsTermica = $("option:selected", this).attr("termica");
	$("#esTermica").val(siEsTermica);
})
/*======================================
= SE TRAE todos los datos del usuario
pero se requiere el ID DEL USUARIO  =
======================================*/
$("#ingNombreDeUsuario").change( function(){ // al cambiar el foco se ejecuta ajax 
	
	$(".alert").remove();//si cambia el input, si hay mensajes de alerta, estas se remueven
	var nombreUsuario = $(this).val();
	// console.log("nombreUsuario", nombreUsuario);
	$("#ingPassword").val("");
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
			// console.log("respuesta",respuesta);
			if (respuesta){ //si respuesta es true (si me trae resultados).. se ejecuta una consulta
			//coloco una alerta despues del elemento con el regNombreUsuario en su elemento padre.
				$("#verificarUser").after('<div class="alert alert-success"><strong>Usuario existente</strong></div>');
				$("#ingPassword").removeAttr("readonly");

				var idUsuarioRespuesta = respuesta["id"];
			 	//guardo el id del hotel en localstorage para ocupar despues
			 	localStorage.setItem("idUsuarioLS", idUsuarioRespuesta);
			
			}else {
				$("#verificarUser").after('<div class="alert alert-warning"><strong>Este usuario no existe</strong></div>');
				$("#ingNombreDeUsuario").val("");
				$("#ingPassword").val("");				 
				$("#ingPassword").attr("readonly",true);
				$("#btnLogin").attr("disabled",true); 				
			}
		}
	})
})

/*=================================================================
= PARA TRAER LA LISTA DE IMPRESORAS DE ACUERDO AL HOTEL QUE ELIJO  =
=================================================================*/
$("#ingPassword").change(function(){    
	var password = $("#ingPassword").val();
	//obtengo los id de hotel e id usuario guardados en localstorage
	var idHotelLS = localStorage.getItem("idHotelLS");
	var idUsuarioLS = localStorage.getItem("idUsuarioLS");
	var nombreHotelLS = localStorage.getItem("nombreHotelLS");
	 
    if (password != '') {
		var datos = new FormData();
		datos.append("idHotelLS",idHotelLS);
		datos.append("idUsuarioLS",idUsuarioLS);

		$.ajax({
			url:"ajax/userPermisos.ajax.php", 
			method: "POST", //el envio es por POST
			data: datos, //datos es la instancia de ajax por el que se envia idHotelLS-idUsuarioLS
			cache: false,
			contentType: false,
			processData: false,
			dataType:"json", //los datos son de tipo json
			success:function(respuesta){ //obtengo una respuesta tipo json			
				if (respuesta){ //si respuesta es true (si me trae resultados).. se ejecuta una consulta
				//coloco una alerta despues del elemento con el regNombreUsuario en su elemento padre.
					$("#msjUserPermisoHotel").after('<div class="alert alert-success"><strong>Tiene permiso de acceso para: '+nombreHotelLS+'</strong></div>');
					$("#btnLogin").removeAttr("disabled");							
					$("#idHotel").val(idHotelLS);
				}else {
					$("#msjUserPermisoHotel").after('<div class="alert alert-danger"><strong>Sin permiso de acceso para: '+nombreHotelLS+'</strong></div>');								
					$("#btnLogin").attr("disabled",true); 				
				}
											
			}
		})
    }else
    	{
    	console.log("Esto es indefinido");    	
    }              
})

