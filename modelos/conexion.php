<?php

class Conexion{

	public static function conectar(){

		$iPservidor = "172.16.1.47";
		$baseDeDatos="RestaurantGo";		
		$usuario="sa";
		$password="P1nch3C0ch1pu3rc0";
		
		try {
			/*PUEDO SOLO DEJAR 
			sqlsrv:Server=192.168.101.25,1433;Database=CARACOL sin especificar el puerto
			PUEDO SOLO DEJAR 
			sqlsrv:Server=192.168.102.22,1433;Database=PLAYACAR*/			
			$conector = new PDO("sqlsrv:Server=".$iPservidor.",1433;Database=".$baseDeDatos,
								$usuario,
							    $password);		

			$conector -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e){

			die(print_r($e->getMessage()));
		}
		return $conector;
	}

	}

