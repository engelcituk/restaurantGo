<?php

require_once "conexion.php";

class ModeloHoteles{

	/*=============================================
	PARA EL REGISTRO DE HOTELES
	=============================================*/
	static public function mdlRegistroHotel($tabla, $datos){

		$connection = Conexion::conectar();

		$stmt = $connection->prepare("INSERT INTO $tabla (nombre, descripcion, estado) VALUES (:nombre, :descripcion, :estado)");

		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
	
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
	SE GENERAN LOS PERMISOS CADA QUE SE CREA UN NUEVO
	HOTEL
	=============================================*/
	static public function mdlRegistroPermisosHotel($tblHotelPermisos, $datosPermisosHotel){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tblHotelPermisos (idHotel, nombrePermisoHotel) VALUES (:idHotel, :permisohotel)");

		$stmt -> bindParam(":idHotel", $datosPermisosHotel["idHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":permisohotel", $datosPermisosHotel["permisohotel"], PDO::PARAM_STR);
	
		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}

	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE HOTELES 
	=============================================*/
	static public function mdlMostrarListaHoteles($tabla, $item, $valor){
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
	FUNCION PARA CONSULTAR LA LISTA DE HOTELES 
	=============================================*/
	static public function mdlObtenerDatoHotelById($tablaHotel,$item2,$valorId){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tablaHotel WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item2, $valorId, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	OBTENGO EL DATO DEl hotel que recibo desde ajax (nombre)
	=============================================*/
	static public function mdlMostrarDatoHotelById($tabla,$valorDeMiCampo){		
	//consulto en base al id
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=:idHotel");
			
		$stmt->bindParam(":idHotel", $valorDeMiCampo, PDO::PARAM_STR);
	

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}
/*=============================================
PARA GUARDAR LOS DATOS AL EDITAR EL HOTEL DENTRO DEL MODAL
=============================================*/
	static public function mdlEditarHotel($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre =:nombre, descripcion= :descripcion, estado =:estado WHERE id =:id");

		$stmt -> bindParam(":id", $datos["idHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":descripcion", $datos["descripcion"], PDO::PARAM_STR);
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
	 PARA ELIMINAR EL HOTEL DESDE EL sweetalert
	=============================================*/
	static public function mdlEliminarHotel($tabla, $datos){

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
	 PARA ACTUALIZAR EL ESTADO  DEL HOTEL 
	=============================================*/
	static public function mdlActualizarEstadoHotel($tabla, $campo, $valorCampo, $campo2, $valorCampo2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $campo2 =:$campo2 WHERE $campo =:$campo");
		//ENLAZAMOS PARAMETROS
		$stmt -> bindParam(":".$campo, $valorCampo, PDO::PARAM_INT); //estado
		$stmt -> bindParam(":".$campo2, $valorCampo2, PDO::PARAM_INT);//EL id del hotel

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;

	}
		
}