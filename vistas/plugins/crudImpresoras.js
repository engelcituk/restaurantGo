 /*==============================================
	PARA FILTRAR LAS impresoras DE ACUERDO
	AL HOTEL ELEGIDO, EL RESULTADO SE CARGA 
	EN el DATATABLE		
 ===================================*/
$("#lstSelectHotelPrinters").change(function(){ //lstSelectHotelPrinters es lista Select de restaurantes	
	var idHotel = $("option:selected",this).attr("idhotelLstPrinter");
	var nombreHotel = $("option:selected",this).text();
	
	// window.location="index.php?ruta=impresoras&idHotel="+idHotel+"&nomHotel="+nombreHotel;	
	if(idHotel=="TODOS"){
		var url="impresoras";		
		location.href = url;	
	}else{		
		window.location="index.php?ruta=impresoras&idHotel="+idHotel+"&nomHotel="+nombreHotel;		
	}
})
 /*===============================================
=PARA ACTIVAR/DESACTIVAR UNA CONFIGURACION DE
DE RESERVAS POR NOCHES DE ESTANCIA =
===============================================*/
$(document).on("click", ".btnActivarImpresora", function(){

	var idImpresora = $(this).attr("idImpresora");
	var estadoImpresora = $(this).attr("attrEstadoImpresora");	
	console.log("idImpresora",idImpresora);
	console.log("estadoImpresora",estadoImpresora);

	var datos = new FormData();
	datos.append("idImpresora", idImpresora);
	datos.append("estadoImpresora", estadoImpresora);

	$.ajax({
		url:"ajax/impresoras.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax 
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json	
		// console.log("respuesta",respuesta)				
		}
	})		
	if (estadoImpresora == 0) {
			$(this).removeClass('btn-success');
			$(this).addClass('btn-danger');
			$(this).html('Desactivado');
			$(this).attr('attrEstadoImpresora', 1);
		}
		else {
			$(this).removeClass('btn-danger');
			$(this).addClass('btn-success');
			$(this).html('Activado');
			$(this).attr('attrEstadoImpresora', 0);
		}

})
/*======================================
=   ELIMINAR  Impresoras          =
======================================*/
$(document).on("click", ".eliminarImpresora", function(){
	
	var idImpresora = $(this).attr("idImpresora");

	console.log("idImpresora", idImpresora);
	swal({
		  title: "¡Atención!",
		  text: "¿Esta seguro de eliminar esta impresora?",
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
		    window.location.href="index.php?ruta=impresoras&idImpresora="+idImpresora;
		  } else {
		//Si se cancela se emite un mensaje
		    swal("Cancelado", "Usted ha cancelado la eliminacion del registro", "error");
		  }
		});
})
/*=====  FIN DE  ELIMINAR impresoras  ======*/
 /*==============================================
	DE ACUERDO AL HOTEL ELEGIDO SE ACTIVAN
	CAMPOS, BOTONES, ETC
 ===================================*/
$("#newLstHotelesModal").change(function(){ //newLstHotelesModal es lista Select de hoteles	
	$("#btnImpresoraGuardar").attr("disabled",true);	
	$(".alert").remove();
	 var idHotel = $("option:selected",this).attr("idhotellstconfig");
	 // console.log("idhotel",idHotel);	
	if (typeof idHotel != "undefined") { //tambien queda como if (typeof idHotel === "undefined")
		localStorage.setItem("idHotelLS", idHotel);
		$("#nochesEstanciaOculto").removeClass("hidden");
		$("#idHotelImpresora").val(idHotel);
		$("#ipImpresoraOcultoCampo").removeClass("hidden");
		$("#regIpImpresora").val("");
		$("#nombreImpresoraOcultoCampo").addClass("hidden");
				
	} else {
		$("#ipImpresoraOcultoCampo").addClass("hidden");
		$("#nombreImpresoraOcultoCampo").addClass("hidden");
		$("#idHotelImpresora").val("");
		$("#nombreImpresoraOcultoCampo").addClass("hidden");
		$("#regNombreImpresora").val("");
	}
})
/*==============================================
 PARA EVITAR COPIAR Y PEGAR EN INPUT DE IP en modal 
 Registrar nueva impresora
 ===================================*/
$(document).ready(function(){
  $("#regIpImpresora").on('paste', function(e){
    e.preventDefault();    
    swal ("Oops" ,  "No está permitido pegar" ,  "error" ); 
  })  
  $("#regIpImpresora").on('copy', function(e){
    e.preventDefault();
    swal("Oops", "No está permitido copiar", "error");
  })
})
/*==============================================
	PARA TRABAJAR CON EL CAMPO DE TIPO IP
	hacer validacion
 ===================================*/

 var pattern = /\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/;
	x = 46;
$("#regIpImpresora").keypress(function (e) {
$(".alert").remove();
    if (e.which != 8 && e.which != 0 && e.which != x && (e.which < 48 || e.which > 57)) {
        // console.log(e.which);
        return false;
	    }
	}).keyup(function () {		
	    var this1 = $(this);
	    if (!pattern.test(this1.val())) {
	        $("#ipValidoMensaje").html('<h3><span class="label label-warning"><strong>Ip inválida</strong></span></h3>');
	       	        
	        while (this1.val().indexOf("..") !== -1) {
	            this1.val(this1.val().replace('..', '.'));
	        }
	        x = 46;
	    } else {
	        x = 0;
	        var lastChar = this1.val().substr(this1.val().length - 1);
	        if (lastChar == '.') {
	            this1.val(this1.val().slice(0, -1));
	        }
	        var ip = this1.val().split('.');
	        if (ip.length == 4) {
	           $("#ipValidoMensaje").html('<h3><span class="label label-success"><strong>Ip válida</strong></span></h3>');	         
	    }
	}
})

$("#regIpImpresora").change(function(){
	$(".alert").remove();
	var ipImpresora = $(this).val();
	// var idHotelLS = localStorage.getItem("idHotelLS");
	// console.log("ipImpresora",ipImpresora);
	// console.log("idHotelLS",idHotelLS);

	var datos = new FormData();
	datos.append("ipImpresora",ipImpresora);

	$.ajax({
		url:"ajax/impresoras.ajax.php", //enviamos a este archivo el nombreUsuario para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json			
			// console.log("respuesta",respuesta);
			if (respuesta){ //si respuesta es true (si me trae resultados)..
				$("#rowNuevaImpresora").after('<div class="alert alert-warning">Esta IP ya existe en la base de datos, intente con otra dirección.</div>');
				$("#regIpImpresora").val(""); //inmediatamente limpiamos el value con el identificador regIpImpresora
				$("#nombreImpresoraOcultoCampo").addClass("hidden");
				$("#regNombreImpresora").val("");
			}else {
				$("#rowNuevaImpresora").after('<div class="alert alert-success"><strong>Ip disponible para ocupar</strong></div>');
				$("#nombreImpresoraOcultoCampo").removeClass("hidden");
			}
		}
	})	
})
//si campo regNombreImpresora esta lleno o vacio
//habilito botón para guardar impresora
$("#regNombreImpresora").change(function(){
	var nombreImpresora = $(this).val();
	// console.log("nombreImpresora",nombreImpresora);
	if (nombreImpresora === "") { 
		$("#btnImpresoraGuardar").attr("disabled",true);		
	} else {
		$("#btnImpresoraGuardar").removeAttr("disabled");
	}
})
/*======================================
= CARGAR DATOS de la impresora en el modal para editar la informacion
======================================*/
 $(document).on("click", ".editImpresora", function(){
 	 	
 	var idImpresoraEditar = $(this).attr("idImpresora");
 	var nombreHotelEdit = $(this).attr("nombreHotel");
 	localStorage.setItem("idImpresoraLS", idImpresoraEditar);

 	$("#nombreHotelImpresora").html(nombreHotelEdit);
 	$("#idImpresoraEdit").val(idImpresoraEditar);
 	
 	var datos = new FormData();
 	datos.append("idImpresoraEditar",idImpresoraEditar);	
 	$.ajax({

		url:"ajax/impresoras.ajax.php", //enviamos a este archivo el id para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json						
			console.log("respuesta",respuesta);
			var esTermica = (respuesta["termica"] == 1) ? "Si" : "No";	
			var esTermica2 = (respuesta["termica"] == 1) ? "1" : "0";
			
			localStorage.setItem("nuevaDireccionIPLS", respuesta["direccionIP"]);							
			$("#ipImpresoraSpan").html(respuesta["direccionIP"]);
			$("#nuevaDireccionIP").val(respuesta["direccionIP"]);
			$("#nombreImpresoraSpan").html(respuesta["nombreImpresora"]);			
			$("#nuevoNomImpresora").val(respuesta["nombreImpresora"]);			
			$("#respuestaTermica").html(esTermica);		
			$("#respuestaTermica").val(esTermica2);
			$("#printTermica").html(esTermica);
		}					 
	})

});
/*=====  FIN DE cargar informaicon impresora en modal para editar ======*/

/*==============================================
	PARA TRABAJAR CON EL CAMPO DE TIPO IP
	hacer validacion-- en el modal de 
	editar impresora
 ===================================*/
var patron2 = /\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/;
	xx = 46;
$("#nuevaDireccionIP").keypress(function (event) {
$(".alert").remove();
    if (event.which != 8 && event.which != 0 && event.which != xx && (event.which < 48 || event.which > 57)) {
        // console.log(event.which);
        return false;
	    }
	}).keyup(function () {		
	    var this2 = $(this);
	    if (!patron2.test(this2.val())) {
	        $("#ipValidoMensajeEditar").html('<h3><span class="label label-warning"><strong>Ip inválida</strong></span></h3>');
	       	        
	        while (this2.val().indexOf("..") !== -1) {
	            this2.val(this2.val().replace('..', '.'));
	        }
	        xx = 46;
	    } else {
	        xx = 0;
	        var lastChar = this2.val().substr(this2.val().length - 1);
	        if (lastChar == '.') {
	            this2.val(this2.val().slice(0, -1));
	        }
	        var ip2 = this2.val().split('.');
	        if (ip2.length == 4) {
	           $("#ipValidoMensajeEditar").html('<h3><span class="label label-success"><strong>Ip válida</strong></span></h3>');	         
	    }
	}
})
// se verifica que no exista esa ip que se desea agregar para editar la direccion IP y el nombre de la impresora
$("#nuevaDireccionIP").change(function(){
	$(".alert").remove();
	var ipImpresora = $(this).val();
	// var idHotelLS = localStorage.getItem("idHotelLS");
	console.log("ipImpresora",ipImpresora);
	// console.log("idHotelLS",idHotelLS);

	var datos = new FormData();
	datos.append("ipImpresora",ipImpresora);

	$.ajax({
		url:"ajax/impresoras.ajax.php", //enviamos a este archivo el nombreUsuario para que lo procese
		method: "POST", //el envio es por POST
		data: datos, //datos es la instancia de ajax por el que se envia el id
		cache: false,
		contentType: false,
		processData: false,
		dataType:"json", //los datos son de tipo json
		success:function(respuesta){ //obtengo una respuesta tipo json			
			// console.log("respuesta",respuesta);
			if (respuesta){ //si respuesta es true (si me trae resultados)..
				// console.log(respuesta);
				$("#rowEditarImpresora").after('<div class="alert alert-warning">IP de impresora existente en la base de datos, por favor mantener la ip actual.</div>');
				var ipActual = localStorage.getItem("nuevaDireccionIPLS");
				$("#nuevaDireccionIP").val(ipActual);
				$("#nombreImpresoraOcultoModal").removeClass("hidden");
				// $("#nuevoNomImpresora").val("");
			}else {
				$("#rowEditarImpresora").after('<div class="alert alert-success"><strong>Está indicando una nueva dirección IP, sí esta disponible para ocupar</strong></div>');
				$("#nombreImpresoraOcultoModal").removeClass("hidden");
			}
		}
	})	
})

/*==============================================
 PARA EVITAR COPIAR Y PEGAR EN INPUT DE IP en modal  Registrar nueva impresora
 192.168.109.155 172.16.0.175
 ===================================*/
$(document).ready(function(){
  $("#nuevaDireccionIP").on('paste', function(e){
    e.preventDefault();    
    swal ("Oops" ,  "No está permitido pegar" ,  "error" ); 
  })  
  $("#nuevaDireccionIP").on('copy', function(e){
    e.preventDefault();
    swal("Oops", "No está permitido copiar", "error");
  })
})
/*==============================================
	FIN DE VALIDACION NUEVADIRECCIONIP-- EN EL MODAL DE 
	EDITAR IMPRESORA SE OCUPA KEYPRESS Y ONCHANGE PARA Ello
 ===================================*/
 //si campo nuevoNomImpresora esta lleno o vacio
//habilito botón para guardar impresora
$("#nuevoNomImpresora").change(function(){
	var nombreImpresora = $(this).val();
	$(".alert").remove();
	// console.log("nombreImpresora",nombreImpresora);
	if (nombreImpresora === "") { 
		$("#btnNuevaImpresoraEdit").attr("disabled",true);		
	} else {
		$("#btnNuevaImpresoraEdit").removeAttr("disabled");
	}
})
