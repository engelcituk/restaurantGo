<?php
// No tabular el codigo. sino marca error -->
require_once "../../../controladores/repRsrvs.controlador.php";
require_once "../../../modelos/repRsrvs.modelo.php";
require_once('tcpdf_include.php');

class imprimirListado{

public $idRestaurantePdf;
public $fechaInformePdfInicio;
public $fechaInformePdfFinal;
public $nomRestaurantePdf;
public function imprimirListaReservas(){

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);//elimino la linea que se imprime en la parte superior
$pdf->startPageGroup(); //permite tener varias paginas de nuestro doc PDF
$pdf->addPage();//adicionamos la nueva pagina

//para el encabezado, logo...
$bloque1 = <<<EOF
	<table>
    	<tr>
        	<td style="width:100px">
            	<img src="images/sandos.jpg">
            </td> 
        </tr>
    </table>
EOF;

$pdf->writeHTML($bloque1,false,false,false,false,'');
//cabecera de la tabla
$nomRestaurante=$this->nomRestaurantePdf;
$valorCampoTabla = $this->idRestaurantePdf; // el valorCampoTabla del id. por ejemplo (id = 7)
//traigo los resultados de acuerdo al id hotel que recibo
$valorCampoTabla2 = $this->fechaInformePdfInicio;
$valorCampoTabla3 = $this->fechaInformePdfFinal;

/*formateo de fechas*/
$fechaInicio=$valorCampoTabla2;
$newFechaInicio = date("d-m-Y", strtotime($fechaInicio));

$fechaFinal=$valorCampoTabla3;
$newFechaFinal = date("d-m-Y", strtotime($fechaFinal));
/*fin de formateo de fechas */

$bloque2 = <<<EOF
	<br><br>
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:#00897b ; width:250px; text-align:center">
				<strong>Reservas, restaurante: $nomRestaurante</strong>
			</td>
			<td style="border: 1px solid #666; background-color:#00897b ; width:290px; text-align:center">
				<strong>Entre las fechas: $newFechaInicio A $newFechaFinal</strong>
			</td>
		</tr>
		<tr>
			<td style="border: 1px solid #666; background-color:#80cbc4; width:40px; text-align:justify"><strong>No.</strong></td>		
			<td style="border: 1px solid #666; background-color:#80cbc4; width:75px; text-align:justify"><strong>Fecha</strong></td>
			<td style="border: 1px solid #666; background-color:#80cbc4; width:110px; text-align:justify"><strong>Reserva</strong></td>
			<td style="border: 1px solid #666; background-color:#80cbc4; width:80px; text-align:justify"><strong>Apellido</strong></td>
			<td style="border: 1px solid #666; background-color:#80cbc4; width:65px; text-align:justify"><strong>No. Hab.</strong></td>			
			<td style="border: 1px solid #666; background-color:#80cbc4; width:60px; text-align:justify"><strong>Hora</strong></td>
			<td style="border: 1px solid #666; background-color:#80cbc4; width:40px; text-align:justify"><strong>pax</strong></td>
			<td style="border: 1px solid #666; background-color:#80cbc4; width:70px; text-align:justify"><strong>usuario</strong></td>
						
		</tr>
	</table>

EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------
$respuesta = ControladorReportes::ctrMostrarListaReservas($valorCampoTabla,$valorCampoTabla2,$valorCampoTabla3);

$contador = 1;
foreach ($respuesta  as $key => $elemento) {
/*corto los ceros que sobran de las horas */
$hora = substr($elemento["hora"], 0, 8);
$bloque3 = <<<EOF
	<table style="font-size:9.5px; padding:5px 10px;">
		<tr>			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:40px; text-align:justify">$contador
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:75px; text-align:justify">$elemento[fechaDeLaReserva]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:110px; text-align:justify">$elemento[reservaIdentificador]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:justify">$elemento[apellido]
			</td>
			<td style="border: 1px solid #666; background-color:white; width:65px; text-align:center">$elemento[habitacion]</td>			
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:60px; text-align:justify">$hora
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:40px; text-align:right">$elemento[pax]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:70px; text-align:justify">$elemento[usuario]
			</td>						
		</tr>		
		<tr>
			<td style="border: 1px solid #666; color:#333; background-color:#e0f2f1; width:115px; text-align:justify"><strong>Observaciones</strong>
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:425px; text-align:justify">$elemento[observaciones]
			</td>	
		</tr>							
	</table>
	
EOF;
$contador = $contador + 1;
$pdf->writeHTML($bloque3, false, false, false, false, '');
}

//salida del pdf
$pdf->Output('listaReservas.pdf');
// el segundo parametro D hace que se descargue
// $pdf->Output('listaReservas', 'D');
}
}

$listaReservas = new imprimirListado();
$listaReservas -> idRestaurantePdf = $_GET["idRest"];
$listaReservas -> fechaInformePdfInicio = $_GET["fechaInicio"];
$listaReservas -> fechaInformePdfFinal = $_GET["fechaFinal"];
$listaReservas -> nomRestaurantePdf = $_GET["nomRest"];
$listaReservas -> imprimirListaReservas();
?>
