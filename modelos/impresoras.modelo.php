<?php 
require_once "conexion.php";

class ModeloImpresoras{

	/*=============================================
	TRAIGO LISTA DE HOTELES
	=============================================*/
	static public function mdlTraerListaDeHoteles($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;			
	}

	/*=============================================
		TRAIGO LA LISTA DE IMPRESORAS DE Impresoras DISPONIBLES
		para mostar en una lista select
	=============================================*/
	static public function mdlListaDeImpresoras($tabla){
		$idHotel=$_SESSION["idHotel"];	
		//consulto las impresoras disponibles en tabla ticketimpresoras
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1 AND idHotel=$idHotel");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	TRAIGO LISTA DE impresoras para cargar en un datatable

	=============================================*/
	static public function mdlMostrarListaCompletaImpresoras($tabla,$campoTabla,$valorCampoTabla){
	
		$stmt = Conexion::conectar()->prepare("SELECT tabla2.nombre AS nombreHotel,tabla1.id AS idImpresora, tabla1.direccionIP AS ipImpresora,tabla1.nombreImpresora AS nombreImpresora, tabla1.estado AS estadoImpresora FROM ticketimpresoras as tabla1 INNER JOIN hoteles as tabla2 ON tabla1.idHotel=tabla2.id WHERE $campoTabla = :$campoTabla");
		//si traigo el id de un hotel ejecuto la consulta con el where con el id
			if($valorCampoTabla != null){

				$stmt -> bindParam(":".$campoTabla, $valorCampoTabla, PDO::PARAM_INT);
				$stmt -> execute();

				return $stmt -> fetchAll();
			 }else
				{
				//uso de joins para traer los datos
				$stmt = Conexion::conectar()->prepare( "SELECT tabla2.nombre AS nombreHotel,tabla1.id AS idImpresora, tabla1.direccionIP AS ipImpresora,tabla1.nombreImpresora AS nombreImpresora, tabla1.termica AS termica, tabla1.estado AS estadoImpresora FROM ticketimpresoras as tabla1 INNER JOIN hoteles as tabla2 ON tabla1.idHotel=tabla2.id");

				$stmt -> execute();

				return $stmt -> fetchAll();

				$stmt -> close();

				$stmt = null;
		}
	}
	/*=============================================
	 PARA ACTUALIZAR EL ESTADO  DE UNA impresora
	=============================================*/
	static public function mdlUpdateEstadoImpresora($tabla, $item1, $valor1, $item2, $valor2){

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
	static public function mdlEliminarImpresora($tabla, $datos){

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
	OBTENGO EL DATO DE UNA IMPRESORA DE
	ACUERDO AL IP RECIBIDO.. PETICIÓN AJAX
	=============================================*/
	static public function mdlTraerInfoImpresora($tabla,$valorDeMiCampo){		
	//consulto en base a la ip de la impresora
	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE direccionIP=:direccionIP");
		

		$stmt->bindParam(":direccionIP",$valorDeMiCampo, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	OBTENGO EL DATO DE LA IMPRESORA POR ID, que recibo desde ajax
	=============================================*/
	static public function mdlMostrarImpresorasHotelById($tabla,$valorDeMiCampo){		
	//consulto en base al id
	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idHotel=:idHotel");
		
		$stmt->bindParam(":idHotel",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	PARA EL REGISTRO DE IMPRESORAS
	=============================================*/
	static public function mdlRegistrarImpresora($tabla, $datos){

		$connection = Conexion::conectar();

		$stmt= $connection->prepare("INSERT INTO $tabla (idHotel, direccionIP, nombreImpresora, estado, termica) VALUES (:idHotel, :direccionIp, :nombreImpresora, :estado, :termica)");

		$stmt -> bindParam(":idHotel", $datos["idHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":direccionIp", $datos["direccionIp"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombreImpresora", $datos["nombreImpresora"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
		$stmt -> bindParam(":termica", $datos["termica"], PDO::PARAM_INT);
		
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
	OBTENGO EL DATO DE LA IMPRESORA POR ID, que recibo desde ajax
	=============================================*/
	static public function mdlObtenerDatoImpresoraById($tabla,$valorDeMiCampo){		
	//consulto en base al id
	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=:idImpresora");
		
		$stmt->bindParam(":idImpresora",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
/*=============================================
PARA GUARDAR LOS DATOS AL EDITAR LA IMPRESORA DENTRO DEL MODAL
=============================================*/
	static public function mdlEditarImpresora($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET direccionIP =:direccionIp, nombreImpresora= :nombreImpresora WHERE id =:idImpresora");

		$stmt -> bindParam(":idImpresora", $datos["idImpresora"], PDO::PARAM_INT);
		$stmt -> bindParam(":direccionIp", $datos["direccionIp"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombreImpresora", $datos["nombreImpresora"], PDO::PARAM_STR);				

		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
}