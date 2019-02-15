<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/seatings.controlador.php";
require_once "../modelos/seatings.modelo.php";


class AjaxSeatings{
/*======================================
=OBTENER DATOS DEL SEATING->TRABAJO CON todos los RESTAURANTES
AL DARLE EN EL ICONO DE EDITAR 
==== MODULO configuracion-seatings
======================================*/
	public $idSeatingEditar;
	public function AjaxObtenerDatoSeating(){

	$tabla = "seatings";
	$valorDeMiCampo = $this->idSeatingEditar; // el valor del id. por ejemplo (id = 7)	
	$respuesta = ModeloSeatings::mdlObtenerDatoSeating($tabla,$valorDeMiCampo); //(id, 7) como parametros para ejecutar
	echo json_encode($respuesta); //echo encode para verificar que se esta obteniendo respuesta OK
	 
	}
/*=====  FIN DE OBTENER seating  ======*/
/*======================================
= PARA ACTIVAR UN SEATING   =
======================================*/
	public $activarIdSeating;
	public $activarEstadoSeating;

	public function ajaxActivarSeating(){

		$tabla = "seatings";
		$item1 = "estado";
		$valor1 = $this->activarEstadoSeating;

		$item2 = "id";
		$valor2 =$this->activarIdSeating;
		
		$respuesta = ModeloSeatings::mdlActualizarEstadoSeating($tabla, $item1, $valor1, $item2, $valor2); 

	}
/*=====FIN  DE ACTIVAR Un seating  ======*/
/*======================================
= VALIDAR NO REPETIR un seating    =
======================================*/
	public $idHotel;
	public $idRestaurante;
	public $horaSeating;

	public function ajaxValidarSeatingHorario(){

		$tabla="seatings";
		$valorDeMiCampo =$this->idHotel; 
		$valorDeMiCampo2= $this->idRestaurante;		
		$valorDeMiCampo3= $this->horaSeating;

		//llamo al controlador que muestra la consulta de los usuarios
		//$respuesta = ControladorUsuarios::ctrMostrarListaUsuarios($item, $valor); //como parametros para ejecutar
		$respuesta = ModeloSeatings::mdlTraerListaSeatings($tabla,$valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3);

		 echo json_encode($respuesta);

	}

}

/*======================================
=   OBJETO-->OBTENER dato seating   =
======================================*/
if(isset($_POST["idSeatingEditar"])){ //SI LA VARIABLE POST VIENE CON INFORMACION IDSeating

	$seating = new AjaxSeatings();
	$seating -> idSeatingEditar = $_POST["idSeatingEditar"]; //la variable publica toma el valor que recibo por POST
	$seating -> AjaxObtenerDatoSeating(); //ejecuto la funcion
}
/*======================================
= OBJETO-->ACTIVAR seating =
======================================*/
if(isset($_POST["activarIdSeating"])){

	$activarSeating = new AjaxSeatings();
	$activarSeating -> activarIdSeating = $_POST["activarIdSeating"];
	$activarSeating -> activarEstadoSeating = $_POST["activarEstadoSeating"]; 
	$activarSeating -> ajaxActivarSeating(); 
}
/*======================================
= OBJETO-->VALIDAR seating =
======================================*/
if(isset($_POST["idHotelVS"])){

	$validarSeating = new AjaxSeatings();
	$validarSeating -> idHotel = $_POST["idHotelVS"]; 
	$validarSeating -> idRestaurante = $_POST["idRestauranteVS"];
	$validarSeating -> horaSeating = $_POST["horaElegidaVS"];
	$validarSeating -> ajaxValidarSeatingHorario(); //ejecuto la funcion
}