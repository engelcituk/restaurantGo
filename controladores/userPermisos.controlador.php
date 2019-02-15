<?php

class ControladorUsuarioPermisos{	
	/*=============================================
	FUNCION PARA BUSCAR EL USUARIO CON SUS PERMISOS
	=============================================*/
	public function ctrMostrarPermisosUsuario(){

		if (isset($_GET["idUsuario"])) {
			
			$tabla = "usuario_permisos";

			$valorDeMiCampo = $_GET["idUsuario"];

			$respuesta = ModeloUsuarioPermisos::mdlMostrarUserPermisos($tabla, $valorDeMiCampo);

			return $respuesta;
		}
	}
	
	/*==================   
	ELIMINAR PERMISOS ANTERIORES Y SE AGREGA LOS NUEVOS PERMISO
	AL USUARIO DE ACUERDO A SU ID  ================*/
	public function ctrBorrarPermisosUsuario(){

		if (isset($_GET["idUsuarioPermiso"])) {
			
			$tabla = "usuario_permisos";
			$datos = $_GET["idUsuarioPermiso"];

			
			$respuesta = ModeloUsuarioPermisos::mdlBorrarPermisosUsuario($tabla, $datos);
			
			if ($respuesta == "OK"){

			echo '
				<script>
					swal(
					  "Exito!",
					  "Permisos modificados!",
					  "success"
					)
				</script>';
			}
		}
	}
	
	
	/*=====  END OF ELIMINAR PERMISOS ANTERIORES Y SE AGREGA LOS NUEVOS PERMISO
	AL USUARIO DE ACUERDO A SU ID  ======*/

	/*=================================================================
	=            PARA AGREGAR NUEVOS PERMISOS A UN USUARIO AL EDITARLOS=
	=================================================================*/
	public function ctrRegistroNuevosPermisosUsuario(){

		if (isset($_GET["idPermisos"])) {

			$tblUsPermisos="usuario_permisos";
			$idUsuario=$_GET["idUsuarioPermiso"];
			$permisos=$_GET["idPermisos"];
			$estadoPermisos=1;
					
		foreach ($permisos as $fila => $valorPermiso) {

			$datosPermisos = array("idUsuario" =>$idUsuario,
							   	   "idPermisoValor" =>$valorPermiso,		   
							   	   "estado" =>$estadoPermisos);
			
			ModeloUsuarios::mdlRegistroUsuarioPermisos($tblUsPermisos, $datosPermisos);						
		}
			
			if ($respuesta == "OK"){
				echo '
					<script>
						swal({
							  title: "¡OK!",
							  text: "¡nuevos permisos asignados!",
							  type:"success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							  },
							function(isConfirm){
								if(isConfirm){
								   window.location="usuarios"
							  	}
						});
					</script>';
			}
		}
	}
	
	
	/*=====  END OF PARA AGREGAR NUEVOS PERMISOS A UN USUARIO*/
	
	
} 

