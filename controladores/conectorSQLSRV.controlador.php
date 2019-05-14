<?php

	class ControladorConectorSQLSRV{

	/*=============================================
	FUNCION PARA MOSTRAR LA LISTA DE conectores
	=============================================*/
	static public function ctrMostrarDatosConector($item, $valor){

		$tabla = "permisoshotel";
		//$item, $valor-->pueden venir como nulos, 
		$respuesta = ModeloConectorSQLSRV::mdlMostrarDatosConector($tabla,$item, $valor);
		//tabla permisoshotel, item=id $valor=valor de id-->mdlMostrarDatosConector("usuarios", id, 7)
		return $respuesta;		
	}
	
}