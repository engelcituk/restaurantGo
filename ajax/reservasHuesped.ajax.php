<?php
session_start();/**/
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/huesped.controlador.php";
require_once "../modelos/huesped.modelo.php";


class AjaxReservix{
/*======================================
=            buscar habitacion            =
======================================*/
	public $numHabitacion;
	public function ajaxBuscarHabitacion(){

	$dbo = "dbo.";
	$empresa = $_SESSION["empresaSQLSRV"];
	$simboloDollar = '$';
	
	$hotel = $_SESSION["hotelSQLSRV"];//lo ocupo para el where con el and
	$cadena = str_replace(' ', '', $dbo.$empresa.$simboloDollar);//Quito espacios para obtener->  dbo.CARACOL$
	
	$tabla = $cadena."Reservas";// dbo.CARACOL$Reservas
	$ocupantes = $cadena."Ocupantes";// dbo.CARACOL$Ocupantes
	
	$valorCampo = $this->numHabitacion; // el valor de habitacion. por ejemplo ( 7) 

	//llamo al controlador que muestra la consulta de los usuarios
	$respuesta = ControladorHuesped::ctrMostrarListasHuesped($tabla, $valorCampo, $ocupantes, $hotel); //(Habitacion, 7) como parametros para ejecutar
	
	 echo json_encode($respuesta); //echo encode para verificar que se esta obteniendo respuesta OK
	 //no comentar echo json_encode()
	}
/*=====  FIN DE buscar habitacion   ======*/
}
 

/*======================================
=   OBJETO-->buscar habitacion  =
======================================*/
if(isset($_POST["numHabitacion"])){
	$habitacion = new AjaxReservix();
	$habitacion -> numHabitacion = $_POST["numHabitacion"]; //la variable publica toma el valor que recibo por POST
	$habitacion -> ajaxBuscarHabitacion(); //ejecuto la funcion
}


