<?php
require_once "conexion.php";

class ModeloReservaEstancia{

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
	TRAIGO LISTA DE CONFIGURACIONES
	=============================================*/
	static public function ctrMostrarListaConfiguraciones($tabla,$campoTabla, $valorCampoTabla){
	
		$stmt = Conexion::conectar()->prepare("SELECT tabla2.nombre AS nombreHotel, tabla1.id AS idConfig, tabla1.nochesEstancia AS nocheEstancia, tabla1.numeroMaxDeReservas AS numMaxRsv, tabla1.estado AS state FROM reservasporestancia AS tabla1 INNER JOIN hoteles AS tabla2 ON tabla1.idHotel=tabla2.id WHERE $campoTabla = :$campoTabla");
		//si traigo el id de un hotel ejecuto la consulta con el where con el id
			if($valorCampoTabla != null){

				$stmt -> bindParam(":".$campoTabla, $valorCampoTabla, PDO::PARAM_INT);
				$stmt -> execute();

				return $stmt -> fetchAll();
			 }else
				{
				//uso de joins para traer los datos
				$stmt = Conexion::conectar()->prepare("SELECT tabla2.nombre AS nombreHotel, tabla1.id AS idConfig, tabla1.nochesEstancia AS nocheEstancia, tabla1.numeroMaxDeReservas AS numMaxRsv, tabla1.estado AS state FROM reservasporestancia AS tabla1 INNER JOIN hoteles AS tabla2 ON tabla1.idHotel=tabla2.id");

				$stmt -> execute();

				return $stmt -> fetchAll();

				$stmt -> close();

				$stmt = null;
		}
	}

	/*=============================================
	 PARA ACTUALIZAR EL ESTADO  DE UNA CONFIGURACION
	 RESERVAS POR NOCHES DE ESTANCIA 
	=============================================*/
	static public function mdlActualizarEstadoRsvsEstancia($tabla, $item1, $valor1, $item2, $valor2){

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
	OBTENGO EL DATO DE la configuracion de numero
	de reservas por noches de estancia, que recibo desde ajax (id)
	=============================================*/
	static public function mdlMostrarDatoNocheEstById($tabla,$valorDeMiCampo){		
	//consulto en base al id
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=:idRsvEstancia");
			
		$stmt->bindParam(":idRsvEstancia",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}
/*=============================================
PARA GUARDAR LOS DATOS AL EDITAR  la configuracion de numero
	de reservas por noches de estancia DENTRO DEL MODAL
=============================================*/
	static public function mdlEditarReservaEstancia($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET numeroMaxDeReservas =:numeroMaxDeReservas WHERE id =:id");

		$stmt -> bindParam(":id", $datos["idRsvEstancia"], PDO::PARAM_INT);
		$stmt -> bindParam(":numeroMaxDeReservas", $datos["numMaxReservas"], PDO::PARAM_INT);
			
		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}

	/*=============================================
	OBTENGO EL DATO DE reservasporestancia, QUE RECIBO DESDE AJAX
	ESTO LO OCUPO PARA VERIFICAR QUE la el numero de noches de
	estanca no se repita EN LA TABLA reservasporestancia	
	=============================================*/
	static public function mdlMostrarDatoNocheEstancia($tabla,$valorDeMiCampo,$valorDeMiCampo2){		
	
	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idHotel=:idHotel AND nochesEstancia=:nochesEstancia");
		
		$stmt->bindParam(":idHotel",$valorDeMiCampo, PDO::PARAM_INT);
		$stmt->bindParam(":nochesEstancia",$valorDeMiCampo2, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	PARA EL REGISTRO DE configuraciones
	de  reservasporestancia
	=============================================*/
	static public function mdlRegConfiguracionEstancia($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idHotel, nochesEstancia, numeroMaxDeReservas, estado) VALUES (:idHotel, :nochesEstancia, :numeroMaxDeReservas, :estado)");

		$stmt -> bindParam(":idHotel", $datos["idHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":nochesEstancia", $datos["nochesEstancia"], PDO::PARAM_INT);
		$stmt -> bindParam(":numeroMaxDeReservas", $datos["numeroMaxDeReservas"], PDO::PARAM_INT);
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
	 PARA ELIMINAR UNA CONFIGURACION DE RESERVAS
	POR NOCHE DE ESTANCIA DESDE EL sweetalert
	=============================================*/
	static public function mdlBorrarConfiguracionEstancia($tabla, $datos){

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
	  PARA ELIMINAR TODAS LAS CONFIGURACIONES DE RESERVAS
	POR NOCHE DE ESTANCIA AL BORRAR UN HOTEL
	=============================================*/
	static public function mdlBorrarConfiguracionEstanciaTodos($tablaRSVPorEstancia, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tablaRSVPorEstancia WHERE idHotel = :idHotel");

		$stmt->bindParam(":idHotel", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}

}
