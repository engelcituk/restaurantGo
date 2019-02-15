<?php 
require_once "../../controladores/repRsrvs.controlador.php";
require_once "../../modelos/repRsrvs.modelo.php";

$reporteExcel = new ControladorReportes();
$reporteExcel->ctrDescargarReporteExcel(); 