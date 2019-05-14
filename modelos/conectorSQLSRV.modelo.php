<?php
require_once "conexion.php";

class ModeloConectorSQLSRV{

	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE USUARIOS 
	=============================================*/
	static public function mdlMostrarDatosConector ($tabla, $item, $valor){
		//TABLA USUARIOS, ITEM=ID $VALOR=VALOR DE ID.. SI RECIBO LLAMADAS POR VALOR DE ID
			//si id no vienen vacio ejecuto esto (id=7 por ejemplo)
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
		
		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_INT);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}

}

