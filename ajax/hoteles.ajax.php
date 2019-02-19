<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/hoteles.controlador.php";
require_once "../modelos/hoteles.modelo.php";


class AjaxHoteles{
/*======================================
=TRAIGO LOS DATOS PARA PODER EDITAR HOTEL=
======================================*/
	public $idHotelEditar;
	public function ajaxEditarHotel(){ 

	$item = "id"; //sería el campo de la tabla
	$valor = $this->idHotelEditar; // el valor del id. por ejemplo (id = 7)

	//llamo al controlador que muestra la consulta de los hoteles
	$respuesta = ControladorHoteles::ctrMostrarListaHoteles($item, $valor); //(id, 7) como parametros para ejecutar
	
	 echo json_encode($respuesta); //echo encode para obtener el json y que se esta obteniendo OK
	 //no comentar echo json_encode()
	}
/*=====  FIN DE EDITAR HOTEL ======*/

/*======================================
= PARA ACTIVAR A UN HOTEL    =
======================================*/
	public $idHotelEstado;
	public $estadoHotel;

	public function ajaxActivarHotel(){

		$tabla = "hoteles";

		$campo = "id";
		$valorCampo =$this->idHotelEstado;

		$campo2 = "estado";
		$valorCampo2 = $this->estadoHotel;


		$respuesta = ModeloHoteles::mdlActualizarEstadoHotel($tabla, $campo, $valorCampo, $campo2, $valorCampo2);
		

}
/*=====FIN  DE ACTIVAR A UN Hotel  ======*/

/*======================================
= OBTENER DATO DE UN hotel, mediante la sentencia
like  =
======================================*/
	public $idHotel;
	public function ajaxObtenerDatoHotelById(){
		
		$tabla="hoteles";
		$valorDeMiCampo =$this->idHotel; 
		
		$respuesta = ModeloHoteles::mdlMostrarDatoHotelById($tabla,$valorDeMiCampo);

		echo json_encode($respuesta);
	}
/*=====FIN DE OBTENER DATO DE NocheEstancia POR ID ======*/

}
/*======================================
=   OBJETO-->EDITAR HOTEL  =
======================================*/
if(isset($_POST["idHotelEditar"])){

	$usuarioEditar = new AjaxHoteles();
	$usuarioEditar -> idHotelEditar = $_POST["idHotelEditar"]; //la variable publica toma el valor que recibo por POST
	$usuarioEditar -> ajaxEditarHotel(); //ejecuto la funcion
}
/*======================================
=   OBJETO-->ACTIVAR HOTEL  =
======================================*/
if(isset($_POST["idHotelEstado"])){

	$activarHotel = new AjaxHoteles();
	$activarHotel -> idHotelEstado =$_POST["idHotelEstado"];  
	$activarHotel -> estadoHotel = $_POST["estadoHotel"];
	$activarHotel -> ajaxActivarHotel(); 
}
/*======================================
=   OBJETO-->ajaxObtenerDatoHotelByLike  =
======================================*/
if(isset($_POST["idHotel"])){

	$datoHotel = new AjaxHoteles();
	$datoHotel -> idHotel = $_POST["idHotel"];
	$datoHotel -> ajaxObtenerDatoHotelById(); 
}







