<?php 
class ControladorImpresoras{

	/*=============================================
	TRAIGO LISTA DE HOTELES--Para ocupar en mi lista select
	=============================================*/
	public function ctrListaDeHotelesSelect(){
		
		$tabla = "permisoshotel";
		$valorDeMiCampo = $_SESSION["id"]; //EL id del usuario

		$respuesta = ModeloUsuarioPermisos::mdlMostraPermisosHotelUsuario($tabla, $valorDeMiCampo);

		foreach ($respuesta as $fila => $elemento){
        	echo '<option idhotelLstPrinter='.$elemento["idHotel"].'>'.$elemento["nombrePermisoHotel"].'</option>';
        }
	} 

	/*=============================================
	TRAIGO LA LISTA DE IMPRESORAS DE IMPRESORAS DISPONIBLES
	EN UNA LISTA DESPLEGABLE DE TIPO  select
	=============================================*/
	public function ctrListaDeImpresoras(){
		$tabla = "ticketimpresoras";
	
		$respuesta = ModeloImpresoras::mdlListaDeImpresoras($tabla);

		foreach ($respuesta as $row => $item){
			echo
				' 
			<option termica="' . $item["termica"] . '" value="'.$item["direccionIP"].'">'.$item["nombreImpresora"].'</option>         
			';
		}
	}

	/*============================================= 
	TRAIGO TODA LA LISTA DE impresoras OCUPADO EN EL MODULO
	impresoras---para cargar en el datatable
	=============================================*/
	static public function ctrMostrarListaCompletaImpresoras($campoTabla,$valorCampoTabla){

		$tabla = "ticketimpresoras";
		
		$respuesta = ModeloImpresoras::mdlMostrarListaCompletaImpresoras($tabla,$campoTabla,$valorCampoTabla);
		
		return $respuesta;	 	
	}
	/*=============================================
	FUNCION PARA ELIMINAR LA IMPRESORA
	=============================================*/
	public function ctrEliminarImpresora(){

		if (isset($_GET["idImpresora"])) {
			
			$tabla = "ticketimpresoras";
			$datos = $_GET["idImpresora"];

			$respuesta = ModeloImpresoras::mdlEliminarImpresora($tabla, $datos);

			if ($respuesta == "OK"){
				echo '
					<script>
						swal({
							title: "¡OK!",
							text: "¡La impresora se ha borrado exitosamente!",
							type:"success",
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
							},
							function(isConfirm){
								if(isConfirm){
									window.location="impresoras"
									}
							});
					</script>';
			}
		}
	}
	/*=============================================
	REGISTRO DE IMPRESORAS
	=============================================*/
	public function ctrRegistrarImpresora(){

		if (isset($_POST["idHotelImpresora"])) {
			
			$tabla = "ticketimpresoras";
			$estado = 1;
			//pregmatch para validar una ip :)
			if (preg_match('/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/', $_POST["regIpImpresora"])) {					
			$datos = array("idHotel" =>$_POST["idHotelImpresora"],
						   "direccionIp" =>$_POST["regIpImpresora"],
						   "nombreImpresora" =>mb_strtoupper($_POST["regNombreImpresora"],'UTF-8'),   
						   "estado" =>$estado,
						   "termica" => $_POST["termica"]);

			$respuesta = ModeloImpresoras::mdlRegistrarImpresora($tabla, $datos);
			

				if ($respuesta != "ERROR"){

					echo '
						<script>
							swal({
								title: "¡OK!",
								text: "EL registro de la impresora, fue exitosa",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
								},
								function(isConfirm){
									if(isConfirm){
										window.location="impresoras"
									}
							});
					</script>';
					}
			}else
				{
				 echo '
				<script>
					swal({
						title: "Error",
						text: "¡Formato de IP incorrecta!",
						type:"error",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						},
						function(isConfirm){
						 if(isConfirm){
							window.location="impresoras"
						}
					});
				</script>';
			}
		}
	}

	/*=============================================
	EDICION DE IMPRESORAS
	=============================================*/
	public function ctrEditarImpresora(){

		if (isset($_POST["idImpresoraEdit"])) {
			
			$tabla = "ticketimpresoras";			
			//pregmatch para validar una ip :)
			if (preg_match('/\b(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b/', $_POST["nuevaDireccionIP"])) {
								
			$datos = array("idImpresora" =>$_POST["idImpresoraEdit"],
						   "direccionIp" =>$_POST["nuevaDireccionIP"],
						   "nombreImpresora" =>strtoupper($_POST["nuevoNomImpresora"]),
						   "termica" => $_POST["termicaEditar"]);

			$respuesta = ModeloImpresoras::mdlEditarImpresora($tabla, $datos);
				
				if ($respuesta == "OK"){
					echo '
						<script>
							swal({
								title: "¡OK!",
								text: "¡La modificación de la impresora, fue exitosa!",
								type:"success",
								confirmButtonText: "Cerrar",
								closeOnConfirm: false
								},
								function(isConfirm){
									if(isConfirm){
										window.location="impresoras"
									}
							});
					</script>';
					}
			}else
				{
				 echo '
				<script>
					swal({
						title: "Error",
						text: "¡Formato de IP incorrecta!",
						type:"error",
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						},
						function(isConfirm){
						 if(isConfirm){
							window.location="impresoras"
						}
					});
				</script>';
			}
		}
	}
}