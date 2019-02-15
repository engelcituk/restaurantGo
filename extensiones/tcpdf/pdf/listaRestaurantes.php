<?php
// No tabular el codigo. sino marca error -->
require_once "../../../controladores/restaurantes.controlador.php";
require_once "../../../modelos/restaurantes.modelo.php";
require_once('tcpdf_include.php');

class imprimirLista{

public $idHotelPdf;
public function imprimirListaRestaurantes(){

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);//elimino la linea que se imprime
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
$bloque2 = <<<EOF
	<br><br>
	<table style="font-size:10px; padding:5px 10px;">
		<tr>
			<td style="border: 1px solid #666; background-color:#42a5f5 ; width:540px; text-align:center">
			<strong>Lista de restaurantes</strong>
			</td>
		</tr>
		<tr>		
			<td style="border: 1px solid #666; background-color:#e3f2fd; width:180px; text-align:justify"><strong>Id</strong></td>
			<td style="border: 1px solid #666; background-color:#e3f2fd; width:180px; text-align:justify"><strong>Nombre</strong></td>
			<td style="border: 1px solid #666; background-color:#e3f2fd; width:180px; text-align:justify"><strong>Especialidad</strong></td>		
		</tr>
	</table>

EOF;
$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------
$campoTabla = "idHotel"; //sería el campo de la tabla
$valorCampoTabla = $this->idHotelPdf; // el valorCampoTabla del id. por ejemplo (id = 7)
//traigo los resultados de acuerdo al id hotel que recibo
$respuesta = ControladorRestaurantes::ctrMostrarListaRestaurantes($campoTabla,$valorCampoTabla);

foreach ($respuesta  as $key => $elemento) {

$bloque3 = <<<EOF
	<table style="font-size:10px; padding:5px 10px;">
		<tr >			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:180px; text-align:justify">
				$elemento[id]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:180px; text-align:justify">
				$elemento[nombre]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:180px; text-align:justify"> 
				$elemento[especialidad]
			</td>			
		</tr>

	</table>
EOF;
$pdf->writeHTML($bloque3, false, false, false, false, '');
}

//salida del pdf
$pdf->Output('listaRestaurantes.pdf');
}
}

$listaRestaurantes = new imprimirLista();
$listaRestaurantes -> idHotelPdf = $_GET["idHotelPdf"];
$listaRestaurantes -> imprimirListaRestaurantes();


?>