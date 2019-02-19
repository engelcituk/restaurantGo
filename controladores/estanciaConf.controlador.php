<?php

class ControladorReservaEstancia{
	/*=============================================
	TRAIGO LISTA DE HOTELES--Para ocupar en mi lista select
	=============================================*/
	public function ctrListaDeHotelesSelect(){
		$tabla = "hoteles";

		$respuesta = ModeloReservaEstancia::mdlTraerListaDeHoteles($tabla);

		foreach ($respuesta as $fila => $elemento){
        	echo '<option idhotelLstConfig='.$elemento["id"].'>'.$elemento["nombre"].'</option>';
        }
	}
	/*=============================================
	TRAIGO TODA LA LISTA DE CONFIGURACIONES/ESTANCIA OCUPADO EN EL MODULO
	config-reservas-estancia
	=============================================*/
	static public function ctrMostrarListaConfiguraciones($campoTabla, $valorCampoTabla){

		$tabla = "reservasporestancia";
		
		$respuesta = ModeloReservaEstancia::ctrMostrarListaConfiguraciones($tabla,$campoTabla, $valorCampoTabla);
		
		return $respuesta;		
	}
	/*=============================================
	FUNCION PARA EDITAR LA CONFIGURACION 
	RESERVAESTANCIA EN EL MODAL
	=============================================*/
	public function ctrEditarReservaEstancia(){
		
		if (isset($_POST["idRsvPorEstancia"])) {//SI EDITAR NOMBRE VIENE LLENO 
			$tabla = " reservasporestancia";			
			$datos = array("idRsvEstancia" =>$_POST["idRsvPorEstancia"],						   
						   "numMaxReservas" =>$_POST["numNuevoTotalRsvs"]);

			//LLAMO AL MODELO QUE HACE EL UPDATE
			$respuesta = ModeloReservaEstancia::mdlEditarReservaEstancia($tabla, $datos);

			if ($respuesta == "OK"){
					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡La modificacion del registro, fue exitoso!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="config-reservas-estancia"
								  	}
							});
						</script>';
				
			}	 
		}		
	}
	/*=============================================
	REGISTRO DE HOTELES
	=============================================*/
	public function ctrRegConfiguracionEstancia(){

		if (isset($_POST["idHotelNoches"])) {
			
			$tabla = "reservasporestancia";
			$estado = 1;	
			$datos = array("idHotel" =>$_POST["idHotelNoches"] ,
						   "nochesEstancia" =>$_POST["regNochesEstancia"],
						   "numeroMaxDeReservas" =>$_POST["regNuevoNumMaxRsvs"],
						   "estado" =>$estado);

			$respuesta = ModeloReservaEstancia::mdlRegConfiguracionEstancia($tabla, $datos);

			if ($respuesta == "OK"){

					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡EL registro de la configuración, fue exitosa!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="config-reservas-estancia"
								  	}
							});
						</script>';
			}
		}
	}
	/*=============================================
	FUNCION PARA ELIMINAR UNA CONFIGURACION DE RESERVAS
	POR NOCHE DE ESTANCIA
	=============================================*/
	public function ctrBorrarConfiguracionEstancia(){

		if (isset($_GET["idRsvEstancia"])) {
			
			$tabla = "reservasporestancia";
			$datos = $_GET["idRsvEstancia"];

			$respuesta = ModeloReservaEstancia::mdlBorrarConfiguracionEstancia($tabla, $datos);

			if ($respuesta == "OK"){
				echo '
					<script>
						swal({
							title: "¡OK!",
							text: "¡Se ha borrado exitosamente!",
							type:"success",
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
							},
							function(isConfirm){
								if(isConfirm){
									window.location="config-reservas-estancia"
								}
							});
					</script>';
			}
		}
	}
} 
 


