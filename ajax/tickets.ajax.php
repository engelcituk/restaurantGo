<?php 
session_start();
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/tickets.controlador.php";
require_once "../modelos/tickets.modelo.php";


class AjaxTickets{

/*======================================
= VALIDAR NO REPETIR A UN ticket    =
======================================*/
	public $validarTicket;
 
	public function ajaxValidarTicket(){
		
		$tabla="tickets";
		$valorDeMiCampo =$this->validarTicket; 
		
		$respuesta = ModeloTicket::mdlMostrarDatoTicket($tabla,$valorDeMiCampo);

		 echo json_encode($respuesta);

	}
/*=====FIN DE VALIDAR NO REPETIR A UN ticket ======*/
/*======================================
= OBTENER DATO DE TICKET POR ID 
SERA OCUPADO PARA CARGAR LOS DATOS 
OBTENIDOS EN UN MODAL   =
======================================*/
	public $idTicket;

	public function ajaxObtnerDatoTicketByID(){
		
		$tabla="tickets";
		$valorDeMiCampo =$this->idTicket; 
		

		$respuesta = ModeloTicket::mdlMostrarDatoTicketById($tabla,$valorDeMiCampo);

		 echo json_encode($respuesta);
	}
/*=====FIN DE OBTENER DATO DE TICKET POR ID ======*/

/*======================================
= PARA ACTIVAR un ticket/idioma    =
======================================*/
	public $idTicketEstado;
	public $estadoTicket;

	public function ajaxActivarTicket(){

		$tabla = "tickets";

		$campo = "id";
		$valorCampo =$this->idTicketEstado;

		$campo2 = "estado";
		$valorCampo2 = $this->estadoTicket;


		$respuesta = ModeloTicket::mdlActualizarEstadoTicket($tabla, $campo, $valorCampo, $campo2, $valorCampo2);
		
		

}
/*=====FIN  DE ACTIVAR A UN Hotel  ======*/

}


/*======================================
= OBJETO-->VALIDAR el idioma del ticket =
======================================*/
if(isset($_POST["idioma"])){

	$validarTicket = new AjaxTickets();
	$validarTicket -> validarTicket = $_POST["idioma"]; //la variable publica toma el valor que recibo por POST enviado por ajax
	$validarTicket -> ajaxValidarTicket(); //ejecuto la funcion
}

/*======================================
= OBJETO-->obtener dato de ticket byID =
======================================*/
if(isset($_POST["idTicket"])){

	$obtenerDatoTicket = new AjaxTickets();
	$obtenerDatoTicket -> idTicket = $_POST["idTicket"]; //la variable publica toma el valor que recibo por POST enviado por ajax
	$obtenerDatoTicket -> ajaxObtnerDatoTicketByID(); //ejecuto la funcion
}

/*======================================
=   OBJETO-->ACTIVAR ticket  =
======================================*/
if(isset($_POST["idTicketEstado"])){

	$activarHotel = new AjaxTickets();
	$activarHotel -> idTicketEstado =$_POST["idTicketEstado"];  
	$activarHotel -> estadoTicket = $_POST["estadoTicket"];
	$activarHotel -> ajaxActivarTicket(); 
}