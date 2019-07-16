<?php

class ControladorReportes{		
	/*=============================================
	TRAIGO LA LISTA DE HOTELES 
	=============================================*/
	public function ctrMostrarListaHoteles(){

		$tabla = "hoteles";
	
		$respuesta = ReporteReservas::mdlMostrarListaHoteles($tabla);
		
		foreach ($respuesta as $fila => $elemento){
        	echo '<li class="lstHotelReport" nombreHotel="'.$elemento["nombre"].'" idHotelRep="'.$elemento["id"].'"><a href="#">'.$elemento["nombre"].'</a></li>';
        }       
	} 
	/*=============================================
	FUNCION PARA MOSTRAR LA LISTA DE RESERVAS
	=============================================*/ 
	static public function ctrMostrarListaReservas($valorCampoTabla,$valorCampoTabla2,$valorCampoTabla3,$valorCampoTabla4){

		$tabla = "reservas";
		 
		$respuesta = ReporteReservas::mdlListaReporteReservas($tabla,$valorCampoTabla,$valorCampoTabla2,$valorCampoTabla3, $valorCampoTabla4);
		
		return $respuesta;
	}

	/*=============================================
	PARA GENERAR LA DESCARGA DEL EXCEL
	=============================================*/
	public function ctrDescargarReporteExcel(){

		$tabla ="reservas";
					
		$valorDeMiCampo=$_GET["idRest"];
		$nameRestaurante=$_GET['nomRest'];
		$nombreRestaurante = $nameRestaurante=="Todos" ? "Todos los restaurantes" : $nameRestaurante;
		$valorDeMiCampo2=$_GET["fechaInicio"];		
		$valorDeMiCampo3=$_GET["fechaFinal"];
		$valorDeMiCampo4 = $_GET["orden"];
				
		/*=============================================
		CREAMOS EL ARCHIVO EXCEL
		=============================================*/
		$nombre =$_GET["reporte"].'.xls';

		header('Expires: 0');
		header('Cache-control: private');
		header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
		header("Cache-Control: cache, must-revalidate"); 
		header('Content-Description: File Transfer');
		header('Last-Modified: '.date('D, d M Y H:i:s'));
		header("Pragma: public"); 
		header('Content-Disposition:; filename="'.$nombre.'"');
		header("Content-Transfer-Encoding: binary");

		echo utf8_decode(
			"<table border='0'>
				<strong style='text-align:center;'>&nbsp&nbsp</strong>
				<tr>
					<td></td>														
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'> $nombreRestaurante</td>
				</tr>
			 </table>
			 <table border='0'>
				
				<strong style='text-align:center;'>&nbsp&nbsp</strong>				
				<tr>
					<td></td>
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'>Numero</td> 
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'>Fecha de la reserva</td>
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'>Reserva</td>
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'>Nombre/Apellido</td>
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'>Numero de Habitacion</td>
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'>Hora de la Reserva</td>
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'>Pax</td>
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'>Usuario</td>									
					<td style='font-weight:bold; border:1px solid #030303; background-color:#4db6ac'>Observaciones</td>
				</tr>");
				$reservas = ReporteReservas::mdlDescargarReporteExcel($tabla,$valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3, $valorDeMiCampo4);

				$contador = 1;
				foreach ($reservas as $fila => $elemento){
					/*corto los ceros que sobran de las horas */
					$hora = substr($elemento["hora"], 0, 8);
					echo utf8_decode("
					 	<tr>
					 		<td></td>			 		
							<td style='border:1px solid #575555; text-align:center;'>".$contador."</td>
							<td style='border:1px solid #575555; text-align:center;'>".$elemento["fechaDeLaReserva"]."</td>	
							<td style='border:1px solid #575555;'>".$elemento["reservaIdentificador"]."</td>
							<td style='border:1px solid #575555;'>".$elemento["apellido"]."</td>
							<td style='border:1px solid #575555;text-align:center;'>".$elemento["habitacion"]."</td>
							<td style='border:1px solid #575555;text-align:center;'>".$hora."</td>
							<td style='border:1px solid #575555;text-align:center;'>".$elemento["pax"]."</td>	
							<td style='border:1px solid #575555;'>".$elemento["usuario"]."</td>
							
							<td style='border:1px solid #575555; text-align:justify;'>".$elemento["observaciones"]."</td>		
				 		</tr>");
						$contador = $contador + 1;
					}
			echo "</table>";
		}
}
