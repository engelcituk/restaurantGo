<?php
require_once "conexion.php";

class ModeloPermisosHotel{

	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA de permisos de permisoshotel
	=============================================*/
	static public function mdlMostrarListaPermisosHoteles($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");

		$stmt -> execute();
		
		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	PARA GUARDAR LOS DATOS DEL HOTEL EDITADO
	DENTRO DEL MODAL
	=============================================*/
	static public function mdlEditarHotelPermisos($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombrePermisoHotel =:nombrePermisoHotel, estado=:estado WHERE idHotel =:idHotel");

		$stmt -> bindParam(":idHotel", $datos["idHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombrePermisoHotel", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);			

		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	/*=============================================
	 PARA ACTUALIZAR EL ESTADO  DEL PERMISO HOTEL 
	=============================================*/
	static public function mdlActualizarEstadoHotelPermiso($tablaPermisos, $campoPermisos, $valorCampoPermisos, $campo2, $valorCampo2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tablaPermisos SET $campo2 =:$campo2 WHERE $campoPermisos =:$campoPermisos");
		//ENLAZAMOS PARAMETROS
		$stmt -> bindParam(":".$campoPermisos, $valorCampoPermisos, PDO::PARAM_INT); //estado
		$stmt -> bindParam(":".$campo2, $valorCampo2, PDO::PARAM_INT);//EL id del hotel

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;

	}	 
	/*=============================================
	 PARA ELIMINAR EL permiso de acceso al hotel DESDE
	  EL sweetalert de eliminar hotel
	=============================================*/
	static public function mdlEliminarHotelPermiso($tablaPermisos,$datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tablaPermisos WHERE idHotel = :idHotel");
		
		$stmt -> bindParam(":idHotel", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
}
