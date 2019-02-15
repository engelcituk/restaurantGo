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
	public $idReservaHotel;
	public function validarPoderHacerReserva(){

		$idReservaHotelValor= $this->idReservaHotel;

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
if(isset($_POST["idReservaHotel"])){

	$idReservaObtenida = new AjaxReservasRestaurantes();
	$idReservaObtenida -> idReservaHotel = $_POST["idReservaHotel"]; //la variable toma el valor por POST
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
/*==============================FIN DE SECTION LISTA DE OBJETOS==================================*/