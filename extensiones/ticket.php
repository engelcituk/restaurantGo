<?php 
session_start();
require __DIR__ . '/posTicket/autoload.php'; //Nota: si renombraste" cambia el nombre en esta línea
require_once "../modelos/tickets.modelo.php";

use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;

class AjaxTickets{
/*======================================
= ESTA FUNCION RECIBE TODOS LOS DATOS DE LA RESERVA que ocupará para imprimir el ticket
======================================*/
	public $restauranteDelaReserva;
	public $fechaDeLaReserva;
	public $HoraDelaReserva;
	public $apellidoDeLaReserva; 
	public $paxDelaReserva;
	public $habitacionDelaReserva;
	// public $mesaDelaReserva;
	public $IdentificadorDelaReserva;
	public $ticketIdiomaDelaReserva;
	public $ticketIPdeLaImpresora;
	public $esTermica;

	public function generaTicket(){

	//LA FUNCION AL EJECUTARSE TOMA LOS VALORES QUE TIENEN MIS VARIABLES PUBLICAS LOS GUARDO EN UNA NUEVA VARIABLE....GUARDO VALOR de FECHADELARESERVA 2018-09-29 EN MI NUEVA VARIABLE Y ASÍ CON LOS DEMÁS
	$restauranteDelaReservaTicket = $this->restauranteDelaReserva;
	$fechaDeLaReservaTicket = $this->fechaDeLaReserva;
	$HoraDelaReservaTicket = $this->HoraDelaReserva;
	$apellidoDeLaReservaTicket = $this->apellidoDeLaReserva;
	$paxDelaReservaTicket = $this->paxDelaReserva;
	$habitacionDelaReservaTicket = $this->habitacionDelaReserva;
	// $mesaDelaReservaTicket = $this->mesaDelaReserva;
	$identificadorDelaReservaTicket = $this->IdentificadorDelaReserva;
	$idiomaDelaReservaTicket = $this->ticketIdiomaDelaReserva;
	// IP DE LA IMPRESORA QUE TRAIGO PARA MANDARLO A ESTA
	$ipImpresoraParaTicket = $this->ticketIPdeLaImpresora; // ip de la impresora
	$siEsTermica = $this->esTermica;// si la impresora es termica

	date_default_timezone_set('America/Cancun');
	$fechaGeneracionTicket = date("Y-m-d H:i:s");

		//consulto todo sobre el ticket de acuerdo al idioma que le doy
		$tabla="tickets";
		$valorDeMiCampo =$idiomaDelaReservaTicket; 
		
		$respuesta = ModeloTicket::mdlMostrarDatoTicket($tabla,$valorDeMiCampo);
		//traigo le encabezado y pie para el ticket de acuerdo al idioma que recibo		
		$encabezadoConsulta=$respuesta["encabezado"];							
		$pieTicketConsulta =$respuesta["pie"];
		
			try {
				//ip IMPRESORA TRAIDA DESDE LA VARIABLE $ipImpresoraParaTicket
				/* 172.16.0.207 ip de la impresora que ocupé para pruebas,
				cambiar la variable parametro $ipImpresoraParaTicket por una ip fija para pruebas si es
				necesaria */ 
			    $conectarImpresora = new NetworkPrintConnector( $ipImpresoraParaTicket, 9100);
			    $saltoLogo="";
			    $impresora = new Printer($conectarImpresora);
				$logo = EscposImage::load("logo.png", false);
				$impresora -> setJustification(Printer::JUSTIFY_CENTER);					
				if ($siEsTermica == 1) {
					$impresora->bitImage($logo);
					$impresora->text($saltoLogo."\n\n");
				}				
			    $impresora->text("   ".$encabezadoConsulta. "\n\n");
			    $impresora->text("   Restaurante: " .$restauranteDelaReservaTicket. "\n\n");
			    $impresora->text("   Habitación: " .$habitacionDelaReservaTicket. "\n");
			    $impresora->text("   Reserva: " .$identificadorDelaReservaTicket. "\n");
			    $impresora->text("   Nombre/Apellido: " .$apellidoDeLaReservaTicket. "\n");
			    $impresora->text("   Fecha: " .$fechaDeLaReservaTicket. "\n");
			    $impresora->text("   Hora: " .$HoraDelaReservaTicket. "\n");
			    $impresora->text("   Pax : " .$paxDelaReservaTicket. "\n\n");
			    // $impresora->text("Mesa No. : " .$mesaDelaReservaTicket. "\n\n");
				$impresora->text($pieTicketConsulta. "\n\n");
				#AGREGO LA FECHA DE LA GENERACION DEL TICKET
				$impresora->text($fechaGeneracionTicket. "\n\n");
			    $impresora -> cut();			    
			    /* Close printer */
				$impresora -> close();				
			} catch (Exception $e) {
				echo "No se puede imprimir con esta impresora: " . $e -> getMessage() . "\n";
		}
	}
/*=====  FIN DE OBTENER datos de la Reserva y generar ticket======*/
}
/*======================================
=   OBJETO-->PARA PASARLE A MIS VARIABLES PUBLICAS   =
======================================*/
if(isset($_POST["fechaDeLaReserva"])){ //SI POST VIENE CON INFORMACION 

	$ticket = new AjaxTickets();
	//la variable publica toma el valor que recibo por POST
	$ticket -> fechaDeLaReserva = $_POST["fechaDeLaReserva"]; 
	$ticket -> HoraDelaReserva = $_POST["HoraDelaReserva"];
	$ticket -> apellidoDeLaReserva = $_POST["apellidoDeLaReserva"];
	$ticket -> paxDelaReserva = $_POST["paxDelaReserva"];
	$ticket -> habitacionDelaReserva = $_POST["habitacionDelaReserva"];
	$ticket -> mesaDelaReserva = $_POST["mesaDelaReserva"];
	$ticket -> restauranteDelaReserva = $_POST["restauranteDelaReserva"];
	$ticket -> IdentificadorDelaReserva = $_POST["IdentificadorDelaReserva"];
	$ticket -> ticketIdiomaDelaReserva = $_POST["ticketIdiomaDelaReserva"];
	$ticket -> ticketIPdeLaImpresora = $_POST["ticketIPdeLaImpresora"];
	$ticket -> esTermica = $_POST["esTermica"];
	$ticket -> generaTicket(); //ejecuto la funcion
}



