<?php
require_once "conexion.php";

class ModeloTicket{

	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE Tickets 
	=============================================*/
	static public function mdlMostrarListaTickets($tabla){
		
		//DE LO CONTRARIO SI ID VIENE VACIO HAGO CONSULTA DE TODO LA TABLA
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}

	
	/*=============================================
	 FUNCION PARA CONSULTAR LA LISTA DE Tickets cuyo estado sea
	 Activo
	 =============================================*/
	static public function mdlMostrarListaTicketsActivos($tabla){
		
		//DE LO CONTRARIO SI ID VIENE VACIO HAGO CONSULTA DE TODO LA TABLA
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	OBTENGO EL DATO DEL TICKET, QUE RECIBO DESDE AJAX
	ESTO LO OCUPO PARA VERIFICAR QUE EL IDIOMA DEL 
	TICKET QUE SE ESTA CREANDO NO EXISTA EN LA TABLA
	DE TICKETS--campo idioma
	=============================================*/
	static public function mdlMostrarDatoTicket($tabla,$valorDeMiCampo){		
	
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE ticketTipo=:idioma");
		
		$stmt->bindParam(":idioma",$valorDeMiCampo, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	OBTENGO EL DATO DEL TICKET, QUE RECIBO DESDE AJAX
	ESTO LO OCUPO PARA cargar los datos en un modal 
	--porID
	=============================================*/
	static public function mdlMostrarDatoTicketById($tabla,$valorDeMiCampo){		
	
	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=:id");
		

		$stmt->bindParam(":id",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	PARA EL REGISTRO DE TICKETS
	=============================================*/
	static public function mdlRegistrarNuevoTicket($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (pie, encabezado, ticketTipo, estado) VALUES (:pie, :encabezado, :ticketTipo, :estado)");

		$stmt -> bindParam(":pie", $datos["pieDePagina"], PDO::PARAM_STR);
		$stmt -> bindParam(":encabezado", $datos["encabezado"], PDO::PARAM_STR);
		$stmt -> bindParam(":ticketTipo", $datos["idioma"], PDO::PARAM_STR);
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
PARA GUARDAR LOS DATOS AL EDITAR EL TICKET DENTRO DEL MODAL
=============================================*/
	static public function mdlEditarTicket($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET encabezado =:encabezado, pie=:pie WHERE id =:id");

		$stmt -> bindParam(":id", $datos["idTicket"], PDO::PARAM_INT);
		$stmt -> bindParam(":encabezado", $datos["encabezado"], PDO::PARAM_STR);
		$stmt -> bindParam(":pie", $datos["pie"], PDO::PARAM_STR);		

		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}

	/*=============================================
	 PARA ELIMINAR EL ticket DESDE EL sweetalert
	=============================================*/
	static public function mdlEliminarTicket($tabla, $datos){

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
	 PARA ACTUALIZAR EL ESTADO  DE UN TICKET 
	=============================================*/
	static public function mdlActualizarEstadoTicket($tabla, $campo, $valorCampo, $campo2, $valorCampo2){

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