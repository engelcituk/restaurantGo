<?php 
class ControladorRestaurantes{

	/*=============================================
	TRAIGO LA LISTA DE HOTELES 
	=============================================*/
	public function ctrMostrarListaHoteles(){

		$tabla = "hoteles";
	
		$respuesta = ModeloRestaurantes::mdlMostrarListaHoteles($tabla);
		
		foreach ($respuesta as $fila => $elemento){
        	echo '<li class="listaHotel listaHotelPdf" nombreHotel="'.$elemento["nombre"].'" idHotelPdf="'.$elemento["id"].'" idHotel="'.$elemento["id"].'"><a href="#">'.$elemento["nombre"].'</a></li>';
        }
        //  
	}  
	/*=============================================
	FUNCION PARA MOSTRAR LA LISTA DE RESTAURANTES:solicitud Ajax
	=============================================*/
	static public function ctrMostrarListaRestaurantes($campoTabla, $valorCampoTabla){

		$tabla = "restaurantes";
		
		$respuesta = ModeloRestaurantes::mdlMostrarListaRestaurantes($tabla,$campoTabla, $valorCampoTabla);
		
		return $respuesta;		
	}
	/*=============================================
	FUNCION PARA MOSTRAR LA LISTA DE RESTAURANTES:solicitud Ajax
	=============================================*/
	static public function ctrMostrarRestsHotelTrabajo($datos)
	{

		$tabla = "restaurantes";

		$respuesta = ModeloRestaurantes:: mdlMostrarRestsHotelTrabajo($tabla, $datos);

		return $respuesta;
	}
	/*=============================================
	FUNCION PARA MOSTRAR LA LISTA DE RESTAURANTES:solicitud Ajax
	=============================================*/
	static public function ctrMostrarListaRestaurantesActivos($campoTabla, $valorCampoTabla)
	{
		$tabla = "restaurantes";

		$respuesta = ModeloRestaurantes:: mdlMostrarListaRestaurantesActivos($tabla, $campoTabla, $valorCampoTabla);

		return $respuesta;
	}
	/*=============================================
	FUNCION PARA traer el dato del RESTAURANTE por id:solicitud Ajax
	=============================================*/
	static public function ctrMostrarRestauranteByid($campoTabla, $valorCampoTabla){

		$tabla = "restaurantes";
		
		$respuesta = ModeloRestaurantes::mdlMostrarRestauranteById($tabla,$campoTabla, $valorCampoTabla);
		
		return $respuesta;		
	}
	/*=============================================
	REGISTRO DE RESTAURANTES 
	=============================================*/
	public function ctrRegistroRestaurante(){

		if (isset($_POST["hotelElige"])) {
			
			$tabla = "restaurantes";
			$estado = 1;	
			$datos = array("idHotel" =>$_POST["idHotelReg"],
						   "nombre" =>$_POST["regRestaurante"],
						   "especialidad" =>$_POST["regEspecialidad"],						   
						   "horarioCierre" =>$_POST["horarioCierre"],
						   "estado" =>$estado);

			$respuesta = ModeloRestaurantes::mdlRegistroRestaurante($tabla, $datos);

			if ($respuesta == "OK"){

					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡EL registro del restaurante, fue exitoso!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="restaurantes"
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
										   window.location="restaurantes"
									  	}
								});
							</script>';
			}
		}
	}
	/*=============================================
	FUNCION PARA EDITARL AL USUARIO EN EL MODAL
	=============================================*/
	public function ctrEditarRestaurante(){
		
		if (isset($_POST["editarNombre"])) {//SI EDITAR NOMBRE VIENE LLENO 

			$tabla = "restaurantes";
			
			$datos = array("id" =>$_POST["idRstrntEditar"],
						   "nombre" =>$_POST["editarNombre"],
						   "especialidad" =>$_POST["editarEspecialidad"],
						   "horarioCierreEdit" =>$_POST["horarioCierreEdit"],
						   "estado" =>$_POST["estadoRestaurante"]);

				//LLAMO AL MODELO QUE HACE EL UPDATE
			$respuesta = ModeloRestaurantes::mdlEditarRestaurante($tabla, $datos);

			if ($respuesta == "OK"){
					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡La modificacion del restaurante, fue exitoso!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="restaurantes"
								  	}
							});
						</script>';
			}	 
		}		
	}
	/*=============================================
	FUNCION PARA ELIMINAR EL HOTEL
	=============================================*/
	public function ctrBorrarRestaurante(){
 
		if (isset($_GET["idRestaurante"])) {
			
			$tabla = "restaurantes";
			$tablaReservas="reservas";
			$tablaSeatings= "seatings";

			$datos = $_GET["idRestaurante"];

			//borro seatings, reservas, ligadas a este restaurante	
			ModeloSeatings:: mdlBorrarSeatingsRestaurante($tablaSeatings, $datos);
			ModeloReservas::mdlEliminarReservasRestaurante($tablaReservas, $datos);
			//borro el restaurante
			$respuesta = ModeloRestaurantes::mdlEliminarRestaurante($tabla, $datos);

			if ($respuesta == "OK"){

						echo '
							<script>
								swal({
									  title: "¡OK!",
									  text: "¡EL restaurante se ha borrado exitosamente!",
									  type:"success",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
									  },
									function(isConfirm){

										if(isConfirm){
										   window.location="restaurantes"
									  	}
								});
							</script>';
				}
		}
	}
		
}


