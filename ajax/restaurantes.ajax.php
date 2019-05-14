<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/restaurantes.controlador.php";
require_once "../modelos/restaurantes.modelo.php";


class AjaxRestaurantes{
/*======================================
=OBTENER Reserva->para traer lista de restaurantes=
======================================*/
	public $idHotel;
	public function ObtenerListaRestaurantes(){

	$campoTabla = "idHotel"; //sería el campo de la tabla
	$valorCampoTabla = $this->idHotel; // el valorCampoTabla del id. por ejemplo (id = 7)

	
	$respuesta = ControladorRestaurantes::ctrMostrarListaRestaurantes($campoTabla, $valorCampoTabla);
	
	 echo json_encode($respuesta); 
	 //no comentar echo json_encode()
	}
/*=====  FIN DE OBTENER lista de restaurantes  ======*/


/*======================================
=            EDITAR RESTAURANTE          =
======================================*/
	public $idRstrnt;
	public function ajaxEditarRestaurante(){

	$campoTabla = "id"; //campo de la tabla
	$valorCampoTabla = $this->idRstrnt; // valor del id

	//llamo al controlador que muestra la consulta de los usuarios
	$respuesta = ControladorRestaurantes::ctrMostrarRestauranteByid($campoTabla,$valorCampoTabla); //(id, 7) como parametros para ejecutar
	
	 echo json_encode($respuesta); 
	}
/*=====  FIN DE EDITAR RESTAURANTE======*/

/*======================================
= PARA ACTIVAR A UN RESTAURANTE    =
======================================*/
	public $idRestaurante;
	public $estadoRestaurante;
	public function ajaxActivarRestaurante(){

		$tabla = "restaurantes";

		$campo = "id";
		$valorCampo =$this->idRestaurante;

		$campo2 = "estado";
		$valorCampo2 = $this->estadoRestaurante;


		$respuesta = ModeloRestaurantes::mdlActualizarEstadoRestaurante($tabla, $campo, $valorCampo, $campo2, $valorCampo2);
	}
}

/*=====FIN  DE ACTIVAR UN RESTAURANTE  ======*/

/*======================================
=   OBJETO-->OBTENER hotel   =
======================================*/
if(isset($_POST["idHotel"])){ //SI LA VARIABLE POST VIENE CON INFORMACION idHotel

	$restaurant = new AjaxRestaurantes();
	$restaurant -> idHotel = $_POST["idHotel"]; //la variable publica toma el valor recibido por POST
	$restaurant -> ObtenerListaRestaurantes(); //ejecuto la funcion
}
/*======================================
=   OBJETO-->EDITAR RESTAURANTE   =
======================================*/
if(isset($_POST["idRstrnt"])){

	$rstrntEditar = new AjaxRestaurantes();
	$rstrntEditar -> idRstrnt = $_POST["idRstrnt"]; //variable publica toma valor que recibo por POST
	$rstrntEditar -> ajaxEditarRestaurante(); //ejecuto la funcion
}
/*======================================
=   OBJETO-->ACTIVAR restaurante  =
======================================*/
if(isset($_POST["idRestaurante"])){

	$activarHotel = new AjaxRestaurantes();
	$activarHotel -> idRestaurante =$_POST["idRestaurante"];  
	$activarHotel -> estadoRestaurante = $_POST["estadoRestaurante"];
	$activarHotel -> ajaxActivarRestaurante(); 
}


