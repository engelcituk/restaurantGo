<?php
require_once "conectorSQLServer.php";

class ModeloHuesped{
	/*=============================================
	CONSULTA A LA TABLA ReservasReservix de SQLServer
	=============================================*/
	static public function mdlMostrarListasHuesped($tabla, $valorCampo, $ocupantes, $hotel){		
		//valorCampo=Habitacion .. si recibo busquedas por habitacion
		if($valorCampo != null){			
			$stmt = ConexionSqlServer::conectarSqlServer()->prepare("
			SELECT  
				Rvas.Reserva,
				Rvas.Noches,
				COUNT(ocup.Reserva) AS Ocupantes,
				Rvas.Habitacion,
				Rvas.Apellido,
				Rvas.Estado,
				Rvas.FechaEntrada,
				Rvas.FechaSalida,
				Rvas.Hotel
			FROM $tabla 
				 	AS Rvas INNER JOIN
				 $ocupantes 
					AS ocup 
					ON Rvas.Reserva = ocup.Reserva
			WHERE Rvas.Estado in (1) AND Habitacion=:habitacion AND Rvas.Hotel=:hotel
			GROUP BY 
				Rvas.Reserva,
				Rvas.Noches,
				Rvas.Habitacion,
				Rvas.Estado,
				Rvas.FechaEntrada,
				Rvas.FechaSalida,
				Rvas.Apellido,
				Rvas.Hotel
		");
			
			$stmt->bindParam(":habitacion", $valorCampo, PDO::PARAM_STR);
			$stmt->bindParam(":hotel", $hotel, PDO::PARAM_STR);
			
			$stmt -> execute();
			return $stmt -> fetch();

		}else{
			//de lo contrario si id viene vacio hago consulta de todo la tabla
			$stmt = ConexionSqlServer::conectarSqlServer()->prepare("
				SELECT  
					Rvas.Reserva, 
					Rvas.Noches, 
					COUNT(ocup.Reserva) AS Ocupantes,
					Rvas.Habitacion, 
					Rvas.Apellido,
					Rvas.Estado, 
					Rvas.FechaEntrada, 
					Rvas.FechaSalida, 
					Rvas.Hotel
				FROM   $tabla 
							AS Rvas INNER JOIN  
						$ocupantes 
							AS ocup 
						ON Rvas.Reserva = ocup.Reserva
				WHERE Rvas.Estado in (1) AND Rvas.Hotel=:hotel
				GROUP BY 
					Rvas.Reserva,
					Rvas.Noches, 
					Rvas.Habitacion,
					Rvas.Estado, 
					Rvas.FechaEntrada, 
					Rvas.FechaSalida,
					Rvas.Apellido,
					Rvas.Hotel
		");
			$stmt->bindParam(":hotel", $hotel, PDO::PARAM_STR);
			$stmt -> execute();
			return $stmt -> fetchAll(PDO::FETCH_BOTH);

		}
		
		$stmt -> close(); 
		$stmt = null;
	}
}
