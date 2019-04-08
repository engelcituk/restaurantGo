<?php 
require_once "conexion.php";

class ReporteReservas {
	/*=============================================
 	FUNCION PARA CONSULTAR LA LISTA DE HOTELES 
    ==========================================*/
	static public function mdlMostrarListaHoteles($tabla){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado=1");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE reservas POR idRestaurante-Fecha O TODA LA LISTA 
	con este genero los datos para el pdf y cargado de datos en el
	=============================================*/
	static public function mdlListaReporteReservas($tabla, $valorCampoTabla,$valorCampoTabla2,$valorCampoTabla3){
	
		date_default_timezone_set('UTC');
		$hoy = date("Y-m-d");		
		
			if($valorCampoTabla != 0){
				
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idRestaurante = :idRestaurante AND fechaDeLaReserva BETWEEN :fechaInicio AND :fechaFinal");
				$stmt->bindParam(":idRestaurante",$valorCampoTabla, PDO::PARAM_INT);
				$stmt->bindParam(":fechaInicio",$valorCampoTabla2, PDO::PARAM_STR);
				$stmt->bindParam(":fechaFinal",$valorCampoTabla3, PDO::PARAM_STR);
				$stmt -> execute();

				return $stmt -> fetchAll();
			}elseif ($valorCampoTabla == 0 && isset($valorCampoTabla2) && isset($valorCampoTabla3)){
				
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fechaDeLaReserva BETWEEN :fechaInicio AND :fechaFinal");

				$stmt->bindParam(":fechaInicio",$valorCampoTabla2, PDO::PARAM_STR);
				$stmt->bindParam(":fechaFinal",$valorCampoTabla3, PDO::PARAM_STR);				
				$stmt -> execute();
				return $stmt -> fetchAll();
				
			}else {				
				 /*ocupo la sesion del id del hotel */
				$idHotel = $_SESSION["idHotel"];
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fechaDeLaReserva>='$hoy' AND idhotel=$idHotel");

				$stmt -> execute();
				return $stmt -> fetchAll();
				$stmt -> close();
				$stmt = null;
		}
	}
 
	/*=============================================
	PARA LA CONSULTA QUE GENERA EL ARCHIVO EXCEL DE
	 LISTA DE RESERVAS DE EQUIS RESTAURANTE
	=============================================*/
	static public function mdlDescargarReporteExcel($tabla,$valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3){
		date_default_timezone_set('UTC');
		$hoy = date("Y-m-d");

		if($valorDeMiCampo != 0){
				
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idRestaurante = :idRestaurante AND fechaDeLaReserva BETWEEN :fechaInicio AND :fechaFinal");
			$stmt->bindParam(":idRestaurante",$valorDeMiCampo, PDO::PARAM_INT);
			$stmt->bindParam(":fechaInicio",$valorDeMiCampo2, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFinal",$valorDeMiCampo3, PDO::PARAM_STR);
			$stmt -> execute();
		
			return $stmt -> fetchAll();
		}elseif ($valorDeMiCampo == 0 && isset($valorDeMiCampo2) && isset($valorDeMiCampo3)){
			
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fechaDeLaReserva BETWEEN :fechaInicio AND :fechaFinal");
		
			$stmt->bindParam(":fechaInicio",$valorDeMiCampo2, PDO::PARAM_STR);
			$stmt->bindParam(":fechaFinal",$valorDeMiCampo3, PDO::PARAM_STR);				
			$stmt -> execute();
			return $stmt -> fetchAll();
			
		}else {				
			 /*ocupo la sesion del id del hotel */
			$idHotel = $_SESSION["idHotel"];
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fechaDeLaReserva>='$hoy' AND idhotel=$idHotel");
		
			$stmt -> execute();
			return $stmt -> fetchAll();
			$stmt -> close();
			$stmt = null;
		}
		
	}
}

