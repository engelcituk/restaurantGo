<?php

class ControladorEstadisticas{	
	/*=============================================
	LISTADO DE restaurantes
	=============================================*/
	static public function ctrMostrarListaRestaurantes($item, $valor){

		$tabla = "restaurantes";
		//$item, $valor-->pueden venir como nulos, en ese caso en el modelo se ejecuta una consulta diferente
		$respuesta = ModeloEstadisticas::mdlMostrarListaRestaurantes($tabla,$item, $valor);
		//tabla restaurantes, item=id $valor=valor de id-->
		return $respuesta;		
	}
	/*=============================================
	CONTAR PAX ACUMULADOS
	=============================================*/
	static public function ctrContarPaxAcumulados($valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3){

		$tabla = "reservas";
		$respuesta = ModeloEstadisticas::mdlContarPaxAcumulados($tabla,$valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3);
		
		return $respuesta;		
	}

	/*=============================================
	CONTAR PAX TOPES DEL DÍA DE ACUERDO AL RESTAURANTE
	Y EL DIA, HOTEL
	=============================================*/
	static public function ctrCapacidadMaximaPaxDia($valorDeMiCampoPax,$valorDeMiCampoPax2,$valorDeMiCampoPax3){

		$tabla = "seatings";
		$respuesta = ModeloEstadisticas::mdlCapacidadMaximaPaxDia($tabla,$valorDeMiCampoPax,$valorDeMiCampoPax2,$valorDeMiCampoPax3);
		
		return $respuesta;		
	}

	/*=============================================
	TRAER TODOS LOS SEATINGS DEL DIA DADO DE ACUERDO AL
	IDHOTEL, IDRESTAURANTE, IDDIA
	=============================================*/
	static public function ctrMostrarSeatingDelDia($valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3){

		$tabla = "seatings";
		$respuesta = ModeloEstadisticas::mdlMostrarSeatingDelDia($tabla,$valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3);
		
		return $respuesta;		
	}

	/*=============================================
	TRAER TODOS LOS SEATINGS DEL DIA DADO DE ACUERDO AL
	IDHOTEL, IDRESTAURANTE, IDDIA
	=============================================*/
	static public function ctrTraerPaxAcumuladoHora($idHotel2,$idRestaurante2,$fechaHoy,$horaSeating){

		$tabla = "reservas";
		$respuesta = ModeloEstadisticas::mdlTraerPaxAcumuladoHora($tabla,$idHotel2,$idRestaurante2,$fechaHoy,$horaSeating);
		
		return $respuesta;		
	}

} 

