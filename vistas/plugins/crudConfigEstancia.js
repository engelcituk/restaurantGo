 /*==============================================
	PARA FILTRAR LAS CONFIGURACIONES DE ACUERDO
	AL HOTEL ELEGIDO, EL RESULTADO SE CARGA 
	EN UN DATATABLE		
 ===================================*/
$("#lstSelectHotelConfig").change(function(){ //lstSelectHotelConfig es lista Select de restaurantes	
	var idHotel = $("option:selected",this).attr("idhotelLstConfig");
	var nombreHotel = $("option:selected",this).text();
	console.log(nombreHotel);
	window.location="index.php?ruta=config-reservas-estancia&idHotel="+idHotel+"&nomHotel="+nombreHotel;	
	
})

 /*===============================================
=PARA ACTIVAR/DESACTIVAR UNA CONFIGURACION DE
DE RESERVAS POR NOCHES DE ESTANCIA =
===============================================*/
$(document).on("click", ".btnActivarConfig", function(){

	var idRsvEstancia = $(this).attr("idRsvEstancia");
	var estadoConfig = $(this).attr("estadoConfig");	

	var datos = new FormData();
	datos.append("idRsvEstancia", idRsvEstancia);
	datos.append("estadoConfig", estadoConfig);

	$.ajax({
		url:"ajax/nochesEstancia.ajax.php", //enviamos a este archivo el id para que lo procese
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
	if (estadoConfig == 0) {

			$(this).removeClass('btn-success');
			$(this).addClass('btn-danger');
			$(this).html('Desactivado');
			$(this).attr('estadoConfig', 1);
		}
		else {
			$(this).removeClass('btn-danger');
			$(this).addClass('btn-success');
			$(this).html('Activado');
			$(this).attr('estadoConfig', 0);
		}

})
/*======================================
=   ELIMINAR  config-reservas-estancia          =
======================================*/
$(document).on("click", ".eliminarConfig", function(){
	
	var idRsvEstancia = $(this).attr("idRsvEstancia");

	console.log("idRsvEstancia", idRsvEstancia);
	swal({
		  title: "¡Atención!",
		  text: "¿Esta seguro de eliminar este registro?",
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
		    window.location.href="index.php?ruta=config-reservas-estancia&idRsvEstancia="+idRsvEstancia;
		  } else {
		//Si se cancela se emite un mensaje
		    swal("Cancelado", "Usted ha cancelado la eliminacion del registro", "error");
		  }
		});
})
/*=====  FIN DE  ELIMINAR config-reservas-estancia  ======*/
/*======================================
=            VER DATO DE config-reservas-estancia
======================================*/
 $(document).on("click", ".editConfigRsv", function(){
    // ^--cuando se le da clic a la clase (editConfigRsv) obtengo el atributo id
    var idNocheEstancia = $(this).attr("idRsvEstancia");
    var nombreHotel = $(this).attr("nombreHotel");
    // console.log("nombreHotel",nombreHotel);

    var datos = new FormData();
    datos.append("idNocheEstancia", idNocheEstancia);

    $.ajax({
        url:"ajax/nochesEstancia.ajax.php", //enviamos a este archivo el id para que lo procese
        method: "POST", //el envio es por POST
        data: datos, //datos es la instancia de ajax por el que se envia el id
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json", //los datos son de tipo json

        success:function(respuesta){ //obtengo una respuesta tipo json
            // console.log("respuesta",respuesta);          
            $("#idRsvPorEstancia").val(respuesta["id"]); //le cargo en esos campos los resultados
            $("#nombreHotelModal").html(nombreHotel);
            $("#numNochesEstancia").val(respuesta["nochesEstancia"]);                      
            $("#numAnteriorTotalRsvs").val(respuesta["numeroMaxDeReservas"]);
            
        }
    })
})
/*=====  FIN VER DATO DE config-reservas-estancia**/
/*======================================
= CON ESTO NO PERMITO EL INGRESO DE ELEMENTOS
 QUE NO SEAN NUMERICOS en campo numNuevoTotalRsvs
======================================*/
$(document).on("input", "#numNuevoTotalRsvs", function(){
	this.value = this.value.replace(/[^0-9]/g,'');
})

/*======================================
= PARA VALIDAR QUE EN EL CAMPO numNuevoTotalRsvs
 SOLO SE INGRESEN NUMEROS
======================================*/
 $("#numNuevoTotalRsvs").change(function(){ 	
 	var numNuevoTotalRsvs = $("#numNuevoTotalRsvs").val(); 	
 	var soloDigitos = this.value.replace(/[^0-9]/g,'');
 	
	    if(soloDigitos > 0 && soloDigitos < 100 && numNuevoTotalRsvs !=''){
	        // console.log("CORRECTO");
	        $("#btnConfigNocheEstancia").removeAttr("disabled");	        
	    }else{
	        swal ( "Oops" ,  "Ingrese un valor válido" ,  "error" )
	        $("#numNuevoTotalRsvs").val("");
	        $("#btnConfEstanciaGuardar").attr("disabled",true);	       
	    }	 
 })
 /*======================================
= CON ESTO NO PERMITO EL INGRESO DE ELEMENTOS
 QUE NO SEAN NUMERICOS en campo regNochesEstancia y
 regNuevoNumMaxRsvs DEL MODAL CREAR NUEVA CONFIGURACIÓN
======================================*/
$(document).on("input", "#regNochesEstancia", function(){
	this.value = this.value.replace(/[^0-9]/g,'');
})
$(document).on("input", "#regNuevoNumMaxRsvs", function(){
	this.value = this.value.replace(/[^0-9]/g,'');
})
 
 /*==============================================
	DE acuerdo al hotel elegido se activan
	campos, botones, etc
 ===================================*/
$("#newLstSelectHotelConfig").change(function(){ //newLstSelectHotelConfig es lista Select de hoteles	
	$("#btnConfEstanciaGuardar").attr("disabled",true);	
	$(".alert").remove();
	var idHotel = $("option:selected",this).attr("idhotellstconfig");	
	if (typeof idHotel != "undefined") { //tambien queda como if (typeof idHotel === "undefined")
		$("#nochesEstanciaOculto").removeClass("hidden");
		localStorage.setItem("idHotelLS", idHotel);
		$("#idHotelNoches").val(idHotel);
		$("#regNochesEstancia").val("");
		$("#regNuevoNumMaxRsvs").val("");
		$("#numMaxRsvOculto").addClass("hidden");				
	} else {
		$("#nochesEstanciaOculto").addClass("hidden");
		$("#numMaxRsvOculto").addClass("hidden");
		$("#idHotelNoches").val("");
		$("#regNochesEstancia").val("");		
	}
	
})

/*==============================================
	PARA EVITAR QUE SE REPITAN DATOS
	DE CONFIGURACION		
 ===================================*/
$("#regNochesEstancia").change(function(){ //regNochesEstancia es lista Select de hoteles
	$(".alert").remove();
	var idHotelLS = localStorage.getItem("idHotelLS");
	var valorNoches = $("#regNochesEstancia").val();	

	var datos = new FormData();
 	datos.append("idHotel",idHotelLS);
 	datos.append("valorNoches",valorNoches);
 	
    if (valorNoches != '' && valorNoches > 0 && valorNoches < 100) {    	
        $.ajax({
            url:"ajax/nochesEstancia.ajax.php", //enviamos a este archivo el nombreUsuario para que lo procese
            method: "POST", //el envio es por POST
            data: datos, //datos es la instancia de ajax por el que se envia el id
            cache: false,
            contentType: false,
            processData: false,
            dataType:"json", //los datos son de tipo json
            success:function(respuesta){ //obtengo una respuesta tipo json  

                // console.log("respuesta",respuesta);
                if (respuesta){ //si respuesta es true (si me trae resultados)..
                //coloco una alerta despues del elemento con el rowNumNochesEstancia en su elemento padre.
                    $("#rowNumNochesEstancia").after('<div class="alert alert-warning"><strong>Nota: </strong> Ya existe para este hotel una configuración para esta cantidad de noches de estancia.</div>');
                    $("#regNochesEstancia").val(""); //limpiamos el value con el identificador idioma
                    $("#numMaxRsvOculto").addClass("hidden");
                    $("#btnConfEstanciaGuardar").attr("disabled",true);   
                }else {
                    $("#rowNumNochesEstancia").after('<div class="alert alert-success"><strong>Nota: </strong> Numero de noches disponible</div>');                                      
                	$("#numMaxRsvOculto").removeClass("hidden");
                }
            }
        })
    }
    else
         {
          swal ( "Oops","Escriba un valor valido", "error")          
          $("#btnConfEstanciaGuardar").attr("disabled",true);           
          $("#regNochesEstancia").val("");
          $("#regNuevoNumMaxRsvs").val("");   
          $("#numMaxRsvOculto").addClass("hidden"); 
    }
})
/*======================================
= PARA VALIDAR QUE EN EL CAMPO regNuevoNumMaxRsvs
 SOLO SE INGRESEN NUMEROS.--- del modal
  Crear nueva configuración
======================================*/
 $("#regNuevoNumMaxRsvs").change(function(){ 	
 	var regNuevoNumMaxRsvs = $("#regNuevoNumMaxRsvs").val(); 	
 	var soloDigitos = this.value.replace(/[^0-9]/g,'');
	    if(soloDigitos >= 0 && soloDigitos < 100 && regNuevoNumMaxRsvs !=''){	       
	        $("#btnConfEstanciaGuardar").removeAttr("disabled");	        
	    }else{
	        swal ( "Oops" ,  "Ingrese un valor válido" ,  "error" )
	        $("#regNuevoNumMaxRsvs").val("");
	        $("#btnConfEstanciaGuardar").attr("disabled",true);	       
	    }	 
 })
