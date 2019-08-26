<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/reservas.controlador.php";
require_once "../modelos/reservas.modelo.php";


class AjaxReservasRestaurantes{
/*======================================
PARA TRAER LA LISTA DE RESTAURANTES DE ACUERDO AL ID
DEL HOTEL OBTENIDO
======================================*/
	public $idHotel;  
	public function obtnerListaDeRestaurantes(){

		$idHotelValor= $this->idHotel;

		$campoDeMiTabla ="idHotel";
		$valorDeMiCampo =$idHotelValor;

		$respuesta = ControladorReservas::ctrObtnerListaDeRestaurantes($campoDeMiTabla,$valorDeMiCampo);
		echo json_encode($respuesta);
	}

/*======================================
PARA CONVERTIR LA FECHA QUE RECIBO A DIA DE LA SEMANA,
EN ESTE CASO LOS CONVIERTO A NUMEROS
======================================*/
	public $fechaReservaObtenida;
	public $idHotelCampo;
	public $idRestaurantCampo;
	public function convertidorFechaDia(){

		$dias = array('', '1','2','3','4','5','6', '7');

		$miFecha = $this->fechaReservaObtenida;

		$diaResultado = $dias[date('N', strtotime($miFecha))];

		$tabla = "seatings";

		// $campoDeMiTabla ="idDiaSemana";
		$valorDeMiCampo =$diaResultado; //valor del dia...1 es lunes, 2 martes
		$valorDeMiCampo2= $this->idHotelCampo;//id del hotel, 1 es caracol, 2 es playacar		
		$valorDeMiCampo3= $this->idRestaurantCampo; //id restaurant, 1 es el riviera..

		// $respuesta = ControladorReservas::ctrTraerSeatingDelDiaDado($campoDeMiTabla,$valorDeMiCampo);
		$respuesta = ModeloReservas::mdlTraerSeatingDelDiaDado($tabla,$valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3);
		echo json_encode($respuesta);
		
	}
/*======================================
PARA OBTENER LA CONFIGURACION DE NUMERO DE RESERVAS QUE PUEDE HACER EL
HUESPED EN EL RESTAURANTE DE ACUERDO A SUS NOCHES DE ESTANCIA en cualquier hotel
======================================*/
	public $idHotel2;
	public $nochesDeEstancia;
	public function obtenerNumMaxDeReservas(){

		$tabla = "reservasporestancia";
		$valorDeMiCampo= $this->idHotel2;		
		$valorDeMiCampo2= $this->nochesDeEstancia;

		$respuesta = ModeloReservas::mdlObtenerNumMaxDeReservas($tabla,$valorDeMiCampo,$valorDeMiCampo2);
		echo json_encode($respuesta);
	}
/*======================================
PARA OBTENER LA LISTA DE MESAS DISPONIBLES PARA EL RESTAURANTE
======================================*/
	public $idRestauranteQ;
	public function obtenerListaDeMesasDisponibles(){

		$idRestauranteValor= $this->idRestauranteQ;

		$campoDeMiTabla ="idRestaurante"; 
		$valorDeMiCampo =$idRestauranteValor;

		$respuesta = ControladorReservas::ctrObtenerListaDeMesasDisponibles($campoDeMiTabla,$valorDeMiCampo);
		echo json_encode($respuesta);
	}

/*======================================
PARA VERIFICAR QUE EL HUESPED PUEDA HACER RESERVA
======================================*/
	public $identificadorReservaHotel;
	public function validarPoderHacerReserva(){

		$idReservaHotelValor= $this->identificadorReservaHotel;

		$campoDeMiTabla ="reservaIdentificador";
		$valorDeMiCampo =$idReservaHotelValor;

		$respuesta = ControladorReservas::ctrValidarPoderHacerReserva($campoDeMiTabla,$valorDeMiCampo);
		echo json_encode($respuesta);
	}
/*======================================
PARA TRAER EL NUMERO DE SEATING QUE YA HAY DE FECHA/HORA X dadas
======================================*/
	public $fechaDeLaReserva;
	public $horaDelSeating;
	public $idRestauranteSeating;
	public function contarReservasYPaxAcumulados(){ 

		$tabla ="reservas";
		
		$valorDeMiCampo = $this->fechaDeLaReserva;
		$valorDeMiCampo2 = $this->horaDelSeating;
		$valorDeMiCampo3 = $this->idRestauranteSeating;


		$respuesta = ModeloReservas::mdlContarReservasYPaxAcumulados($tabla,$valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3);
		
		echo json_encode($respuesta);

	}
	/*======================================
PARA TRAER EL NUMERO DE SEATING QUE YA HAY DE FECHA/ X dadas
======================================*/
	public $fechaDeLaReservaDia;	
	public $idRestauranteSeatingDia;
	public function contarReservasYPaxAcumuladosDia()
	{

		$tabla = "reservas";

		$valorDeMiCampo = $this->fechaDeLaReservaDia;		
		$valorDeMiCampo2 = $this->idRestauranteSeatingDia;


		$respuesta = ModeloReservas::mdlContarReservasYPaxAcumuladosDia($tabla, $valorDeMiCampo, $valorDeMiCampo2);

		echo json_encode($respuesta);
	}

	public $idRestCierre;
	public $fechaRestOpen;
	public function restauranteAbiertoVerificar(){

		$tabla = "RestauranteCierres";
		$idRestaurante = $this->idRestCierre;
		$fecha = $this->fechaRestOpen;		
		//creo array para enviar los datos
		$datos = array(
			"idRestaurante" => $idRestaurante,
			"fecha" => $fecha
		);

		$respuesta = ModeloReservas::mdlrestauranteAbiertoVerificar($tabla, $datos);

		echo json_encode($respuesta);
	}

	public $idRestCierre2;
	public $fechaInicio;
	public $fechaFinal;
	public function verificarSiRestauranteTieneRSV(){

		$tabla = "reservas";
		$idRestaurante = $this->idRestCierre2;
		$fechaInicio = $this->fechaInicio;
		$fechaFinal = $this->fechaFinal;
		//creo array para enviar los datos
		$datos = array(
			"idRestaurante" => $idRestaurante,
			"fechaInicio" => $fechaInicio,
			"fechaFinal" => $fechaFinal
		);

		$respuesta = ModeloReservas::mdlVerificarSiRestauranteTieneRSV($tabla, $datos);

		echo json_encode($respuesta);
	}
}
/*==============================SECTION DE OBJETOS==================================*/

/*======================================
=   OBJETO-->obtnerListaDeRestaurantes   =
======================================*/
if(isset($_POST["idHotel"])){ //SI LA VARIABLE POST VIENE CON INFORMACION idHotel

	$idHotel = new AjaxReservasRestaurantes();
	$idHotel -> idHotel = $_POST["idHotel"]; //la variable publica toma el valor por POST
	$idHotel -> obtnerListaDeRestaurantes(); //ejecuto la funcion
}
/*======================================
=   OBJETO-->para Verificar si restaurante no está cerrado =
======================================*/
if (isset($_POST["idRestCierre"])) { 

	$restCierre = new AjaxReservasRestaurantes();
	$restCierre->idRestCierre = $_POST["idRestCierre"];
	$restCierre->fechaRestOpen = $_POST["fechaRestOpen"]; 
	$restCierre->restauranteAbiertoVerificar(); 
}
/*======================================
=   OBJETO-->para Verificar si restaurante no está cerrado =
======================================*/
if (isset($_POST["idRestCierre2"])) {

	$restCierre2 = new AjaxReservasRestaurantes();
	$restCierre2->idRestCierre2 = $_POST["idRestCierre2"];
	$restCierre2->fechaInicio = $_POST["fechaInicio"];
	$restCierre2->fechaFinal = $_POST["fechaFin"];
	$restCierre2->verificarSiRestauranteTieneRSV();
}
/*======================================
=   OBJETO-->convertidorFechaDia   =
======================================*/
if(isset($_POST["fechaReservaObtenida"])){ //SI LA VARIABLE POST VIENE CON INFORMACION fechaReserva

	$fechaObtenida = new AjaxReservasRestaurantes();
	$fechaObtenida -> fechaReservaObtenida = $_POST["fechaReservaObtenida"]; //la variable publica toma el valor por POST
	$fechaObtenida -> idHotelCampo = $_POST["idHotelCampo"];
	$fechaObtenida -> idRestaurantCampo = $_POST["idRestaurantCampo"];
	$fechaObtenida -> convertidorFechaDia(); //ejecuto la funcion
}
/*======================================
=   OBJETO-->obtnerNumMaxDeReservas   =
======================================*/
if(isset($_POST["nochesDeEstancia"])){

	$nocheNumObtenida = new AjaxReservasRestaurantes();
	$nocheNumObtenida -> nochesDeEstancia = $_POST["nochesDeEstancia"]; //la variable publica toma el valor por POST
	$nocheNumObtenida -> idHotel2 = $_POST["idHotel2"];
	$nocheNumObtenida -> obtenerNumMaxDeReservas();
}
/*======================================
=   OBJETO-->obtenerListaDeMesasDisponibles   =
======================================*/
if(isset($_POST["idRestauranteQ"])){

	$idRestauranteQObtenida = new AjaxReservasRestaurantes();
	$idRestauranteQObtenida -> idRestauranteQ = $_POST["idRestauranteQ"]; //la variable publica toma el valor por POST
	$idRestauranteQObtenida -> obtenerListaDeMesasDisponibles();
}

/*======================================
=   OBJETO-->validarPoderHacerReserva   =
======================================*/
if(isset($_POST["identificadorReservaHotel"])){

	$idReservaObtenida = new AjaxReservasRestaurantes();
	$idReservaObtenida -> identificadorReservaHotel = $_POST[ "identificadorReservaHotel"]; //la variable toma el valor por POST
	$idReservaObtenida -> validarPoderHacerReserva();
}
/*======================================
=   OBJETO-->contarReservasYPaxAcumulados   =
======================================*/
if(isset($_POST["fechaDeLaReserva"])){

	$contarRsvSumPax = new AjaxReservasRestaurantes();
	$contarRsvSumPax -> fechaDeLaReserva = $_POST["fechaDeLaReserva"];//variable toma el valor por POST
	$contarRsvSumPax -> horaDelSeating = $_POST["horaDelSeating"];
	$contarRsvSumPax -> idRestauranteSeating = $_POST["idRestauranteSeating"];
	$contarRsvSumPax -> contarReservasYPaxAcumulados();
}
/*======================================
=   OBJETO-->contarReservasYPaxAcumuladosDia   =
======================================*/
if (isset($_POST[ "fechaDeLaReservaDia"])) {

	$contarRsvSumPax = new AjaxReservasRestaurantes();
	$contarRsvSumPax->fechaDeLaReservaDia = $_POST["fechaDeLaReservaDia"]; //variable toma el valor por POST	
	$contarRsvSumPax->idRestauranteSeatingDia = $_POST["idRestauranteSeatingDia"];
	$contarRsvSumPax->contarReservasYPaxAcumuladosDia();
}
/*======================================
=   OBJETO-->contarReservasYPaxAcumuladosDia   =
======================================*/
if (isset($_POST["fechaDeLaReservaDia"])) {

	$contarRsvSumPax = new AjaxReservasRestaurantes();
	$contarRsvSumPax->fechaDeLaReservaDia = $_POST["fechaDeLaReservaDia"]; //variable toma el valor por POST	
	$contarRsvSumPax->idRestauranteSeatingDia = $_POST["idRestauranteSeatingDia"];
	$contarRsvSumPax->contarReservasYPaxAcumuladosDia();
}
/*==============================FIN DE SECTION LISTA DE OBJETOS==================================*/