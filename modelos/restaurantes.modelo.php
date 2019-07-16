<?php 
require_once "conexion.php";

class ModeloRestaurantes{

/*=============================================
	PARA EL REGISTRO DE RESTAURANTES
	=============================================*/
	static public function mdlRegistroRestaurante($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idHotel, nombre, especialidad, paxMaximoDia, horaCierre, estado) VALUES (:idHotel, :nombre, :especialidad, :paxMaximoDia, :horarioCierre, :estado)");

		$stmt -> bindParam(":idHotel", $datos["idHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":especialidad", $datos["especialidad"], PDO::PARAM_STR);		
		$stmt -> bindParam(":horarioCierre", $datos["horarioCierre"], PDO::PARAM_STR);
		$stmt -> bindParam( ":paxMaximoDia", $datos[ "paxMaximoDia"], PDO::PARAM_INT);
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

		$listaIdHotelesUsuario = new ControladorRestaurantes();
		$idHoteles = $listaIdHotelesUsuario->ctrListaUsuarioArrayIdHoteles();
		$arrayIdHoteles = $idHoteles;
		$borroUltimaComaArray = substr($arrayIdHoteles, 0, -1)."";
		$CadenaConsultaFinal = $borroUltimaComaArray . ")"; //resulta en un array así->  (2,3,4,5 )

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campoTabla = :$campoTabla");
			if($campoTabla != null){

				$stmt -> bindParam(":".$campoTabla, $valorCampoTabla, PDO::PARAM_INT);

				$stmt -> execute();

				return $stmt -> fetchAll();

			 } 
			 else
				{

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idHotel IN $CadenaConsultaFinal");

				$stmt -> execute();

				return $stmt -> fetchAll();

				$stmt -> close();

				$stmt = null;
		}
	}
	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE RESTAURANTES POR idHotel O TODA LA LISTA 
	=============================================*/
	static public function mdlMostrarRestsHotelTrabajo($tabla, $datos)
	{
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idHotel = :idHotel");

		$stmt->bindParam(":idHotel", $datos, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll();
		
		$stmt->close();

		$stmt = null;
		
	}
	static public function mdlEliminarRestaurantes2($tablaRestaurantes, $datos)
	{

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tablaRestaurantes WHERE idHotel = :idHotel");

		$stmt->bindParam(":idHotel", $datos, PDO::PARAM_INT);


		if ($stmt->execute()) {
			return "OK";
		} else {
			return "ERROR";
		}

		$stmt->close();

		$stmt = null;
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

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre =:nombre, especialidad= :especialidad, paxMaximoDia=:paxMaximoDia, horaCierre= :horarioCierre, estado =:estado WHERE id =:id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
		$stmt -> bindParam(":especialidad", $datos["especialidad"], PDO::PARAM_STR);
		$stmt -> bindParam(":horarioCierre", $datos[ "horarioCierreEdit"], PDO::PARAM_STR);
		$stmt -> bindParam(":paxMaximoDia", $datos[ "paxMaximoDiaEditar"], PDO::PARAM_INT);
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

	/*=============================================
	 FUNCION PARA CONSULTAR LA LISTA DE FECHAS DE CIERRE DEL RESTAURANTE
	 =============================================*/
	static public function mdlGetInfoCierreRestaurante($tabla, $idRestaurante){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idRestaurante=:idRestaurante");
		$stmt->bindParam(":idRestaurante", $idRestaurante, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;
	}
	/*=============================================
	 PARA ELIMINAR una fecha de cierre de un restaurante
	=============================================*/
	static public function mdlBorrarFechasCierre($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt->bindParam(":id", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		} else {
			return "ERROR";
		}

		$stmt->close();

		$stmt = null;
	}

	/*=============================================
	FUNCION PARA OBTENER FECHAS DE CIERRE DEL RESTAURANTE POR idRestaurante/FECHAS
	 =============================================*/
	static public function mdlValidarFechasCierreRestaurante($tabla, $idRestaurante, $fechaInicio, $fechaFin){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idRestaurante = :idRestaurante AND fechaInicio=:fechaInicio AND fechaFin=:fechaFin");

		$stmt->bindParam(":idRestaurante", $idRestaurante, PDO::PARAM_INT);
		$stmt->bindParam(":fechaInicio", $fechaInicio, PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $fechaFin, PDO::PARAM_STR);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt = null;
	}
	/*=============================================
PARA GUARDAR LOS DATOS AL EDITAR EL RESTAURANTE EN EL MODAL
=============================================*/
	static public function mdlGuardarFechasCierre($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idRestaurante, fechaInicio, fechaFin) VALUES (:idRestaurante, :fechaInicio, :fechaFin)");

		$stmt->bindParam(":idRestaurante", $datos["idRestaurante"], PDO::PARAM_INT);
		$stmt->bindParam(":fechaInicio", $datos["fechaInicio"], PDO::PARAM_STR);
		$stmt->bindParam(":fechaFin", $datos["fechaFin"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "OK";
		} else {
			return "ERROR";
		}

		$stmt->close();

		$stmt = null;
	}
}