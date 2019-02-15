<?php 
require_once "conectorSQLServer.php";

class ModeloHuesped{
	/*=============================================
	CONSULTA A LA TABLA ReservasReservix de SQLServer
	=============================================*/
	static public function mdlMostrarListasHuesped($tabla, $item, $valor){
		//$tabla ReservasReservix, $item=Habitacion $valor=numero de Habitacion.. si recibo busquedas por habitacion
		if($item != null){
			//si id no vienen vacio ejecuto esto (id=7 por ejemplo)
			$stmt = ConexionSqlServer::conectarSqlServer()->prepare("SELECT * FROM $tabla WHERE $item = :$item AND Estado=1");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetch();

		}else{
			//de lo contrario si id viene vacio hago consulta de todo la tabla
			$stmt = ConexionSqlServer::conectarSqlServer()->prepare("SELECT * FROM $tabla WHERE Estado=1");
			$stmt -> execute();
			return $stmt -> fetchAll(PDO::FETCH_BOTH);

		}

		$stmt -> close();
		$stmt = null;
	}
}