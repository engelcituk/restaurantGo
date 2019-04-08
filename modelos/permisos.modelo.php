<?php
require_once "conexion.php";

class ModeloPermisos{

	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA de permisos 
	=============================================*/
	static public function mdlMostrarListaPermisos($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA de permisos acceso hotel
	=============================================*/
	static public function mdlMostrarPermisosTipoHotel($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");

		$stmt -> execute();
		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	OBTENGO EL DATO DE LA IMPRESORA POR ID, que recibo desde ajax
	=============================================*/
	static public function mdlObtenerDatoPermisoById($tabla,$valorDeMiCampo){		
	//consulto en base al id
	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=:idPermiso");
		
		$stmt->bindParam(":idPermiso",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	PARA EL REGISTRO DE PERMISOS
	=============================================*/
	static public function mdlRegistrarPermiso($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombrePermiso) VALUES (:nombrePermiso)");

		$stmt -> bindParam(":nombrePermiso", $datos["nombrePermiso"], PDO::PARAM_STR);
			
		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}

	/*=============================================
	 PARA ACTUALIZAR EL ESTADO  DE UN permiso
	=============================================*/
	static public function mdlCambiarEstadoPermiso($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 =:$item1 WHERE $item2 =:$item2");
		//ENLAZAMOS PARAMETROS
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	/*=============================================
	 PARA ELIMINAR LA IMPRESORA DESDE EL sweetalert
	=============================================*/
	static public function mdlEliminarPermiso($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	/*=============================================
	OBTENGO EL DATO DE UN permiso DE
	ACUERDO AL nombre RECIBIDO.. PETICIÓN AJAX
	=============================================*/
	static public function mdlTraerInfoPermiso($tabla,$valorDeMiCampo){		
	//consulto en base a la ip de la impresora
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE nombrePermiso=:nombrePermiso");
		
		$stmt->bindParam(":nombrePermiso",$valorDeMiCampo, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
PARA GUARDAR LOS DATOS AL EDITAR EL PERMISO DENTRO DEL MODAL
=============================================*/
	static public function mdlEditarPermiso($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombrePermiso =:nombrePermiso WHERE id =:id");

		$stmt -> bindParam(":id", $datos["idPermiso"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombrePermiso", $datos["nombrePermiso"], PDO::PARAM_STR);
		
		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
}
