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
		// $("#fechaReporte").attr("readonly",true);
	} else {
		$("#fechaReporte").removeAttr("readonly");		
	}
})
 /*===============FIN=================*/
$("#ordenFiltroDatos").change(function () {	
	var ordenFiltro = $("option:selected", this).val(); //obtengo el value que tengo en la lista		
	localStorage.setItem("ordenFiltroLS", ordenFiltro);	
	
})
 /*===============FIN=================*/
 /*==============================================
	CAPTURAR LA FECHA DE REPORTE, muestro botón de generar reporte	
 ===================================*/
$("#fechaReporte").change(function(){	
	var fechaInformeInicial = $("#fechaReporte").val();
	localStorage.setItem("fechaInicioReporteLS", fechaInformeInicial);	
	//obtengo de localStorage el id del restaurante y el nombre para el informe
	console.log("FechaInicio",fechaInformeInicial);
	$("#fechaReporteFin").attr('min' , fechaInformeInicial);
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
		// console.log("fechaInformeInicio",fechaInformeInicio);
		var inicio= fechaInformeInicio;
		var final= fechaInformeFinal;

		if(inicio<=final){
			console.log("formato de fecha correcto");
			var idRestaurante = localStorage.getItem("idRestauranteLS");
			var nombreRestaurante = localStorage.getItem("NomRestauranteLS");

			if (idRestaurante == null) {
				idRestaurante = 0;
				nombreRestaurante="Todos";
			}
			var valorOrdenamiento =obtenerOrdenFiltro();
			window.location = "index.php?ruta=reportes-reservacion&idRest="+idRestaurante+"&nomRest="+nombreRestaurante+"&fechaInicio="+inicio+"&fechaFinal="+final+"&orden="+valorOrdenamiento;						
		}else{
			swal ( "Oops","La fecha de inicio "+inicio+" es mayor que la fecha final "+final, "error");
		}
	} else {		
		swal ( "Oops","No tiene fecha de inicio", "error");
	}	
}) 
 /*===============FIN=================*/
 function obtenerOrdenFiltro(){
	 var valorFiltro = "fechaDeLaReserva ASC, hora ASC";
	 
	 if (localStorage.getItem("ordenFiltroLS") === null) {
		 localStorage.setItem("ordenFiltroLS", valorFiltro);	
	 }else{
		 var valorFiltro = localStorage.getItem("ordenFiltroLS");
	 }
	 return valorFiltro;
 }
/*======================================
=      genera PDF            =
======================================*/
 $(document).on("click", "#btnReporte", function(){ 
 	var idRestaurante = localStorage.getItem("idRestauranteLS");
  	var nombreRestaurante = localStorage.getItem("NomRestauranteLS");
	var fechaInformeInicio = localStorage.getItem("fechaInicioReporteLS");
	var fechaInformeFinal = localStorage.getItem("fechaFinalReporteLS");
	var ordenFiltro = localStorage.getItem("ordenFiltroLS");

	if (idRestaurante == null) {
		idRestaurante=0;
	} 
	 window.open("extensiones/tcpdf/pdf/listaReservas.php?idRest=" + idRestaurante + "&fechaInicio=" + fechaInformeInicio + "&fechaFinal=" + fechaInformeFinal + "&nomRest=" + nombreRestaurante + "&orden=" + ordenFiltro, "_blank");
  	 
})
/*=====  FIN DE genera PDF  ======*/
//borro las variables de localstorage
$(document).on("click", "#btnResetearFiltro", function(){ 
// console.log("hola");
localStorage.clear();
})