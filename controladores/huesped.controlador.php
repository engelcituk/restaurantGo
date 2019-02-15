<?php 

class ControladorHuesped{
	/*=============================================
	PARA MOSTRAR LA LISTA DE LA TABLA ReservasReservix]
	=============================================*/
	static public function ctrMostrarListasHuesped($item, $valor){

		$tabla = "RestaurantGo";
		//$item, $valor-->pueden venir como nulos, en ese caso en el modelo se ejecuta una consulta diferente //si vienen nulos.
		$respuesta = ModeloHuesped::mdlMostrarListasHuesped($tabla,$item, $valor);
		//tabla ReservasReservix, item=id $valor=valor de id-->mdlMostrarListaUsuarios("usuarios", id, 7)
		return $respuesta;		
	}
}