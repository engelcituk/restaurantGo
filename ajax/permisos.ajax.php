<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/permisos.controlador.php";
require_once "../modelos/permisos.modelo.php";


class AjaxPermisos{
/*======================================
= PARA ACTIVAR UN PERMISO  =
======================================*/
	public $activarIdPermiso;
	public $activarEstadoPermiso;

	public function ajaxActivarEstadoPermiso(){

		$tabla = "permisos";
		$item1 = "estado";
		$valor1 = $this->activarEstadoPermiso;

		$item2 = "id";
		$valor2 =$this->activarIdPermiso;
		
		$respuesta = ModeloPermisos::mdlCambiarEstadoPermiso($tabla, $item1, $valor1, $item2, $valor2);
		
	}
/*=====FIN  DE ACTIVA PERMISO ======*/

/*======================================
= VALIDAR NO REPETIR IP DE UN PERMISO   =
======================================*/
	public $nombrePermiso;
	public function ajaxValidarNombrePermiso(){

		$tabla="permisos";
		$valorDeMiCampo =$this->nombrePermiso; 
	
		$respuesta = ModeloPermisos::mdlTraerInfoPermiso($tabla,$valorDeMiCampo);

		echo json_encode($respuesta);

	}

/*======================================
=OBTENER DATO DE UN permiso DE ACUERDO A SU ID
CAPTURADO, DATOS QUE SON CARGADOS EN UN MODAL 
==== MODULO permisos
======================================*/
	public $idPermisoEditar;
	public function AjaxObtenerDatoPermiso(){

	$tabla = "permisos";
	$valorDeMiCampo = $this->idPermisoEditar; 

	$respuesta = ModeloPermisos::mdlObtenerDatoPermisoById($tabla,$valorDeMiCampo);

	echo json_encode($respuesta); //echo encode para verificar que se esta obteniendo respuesta OK
	 
	}

}
/*======================================
= OBJETO-->ACTIVA PERMISO =
======================================*/
if(isset($_POST["idPermiso"])){
	$activarPermiso = new AjaxPermisos();
	$activarPermiso -> activarIdPermiso = $_POST["idPermiso"];
	$activarPermiso -> activarEstadoPermiso = $_POST["estadoPermiso"]; 
	$activarPermiso -> ajaxActivarEstadoPermiso(); 
}
/*======================================
= OBJETO-->VALIDAR NOMBRE PERMISO =
======================================*/
if(isset($_POST["valorPermiso"])){
	$nombrePermisoValidar = new AjaxPermisos();
	$nombrePermisoValidar -> nombrePermiso = $_POST["valorPermiso"]; 	
	$nombrePermisoValidar -> ajaxValidarNombrePermiso(); //ejecuto la funcion
}
/*======================================
=   OBJETO-->OBTENER dato permiso   =
======================================*/
if(isset($_POST["idPermisoEditar"])){ //SI LA VARIABLE POST VIENE CON INFORMACION idPermisoEditar
	$permiso = new AjaxPermisos();
	$permiso -> idPermisoEditar = $_POST["idPermisoEditar"];
	$permiso -> AjaxObtenerDatoPermiso(); //ejecuto la funcion
}