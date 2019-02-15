<?php
require_once "conexion.php";

class ModeloSeatings{

/*=============================================
	TRAIGO LISTA DE HOTELES
	=============================================*/
	static public function mdlTraerListaDeHoteles($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;			
	}
	/*=============================================
	OBTENGO EL DATO DEl SEATING POR ID, que recibo desde ajax
	=============================================*/
	static public function mdlObtenerDatoSeating($tabla,$valorDeMiCampo){		
	//consulto en base al id
	$stmt = Conexion::conectar()->prepare("SELECT seatings.id AS idSeating, seatings.estado AS estadoSeating, hoteles.nombre AS nomHotel,restaurantes.nombre AS nomRestaurante,diassemana.dia AS diaSemana, seatings.horaSeating AS hora,seatings.paxMaximo AS pm,seatings.reservasMaximas AS rm FROM $tabla  INNER JOIN diassemana ON seatings.idDiaSemana=diassemana.id INNER JOIN restaurantes ON seatings.idRestaurante=restaurantes.id INNER JOIN hoteles ON seatings.idHotel=hoteles.id WHERE seatings.id=:idSeating");
		

		$stmt->bindParam(":idSeating",$valorDeMiCampo, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	TRAIGO LISTA DE SEATINGS
	=============================================*/
	static public function mdlMostrarListaSeatings($tabla,$campoTabla, $valorCampoTabla){
	
		$stmt = Conexion::conectar()->prepare("SELECT seatings.id AS idSeating, seatings.estado AS estadoSeating, hoteles.nombre AS nomHotel,restaurantes.nombre AS nomRestaurante,diassemana.dia AS diaSemana, seatings.horaSeating AS hora,seatings.paxMaximo AS pm,seatings.reservasMaximas AS rm FROM $tabla  INNER JOIN diassemana ON seatings.idDiaSemana=diassemana.id INNER JOIN restaurantes ON seatings.idRestaurante=restaurantes.id INNER JOIN hoteles ON seatings.idHotel=hoteles.id WHERE $campoTabla = :$campoTabla");

			//si traigo el id de un restaurante ejecuto la consulta con el where con el id
			if($valorCampoTabla != null){

				$stmt -> bindParam(":".$campoTabla, $valorCampoTabla, PDO::PARAM_INT);
				$stmt -> execute();

				return $stmt -> fetchAll();
			 }else
				{
				//uso de joins para traer los datos
				$stmt = Conexion::conectar()->prepare("SELECT seatings.id AS idSeating, seatings.estado AS estadoSeating, hoteles.nombre AS nomHotel,restaurantes.nombre AS nomRestaurante,diassemana.dia AS diaSemana, seatings.horaSeating AS hora,seatings.paxMaximo AS pm,seatings.reservasMaximas AS rm FROM $tabla  INNER JOIN diassemana ON seatings.idDiaSemana=diassemana.id INNER JOIN restaurantes ON seatings.idRestaurante=restaurantes.id INNER JOIN hoteles ON seatings.idHotel=hoteles.id");

				$stmt -> execute();

				return $stmt -> fetchAll();

				$stmt -> close();

				$stmt = null;
		}
	}

	/*=============================================
	 PARA ACTUALIZAR EL ESTADO  DE UN SEATING
	=============================================*/
	static public function mdlActualizarEstadoSeating($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 =:$item1 WHERE $item2 =:$item2");
		//ENLAZAMOS PARAMETROS
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;

	}
/*=============================================
FUNCION PARA GUARDA LOS DATOS AL
EDITAR EL SEATING EN EL MODAL
=============================================*/
	static public function mdlEditarSeating($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET paxMaximo =:paxMaximo, reservasMaximas= :reservasMaximas WHERE id =:id");

		$stmt -> bindParam(":id", $datos["idSeating"], PDO::PARAM_INT);
		$stmt -> bindParam(":paxMaximo", $datos["paxMaximo"], PDO::PARAM_INT);		
		$stmt -> bindParam(":reservasMaximas", $datos["reservasMaximas"], PDO::PARAM_INT);		

		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}

	/*=============================================
	FUNCION PARA TRAER LA LISTA DE HORARIOS Y DESPLEGARLOS
	EN EL MODAL
	=============================================*/
	static public function mdlTraerCatalogoHorario($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	TRAIGO LOS SEATINGS DE ACUERDO A LOS PARAMETROS QUE RECIBO
	EL ID DEL HOTEL, ID DEL RESTAURANTE, LA HORA
	peticion desde ajax
	=============================================*/
	static public function mdlTraerListaSeatings($tabla,$valorDeMiCampo, $valorDeMiCampo2,$valorDeMiCampo3){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idHotel=:idHotel AND idRestaurante=:idRestaurante AND horaSeating=:horaSeating");
		//campoDemitabla es idDiaSemana	

		$stmt->bindParam(":idHotel",$valorDeMiCampo, PDO::PARAM_INT);
		$stmt->bindParam(":idRestaurante",$valorDeMiCampo2, PDO::PARAM_INT);
		$stmt->bindParam(":horaSeating",$valorDeMiCampo3, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	PARA EL REGISTRO DE HOTELES
	=============================================*/
	static public function mdlRegistrarNuevoSeating($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idHotel, idRestaurante, idDiaSemana, horaSeating, paxMaximo, reservasMaximas, estado) VALUES (:idHotel, :idRestaurante, :idDiaSemana, :horaSeating, :paxMaximo, :reservasMaximas, :estado)");

		$stmt -> bindParam(":idHotel", $datos["idHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":idRestaurante", $datos["idRestaurante"], PDO::PARAM_INT);
		$stmt -> bindParam(":idDiaSemana", $datos["idDiaSemana"], PDO::PARAM_INT);
		$stmt -> bindParam(":horaSeating", $datos["horaSeating"], PDO::PARAM_STR);
		$stmt -> bindParam(":paxMaximo", $datos["pm"], PDO::PARAM_INT);
		$stmt -> bindParam(":reservasMaximas", $datos["rm"], PDO::PARAM_INT);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);

		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
}