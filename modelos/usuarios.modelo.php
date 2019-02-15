<?php

require_once "conexion.php";

class ModeloUsuarios{

	/*=============================================
	PARA EL INGRESO DEL USUARIOS
	=============================================*/

	static public function mdlIngresoUsuarios($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		//retornamos un fecht por ser solo un registro
		return $stmt -> fetch();

		$stmt-> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRAR USUARIOS
	=============================================*/

	static public function mdlRegistroUsuario($tabla, $datos){

		$connection = Conexion::conectar();

		$stmt = $connection->prepare("INSERT INTO $tabla (nombre, nombreDeUsuario, password, estado, nivel) VALUES (:nombre, :nombreDeUsuario, :password, :estado, :nivel)");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombreDeUsuario", $datos["nombreDeUsuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
		$stmt -> bindParam(":nivel", $datos["nivel"], PDO::PARAM_INT);

		if ($stmt->execute()) {

			$id =$connection->lastInsertId();
			
			return $id;
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}

	/*=============================================
	REGISTRAR USUARIOS Y SUS PERMISOS (acciones)
	=============================================*/
	static public function mdlRegistroUsuarioPermisos($tblUsPermisos, $datosPermisos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tblUsPermisos (idUsuario, idPermiso) VALUES (:idUsuario, :idPermiso)");

		$stmt -> bindParam(":idUsuario", $datosPermisos["idUsuario"], PDO::PARAM_INT);
		$stmt -> bindParam(":idPermiso", $datosPermisos["idPermisoValor"], PDO::PARAM_INT);
			
		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	/*=============================================
	REGISTRAR USUARIO Y SUS PERMISOS  (acceso hoteles)
	=============================================*/
	static public function mdlRegistroUserPermisosHotel($tblUsPermisosHotel, $datosPermisosHotel){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tblUsPermisosHotel (idUsuario, idPermisoHotel) VALUES (:idUsuario, :idPermisoHotel)");

		$stmt -> bindParam(":idUsuario", $datosPermisosHotel["idUsuarioHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":idPermisoHotel", $datosPermisosHotel["idPermisoHotelValor"], PDO::PARAM_INT);
			
		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE USUARIOS 
	=============================================*/
	static public function mdlMostrarListaUsuarios ($tabla, $item, $valor){
		//TABLA USUARIOS, ITEM=ID $VALOR=VALOR DE ID.. SI RECIBO LLAMADAS POR VALOR DE ID
		if($item != null){
			//si id no vienen vacio ejecuto esto (id=7 por ejemplo)
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{
			//DE LO CONTRARIO SI ID VIENE VACIO HAGO CONSULTA DE TODO LA TABLA
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;
}
/*=============================================
	FUNCION PARA EDITAR AL USUARIO DENTRO DEL MODAL
	=============================================*/
	static public function mdlEditarUsuario($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre =:nombre, nombreDeUsuario= :nombreDeUsuario, password =:password WHERE id =:id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombreDeUsuario", $datos["nombreDeUsuario"], PDO::PARAM_STR);		
		$stmt -> bindParam(":password", $datos["password"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	/*=============================================
	 PARA ELIMINAR EL USUARIO desde el sweetalert
	=============================================*/
	static public function mdlEliminarUsuario($tabla, $datos){

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
	 PARA ACTUALIZAR EL ESTADO  DEL USUARIO 
	=============================================*/
	static public function mdlActualizarEstadoUsuario($tabla, $item1, $valor1, $item2, $valor2){

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
}