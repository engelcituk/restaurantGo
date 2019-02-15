/*==============================================
	PARA CUANDO SE HAGA EL ONCHANGE SE MUESTRE EL
	CALENDARIO	SI SE ELIGE VACIO SE OCULTA CALENDARIO
	 Y BOTON DE GENERAR REPORTE
 ===================================*/
$("#lstRestaurantesReportes").change(function(){

	var idRestaurante = $("option:selected",this).attr("idRestaurante");
	var nombreRestaurante = $("option:selected",this).val(); //obtengo el value que tengo en la lista	
	var nombreRestauranteTexto = $("option:selected",this).text(); //obtengo el value que tengo en la lista	
	//guardo en localStorage el id del restaurante y el nombre
	localStorage.setItem("idRestauranteLS", idRestaurante);	
	localStorage.setItem("NomRestauranteLS", nombreRestauranteTexto);

	if (nombreRestaurante=="") {
		swal ( "Oops","Elija un restaurante", "error");		
		$("#fechaReporte").attr("readonly",true);
	} else {
		$("#fechaReporte").removeAttr("readonly");		
	}
})
 /*===============FIN=================*/
 /*==============================================
	CAPTURAR LA FECHA DE REPORTE, muestro botón de generar reporte	
 ===================================*/
$("#fechaReporte").change(function(){	
	var fechaInforme = $("#fechaReporte").val();
	localStorage.setItem("fechaInicioReporteLS", fechaInforme);	
	//obtengo de localStorage el id del restaurante y el nombre para el informe
	$("#fechaReporteFin").removeAttr("readonly");	
})
 /*===============FIN=================*/
  /*==============================================
	CAPTURAR LA FECHA DE REPORTE, muestro botón de generar reporte	
 ===================================*/
$("#fechaReporteFin").change(function(){
	var fechaInformeInicio = localStorage.getItem("fechaInicioReporteLS");
	
	var fechaInformeFinal = $("#fechaReporteFin").val();
	localStorage.setItem("fechaFinalReporteLS", fechaInformeFinal);
	

	if (fechaInformeInicio!=null) {
		console.log("fechaInformeInicio",fechaInformeInicio);
		var inicio= fechaInformeInicio;
		var final= fechaInformeFinal;

		if(inicio<=final){
			console.log("formato de fecha correcto");
			var idRestaurante = localStorage.getItem("idRestauranteLS");
			var nombreRestaurante = localStorage.getItem("NomRestauranteLS");

			window.location="index.php?ruta=reportes-reservacion&idRest="+idRestaurante+"&nomRest="+nombreRestaurante+"&fechaInicio="+inicio+"&fechaFinal="+final;

		}else{
			swal ( "Oops","La fecha de inicio "+inicio+" es mayor que la fecha final "+final, "error");
		}
	} else {		
		swal ( "Oops","No tiene fecha de inicio", "error");
	}	
})
 /*===============FIN=================*/
/*======================================
=      genera PDF            =
======================================*/
 $(document).on("click", "#btnReporte", function(){ 
 	var idRestaurante = localStorage.getItem("idRestauranteLS");
    var nombreRestaurante = localStorage.getItem("NomRestauranteLS");
	var fechaInformeInicio = localStorage.getItem("fechaInicioReporteLS");
	var fechaInformeFinal = localStorage.getItem("fechaFinalReporteLS");
  	
  	 window.open("extensiones/tcpdf/pdf/listaReservas.php?idRest="+idRestaurante+"&fechaInicio="+fechaInformeInicio+"&fechaFinal="+fechaInformeFinal+"&nomRest="+nombreRestaurante, "_blank");
})
/*=====  FIN DE genera PDF  ======*/
 