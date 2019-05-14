<?php 
class ControladorPermisosHotel{
	/*=============================================
	TRAIGO TODA LA LISTA DE permisoshotel OCUPADO EN EL MODULO
	usuarios---para cargar en el modal de nuevo usuario
	=============================================*/
	static public function ctrMostrarPermisosCheckboxesHoteles(){

		$tabla = "permisoshotel";
		
		$respuesta = ModeloPermisosHotel::mdlMostrarListaPermisosHoteles($tabla);

		echo '<div class="row">';
			foreach ($respuesta as $fila => $elemento) {                                     
	          echo '
				<div class="col-md-4 col-xs-6">
	            	<input type="checkbox" name="permisohotel[]" value="'.$elemento["idHotel"].'"> '.$elemento["nombrePermisoHotel"].'<br><br>
	            </div> ';                                                               
	        }
        echo '</div>';	
	}
	
	
}