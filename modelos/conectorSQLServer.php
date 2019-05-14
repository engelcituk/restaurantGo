<?php              
class ConexionSqlServer{

	public static function conectarSqlServer(){
		/*variables de sesion que traen los datos de conexion a ocupar de acuerdo al hotel seleccionado
		al iniciar sesión en el login*/		
		$iPservidor =$_SESSION["servidorSQLSRV"];
		$baseDeDatos=$_SESSION["bdSQLSRV"];
		$usuario=$_SESSION["usuarioSQLSRV"];
		$password=$_SESSION["passwordSQLSRV"];
		// $empresa=$_SESSION["empresaSQLSRV"];	
		// $hotel=$_SESSION["hotelSQLSRV"];
		
		try { 
			/*PUEDO SOLO DEJAR sqlsrv:Server=192.168.101.25,1433;Database=CARACOL sin especificar el puerto
			PUEDO SOLO DEJAR sqlsrv:Server=192.168.102.22,1433;Database=PLAYACAR*/			
			$conector = new PDO("sqlsrv:Server=".$iPservidor.",1433;Database=".$baseDeDatos."",
								$usuario,
							    $password);		

			$conector -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch (Exception $e){

			die(print_r($e->getMessage()));
		}
		return $conector;
	}

} 