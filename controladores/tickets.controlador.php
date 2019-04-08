<?php 

class ControladorTicket{
	
	/*=============================================
	TRAIGO LISTA DE TICKET/IDIOMA DISPONIBLES
	EN MINIATURAS
	=============================================*/
	public function ctrTraerListaDeTicket(){
		
		$tabla = "tickets";
	
		$respuesta = ModeloTicket::mdlMostrarListaTickets($tabla);

		echo '<div class="row">';
			foreach ($respuesta as $row => $item){
				echo 
				'			 
		        <div class="col-xs-6 col-md-2">
			        <div class="small-box colorTickets ">
				        <div class="inner">
				            <h5><strong>'.$item["ticketTipo"].'</strong></h5>
				            <p>'.$item["encabezado"].'</p>
				        </div>
				        <div class="icon">
				            <i class="fas fa-language"></i>
						</div>
						<span data-toggle="modal" data-target="#verTicket" idTicket="'.$item["id"].'" class=" verTicket">
							<a  class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver Ticket"><i class="fas fa-eye"></i></a>
						</span>
						<span data-toggle="modal" idTicketEditar="'.$item["id"].'" data-target="#editarTicket" class="editarTicket">
							<a data-toggle="tooltip" class="btn btn-sm btn-primary" data-placement="top" title="Editar Ticket"><i class="fas fa-edit"></i></a>
						</span>';
				       if ($item["estado"]!=0) {
                         echo ' <a href="#" id="ticketEstado" class="btn btn-success btn-sm btnActivarTicket" idTicketEstado="'.$item["id"].'" estadoTicket="0" data-toggle="tooltip" data-placement="bottom" title="Desactivar Ticket"><i class="fas fa-check"></i></a>';
                        }else{
                          echo' <a href="#" id="ticketEstado" class="btn btn-warning btn-sm btnActivarTicket" idTicketEstado="'.$item["id"].'" estadoTicket="1" data-toggle="tooltip" data-placement="bottom" title="Activar Ticket"><i class="fas fa-ban"></i></a>';

                        }				            
			     echo' <a href="#" idTicketEliminar="'.$item["id"].'" class="btn btn-sm btn-danger eliminarTicket" data-toggle="tooltip" data-placement="top" title="Borrar Ticket"><i class="fas fa-trash-alt"></i></a>
			     </div>
		        </div>		   
				';
			}
		echo '</div>';
	}
	/*=============================================
	TRAIGO LISTA DE TICKET/IDIOMA DISPONIBLES
	EN MINIATURAS
	=============================================*/
	public function ctrTraerListaDeTicket2(){
		
		$tabla = "tickets";
	
		$respuesta = ModeloTicket::mdlMostrarListaTickets($tabla);

		echo '<div class="row">';
			foreach ($respuesta as $row => $item){
				$pieTicket =$item["pie"];
				
				
				echo 
				'		
		        <div class="col-xs-12 col-md-12">
			        <div class="well">
				        <div class="inner">
				            <h5><strong>'.$item["ticketTipo"].'</strong></h5>
				            <p>'.$item["encabezado"].'</p>
				            
				            <p>'.str_replace("\n", "<br>", $pieTicket).'</p>
				           
				        </div>				        				          
			     </div>
		        </div>		   
				';
			}
		echo '</div>';
	}
	// /*=============================================
	// TRAIGO LISTA DE TICKET/IDIOMA DISPONIBLES
	// PARA DESPLEGAR EN UNA LISTA DE TIPO
	// SELECT--Traigo los tickets activo
	// =============================================*/
	public function ctrTraerListaTicketsSelectOption(){
		$tabla = "tickets";
		$respuesta = ModeloTicket::mdlMostrarListaTicketsActivos($tabla);
			foreach ($respuesta as $row => $item){
				echo 
				'	<option value="'.$item["ticketTipo"].'">'.$item["ticketTipo"].'</option>		
		        '; 
		}
	}
	/*=============================================
	PARA CREAR UN NUEVO TICKET
	=============================================*/
	public function ctrRegistrarNuevoTicket(){

		if (isset($_POST["idioma"])) {
			
			$tabla = "tickets";
			$estado = 1;
			$idioma=strtoupper($_POST["idioma"]);
			$encabezado=strtoupper($_POST["encabezado"]);
			$pieDepagina=strtoupper($_POST["pieDePagina"]);
			$idHotel =$_POST["idHotel"];

			$datos = array("idioma" =>$idioma,
						   "encabezado" =>$encabezado,
							 "pieDePagina" =>$pieDepagina,
							 "idHotel"=> $idHotel,
						   "estado"=>$estado);

			$respuesta = ModeloTicket::mdlRegistrarNuevoTicket($tabla, $datos);

			if ($respuesta == "OK"){

					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡EL registro del Ticket, fue exitoso!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){

									if(isConfirm){
									   window.location="configuracion-tickets"
								  	}
							});
						</script>';
				}else				
				     {
						echo '
							<script>
								swal({
									  title: "Error",
									  text: "¡Error al registrar el Ticket",
									  type:"error",
									  confirmButtonText: "Cerrar",
									  closeOnConfirm: false
									  },
									function(isConfirm){

										if(isConfirm){
										   window.location="configuracion-tickets"
									  	}
								});
							</script>';
			}
		}
	}
	/*=============================================
	FUNCION PARA EDITARL EL TICKET EN EL MODAL
	=============================================*/
	public function ctrEditarTicket(){
		
		if (isset($_POST["idTicketModalEditar"])) {//SI EDITAR idTicketModalEditar VIENE LLENO 

			$tabla = "tickets";
			
			$datos = array("idTicket" =>$_POST["idTicketModalEditar"],
						   "encabezado" =>$_POST["headerModalEditar"],
						   "pie"=>$_POST["footModalEditar"]);

			//LLAMO AL MODELO QUE HACE EL UPDATE
			$respuesta = ModeloTicket::mdlEditarTicket($tabla, $datos);

			if ($respuesta == "OK"){
					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡La modificacion del Ticket, fue exitoso!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){
									if(isConfirm){
									   window.location="configuracion-tickets"
								  	}
							});
						</script>';
				
			}	 
		}		
	}
	/*=============================================
	FUNCION PARA ELIMINAR EL TICKET
	=============================================*/
	public function ctrEliminarTicket(){

		if (isset($_GET["idTicketEliminar"])) {
			
			$tabla = "tickets";
			$datos = $_GET["idTicketEliminar"];

			$respuesta = ModeloTicket::mdlEliminarTicket($tabla, $datos);

			if ($respuesta == "OK"){
				echo '
					<script>
						swal({
							title: "¡OK!",
							text: "¡EL Ticket se ha borrado exitosamente!",
							type:"success",
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
							},
							function(isConfirm){
								if(isConfirm){
									window.location="configuracion-tickets"
									}
							});
					</script>';
			}
		}
	}
}
