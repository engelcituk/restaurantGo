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
	/*=====FIN  DE ACTIVAR UN RESTAURANTE  ======*/

/*======================================
= PARA OBTENER LAS FECHAS DE CIERRE DE UN RESTAURANTE   =
======================================*/
	public $idRestCierre;	
	public function getInfoCierreRestaurante(){

		$tabla = "RestauranteCierres";		
		$idRestaurante = $this->idRestCierre;

		$respuesta = ModeloRestaurantes::mdlGetInfoCierreRestaurante($tabla, $idRestaurante);

		echo json_encode($respuesta);
	}
	/*=====FIN  PARA OBTENER LAS FECHAS DE CIERRE DE UN RESTAURANTE   ======*/

/*======================================
= PARA VALIDAR NO REPETIR FECHAS DE CIERRE LAS FECHAS DE CIERRE DE UN RESTAURANTE   =
======================================*/
	public $idRestCierreAdd;
	public $fechaInicio;
	public $fechaFin;
	public function validarFechasCierreRestaurante(){

		$tabla = "RestauranteCierres";
		$idRestaurante = $this->idRestCierreAdd;
		$fechaInicio = $this->fechaInicio;
		$fechaFin = $this->fechaFin;

		$respuesta = ModeloRestaurantes::mdlValidarFechasCierreRestaurante($tabla, $idRestaurante,$fechaInicio, $fechaFin);

		echo json_encode($respuesta);
	}
	/*=====FIN  DE NO REPETIR FECHAS DE CIERRE LAS FECHAS DE CIERRE DE UN RESTAURANTE ======*/

	/*======================================
= PARA VALIDAR NO REPETIR FECHAS DE CIERRE LAS FECHAS DE CIERRE DE UN RESTAURANTE   =
======================================*/
	public $idRestCerrarAdd;
	public $fechaInicioAdd;
	public $fechaFinAdd;
	public function guardaFecha()
	{

		$tabla = "RestauranteCierres";
		$idRestaurante = $this->idRestCerrarAdd;
		$fechaInicio = $this->fechaInicioAdd;
		$fechaFin = $this->fechaFinAdd;

		//creo array para enviar los datos
		$datos = array(
			"idRestaurante" => $idRestaurante,
			"fechaInicio" => $fechaInicio,
			"fechaFin" => $fechaFin
		);

		$respuesta = ModeloRestaurantes::mdlGuardarFechasCierre($tabla, $datos);

		echo json_encode($respuesta);
	}
/*=====FIN  DE NO REPETIR FECHAS DE CIERRE LAS FECHAS DE CIERRE DE UN RESTAURANTE ======*/

}

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

	$activarRest = new AjaxRestaurantes();
	$activarRest -> idRestaurante =$_POST["idRestaurante"];  
	$activarRest -> estadoRestaurante = $_POST["estadoRestaurante"];
	$activarRest -> ajaxActivarRestaurante(); 
}

/*======================================
=   OBJETO-->traer fecha cierres restaurante  =
======================================*/
if (isset($_POST["idRestauranteCierre"])) {
	$cierreRest = new AjaxRestaurantes();
	$cierreRest->idRestCierre = $_POST["idRestauranteCierre"];	
	$cierreRest->getInfoCierreRestaurante();
}

/*======================================
=   OBJETO-->no repetir fechas de cierre restaurante =
======================================*/
if (isset($_POST["idRestCierreAdd"])) {
	$cierreObjRest = new AjaxRestaurantes();
	$cierreObjRest->idRestCierreAdd = $_POST["idRestCierreAdd"];
	$cierreObjRest->fechaInicio = $_POST["fechaInicio"];
	$cierreObjRest->fechaFin = $_POST["fechaFin"];
	$cierreObjRest->validarFechasCierreRestaurante();
}
/*======================================
=   OBJETO-->Guarda fecha de cierre restaurante =
======================================*/
if (isset($_POST["idRestCerrarAdd"])) {
	$cierreObjRest = new AjaxRestaurantes();
	$cierreObjRest->idRestCerrarAdd = $_POST["idRestCerrarAdd"];
	$cierreObjRest->fechaInicioAdd = $_POST["fechaInicioAdd"];
	$cierreObjRest->fechaFinAdd = $_POST["fechaFinAdd"];
	$cierreObjRest->guardaFecha();
}

