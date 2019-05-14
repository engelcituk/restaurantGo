<?php
require_once "conexion.php";

class ModeloUsuarioPermisos{


	/*=============================================
	OBTENGO los permisos del usuario, que recibo desde ajax (id)
	permisos de tipo acciones
	=============================================*/
	static public function mdlMostrarUserPermisos($tabla,$valorDeMiCampo){		
	//consulto en base al id
		$stmt = Conexion::conectar()->prepare("SELECT t0.id, t0.nombrePermiso, t1.idPermiso, t1.idUsuario FROM $tabla t0 LEFT JOIN usuario_permisos t1 ON t0.id=t1.idPermiso AND t1.idUsuario=:idUsuario");
			
		$stmt->bindParam(":idUsuario",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	OBTENGO los permisos del usuario, que recibo desde POST (idUsuario)	
	=============================================*/
	static public function mdlTraerPermisosUsuario($tablaUsrPermisos,$valorDeMiCampo){		
	//consulto en base al id
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tablaUsrPermisos WHERE idUsuario=:idUsuario");
			
		$stmt->bindParam(":idUsuario",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	OBTENGO los permisos del usuario, que solicito desde ajax (id)
	permisos de acceso a hoteles
	=============================================*/
	static public function mdlMostrarUserPermisosHotel($tabla,$valorDeMiCampo){		
	//consulto en base al id recibido
		$stmt = Conexion::conectar()->prepare("SELECT t0.idHotel, t0.nombrePermisoHotel, t1.idPermisoHotel, t1.idUsuario FROM $tabla t0 LEFT JOIN usuario_permisos_hotel t1 ON t0.idHotel=t1.idPermisoHotel AND t1.idUsuario=:idUsuario");
			
		$stmt->bindParam(":idUsuario",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	OBTENGO los permisos del usuario, que solicito desde ajax (id)
	permisos de acceso a hoteles
	=============================================*/
	static public function mdlVerificarUserAccesoHotel($tabla, $valorDeMiCampo,$valorDeMiCampo2){		
	//consulto en base al id recibido
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idUsuario=:idUsuarioLS AND idPermisoHotel=:idHotelLS");

		$stmt->bindParam(":idUsuarioLS",$valorDeMiCampo2, PDO::PARAM_INT);
		$stmt->bindParam(":idHotelLS",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	 PARA ELIMINAR LOS PERMISOS DEL USUARIO
	=============================================*/
	static public function mdlBorrarPermisosUsuario($tblPermisos, $idBorrarUser){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tblPermisos WHERE idUsuario = :idUsuario");

		$stmt -> bindParam(":idUsuario", $idBorrarUser, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}

	/*=============================================
	 PARA ELIMINAR LOS PERMISOS DEL USUARIO
	=============================================*/
	static public function mdlBorrarPermisosUsuarioHotel($tblPermisosHotel, $idBorrarUser){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tblPermisosHotel WHERE idUsuario = :idUsuario");

		$stmt -> bindParam(":idUsuario", $idBorrarUser, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}

}