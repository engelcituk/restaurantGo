<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/estanciaConf.controlador.php";
require_once "../modelos/estanciaConf.modelo.php";


class AjaxNochesEstancia{
/*======================================
= PARA ACTIVAR UNa configuracion NochesEstancia  =
======================================*/
	public $activarIdNocheEstancia;
	public $activarEstadoNocheEstancia;

	public function ajaxActivarEstadoNocheEstancia(){

		$tabla = "reservasporestancia";
		$item1 = "estado";
		$valor1 = $this->activarEstadoNocheEstancia;

		$item2 = "id";
		$valor2 =$this->activarIdNocheEstancia;
		
		$respuesta = ModeloReservaEstancia::mdlActualizarEstadoRsvsEstancia($tabla, $item1, $valor1, $item2, $valor2); 

	
	}
/*=====FIN  DE ACTIVAR Una configuracion nocheEstancia ======*/
/*======================================
= OBTENER DATO DE UNA CONFIGURACION DE RESERVA POR
NOCHES DE ESTANCIA POR ID SERA OCUPADO PARA CARGAR LOS DATOS 
OBTENIDOS EN UN MODAL   =
======================================*/
	public $idNocheEstancia;

	public function ajaxObtenerDatoNocheEstanciaByID(){
		
		$tabla="reservasporestancia";
		$valorDeMiCampo =$this->idNocheEstancia; 
		

		$respuesta = ModeloReservaEstancia::mdlMostrarDatoNocheEstById($tabla,$valorDeMiCampo);

		echo json_encode($respuesta);
	}
/*=====FIN DE OBTENER DATO DE NocheEstancia POR ID ======*/

/*======================================
= VALIDAR NO REPETIR A UN numero de noche estancia    =
======================================*/
	public $idHotelEstancia;	
	public $valorNochesEstancia;

	public function ajaxValidarNocheNumEstancia(){
		
		$tabla="reservasporestancia";
		$valorDeMiCampo =$this->idHotelEstancia; 
		
		$valorDeMiCampo2 =$this->valorNochesEstancia; 				

		$respuesta = ModeloReservaEstancia::mdlMostrarDatoNocheEstancia($tabla,$valorDeMiCampo,$valorDeMiCampo2);

		echo json_encode($respuesta);

	}
/*=====FIN DE VALIDAR NO REPETIR A UN numero de noche estancia ======*/

}
/*======================================
= OBJETO-->ACTIVAR NochesEstancia =
======================================*/
if(isset($_POST["idRsvEstancia"])){

	$activarNocheEstancia = new AjaxNochesEstancia();
	$activarNocheEstancia -> activarIdNocheEstancia = $_POST["idRsvEstancia"];
	$activarNocheEstancia -> activarEstadoNocheEstancia = $_POST["estadoConfig"]; 
	$activarNocheEstancia -> ajaxActivarEstadoNocheEstancia(); 
}
/*======================================
= OBJETO-->obtener dato de nocheEstancia byID =
======================================*/
if(isset($_POST["idNocheEstancia"])){

	$obtenerDatoNocheEstancia = new AjaxNochesEstancia();
	$obtenerDatoNocheEstancia -> idNocheEstancia = $_POST["idNocheEstancia"]; 
	$obtenerDatoNocheEstancia -> ajaxObtenerDatoNocheEstanciaByID(); //ejecuto la funcion
}
/*======================================
= OBJETO-->VALIDAR el numero de noche de estancia =
======================================*/
if(isset($_POST["idHotel"])){

	$validarNocheEstancia = new AjaxNochesEstancia();
	$validarNocheEstancia -> idHotelEstancia = $_POST["idHotel"];
	$validarNocheEstancia -> valorNochesEstancia = $_POST["valorNoches"];
	$validarNocheEstancia -> ajaxValidarNocheNumEstancia(); //ejecuto la funcion
}