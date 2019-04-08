<?php
require_once "conexion.php";

class ModeloEstadisticas{

    /*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE RESTAURANTES 
	=============================================*/
	static public function mdlMostrarListaRestaurantes($tabla, $item, $valor){
		//TABLA USUARIOS, ITEM=ID $VALOR=VALOR DE ID.. SI RECIBO LLAMADAS POR VALOR DE ID
		if($item != null){
			//si id no vienen vacio ejecuto esto (id=7 por ejemplo)
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

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
	PARA CONTAR LOS PAX ACUMULADOS Y CANITIDAD DE RESERVAS 
	=============================================*/
	static public function mdlContarPaxAcumulados($tabla,$valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as totalReservas, SUM(pax) as sumaPax FROM $tabla WHERE idHotel=:idHotel AND idRestaurante=:idRestaurante AND fechaDeLaReserva=:fechaHoy AND estado=1");

		$stmt->bindParam(":idHotel",$valorDeMiCampo, PDO::PARAM_INT);
		$stmt->bindParam(":idRestaurante",$valorDeMiCampo2, PDO::PARAM_INT);		
		$stmt->bindParam(":fechaHoy",$valorDeMiCampo3, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	CONTAR PAX TOPES DEL DÍA DE ACUERDO AL RESTAURANTE
	Y EL DIA, HOTEL
	=============================================*/
	static public function mdlCapacidadMaximaPaxDia($tabla,$valorDeMiCampoPax,$valorDeMiCampoPax2,$valorDeMiCampoPax3){

		$stmt = Conexion::conectar()->prepare("SELECT SUM(paxMaximo) AS sumaPax, SUM(reservasMaximas) AS totalReservas FROM $tabla WHERE idHotel=:idHotel AND idRestaurante=:idRestaurante AND idDiaSemana=:idDiaSemana AND estado=1");
		
		$stmt->bindParam(":idHotel",$valorDeMiCampoPax, PDO::PARAM_INT);
		$stmt->bindParam(":idRestaurante",$valorDeMiCampoPax2, PDO::PARAM_INT);		
		$stmt->bindParam(":idDiaSemana",$valorDeMiCampoPax3, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}
	
	/*=============================================
	TRAER TODOS LOS SEATINGS DEL DIA DADO DE ACUERDO AL
	IDHOTEL, IDRESTAURANTE, IDDIAsemana
	=============================================*/
	static public function mdlMostrarSeatingDelDia($tabla,$valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3){
 
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idHotel=:idHotel AND idRestaurante=:idRestaurante AND idDiaSemana=:idDiaSemana AND estado=1");
		
		$stmt->bindParam(":idHotel",$valorDeMiCampo, PDO::PARAM_INT);
		$stmt->bindParam(":idRestaurante",$valorDeMiCampo2, PDO::PARAM_INT);		
		$stmt->bindParam(":idDiaSemana",$valorDeMiCampo3, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	PARA CONTAR LOS PAX ACUMULADOS Y CANITIDAD DE RESERVAS 
	=============================================*/
	static public function mdlTraerPaxAcumuladoHora($tabla,$idHotel2,$idRestaurante2,$fechaHoy,$horaSeating){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as totalReservas, SUM(pax) as sumaPax FROM $tabla WHERE idHotel=:idHotel AND idRestaurante=:idRestaurante AND fechaDeLaReserva=:fechaHoy AND hora=:horaFecha AND estado=1");

		$stmt->bindParam(":idHotel",$idHotel2, PDO::PARAM_INT);
		$stmt->bindParam(":idRestaurante",$idRestaurante2, PDO::PARAM_INT);		
		$stmt->bindParam(":fechaHoy",$fechaHoy, PDO::PARAM_STR);
		$stmt->bindParam(":horaFecha",$horaSeating, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}
	
} 
