<?php
require_once "conexion.php";

class ModeloPermisosHotel{

	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA de permisos de permisoshotel
	=============================================*/
	static public function mdlMostrarListaPermisosHoteles($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt -> execute();
		
		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}	
}
