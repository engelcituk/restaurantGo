<?php 
//se requiere el controlador y el modelo para obtener respuesta
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";


class AjaxUsuarios{
/*======================================
=            EDITAR USUARIO            =
======================================*/
	public $idUsuario;
	public function ajaxEditarUsuario(){

	$item = "id"; //sería el campo de la tabla
	$valor = $this->idUsuario; // el valor del id. por ejemplo (id = 7)

	//llamo al controlador que muestra la consulta de los usuarios
	$respuesta = ControladorUsuarios::ctrMostrarListaUsuarios($item, $valor); //(id, 7) como parametros para ejecutar
	
	 echo json_encode($respuesta); //echo encode para obtener el json y que se esta obteniendo OK
	 //no comentar echo json_encode()
	}
/*=====  FIN DE EDITAR USUARIO  ======*/

/*======================================
= VALIDAR NO REPETIR A UN USUARIO    =
======================================*/
	public $validarUsuario;

	public function ajaxValidarNombreUsuario(){

		$item = "nombreDeUsuario"; //sería el campo de la tabla
		$valor = $this->validarUsuario; // el valor del nombreDeUsuario. por ejemplo (nombreDeUsuario = juan1234)

		//llamo al controlador que muestra la consulta de los usuarios
		$respuesta = ControladorUsuarios::ctrMostrarListaUsuarios($item, $valor); //como parametros para ejecutar
		
		 echo json_encode($respuesta);

	}
/*=====FIN DE VALIDAR NO REPETIR A UN USUARIO ======*/

/*======================================
= PARA ACTIVAR A UN USUARIO    =
======================================*/
	public $activarUsuario;
	public $activarId;

	public function ajaxActivarUsuario(){

		$tabla = "usuarios";
		$item1 = "estado";
		$valor1 = $this->activarUsuario;

		$item2 = "id";
		$valor2 =$this->activarId;

		$respuesta = ModeloUsuarios::mdlActualizarEstadoUsuario($tabla, $item1, $valor1, $item2, $valor2); 

	}
/*=====FIN  DE ACTIVAR A UN USUARIO  ======*/
}
/*======================================
=   OBJETO-->EDITAR USUARIO   =
======================================*/
if(isset($_POST["idUsuario"])){

	$usuarioEditar = new AjaxUsuarios();
	$usuarioEditar -> idUsuario = $_POST["idUsuario"]; //la variable publica toma el valor que recibo por POST
	$usuarioEditar -> ajaxEditarUsuario(); //ejecuto la funcion
}
/*======================================
= OBJETO-->VALIDAR NOMBRE DE USUARIO =
======================================*/
if(isset($_POST["nombreUsuario"])){

	$validarUsuario = new AjaxUsuarios();
	$validarUsuario -> validarUsuario = $_POST["nombreUsuario"]; //la variable publica toma el valor que recibo por POST enviado por ajax
	$validarUsuario -> ajaxValidarNombreUsuario(); //ejecuto la funcion
}
/*======================================
= OBJETO-->ACTIVAR USUARIO =
======================================*/
if(isset($_POST["activarUsuario"])){

	$activarUsuario = new AjaxUsuarios();
	$activarUsuario -> activarUsuario = $_POST["activarUsuario"]; 
	$activarUsuario -> activarId = $_POST["activarId"];
	$activarUsuario -> ajaxActivarUsuario(); 
}




