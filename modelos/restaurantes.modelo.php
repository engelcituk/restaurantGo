<?php 
require_once "conexion.php";

class ModeloRestaurantes{

/*=============================================
	PARA EL REGISTRO DE RESTAURANTES
	=============================================*/
	static public function mdlRegistroRestaurante($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idHotel, nombre, especialidad, horaCierre, estado) VALUES (:idHotel, :nombre, :especialidad, :horarioCierre, :estado)");

		$stmt -> bindParam(":idHotel", $datos["idHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":especialidad", $datos["especialidad"], PDO::PARAM_STR);		
		$stmt -> bindParam(":horarioCierre", $datos["horarioCierre"], PDO::PARAM_STR);
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
 	FUNCION PARA CONSULTAR LA LISTA DE HOTELES 
=============================================*/
	static public function mdlMostrarListaHoteles($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}
 

	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE RESTAURANTES POR idHotel O TODA LA LISTA 
	=============================================*/
	static public function mdlMostrarListaRestaurantes($tabla, $campoTabla, $valorCampoTabla){


		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campoTabla = :$campoTabla");
			if($campoTabla != null){

				$stmt -> bindParam(":".$campoTabla, $valorCampoTabla, PDO::PARAM_INT);

				$stmt -> execute();

				return $stmt -> fetchAll();

			 } 
			 else
				{

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");

				$stmt -> execute();

				return $stmt -> fetchAll();

				$stmt -> close();

				$stmt = null;
		}
	}
	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE RESTAURANTES POR idHotel O TODA LA LISTA 
	=============================================*/
	static public function mdlMostrarListaRestaurantesActivos($tabla, $campoTabla, $valorCampoTabla)
	{
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campoTabla = :$campoTabla AND estado=1");
		if ($campoTabla != null) {

			$stmt->bindParam(":" . $campoTabla, $valorCampoTabla, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetchAll();
		} else {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ");

				$stmt->execute();

				return $stmt->fetchAll();

				$stmt->close();

				$stmt = null;
			}
	}
	
	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE RESTAURANTES POR idHotel O TODA LA LISTA 
	para generar el pdf 
	=============================================*/
	static public function mdlMostrarListaRestaurantesPdf($tabla,$campoTabla, $valorCampoTabla){


		if($campoTabla != null ){
			// echo "<script> console.log('entré aquí');</script>";
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campoTabla = :$campoTabla");

				$stmt -> bindParam(":".$campoTabla, $valorCampoTabla, PDO::PARAM_INT);

				$stmt -> execute();

				return $stmt -> fetchAll();

			 } 
			 elseif($campoTabla==null)
				{
				// echo "<script> console.log('entré aquí');</script>";
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

				$stmt -> execute();

				return $stmt -> fetchAll();

				$stmt -> close();

				$stmt = null;
		}
	}

	/*=============================================
	FUNCION PARA TRAER DATO DEL RESTAURANTE POR idRestaurante
	 =============================================*/
	static public function mdlMostrarRestauranteById($tabla,$campoTabla, $valorCampoTabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campoTabla = :$campoTabla");
			
		$stmt -> bindParam(":".$campoTabla, $valorCampoTabla, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();
			 
		$stmt = null;
		
	}

/*=============================================
PARA GUARDAR LOS DATOS AL EDITAR EL RESTAURANTE EN EL MODAL
=============================================*/
	static public function mdlEditarRestaurante($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre =:nombre, especialidad= :especialidad, horaCierre= :horarioCierreEdit, estado =:estado WHERE id =:id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":especialidad", $datos["especialidad"], PDO::PARAM_STR);
		$stmt -> bindParam( ":horarioCierreEdit", $datos[ "horarioCierreEdit"], PDO::PARAM_STR);
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
	 PARA ELIMINAR EL RESTAURANTE DESDE EL sweetalert
	=============================================*/
	static public function mdlEliminarRestaurante($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt->close();

		$stmt = null;
	}
	/*=============================================
	 PARA ELIMINAR TODOS LOS RESTAURANTES CUANDO SE BORRA UN HOTEL
	=============================================*/
	static public function mdlEliminarRestaurantes($tablaRestaurantes, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tablaRestaurantes WHERE idHotel = :idHotel");

		$stmt->bindParam(":idHotel", $datos, PDO::PARAM_INT);
	

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	/*=============================================
	 PARA ACTUALIZAR EL ESTADO  DEL RESTAURANTE 
	=============================================*/
	static public function mdlActualizarEstadoRestaurante($tabla, $campo, $valorCampo, $campo2, $valorCampo2){

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