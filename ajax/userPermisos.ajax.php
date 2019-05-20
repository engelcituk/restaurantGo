<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/userPermisos.controlador.php";
require_once "../modelos/userPermisos.modelo.php";


class AjaxUserPermisos{
/*======================================
=OBTENER todos los permisos->para traer lista de UserPermisos=
======================================*/
	public $idUsuario;
	public function ObtenerPermisosUsuario(){
	
	$tabla="permisos";
	$valorDeMiCampo =$this->idUsuario; 
	
	$respuesta = ModeloUsuarioPermisos::mdlMostrarUserPermisos($tabla, $valorDeMiCampo);
	
	 echo json_encode($respuesta); 
	 //no comentar echo json_encode()
	}
/*=====  FIN DE OBTENER lista de UserPermisos  ======*/ 

/*======================================
=OBTENER lista de UserPermisoshotel=
para ver a que hotel tiene permisos de acceso
al usuario
======================================*/
	public $idUsuarioHotel;
	public function ObtenerPermisosHotelUsuario(){
	
	$tabla="permisoshotel";
	$valorDeMiCampo =$this->idUsuarioHotel; 
	
	$respuesta = ModeloUsuarioPermisos::mdlMostrarUserPermisosHotel($tabla, $valorDeMiCampo);
	
	 echo json_encode($respuesta); 
	 //no comentar echo json_encode()
	}
/*=====  FIN DE OBTENER lista de UserPermisos  ======*/

/*======================================
=VERIFICA SI USUARIO TIENE PERMISOS EN x HOTEL=
para ver si exise un permiso hotel relacionado con 
un usuario respecto al id del hotel y el id del usuario
======================================*/
	public $idHotelLS;
	public $idUsuarioLS;
	public function verificarSiUsuarioTieneAccesoHotel(){
	
	$tabla="usuario_permisos_hotel";

	$valorDeMiCampo =$this->idHotelLS; 
	$valorDeMiCampo2 =$this->idUsuarioLS;
	
	$respuesta = ModeloUsuarioPermisos::mdlVerificarUserAccesoHotel($tabla, $valorDeMiCampo,$valorDeMiCampo2);
	
	 echo json_encode($respuesta); 
	 //no comentar echo json_encode()
	}
/*=====  FIN DE VERIFICA SI USUARIO TIENE PERMISOS EN X HOTEL  ======*/
}

/*======================================
=   OBJETO-->OBTENER   =
======================================*/
if(isset($_POST["idUsuario"])){ //SI LA VARIABLE POST VIENE CON INFORMACION idUsuario

	$userPermiso = new AjaxUserPermisos();
	$userPermiso -> idUsuario = $_POST["idUsuario"]; //la variable publica toma el valor recibido por POST
	$userPermiso -> ObtenerPermisosUsuario(); //ejecuto la funcion
}

/*======================================
=   OBJETO-->OBTENER  =
======================================*/
if(isset($_POST["idUsuarioHotel"])){ //SI LA VARIABLE POST VIENE CON INFORMACION idUsuario

	$userPermisoHotel = new AjaxUserPermisos();
	$userPermisoHotel -> idUsuarioHotel = $_POST["idUsuarioHotel"]; //
	$userPermisoHotel -> ObtenerPermisosHotelUsuario(); //ejecuto la funcion
}

/*======================================
=   OBJETO-->OBTENER verificarSiUsuarioTieneAccesoHotel   =
======================================*/
if(isset($_POST["idHotelLS"])){ //SI LA VARIABLE POST VIENE CON INFORMACION idUsuario

	$userAccesoHotel = new AjaxUserPermisos();
	$userAccesoHotel -> idHotelLS = $_POST["idHotelLS"]; //
	$userAccesoHotel -> idUsuarioLS = $_POST["idUsuarioLS"]; 
	$userAccesoHotel -> verificarSiUsuarioTieneAccesoHotel(); //ejecuto la funcion
}




