<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/impresoras.controlador.php";
require_once "../modelos/impresoras.modelo.php";


class AjaxImpresora{
/*======================================
= PARA ACTIVAR UNA IMPRESORA  =
======================================*/
	public $activarIdImpresora;
	public $activarEstadoImpresora;

	public function ajaxActivarEstadoImpresora(){

		$tabla = "ticketimpresoras";
		$item1 = "estado";
		$valor1 = $this->activarEstadoImpresora;

		$item2 = "id";
		$valor2 =$this->activarIdImpresora;
		
		$respuesta = ModeloImpresoras::mdlUpdateEstadoImpresora($tabla, $item1, $valor1, $item2, $valor2);
	}
/*=====FIN  DE ACTIVAR IMPRESORA ======*/
/*======================================
= VALIDAR NO REPETIR IP DE UNA IMPRESORA   =
======================================*/
	public $ipImpresora;
	public function ajaxValidarIpImpresora(){

		$tabla="ticketimpresoras";
		$valorDeMiCampo =$this->ipImpresora; 
	
		$respuesta = ModeloImpresoras::mdlTraerInfoImpresora($tabla,$valorDeMiCampo);

		echo json_encode($respuesta);

	}

	/*======================================
=OBTENER DATO DE UNA IMPRESORA DE ACUERDO A SU ID
CAPTURADO, DATOS QUE SON CARGADOS EN UN MODAL 
==== MODULO IMPRESORAS
======================================*/
	public $idImpresoraEditar;
	public function AjaxObtenerDatoImpresora(){

	$tabla = "ticketimpresoras";
	$valorDeMiCampo = $this->idImpresoraEditar; 

	$respuesta = ModeloImpresoras::mdlObtenerDatoImpresoraById($tabla,$valorDeMiCampo);

	echo json_encode($respuesta); //echo encode para verificar que se esta obteniendo respuesta OK
	 
	}

	/*======================================
= OBTENER LISTA DE IMPRESORAS DE ACUERDO AL ID DEL HOTEL  =
======================================*/
	public $idHotelImpresora;
	public function ajaxObtenerListaImpresorasByIdHotel(){
		
		$tabla="ticketimpresoras";
		$valorDeMiCampo =$this->idHotelImpresora; 
		
		$respuesta = ModeloImpresoras::mdlMostrarImpresorasHotelById($tabla,$valorDeMiCampo);

		echo json_encode($respuesta);
	}
/*=====FIN DE OBTENER DATO DE NocheEstancia POR ID ======*/

}
/*======================================
= OBJETO-->ACTIVAR IMPRESORA =
======================================*/
if(isset($_POST["idImpresora"])){
	$activarImpresora = new AjaxImpresora();
	$activarImpresora -> activarIdImpresora = $_POST["idImpresora"];
	$activarImpresora -> activarEstadoImpresora = $_POST["estadoImpresora"]; 
	$activarImpresora -> ajaxActivarEstadoImpresora(); 
}
/*======================================
= OBJETO-->VALIDAR ip Impresora =
======================================*/
if(isset($_POST["ipImpresora"])){
	$validarIpImpresora = new AjaxImpresora();
	$validarIpImpresora -> ipImpresora = $_POST["ipImpresora"]; 	
	$validarIpImpresora -> ajaxValidarIpImpresora(); //ejecuto la funcion
}
/*======================================
=   OBJETO-->OBTENER dato impresora   =
======================================*/
if(isset($_POST["idImpresoraEditar"])){ //SI LA VARIABLE POST VIENE CON INFORMACION idImpresoraEditar
	$impresora = new AjaxImpresora();
	$impresora -> idImpresoraEditar = $_POST["idImpresoraEditar"];
	$impresora -> AjaxObtenerDatoImpresora(); //ejecuto la funcion
}
/*======================================
=   OBJETO-->OBTENER dato impresora   =
======================================*/
if(isset($_POST["idHotelImpresora"])){ //SI LA VARIABLE POST VIENE CON INFORMACION idImpresoraEditar
	$impresora = new AjaxImpresora();
	$impresora -> idHotelImpresora = $_POST["idHotelImpresora"];
	$impresora -> ajaxObtenerListaImpresorasByIdHotel(); //ejecuto la funcion
}