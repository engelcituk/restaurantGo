<?php

class ControladorReservas{

	/*=============================================
	TRAIGO LISTA DE HOTELES 
	=============================================*/
	public function ctrTraerListaDeHoteles(){
		$tabla = "hoteles";
	
		$respuesta = ModeloReservas::mdlTraerListaDeHoteles($tabla);

		foreach ($respuesta as $row => $item){
			echo 
			'
			<option nombreHotel="'.$item["nombre"].'" value="'.$item["id"].'">'.$item["nombre"].'</option>

			';
		}
	} 
	/*=============================================
	TRAIGO LISTA DE HOTELES--Para ocupar en un dropdown
	=============================================*/
	public function ctrListaDeHotelesDropdown(){
		$tabla = "hoteles";
	
		$respuesta = ModeloReservas::mdlTraerListaDeHoteles($tabla);

		foreach ($respuesta as $fila => $elemento){
        	echo '<li class="lstHotelCrud" nombreHotel="'.$elemento["nombre"].'" idHotelRep="'.$elemento["id"].'"><a href="#">'.$elemento["nombre"].'</a></li>';
        }
	}
	/*=============================================
	TRAIGO LOS DATOS DEL RESTAURANTE
	=============================================*/
	public function ctrMostrarDatosRestaurante(){
		$tabla = "restaurantes";
	
		$respuesta = ModeloReservas::mdlMostrarDatosRestaurante($tabla);

		foreach ($respuesta as $row => $item){
			echo 
			'
			<h1> Reservas: '.$item["nombre"].'</h1>
			<input type="text" class="form-control hidden" id="idRestaurante" name="idRestaurante" value="'.$item["id"].'">

			';
		}
	}
	/*=============================================
	TRAIGO EL TOTAL DE FECHAS PARA HACER RESERVAS 
	=============================================*/
	public function ctrContadorDeFechasDisponibles(){
		$tabla = "controlreservas";
	
		$respuesta = ModeloReservas::mdlContadorDeFechasDisponibles($tabla);

		foreach ($respuesta as $row => $item){
			echo 
			'
			<input type="text" value="'.$item[0].'" totalFechas="'.$item[0].'">
            
			';
		}
	}

	/*=============================================
	TRAIGO LAS MESAS DISPONIBLES PARA LAS RESERVAS
	=============================================*/
	public function ctrMostrarMesasElRiviera(){
		$tabla = "mesas";
	
		$respuesta = ModeloReservas::mdlMostrarMesas($tabla);

		foreach ($respuesta as $row => $item){
			echo 
			'
			<option value="'.$item["numMesa"].'">Mesa No. '.$item["numMesa"].' Cap. '.$item["capacidad"].'</option>
            
			';
		}
	}


	/*=============================================
	TRAIGO LA LISTA DE RESERVAS 
	=============================================*/
	public function ctrListaDeReservas(){
		$tabla = "reservas";
	
		$respuesta = ModeloReservas::mdlListaDeReservasHotel($tabla);

		foreach ($respuesta as $row => $item){
			echo 
			'
			<tr>
                  <td>'.$item["fechaDeLaReserva"].'</td>
                  <td>'.$item["apellido"].'</td>
                  <td>'.$item["pax"].'</td>
                  <td>'.$item["numeroMesa"].'</td>
                  
                  <td>'.$item["hora"].'</td>
                  
                  <td>'.$item["estado"].'</td>
                  <td>
                    <button class="btn btn-primary mostrarTicket" idReserva="'.$item["id"].'" data-toggle="modal" data-target="#imprimirTicket"><i class="fa fa-print"></i></button>
                  </td>
                  <td>
                    <button class="btn btn-success"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
                  </td>
                  <td></td>
            </tr>
            
			';
		}
	}
	/*=============================================
	TRAIGO LISTA DE RESTAURANTES DE ACUERDO AL ID idHotel QUE AJAX envía
	=============================================*/
	static public function ctrObtnerListaDeRestaurantes($campoDemiTabla,$valorDeMiCampo){
		$tabla = "restaurantes";
	
		$respuesta = ModeloReservas::mdlObtnerListaDeRestaurantes($tabla,$campoDemiTabla,$valorDeMiCampo);
		//tabla restaurantes, campoDemiTabla=idHotel $campoDemiTabla=valor de id
		return $respuesta;
		
	}
	/*=============================================
	TRAIGO LOS DATOS DE LA RESERVA POR id LO OCUPO DESDE AJAX
	=============================================*/
	static public function ctrObtenerDatoReserva($item,$valor){
		$tabla = "reservas";
	
		$respuesta = ModeloReservas::mdlObtenerDatoReserva($tabla,$item,$valor);
		//tabla reservas, item=id $valor=valor de id-->mdlObtenerDatoReserva("reservas", id, 7)
		return $respuesta;
		
	}	
	/*=============================================
	PARA OBTENER LAS MESAS DISPONIBLEs: solicitud ajax
	=============================================*/
	static public function ctrObtenerListaDeMesasDisponibles($campoDemiTabla, $valorDeMiCampo){

		$tabla= "mesas";

		$respuesta = ModeloReservas::mdlObtenerListaDeMesasDisponibles($tabla,$campoDemiTabla, $valorDeMiCampo);
		//tabla mesas, campoDemiTabla=idRestaurante $valorDeMiCampo=1)

		return $respuesta;
	}

	/*=============================================
	PARA VERIFICAR QUE EL HUESPED PUEDA HACER RESERVA: solicitud ajax
	=============================================*/
	static public function ctrValidarPoderHacerReserva($campoDemiTabla, $valorDeMiCampo){
 
		$tabla= "reservas";

		$respuesta = ModeloReservas::mdlValidarPoderHacerReserva($tabla,$campoDemiTabla, $valorDeMiCampo);
		//tabla reservas, campoDemiTabla=reservaIdentificador $valorDeMiCampo=RCAW18025604-01)

		return $respuesta;
	}
	/*=============================================
	PARA PROCESAR LOS DATOS DE LA RESERVA
	=============================================*/
	public function ctrRealizarLaReserva(){

	if (isset($_POST["fechaReserva"])) {

		$numReservasMax=$_POST["numReservasMax"];
		$numDePaxMaxima=$_POST["numDePaxMaxima"];
		$sinLimites="sin limites";
		$totalReservasHechas=$_POST["totalReservasHechas"];
		$totalPaxAcumulados=$_POST["totalPaxAcumulados"];		
		$numeroDePax = $_POST["numeroDePax"];
		$paxLimiteRestaurante = $_POST["paxLimiteRestaurante"]; 
		$valorReservaPorHacer= 1;

		$paxTotDeLaRsv=$totalPaxAcumulados+$numeroDePax;
		// $reservaTotal=$totalReservasHechas+$valorReservaPorHacer;

		$tabla = "reservas";
		$estado=1;
		$origen="HOTEL";
		$datos = array(
					   "fechaReserva" =>$_POST["fechaReserva"],
					   "reservaIdentificador" =>$_POST["reserva"],
					   "idHotel" =>$_POST["idHotel2"],
						 "idRestaurante" =>$_POST["idRestaurante2"],
						 "fechaLimiteRSV" =>$_POST["fechaMaximaRSV"],
					   "nombreRestaurante" =>$_POST["campoNombreRestaurante"],
					   "apellido" =>$_POST["apellido"],
					   "horario" =>$_POST["horarioReserva"],					  
					   "estado" =>$estado,
					   "origen"=>$origen,
					   "usuario"=> $_SESSION["nombreDeUsuario"],
					   "habitacion" =>$_POST["numHabitacion"],
					   "pax" =>$_POST["numeroDePax"],					   
					   "ticket" =>$_POST["ticketElige"],
					   "observaciones" =>$_POST["observaciones"]
					);
			
					$rsvFechaTicket= $datos["fechaReserva"];
					$rsvHoraTicket= $datos["horario"]; 
					$rsvIdentificadorTicket= $datos["reservaIdentificador"];
					$rsvApellidoTicket= $datos["apellido"];
					$rsvHabitacionTicket= $datos["habitacion"];
					$rsvPaxTicket= $datos["pax"];
					//$rsvMesaTicket= $datos["numeroMesa"];
					$rsvRestauranteTicket= $datos["nombreRestaurante"];
					$rsvIdiomaTicket= $datos["ticket"];

			if ( $paxTotDeLaRsv > $numDePaxMaxima && $numDePaxMaxima !=  $sinLimites) {
				echo '
					<script>
					event.preventDefault();
						swal({
								title: "¡Error!",
								text: "Se ha alcanzado el limite de pax que puede cubrir para esta hora",
								type:"error",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
								},
							function(isConfirm){
								if(isConfirm){
									return false;
								}
						});					
					</script>';
			} else {				

				$respuesta = ModeloReservas::mdlRegistrarReserva($tabla, $datos);

				if ($respuesta == "OK"){
					$horaReserva = substr($rsvHoraTicket, 0, 8);
					echo '
						<script>
							$(document).ready(function()
							   {
							      $("#ticketImpresora").modal("show");

							      $("#reservaFecha").val("'.$rsvFechaTicket.'");
							      $("#reservaHora").val("'.$horaReserva.'");
							      $("#reservaHotel").val("'.$rsvIdentificadorTicket.'");
							      $("#reservaApellido").val("'.$rsvApellidoTicket.'");
							      $("#reservaHabitacion").val("'.$rsvHabitacionTicket.'");
							      $("#reservaPax").val("'.$rsvPaxTicket.'");							      
							      $("#nombreRestauranteTicket").val("'.$rsvRestauranteTicket.'");
							      $("#reservaTicket").val("'.$rsvIdiomaTicket.'");

							   });
						</script>';
				}else {
					echo '
						<script>
							swal({
								  title: "¡Error!",
								  text: "No se pudo realizar la reserva",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="hacer-reservas"
								  	}
							});
						</script>';
				}							
			}			
		}
	}
	/*=============================================
	PARA PROCESAR LOS DATOS DE LA RESERVA
	de un cliente Externo
	=============================================*/
	public function ctrRealizarLaReservaExternos(){

		if (isset($_POST["nombreCompleto"])) {
				
			$numDePaxMaxima=$_POST["numDePaxmAximo"];						
			$totalPaxAcumulados=$_POST["sumaPaxExternos"];
			$sinLimites="sin limites";	
			$numeroDePax = $_POST["paxExternos"];			
	
			$paxTotDeLaRsv=$totalPaxAcumulados+$numeroDePax;			
	
			$tabla = "reservas";
			$estado=1;
			$origen="EXTERNO";
			
			$datos = array(
						   "fechaReserva" =>$_POST["fechaReservaExternos"],
						   "reservaIdentificador" =>$_POST["rsvExternos"],
						   "idHotel" =>$_POST["idHotelExterno"],
						   "idRestaurante" =>$_POST["idRestauranteEx"],
						   "nombreRestaurante" =>$_POST["restauranteNombreExternos"],
						   "apellido" =>strtoupper($_POST["nombreCompleto"]),
						   "horario" =>$_POST["horarioReservaExternos"],					  
						   "estado" =>$estado,
						   "origen"=>$origen,
						   "usuario"=> $_SESSION["nombreDeUsuario"],
						   "habitacion" =>$_POST["habitacionExternos"],
						   "pax" =>$_POST["paxExternos"],					   
						   "ticket" =>$_POST["ticketEligeExternos"],
						   "observaciones" =>$_POST["observacionesExterno"]
						);
				
						$rsvFechaTicket= $datos["fechaReserva"];
						$rsvHoraTicket= $datos["horario"];
						$rsvIdentificadorTicket= $datos["reservaIdentificador"];
						$rsvApellidoTicket= $datos["apellido"];
						$rsvHabitacionTicket= $datos["habitacion"];
						$rsvPaxTicket= $datos["pax"];						
						$rsvRestauranteTicket= $datos["nombreRestaurante"];
						$rsvIdiomaTicket= $datos["ticket"];
	
				if ($paxTotDeLaRsv > $numDePaxMaxima && $numDePaxMaxima !=  $sinLimites  ) {
					echo '
						<script>
							swal({
									title: "¡Error!",
									text: "Se ha alcanzado el limite de pax que puede cubrir para esta hora",
									type:"error",
									confirmButtonText: "Cerrar",
									closeOnConfirm: false
									},
								function(isConfirm){
									if(isConfirm){
										window.location="hacer-reservas"
									}
							});
						</script>';
				} else {				
					$respuesta = ModeloReservas::mdlRegistrarReserva($tabla, $datos);
	
					if ($respuesta == "OK"){
						$horaReserva = substr($rsvHoraTicket, 0, 8);							
						echo '
							<script>
								$(document).ready(function()
								   {
									  $("#ticketImpresora").modal("show");
	
									  $("#reservaFecha").val("'.$rsvFechaTicket.'");
									  $("#reservaHora").val("'.$horaReserva.'");
									  $("#reservaHotel").val("'.$rsvIdentificadorTicket.'");
									  $("#reservaApellido").val("'.$rsvApellidoTicket.'");
									  $("#reservaHabitacion").val("'.$rsvHabitacionTicket.'");
									  $("#reservaPax").val("'.$rsvPaxTicket.'");							      
									  $("#nombreRestauranteTicket").val("'.$rsvRestauranteTicket.'");
									  $("#reservaTicket").val("'.$rsvIdiomaTicket.'");
	
								   });
							</script>';
					}							
				}			
			}
		}
	/*=============================================
	FUNCION PARA ELIMINAR una reserva
	=============================================*/
	public function ctrBorrarReserva(){

		if (isset($_GET["idReserva"])) {
			
			$tabla = "reservas";
			$datos = $_GET["idReserva"];

			$respuesta = ModeloReservas::mdlEliminarReserva($tabla, $datos);

			if ($respuesta == "OK"){

						echo '
							<script>
								swal({
									  title: "¡OK!",
									  text: "¡La reserva se ha borrado exitosamente!",
									  type:"success",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
									  },
									function(isConfirm){

										if(isConfirm){
										   window.location="administrar-reservas"
									  	}
								});
							</script>';
				}
		}
	}

	
	/*=============================================
	FUNCION PARA MOSTRAR LA LISTA DE RESERVAS ocupado en el modulo
	administrar-reservas
	=============================================*/
	static public function ctrMostrarListaReservas($valorCampoTabla, $valorCampoTabla2){

		$tabla = "reservas";
		
		$respuesta = ModeloReservas::mdlListaDeReservas($tabla, $valorCampoTabla,$valorCampoTabla2);
		
		return $respuesta;		
	}
	/*=============================================
	FUNCION PARA EDITAR UNA RESERVA DE LA LISTA DE RESERVAS ocupado en el modulo
	administrar-reservas
	=============================================*/
	public function ctrEditarLaReserva(){

	if (isset($_POST["observaciones"])) {

		$idDeLaReserva=$_POST["idDeLaReserva"];

		$numReservasMax=$_POST["numReservasMax"];
		$numDePaxMaxima=$_POST["numDePaxMaxima"];

		$totalReservasHechas=$_POST["totalReservasHechas"];
		$totalPaxAcumulados=$_POST["totalPaxAcumulados"];

		$numeroDePaxCampo = $_POST["nuevoPax"];
		$valorReservaPorHacer= 1;

		$paxTotDeLaRsv=$totalPaxAcumulados+$numeroDePaxCampo;
		$reservaTotal=$totalReservasHechas+$valorReservaPorHacer;

				
			if ($paxTotDeLaRsv > $numDePaxMaxima ) {
				echo '
				<script>
					swal({
						title: "¡Error!",
						text: "Se ha alcanzado el limite de pax/reservas que puede cubrir para esta hora",
						type:"error",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						},
							function(isConfirm){
								if(isConfirm){
									window.location="administrar-reservas"
							}
					});
				</script>';
			} else {

				if ($_POST["nuevoRestaurante"]=="" ||$_POST["nuevaFecha"] =="" || $_POST["horarioReserva"]==""|| $_POST["nuevoPax"]=="") {
					//si campos de nueva fecha, horario, nuevo pax son vacios.. tomo los datos de los campos que trae la consulta	
					$nombreRestaurante=$_POST["nombreRestaurante"];		
					$fechaReserva=$_POST["fechaDeLaReserva"];
					$horarioReserva=$_POST["hora"];
					$numeroDePax=$_POST["pax"];
				} else {
					// sino tomo los valores de los campos que se activan
					$nombreRestaurante=$_POST["nuevoRestaurante"];
					$fechaReserva=$_POST["nuevaFecha"];
					$horarioReserva=$_POST["horarioReserva"];
					$numeroDePax=$_POST["nuevoPax"];
				}

				$tabla = "reservas";	
				$datos = array(
					   "id"=>$idDeLaReserva,
					   "nombreRestaurante"=>$nombreRestaurante,
					   "usuario"=> $_SESSION["nombreDeUsuario"],					   
					   "fechaReserva" =>$fechaReserva,					   
					   "nuevaHora" => $horarioReserva,
					   "pax" =>$numeroDePax,					  					  
					   "observaciones" =>$_POST["observaciones"]
					);
				
				$respuesta = ModeloReservas::mdlEditarLaReserva($tabla, $datos);

				if ($respuesta == "OK"){
					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡Reserva guardada exitosamente!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="administrar-reservas"
								  	}
							});
						</script>';
				}else {
					echo '
						<script>
							swal({
								  title: "¡Error!",
								  text: "No se pudo realizar la reserva",
								  type:"error",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="administrar-reservas"
								  	}
							});
						</script>';
				}							
			}			
		}
	}
} 

