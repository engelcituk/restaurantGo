<?php
 
class ControladorSeatings{
	/*=============================================
	TRAIGO LISTA DE HOTELES--Para ocupar en mi lista select
	=============================================*/
	public function ctrListaDeHotelesSelect(){
		$tabla = "hoteles";
		$respuesta = ModeloSeatings::mdlTraerListaDeHoteles($tabla);

		foreach ($respuesta as $fila => $elemento){
        	echo '<option idhotelLstSeating='.$elemento["id"].'>'.$elemento["nombre"].'</option>';
        }
	}

	/*=============================================
	TRAIGO TODA LA LISTA DE SEATINGS ocupado en el modulo 
	configuracion-seatings
	=============================================*/
	static public function ctrMostrarListaSeatings($campoTabla, $valorCampoTabla){

		$tabla = "seatings";
		
		$respuesta = ModeloSeatings::mdlMostrarListaSeatings($tabla,$campoTabla, $valorCampoTabla);
		
		return $respuesta;		
	}

	/*=============================================
	TRAIGO LOS DATOS DEL SEATING POR id LO OCUPO DESDE AJAX
	=============================================*/
	static public function ctrObtenerDatoSeating($item,$valor){
		$tabla = "seatings";
	
		$respuesta = ModeloSeatings::mdlObtenerDatoSeating($tabla,$item,$valor);
		//tabla reservas, item=id $valor=valor de id-->mdlObtenerDatoReserva("reservas", id, 7)
		return $respuesta;
		
	}

	/*=============================================
	FUNCION PARA GUARDA LOS DATOS AL
	 EDITAR EL SEATING EN EL MODAL
	=============================================*/
	public function ctrEditarSeating(){
		
		if (isset($_POST["numPaxEditar"])) {//SI EDITAR numPaxEditar VIENE LLENO 

			$tabla = "seatings";			
			$datos = array("idSeating" =>$_POST["idSeating"],
						   "paxMaximo" =>$_POST["numPaxEditar"],
						   "reservasMaximas" =>$_POST["numRsvEditar"]);
			//LLAMO AL MODELO QUE HACE EL UPDATE
			$respuesta = ModeloSeatings::mdlEditarSeating($tabla, $datos);
			if ($respuesta == "OK"){
				echo '
				<script>
					swal({
						title: "¡OK!",
						text: "¡La modificacion del Seating, fue exitoso!",
						type:"success",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						},
						function(isConfirm){
							if(isConfirm){
							window.location="configuracion-seatings"
							}
						});
				</script>';				
			}	 
		}		
	}
	/*=============================================
	FUNCION PARA TRAER LA LISTA DE HORARIOS Y DESPLEGARLOS
	EN EL MODAL
	=============================================*/
	public function ctrTraerCatalogoHorario(){

		$tabla = "catalogohoras";
		$respuesta = ModeloSeatings::mdlTraerCatalogoHorario($tabla);
		
		foreach ($respuesta as $fila => $elemento){
			$cadenaHora = $elemento["hora"];
            $cadenaHoraCorta =substr($cadenaHora, 0, 8);       	        
			echo '<option idSeating='.$elemento["id"].'>'.$cadenaHoraCorta.'</option>';      	
        }
       
	}
	/*=============================================
	REGISTRO DE HOTELES
	=============================================*/
	public function ctrRegistrarNuevoSeating(){

		if (isset($_POST["idHotelfield"])) {
			
			$tabla = "seatings";
			$estado = 1;
			$dia=1;
			// pongo 7 que son la cantidad de días de la semana
			while ($dia <= 7) {
				$datos = array("idHotel" =>$_POST["idHotelfield"],
						   "idRestaurante" =>$_POST["idRestaurantefield"],
						   "idDiaSemana" =>$dia,
						   "horaSeating" =>$_POST["catalogoHorarios"],
						   "pm" =>$_POST["numPaxModal"],
						   "rm" =>$_POST["numRSVModal"],
						   "estado" =>$estado);			
				$respuesta = ModeloSeatings::mdlRegistrarNuevoSeating($tabla, $datos);
				$dia++;
			}
			
			if ($respuesta == "OK"){

					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡EL registro del seating, fue exitoso!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="configuracion-seatings"
								  	}
							});
						</script>';
				}
		}
	}

} 
 

