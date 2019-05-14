<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "controladores/plantilla.controlador.php";
require_once "controladores/hoteles.controlador.php";
require_once "controladores/usuarios.controlador.php";
require_once "controladores/restaurantes.controlador.php";
require_once "controladores/huesped.controlador.php";
require_once "controladores/reservas.controlador.php";
require_once "controladores/repRsrvs.controlador.php";
require_once "controladores/seatings.controlador.php";
require_once "controladores/tickets.controlador.php";
require_once "controladores/estanciaConf.controlador.php";
require_once "controladores/impresoras.controlador.php";
require_once "controladores/permisos.controlador.php";
require_once "controladores/permisosHotel.controlador.php";
require_once "controladores/userPermisos.controlador.php";
require_once "controladores/conectorSQLSRV.controlador.php";
require_once "controladores/estadisticas.controlador.php";
require_once "controladores/fechas.controlador.php";

require_once "modelos/hoteles.modelo.php";
require_once "modelos/usuarios.modelo.php";
require_once "modelos/restaurantes.modelo.php";
require_once "modelos/huesped.modelo.php";
require_once "modelos/reservas.modelo.php";
require_once "modelos/repRsrvs.modelo.php";
require_once "modelos/seatings.modelo.php";
require_once "modelos/tickets.modelo.php";
require_once "modelos/estanciaConf.modelo.php";
require_once "modelos/impresoras.modelo.php";
require_once "modelos/permisos.modelo.php";
require_once "modelos/permisosHotel.modelo.php";
require_once "modelos/userPermisos.modelo.php";
require_once "extensiones/posTicket/autoload.php";
require_once "modelos/conectorSQLSRV.modelo.php";
require_once "modelos/estadisticas.modelo.php";

require_once "modelos/rutas.php";

$plantilla = new ControladorPlantilla();
$plantilla -> plantilla();
