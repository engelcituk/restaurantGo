<?php

class ControladorUsuarios{
  
	/*=============================================
	INGRESO DE USUARIOS
	=============================================*/	
	public function ctrIngresoUsuarios(){	

		if(isset($_POST["ingNombreDeUsuario"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["ingNombreDeUsuario"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPassword"])){
			   
			   $encriptar = crypt($_POST["ingPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
						
				$tabla = "usuarios";
				$item = "nombreDeUsuario";
				$valor = $_POST["ingNombreDeUsuario"];
				$impresorasIP = $_POST["impresoras"];
				
				//debo hacer que no haya registros con el mismo mail
				$respuesta = ModeloUsuarios::mdlIngresoUsuarios($tabla, $item, $valor);

				  //traigo los datos del hotel con el que se va trabajar
				  $idHotel = $_POST["idHotel"];
				  
				  $tablaHotel="hoteles";
				  $item2 = "id";
                  $valorId = $idHotel;

                  //para obtener los datos del hotel de acuerdo al id que le pasamos
                  $hotelRespuesta = ModeloHoteles::mdlObtenerDatoHotelById($tablaHotel,$item2,$valorId);
											
				if($respuesta["nombreDeUsuario"] == $_POST["ingNombreDeUsuario"] && $respuesta["password"] == $encriptar){
					//SI EL USUARIO ESTÁ ACTIVADO O IGUAL A 1 INICIO SESIÓN									
					if ($respuesta["estado"]==1) {
						// creo un arreglo para guardar los permisos que tiene ese usuario
                		$arreglo=array();
						//traigo los permisos del usuario
						$tablaUsrPermisos="usuario_permisos";
						$valorDeMiCampo=$respuesta["id"];//es el id del usuario.  lo ocupo para traer los permisos del usuario en la tabla usuario_permisos

						$permisosUser=ModeloUsuarioPermisos::mdlTraerPermisosUsuario($tablaUsrPermisos,$valorDeMiCampo);

						foreach ($permisosUser as $filaUser => $elementoUser) {
						//cargo el array $arreglo con valores
							array_push($arreglo, $elementoUser["idPermiso"]); 
		        }		               
		          /*determinamos los permisos del usuario, creando variables de sesión los numeros son los id de los permisos*/
				       in_array(3, $arreglo)?$_SESSION["HACER RESERVAS"]=1:$_SESSION["HACER RESERVAS"]=0;
				       in_array(4, $arreglo)?$_SESSION["ACTIVAR RESERVAS"]=1:$_SESSION["ACTIVAR RESERVAS"]=0;
				       in_array(5, $arreglo)?$_SESSION["REIMPRIMIR TICKET"]=1:$_SESSION["REIMPRIMIR TICKET"]=0;
				       in_array(6, $arreglo)?$_SESSION["EDITAR RESERVAS"]=1:$_SESSION["EDITAR RESERVAS"]=0;
				       in_array(7, $arreglo)?$_SESSION["BORRAR RESERVAS"]=1:$_SESSION["BORRAR RESERVAS"]=0;
				       in_array(8, $arreglo)?$_SESSION["REPORTES"]=1:$_SESSION["REPORTES"]=0;
							 in_array(9, $arreglo)?$_SESSION["C-HOTELES"]=1:$_SESSION["C-HOTELES"]=0;
							 in_array(1011, $arreglo)?$_SESSION["C-USUARIOS"]=1:$_SESSION["C-USUARIOS"]=0;
							 in_array(1012, $arreglo)?$_SESSION["C-RESTAURANTES"]=1:$_SESSION["C-RESTAURANTES"]=0;
							 in_array(1013, $arreglo)?$_SESSION["C-SEATINGS"]=1:$_SESSION["C-SEATINGS"]=0;
							 in_array(1014, $arreglo)?$_SESSION["C-TICKETS"]=1:$_SESSION["C-TICKETS"]=0;
							 in_array(1015, $arreglo)?$_SESSION["C-RSVXESTANCIA"]=1:$_SESSION["C-RSVXESTANCIA"]=0;
							 in_array(1016, $arreglo)?$_SESSION["C-IMPRESORAS"]=1:$_SESSION["C-IMPRESORAS"]=0;
				       /*fin variables de sesion permisos usuario*/

		                /*variables de sesión para ocupar en todo el sistema--estos son datos del usuario*/
						$_SESSION["validarSesionBackend"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["nombreDeUsuario"] = $respuesta["nombreDeUsuario"];
						$_SESSION["ipImpresora"]=$impresorasIP;
						$_SESSION["nombreHotel"]= $hotelRespuesta["nombre"];
						$_SESSION["idHotel"]= $hotelRespuesta["id"];
						$_SESSION["SUBMENU LATERAL"]=1;

						/*Para generar las variables de sesion para usar el conector adecuado*/
						$item = "idHotel";//el campo de la tabla
            $valor = $_SESSION["idHotel"];//el valor
            $respuesta = ControladorConectorSQLSRV::ctrMostrarDatosConector($item,$valor);
		              
		        $_SESSION["servidorSQLSRV"] = $respuesta["ipServidor"];
		        $_SESSION["bdSQLSRV"] = $respuesta["baseDeDatos"];
		        $_SESSION["usuarioSQLSRV"] = $respuesta["usuario"];
						$_SESSION["passwordSQLSRV"] = $respuesta["password"];
						$_SESSION["VER-MENU-CONFIGURACION"]=1;
						$_SESSION["ICONO BANDERA"]=1; //para mostrar la bandera que despliega el lateral de estadisticas
		        /*fin variables de sesion para usar el conector adecuado*/						
						echo '<script>
								window.location="hacer-reservas";
					          </script>';					  
					}else {
						//DE LO CONTRARIO MENSAJE DE USUARIO NO ESTA ACTIVADO
						echo '<br><div class="alert alert-danger">El usuario no está activo</div>';
					}
				}else{

					echo '<br><div class="alert alert-danger">Error con los datos de acceso, vuelva a intentarlo</div>';
				}

			}
		}
	}
	/*=============================================
	REGISTRO DE USUARIOS
	=============================================*/	
	public function ctrRegistroUsuario(){
		
		if (isset($_POST["regUsuario"])) {
			
			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["regUsuario"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["regNombreUsuario"])&&
				preg_match('/^[a-zA-Z0-9]*$/', $_POST["regPassword"])){

				$encriptar = crypt($_POST["regPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');

				$tabla = "usuarios";
				$estado=1;
				$nivel=0;
			
				$datos = array("nombre" =>$_POST["regUsuario"],							   
							   "nombreDeUsuario" =>$_POST["regNombreUsuario"],
							   "password" =>$encriptar,							   
							   "estado" =>$estado,
							   "nivel" =>$nivel);

				$respuesta = ModeloUsuarios::mdlRegistroUsuario($tabla, $datos);
				
				if ($respuesta != "ERROR"){

					$tblUsPermisos="usuario_permisos";
					$idUsuario=$respuesta;
					$permisos=$_POST["permiso"];
					
					
					foreach ($permisos as $fila => $valorPermiso) {

						$datosPermisos = array("idUsuario" =>$idUsuario,
										   	   "idPermisoValor" =>$valorPermiso);						
						ModeloUsuarios::mdlRegistroUsuarioPermisos($tblUsPermisos, $datosPermisos);						
					}

					$tblUsPermisosHotel="usuario_permisos_hotel";					
					$permisosHotel=$_POST["permisohotel"];
										
					foreach ($permisosHotel as $fila => $valorPermisoHotel) {

						$datosPermisosHotel = array("idUsuarioHotel" =>$idUsuario,
										   	  		"idPermisoHotelValor" =>$valorPermisoHotel);
						
						ModeloUsuarios::mdlRegistroUserPermisosHotel($tblUsPermisosHotel, $datosPermisosHotel);						
					}

					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡EL registro del usuario, y sus permisos fue exitoso!",
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

			}else {

				echo '
				<script>
					swal({
						  title: "Error",
						  text: "¡Error al registrar el usuario, no se permiten caracteres especiales!",
						  type:"error",
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
	/*=============================================
	FUNCION PARA MOSTRAR LA LISTA DE USUARIOS 
	=============================================*/
	static public function ctrMostrarListaUsuarios($item, $valor){

		$tabla = "usuarios";
		//$item, $valor-->pueden venir como nulos, en ese caso en el modelo se ejecuta una consulta diferente
		//si vienen nulos.
		$respuesta = ModeloUsuarios::mdlMostrarListaUsuarios($tabla,$item, $valor);
		//tabla usuarios, item=id $valor=valor de id-->mdlMostrarListaUsuarios("usuarios", id, 7)
		return $respuesta;		
	}
	/*=============================================
	FUNCION PARA EDITAR AL USUARIO EN EL MODAL
	=============================================*/
	public function ctrEditarUsuario (){
		
		if (isset($_POST["editarNombre"])) {//SI EDITAR NOMBRE VIENE LLENO 
			
			if (preg_match('/^[a-zA-ZñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["editarNombre"]) &&
				preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["editarNombreDeUsuario"])
				){				

				$tabla = "usuarios";//LA TABLA DONDE SE HARÁ EL UPDATE
				if ($_POST["editarPassword"] !="") { // SI EDITAR PASS VIENE CON INFO					
					if (preg_match('/^[a-zA-Z0-9]*$/', $_POST["editarPassword"])) { //VERIFICO SI PASS TIENE NUMEROS, LETRAS MINUSCULAS O MAYUS, CARACTERES ESPECIALES NO ADMITO					
				$encriptar = crypt($_POST["editarPassword"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
					}else{

						echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡La contraseña no debe ser vacía o llevar caracteres especiales!",
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
				}else {
					$passwordActual = $_POST["passwordActual"];
					$encriptar = $passwordActual;
				}
				$datos = array("id" =>$_POST["idUsuarioEditar"],
							   "nombre" =>$_POST["editarNombre"] ,							   
							   "password" =>$encriptar,
							   "nombreDeUsuario" =>$_POST["editarNombreDeUsuario"]
							    );
				//LLAMO AL MODELO QUE HACE EL UPDATE
				$respuesta = ModeloUsuarios::mdlEditarUsuario($tabla, $datos);

				if ($respuesta == "OK"){
					//si respuesta retornada es OK // primera tabla de usuario_permisos
					$tblPermisos="usuario_permisos";
					$idBorrarUser=$_POST["idUsuarioEditar"];

					//si respuesta retornada es OK//segunda tabla usuario_permisos_hotel
					$tblPermisosHotel="usuario_permisos_hotel";
					
					//borro los permisos previos del usuario (permisos de tipo acciones)
					ModeloUsuarioPermisos::mdlBorrarPermisosUsuario($tblPermisos, $idBorrarUser);
					//borro los permisos previos del usuario (permisos de tipo acceso hoteles)
					ModeloUsuarioPermisos::mdlBorrarPermisosUsuarioHotel($tblPermisosHotel, $idBorrarUser);

					//vuelvo a guardar los nuevos permisos (acciones)
					$tblUsPermisos="usuario_permisos";
					$idUsuario=$_POST["idUsuarioEditar"];
					$permisos=$_POST["permiso"];
										
					//con ciclo foreach recorro el array de IDs permisos-inserto permisos acciones
					foreach ($permisos as $fila => $valorPermisos) {

						$datosPermisos = array("idUsuario" =>$idUsuario,
										   	   "idPermisoValor" =>$valorPermisos);						
						ModeloUsuarios::mdlRegistroUsuarioPermisos($tblUsPermisos, $datosPermisos);
					}
					//con ciclo foreach recorro el array de IDs permisos-inserto permisos Hoteles
					$tblUsPermisosHotel="usuario_permisos_hotel";					
					$permisosHotel=$_POST["permisoHotelEditar"];
										
					foreach ($permisosHotel as $fila => $valorPermisoHotel) {

						$datosPermisosHotel = array("idUsuarioHotel" =>$idUsuario,
										   	  		"idPermisoHotelValor" =>$valorPermisoHotel);			
						ModeloUsuarios::mdlRegistroUserPermisosHotel($tblUsPermisosHotel, $datosPermisosHotel);						
					}
					//muestro mensaje de exito si se editó correctamente usuario							
					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡La modificacion del usuario, fue exitoso!",
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
			}else {
				echo '
				<script>
					swal({
						  title: "Error",
						  text: "¡No se permiten caracteres especiales!",
						  type:"error",
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
	
	/*=============================================
	FUNCION PARA ELIMINAR EL USUARIO 
	=============================================*/
	public function ctrBorrarUsuario(){

		if (isset($_GET["idUsuario"])) {
			
			$tabla = "usuarios";
			$datos = $_GET["idUsuario"];

			$respuesta = ModeloUsuarios::mdlEliminarUsuario($tabla, $datos);

			if ($respuesta == "OK"){

						echo '
							<script>
								swal({
									  title: "¡OK!",
									  text: "¡EL registro se ha borrado exitosamente!",
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

	/*=============================================
	INGRESO DE USUARIO full
	=============================================*/	
	public function ctrIngresoUsuarioPro(){	

		if(isset($_POST["ingUsuarioPro"])){

			if(preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]*$/', $_POST["ingUsuarioPro"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["ingPasswordPro"])){
			   
			   $encriptar = crypt($_POST["ingPasswordPro"], '$2a$07$asxx54ahjppf45sd87a5a4dDDGsystemdev$');
						
				$tabla = "usuarios";
				$item = "nombreDeUsuario";
				$valor = $_POST["ingUsuarioPro"];				
							
				$respuesta = ModeloUsuarios::mdlIngresoUsuarios($tabla, $item, $valor);											
				if($respuesta["nombreDeUsuario"] == $_POST["ingUsuarioPro"] && $respuesta["password"] == $encriptar){
					//SI EL USUARIO ESTÁ ACTIVADO O IGUAL A 1 INICIO SESIÓN									
					if ($respuesta["estado"]==1 && $respuesta["nivel"]==1 ) {						
		                /*variables de sesión para ocupar en todo el sistema--estos son datos del usuario*/
						$_SESSION["validarSesionBackend"] = "ok";
						$_SESSION["id"] = $respuesta["id"];
						$_SESSION["nombre"] = $respuesta["nombre"];
						$_SESSION["nombreDeUsuario"] = $respuesta["nombreDeUsuario"];
						
						$_SESSION["nombreHotel"]= 0;
						$_SESSION["idHotel"]=0;
						$_SESSION["ipImpresora"]=0;

						$_SESSION["servidorSQLSRV "]= 0;
						$_SESSION["bdSQLSRV "]=0;
						$_SESSION["usuarioSQLSRV"]=0;
						$_SESSION["passwordSQLSRV"]=0;
							
						/*SOLO LE PERMITO ACCESO A LA PARTE DE CONFIGURACION*/
						$_SESSION["HACER RESERVAS"]=0;
						$_SESSION["ADMINISTRARRESERVASPAGINAS"]=0;						
						$_SESSION["PAGINAINICIO"]=0;
				    $_SESSION["ACTIVAR RESERVAS"]=0;
				    $_SESSION["REIMPRIMIR TICKET"]=0;
				    $_SESSION["EDITAR RESERVAS"]=0;
				    $_SESSION["BORRAR RESERVAS"]=0;
						$_SESSION["REPORTES"]=0;
						$_SESSION["SUBMENU LATERAL"]=0;
						$_SESSION["VER-MENU-CONFIGURACION"]=1;					
						$_SESSION["ICONO BANDERA"]=0;// 0	para mostrar iconoBandera para mostrar el lateral de estadisticas
						$_SESSION["C-HOTELES"]=1;
						$_SESSION["C-USUARIOS"]=1;
						$_SESSION["C-RESTAURANTES"]=1;
						$_SESSION["C-SEATINGS"]=1;
						$_SESSION["C-TICKETS"]=1;
						$_SESSION["C-RSVXESTANCIA"]=1;
						$_SESSION["C-IMPRESORAS"]=1;
					
						echo '<script>
								window.location="hoteles";
					          </script>';					  
					}else {
						//DE LO CONTRARIO MENSAJE DE USUARIO NO ESTA ACTIVADO
						echo '<br><div class="alert alert-danger">El usuario no está activo o no tiene nivel de acceso a configuracion</div>';
					}
				}else{

					echo '<br><div class="alert alert-danger">Error con los datos de acceso, vuelva a intentarlo</div>';
				}
			}
		}
	}
	
}



