<?php

class ControladorFechas{
	
	/*=============================================
    Para obtener la fecha de hoy 
    en formato año-mes-dia
	=============================================*/
	public static function ctrObtnerFechaHoy(){

        date_default_timezone_set('UTC');
        $respuestaFechaHoy = date("Y-m-d");
        
        return $respuestaFechaHoy;
    }
    public static function ctrObtnerFechaHoyDMY(){

        date_default_timezone_set('UTC');
        $respuestaFechaHoyDMY = date("d-m-Y");
        
        return $respuestaFechaHoyDMY;
    }

    // public $fechaRecibida;
    // public function ctrBloquearFechaReservaHoy(){
	// 	$valorDeMiFecha =$this->fechaRecibida; 
	// 	$respuestaFecha=$valorDeMiFecha;
	// 	return $respuestaFecha;
    // }	
} 

/*======================================
=   OBJETO-->ajaxObtenerDatoHotelByLike  =
======================================*/
// if(isset($_GET["fechaEnviada"])){

// 	$fechaObtenida = new ControladorFechas();
// 	$fechaObtenida -> fechaRecibida = $_GET["fechaEnviada"];
// 	$fechaObtenida -> ctrBloquearFechaReservaHoy(); 
// }