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

	$item = "Habitacion"; //sería el campo de la tabla
	$valor = $this->numHabitacion; // el valor del id. por ejemplo (id = 7)

	//llamo al controlador que muestra la consulta de los usuarios
	$respuesta = ControladorHuesped::ctrMostrarListasHuesped($item, $valor); //(Habitacion, 7) como parametros para ejecutar
	
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


