<?php 

class ControladorHuesped{
	/*=============================================
	PARA MOSTRAR LA LISTA DE LA TABLA ReservasReservix]
	=============================================*/
	static public function ctrMostrarListasHuesped($tabla, $valorCampo, $ocupantes, $hotel){						
		//$item, $valor-->pueden venir como nulos, en ese caso en el modelo se ejecuta una consulta diferente //si vienen nulos.
		$respuesta = ModeloHuesped::mdlMostrarListasHuesped($tabla, $valorCampo, $ocupantes, $hotel);
		//tabla ReservasReservix, item=id $valor=valor de id-->mdlMostrarListaUsuarios("usuarios", id, 7)
		return $respuesta;		
	}
}
