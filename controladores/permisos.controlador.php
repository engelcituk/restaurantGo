<?php 
class ControladorPermisos{

/*=============================================
	TRAIGO TODA LA LISTA DE impresoras OCUPADO EN EL MODULO
	impresoras---para cargar en el datatable
	=============================================*/
	static public function ctrMostrarListaCompletaPermisos(){

		$tabla = "permisos";
		
		$respuesta = ModeloPermisos::mdlMostrarListaPermisos($tabla);
		
		return $respuesta;		
	}

	/*=============================================
	TRAIGO TODA LA LISTA DE impresoras OCUPADO EN EL MODULO
	impresoras---para cargar en el datatable
	=============================================*/
	static public function ctrMostrarPermisosTipoHotel(){

		$tabla = " permisoshotel";
		
		$respuesta = ModeloPermisos::mdlMostrarPermisosTipoHotel($tabla);
		
		foreach ($respuesta as $row => $item){
			echo 
			'
			<option idHotel="'.$item["idHotel"].'" value="'.$item["idHotel"].'">'.$item["nombrePermisoHotel"].'</option>

			';
		};	
	}
	/*=============================================
	TRAIGO TODA LA LISTA DE permisos OCUPADO EN EL MODULO
	impresoras---para cargar en el datatable
	=============================================*/
	static public function ctrMostrarPermisosCheckboxes(){

		$tabla = "permisos";
		
		$respuesta = ModeloPermisos::mdlMostrarListaPermisos($tabla);

		echo '<div class="row">';
			foreach ($respuesta as $fila => $elemento) {                                     
	          echo '
				<div class="col-md-4 col-xs-6">
	            	<input type="checkbox" name="permiso[]" value="'.$elemento["id"].'"> '.$elemento["nombrePermiso"].'<br><br>
	            </div> ';                                                               
	        }
        echo '</div>';	
	}
	/*=============================================
	TRAIGO TODA LA LISTA DE permisos OCUPADO EN EL MODULO
	impresoras---para cargar en el datatable
	=============================================*/
	static public function ctrPermisosCheckboxesParaEditar(){

		$tabla = "permisos";
		
		$respuesta = ModeloPermisos::mdlMostrarListaPermisos($tabla);

		return $respuesta;
			
	}

	/*=============================================
	FUNCION PARA ELIMINAR LA IMPRESORA
	=============================================*/
	public function ctrEliminarPermiso(){

		if (isset($_GET["idPermiso"])) {
			
			$tabla = "permisos";
			$datos = $_GET["idPermiso"];

			$respuesta = ModeloPermisos::mdlEliminarPermiso($tabla, $datos);

			if ($respuesta == "OK"){
				echo '
					<script>
						swal({
							title: "¡OK!",
							text: "¡El permiso se ha borrado exitosamente!",
							type:"success",
							confirmButtonText: "Cerrar",
							closeOnConfirm: false
							},
							function(isConfirm){
								if(isConfirm){
									window.location="permisos"
									}
							});
					</script>';
			}
		}
	}
	/*=============================================
	REGISTRO DE PERMISOS
	=============================================*/
	public function ctrRegistrarPermiso(){

		if (isset($_POST["regNombrePermiso"])) {
			
			$tabla = "permisos";
			$estado = 1;

			$datos = array("nombrePermiso" =>mb_strtoupper($_POST["regNombrePermiso"],'UTF-8'));

			$respuesta = ModeloPermisos::mdlRegistrarPermiso($tabla, $datos);

			if ($respuesta == "OK"){
					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡EL registro del permiso, fue exitoso!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){
									if(isConfirm){
									   window.location="permisos"
								  	}
							});
						</script>';
			}
		}
	}

	/*=============================================
	FUNCION PARA EDITARL PERMISO EN EL MODAL y guardar
	=============================================*/
	public function ctrEditarPermiso(){
		
		if (isset($_POST["idPermisoEdit"])) {//SI EDITAR NOMBRE VIENE LLENO 

			$tabla = "permisos";
			
			$datos = array("idPermiso" =>$_POST["idPermisoEdit"],
						   "nombrePermiso" =>$_POST["nuevoNombrePermiso"]);
				//LLAMO AL MODELO QUE HACE EL UPDATE
			$respuesta = ModeloPermisos::mdlEditarPermiso($tabla, $datos);

			if ($respuesta == "OK"){
					echo '
						<script>
							swal({
								  title: "¡OK!",
								  text: "¡La modificacion del permiso, fue exitoso!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								  },
								function(isConfirm){
									if(isConfirm){
									   window.location="permisos"
								  	}
							});
						</script>';
				
			}	 
		}		
	}
}