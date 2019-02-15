<?php

class ControladorHoteles{
	
	/*=============================================
	REGISTRO DE HOTELES
	=============================================*/
	public function ctrRegistroHotel(){

		if (isset($_POST["nombreHotel"])) {
			
			$tabla = "hoteles";
			$estado = 1;	
			$datos = array("nombre" =>$_POST["nombreHotel"],
						   "descripcion" =>$_POST["descripcion"],
						   "estado" =>$estado);

			$respuesta = ModeloHoteles::mdlRegistroHotel($tabla, $datos);

			if ($respuesta != "ERROR"){

				$tblHotelPermisos="permisoshotel";

				$idHotelPermiso=$respuesta;
				$nombrePermisoHotel=$_POST["nombreHotel"];
							
				$datosPermisosHotel = array("idHotel" =>$idHotelPermiso,
									   		"permisohotel" =>$nombrePermisoHotel);

				ModeloHoteles::mdlRegistroPermisosHotel($tblHotelPermisos, $datosPermisosHotel);											

					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡EL registro del hotel, fue exitoso! su id es '.$respuesta.'",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="hoteles"
								  	}
							});
						</script>';
				}else				
				     {
						echo '
							<script>
								swal({
									  title: "Error",
									  text: "¡Error al registrar el Hotel",
									  type:"error",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
									  },
									function(isConfirm){

										if(isConfirm){
										   window.location="hoteles"
									  	}
								});
							</script>';
			}
		}
	}

	/*=============================================
	LISTADO DE HOTELES
	=============================================*/
	static public function ctrMostrarListaHoteles($item, $valor){

		$tabla = "hoteles";
		//$item, $valor-->pueden venir como nulos, en ese caso en el modelo se ejecuta una consulta diferente
		//si vienen nulos.
		$respuesta = ModeloHoteles::mdlMostrarListaHoteles($tabla,$item, $valor);
		//tabla usuarios, item=id $valor=valor de id-->mdlMostrarListaUsuarios("usuarios", id, 7)
		return $respuesta;		
	}

	/*=============================================
	FUNCION PARA EDITARL EL HOTEL EN EL MODAL
	=============================================*/
	public function ctrEditarhotel(){
		
		if (isset($_POST["editarNombre"])) {//SI EDITAR NOMBRE VIENE LLENO 

			$tabla = "hoteles";
			
			$datos = array("idHotel" =>$_POST["idhotelEditar"],
						   "nombre" =>$_POST["editarNombre"],
						   "descripcion" =>$_POST["editarDescripcion"],
						   "estado" =>$_POST["estadoHotel"]);

				//LLAMO AL MODELO QUE HACE EL UPDATE
			$respuesta = ModeloHoteles::mdlEditarHotel($tabla, $datos);

			if ($respuesta == "OK"){
					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡La modificacion del Hotel, fue exitoso!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="hoteles"
								  	}
							});
						</script>';
				
			}	 
		}		
	}
	/*=============================================
	FUNCION PARA ELIMINAR EL HOTEL
	=============================================*/
	public function ctrBorrarHotel(){

		if (isset($_GET["idHotelBorrar"])) {
			
			$tabla = "hoteles";
			$datos = $_GET["idHotelBorrar"];

			$respuesta = ModeloHoteles::mdlEliminarHotel($tabla, $datos);

			if ($respuesta == "OK"){

						echo '
							<script>
								swal({
									  title: "¡OK!",
									  text: "¡EL Hotel se ha borrado exitosamente!",
									  type:"success",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
									  },
									function(isConfirm){

										if(isConfirm){
										   window.location="hoteles"
									  	}
								});
							</script>';
				}
		}
	}
	
} 

