<?php 
require_once "conexion.php";

class ModeloReservas{
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
	TRAIGO LOS DATOS DEL RESTAURANTE
	=============================================*/
	static public function mdlMostrarDatosRestaurante($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=1");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;			
	}

/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE FECHAS 
	=============================================*/
	static public function mdlMostrarFechas($tabla){
		date_default_timezone_set('UTC');
		$hoy = date("Y-m-d");
		//TRAIGO TODAS LA FECHAS MAYORES A HOY ORDENADOS DE MENOR A MAYOR
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idRestaurante=1 AND fechaReserva >='$hoy' ORDER BY fechaReserva");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();
 
		$stmt = null;
	}
/*=============================================
	CUENTO EL TOTAL DE FECHAS PARA HACER RESERVAS 
	=============================================*/
	static public function mdlContadorDeFechasDisponibles($tabla){
		
		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) FROM $tabla WHERE idRestaurante = 1");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	FUNCION PARA CONSULTAR LA LISTA DE MESAS 
	=============================================*/
	static public function mdlMostrarMesas($tabla){
		
		//traigo todas la fechas mayores a hoy ordenados de menor a mayor
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idRestaurante=1");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	REGISTRAR RESERVAS
	=============================================*/

	static public function mdlRegistrarReserva($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(fechaDeLaReserva,reservaIdentificador,idHotel,idRestaurante,nombreRestaurante,apellido,hora,estado,usuario,habitacion,pax,ticket,fechaLimite,observaciones,origen) VALUES (:fechaReserva,:reservaIdentificador,:idHotel,:idRestaurante,:nombreRestaurante,:apellido,:hora,:estado,:usuario,:habitacion,:pax,:ticket, :fechaLimiteRSV,:observaciones,:origen)");

		$stmt -> bindParam(":fechaReserva", $datos["fechaReserva"], PDO::PARAM_STR);
		$stmt -> bindParam(":reservaIdentificador", $datos["reservaIdentificador"], PDO::PARAM_STR);
		$stmt -> bindParam(":idHotel", $datos["idHotel"], PDO::PARAM_INT);
		$stmt -> bindParam(":idRestaurante", $datos["idRestaurante"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombreRestaurante", $datos["nombreRestaurante"], PDO::PARAM_STR);
		$stmt -> bindParam(":apellido", $datos["apellido"], PDO::PARAM_STR);
		$stmt -> bindParam(":hora", $datos["horario"], PDO::PARAM_STR);
		$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":habitacion", $datos["habitacion"], PDO::PARAM_STR);
		$stmt -> bindParam(":pax", $datos["pax"], PDO::PARAM_INT);
		$stmt -> bindParam(":ticket", $datos["ticket"], PDO::PARAM_STR);
		$stmt -> bindParam(":fechaLimiteRSV", $datos["fechaLimiteRSV"], PDO::PARAM_STR);
		$stmt -> bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);
		$stmt -> bindParam(":origen", $datos["origen"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	

	/*=============================================
	TRAIGO LA LISTA DE RESERVAS DEL HOTEL Tiene que ser de cualquier hotel--Corregir esto
	=============================================*/
	static public function mdlListaDeReservasHotel($tabla){
		date_default_timezone_set('UTC');
		$hoy = date("Y-m-d");		
		//consulto las reservas en tabla reservas donde sea mayor o igual a la fecha de hoy
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fechaDeLaReserva>='$hoy'");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	OBTENGO EL DATO DE LA RESERVA POR ID
	=============================================*/
	static public function mdlObtenerDatoReserva($tabla, $item, $valor){
				
		//consulto en base al id
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item=:$item");

		$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;

	}
	/*=============================================
	TRAIGO LISTA DE RESTAURANTES DE ACUERDO AL ID idHotel QUE ctrObtnerListaDeRestaurantes
	ENVÍA
	=============================================*/
	static public function mdlObtnerListaDeRestaurantes($tabla,$campoDemiTabla, $valorDeMiCampo){

		//CONSULTO CON BASE AL NUMERO QUE RECIBO, RESTAURANTE 1 ES EL RIVIERA
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campoDemiTabla=:$campoDemiTabla AND estado=1");
		//campoDemitabla es idDiaSemana

		$stmt->bindParam(":".$campoDemiTabla, $valorDeMiCampo, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	TRAIGO LOS SEATING DEL DIA DADO, QUE   ESTA SOLICITANDO
	EN ESTA CASO ESTOY TRAYENDO TODO SOBRE ESTOS HORARIOS
	=============================================*/
	static public function mdlTraerSeatingDelDiaDado($tabla,$valorDeMiCampo, $valorDeMiCampo2,$valorDeMiCampo3){

		//CONSULTO CON BASE AL los Id que recibo, hotel, restaurante, dia
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idHotel=:idHotel AND idRestaurante=:idRestaurante AND idDiaSemana=:idDiaSemana AND estado=1");
				
		$stmt->bindParam(":idDiaSemana",$valorDeMiCampo, PDO::PARAM_INT);
		$stmt->bindParam(":idHotel",$valorDeMiCampo2, PDO::PARAM_INT);
		$stmt->bindParam(":idRestaurante",$valorDeMiCampo3, PDO::PARAM_INT);

		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;
	}
	/*=============================================
	TRAIGO LOS SEATING DEL DIA DADO, QUE  ESTA SOLICITANDO
	EN ESTA CASO ESTOY TRAYENDO TODO SOBRE ESTOS HORARIOS
	=============================================*/
	static public function mdlTraerSeatingDelDiaDadoTodos($tabla,$valorDeMiCampo, $valorDeMiCampo2){

		//CONSULTO CON BASE AL los Id que recibo, hotel, restaurante, dia
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idHotel=:idHotel AND idDiaSemana=:idDiaSemana AND estado=1");

		$stmt->bindParam(":idDiaSemana",$valorDeMiCampo, PDO::PARAM_INT);
		$stmt->bindParam(":idHotel",$valorDeMiCampo2, PDO::PARAM_INT);		
		
		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt  = null;

	}
	/*=============================================
	TRAIGO EL numeroMaxDeReservas QUE ctrObtenerNumMaxDeReservas ESTA SOLICITANDO
	EN ESTA CASO ESTOY TRAYENDO AL MODELO LAS NOCHES DE ESTANCIA DEL HUESPED
	=============================================*/
	static public function mdlObtenerNumMaxDeReservas($tabla,$valorDeMiCampo, $valorDeMiCampo2){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idHotel=:idHotel AND nochesEstancia=:nochesEstancia AND estado=1");
		//campoDemitabla es idDiaSemana	

		$stmt->bindParam(":idHotel",$valorDeMiCampo, PDO::PARAM_STR);
		$stmt->bindParam(":nochesEstancia",$valorDeMiCampo2, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	TRAIGO  LAS MESAS DISPONIBLES
	=============================================*/
	static public function mdlObtenerListaDeMesasDisponibles($tabla,$campoDemiTabla, $valorDeMiCampo){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $campoDemiTabla=:$campoDemiTabla AND estado=1");		

		$stmt->bindParam(":".$campoDemiTabla, $valorDeMiCampo, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}

	/*=============================================
	PARA VERIFICAR QUE EL HUESPED PUEDA HACER RESERVA: solicitud ctrValidarPoderHacerReserva
	=============================================*/
	static public function mdlValidarPoderHacerReserva($tabla,$campoDemiTabla, $valorDeMiCampo){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as totalRsvHuesped FROM $tabla WHERE $campoDemiTabla=:$campoDemiTabla");

		$stmt->bindParam(":".$campoDemiTabla, $valorDeMiCampo, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	PARA VERIFICAR QUE EL HUESPED PUEDA HACER RESERVA: solicitud 
	=============================================*/
	static public function mdlContarReservasYPaxAcumulados($tabla, $valorDeMiCampo, $valorDeMiCampo2,$valorDeMiCampo3){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as totalReservas, SUM(pax) as sumaPax FROM $tabla WHERE idRestaurante=:id AND fechaDeLaReserva=:fechaDelaReserva AND hora=:hora");

		$stmt->bindParam(":id",$valorDeMiCampo3, PDO::PARAM_INT);
		$stmt->bindParam(":fechaDelaReserva",$valorDeMiCampo, PDO::PARAM_STR);
		$stmt->bindParam(":hora",$valorDeMiCampo2, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================
	PARA VERIFICAR QUE EL HUESPED PUEDA HACER RESERVA: solicitud 
	=============================================*/
	static public function mdlContarReservasYPaxAcumuladosDia($tabla, $valorDeMiCampo, $valorDeMiCampo2)
	{

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) as totalReservas, SUM(pax) as sumaPax FROM $tabla WHERE idRestaurante=:id AND fechaDeLaReserva=:fechaDelaReserva");

		$stmt->bindParam(":id", $valorDeMiCampo2, PDO::PARAM_INT);
		$stmt->bindParam(":fechaDelaReserva", $valorDeMiCampo, PDO::PARAM_STR);
	

		$stmt->execute();

		return $stmt->fetch();

		$stmt->close();

		$stmt = null;
	}
	/*=============================================
	 PARA ELIMINAR UNA RESERVA DESDE EL sweetalert
	=============================================*/
	static public function mdlEliminarReserva($tabla, $datos){

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
	  PARA ELIMINAR TODAS LAS RESERVAS LIGADAS A UN HOTEL
	  AL SER BORRADO ESTE
	=============================================*/
	static public function mdlEliminarReservasHotel($tablaReservas, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tablaReservas WHERE idHotel = :idHotel");

		$stmt->bindParam( ":idHotel", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt->close();

		$stmt = null;
	}
	/*=============================================
 	  PARA ELIMINAR TODAS LAS RESERVAS LIGADAS A UN RESTAURANTE
	  AL SER BORRADO ESTE
	=============================================*/
	static public function mdlEliminarReservasRestaurante($tablaReservas, $datos){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tablaReservas WHERE idRestaurante = :idRestaurante");

		$stmt->bindParam( ":idRestaurante", $datos, PDO::PARAM_INT);

		if ($stmt->execute()) {
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	/*=============================================
	PARA LA CONSULTA QUE GENERA LAS RESERVAS DE ACUERDO 
	AL RESTAURANTE SELECCIONADO.. CONSULTA OCUPADA EN EL MODULO
	administrar-reservas
	=============================================*/
	
	static public function mdlListaDeReservas($tabla, $valorCampoTabla, $valorCampoTabla2){
		date_default_timezone_set('UTC');
        $hoy = date("Y-m-d");
        $idHotel = $_SESSION["idHotel"]; 

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idRestaurante = :idRestaurante AND fechaDeLaReserva = :fecha AND idHotel=$idHotel");
			if($valorCampoTabla != null AND $valorCampoTabla2 != null){/*$campoTabla2 ="fechaDeLaReserva";*/
				
				$stmt -> bindParam(":idRestaurante", $valorCampoTabla, PDO::PARAM_INT);				
				$stmt -> bindParam(":fecha", $valorCampoTabla2, PDO::PARAM_STR);
				$stmt -> execute();
				
				return $stmt -> fetchAll();
				
			 }else if($valorCampoTabla !=null){
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fechaDeLaReserva>='$hoy' AND idRestaurante = :idRestaurante AND idHotel=$idHotel");

				$stmt -> bindParam(":idRestaurante", $valorCampoTabla, PDO::PARAM_INT);				
				
				$stmt -> execute();
				
				return $stmt -> fetchAll();
			 }
			 else
			 {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE fechaDeLaReserva>='$hoy' AND idHotel=$idHotel");

				$stmt -> execute();

				return $stmt -> fetchAll();

				$stmt -> close();

				$stmt = null;
		}
	}

	/*=============================================
	FUNCION PARA GUARDAR LA RESERVA EDITADA  DENTRO DEL MODAL
	=============================================*/
	static public function mdlEditarLaReserva($tabla, $datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fechaDeLaReserva =:fecha, nombreRestaurante=:nombreRestaurante, hora= :hora, usuario =:usuario, pax=:pax, observaciones=:observaciones WHERE id =:id");

		$stmt -> bindParam(":id", $datos["id"], PDO::PARAM_INT);
		$stmt -> bindParam(":nombreRestaurante", $datos["nombreRestaurante"], PDO::PARAM_STR);
		$stmt -> bindParam(":fecha", $datos["fechaReserva"], PDO::PARAM_STR);
		$stmt -> bindParam(":hora", $datos["nuevaHora"], PDO::PARAM_STR);
		$stmt -> bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
		$stmt -> bindParam(":pax", $datos["pax"], PDO::PARAM_INT);
		$stmt -> bindParam(":observaciones", $datos["observaciones"], PDO::PARAM_STR);

		if ($stmt->execute()) {
			
			return "OK";
		}else {
			return "ERROR";
		}

		$stmt-> close();

		$stmt = null;
	}
	/*=============================================
	 PARA ACTUALIZAR EL ESTADO  DE UNA RESERVA 
	=============================================*/
	static public function mdlActualizarEstadoReserva($tabla, $item1, $valor1, $item2, $valor2){

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
	CUENTO EL TOTAL DE FECHAS PARA HACER RESERVAS 
	=============================================*/
	static public function mdlrestauranteAbiertoVerificar($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("SELECT COUNT(*) AS totalFechas FROM $tabla WHERE idRestaurante=:idRestaurante AND :fecha between fechaInicio and fechaFin");

		$stmt->bindParam(":idRestaurante", $datos["idRestaurante"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha", $datos["fecha"], PDO::PARAM_STR);
		
		$stmt->execute();

		return $stmt->fetchAll();

		$stmt->close();

		$stmt = null;
	}
	
}