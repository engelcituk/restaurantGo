<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";


class AjaxReservas{
/*======================================
=OBTENER Reserva->trabajo con cualquier restaurante=
======================================*/
	public $idReserva;
	public function ObtenerDatoReserva(){

	$item = "id"; //sería el campo de la tabla
	$valor = $this->idReserva; // el valor del id. por ejemplo (id = 7)

	//llamo al controlador que muestra la consulta de los Reservas
	$respuesta = ControladorReservas::ctrObtenerDatoReserva($item, $valor); //(id, 7) como parametros para ejecutar
	
	 echo json_encode($respuesta); //echo encode para verificar que se esta obteniendo respuesta OK
	 //no comentar echo json_encode()
	}
/*=====  FIN DE OBTENER Reserva  ======*/
/*======================================
= PARA ACTIVAR UNA RESERVA   =
======================================*/
	public $activarIdReserva;
	public $activarEstadoReserva;

	public function ajaxActivarReserva(){

		$tabla = "reservas";
		$item1 = "estado";
		$valor1 = $this->activarEstadoReserva;

		$item2 = "id";
		$valor2 =$this->activarIdReserva;

		$respuesta = ModeloReservas::mdlActualizarEstadoReserva($tabla, $item1, $valor1, $item2, $valor2); 

	}
/*=====FIN  DE ACTIVAR UNA RESERVA  ======*/
}

/*======================================
=   OBJETO-->OBTENER Reserva   =
======================================*/
if(isset($_POST["idReserva"])){ //SI LA VARIABLE POST VIENE CON INFORMACION IDRESERVA

	$reserva = new AjaxReservas();
	$reserva -> idReserva = $_POST["idReserva"]; //la variable publica toma el valor que recibo por POST
	$reserva -> ObtenerDatoReserva(); //ejecuto la funcion
}
/*======================================
= OBJETO-->ACTIVAR RESERVA =
======================================*/
if(isset($_POST["activarIdReserva"])){

	$activarReserva = new AjaxReservas();
	$activarReserva -> activarIdReserva = $_POST["activarIdReserva"];
	$activarReserva -> activarEstadoReserva = $_POST["activarEstadoReserva"]; 
	$activarReserva -> ajaxActivarReserva(); 
}
