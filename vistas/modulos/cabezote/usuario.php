
<!--=====================================
USUARIOS
======================================-->	
<?php
/*si no existe la variable de sesion el icono de bandera se le desaparece*/
  if($_SESSION["ICONO BANDERA"]==1){
	  echo '<li>
				<a href="#" data-toggle="control-sidebar"><i class="fas fa-flag"></i></a>
			</li>';
}
?>
<!-- user-menu -->

<li class="dropdown user user-menu">
	<!-- dropdown-toggle -->
	<a href="#" class="dropdown-toggle" data-toggle="dropdown">
	
		<img src="vistas/dist/img/sandos1.jpg" class="user-image" alt="User Image">
		
		<span class="hidden-xs"><?php echo $_SESSION["nombreDeUsuario"]; ?></strong></span>
		
		
	</a>
	<!-- dropdown-toggle -->

	<!-- dropdown-menu -->
	<ul class="dropdown-menu">

		<li class="user-header">
		
			<img src="vistas/dist/img/sandos1.jpg" class="img-circle" alt="User Image">

			<p>
			SANDOSHOTELS & RESORTS
			</p>
		
		</li>

		<li class="user-footer">
		
			<div class="pull-left">
				
				<!-- <a href="perfil" class="btn btn-default btn-flat">Perfil</a> -->			
			</div>			
			<div class="pull-right">
			
				<a href="salir" class="btn btn-warning btn-flat"><i class="fas fa-sign-out-alt"></i> Salir</a>
			</div>
		</li>

	</ul>
	<!-- dropdown-menu -->
</li>
<!-- user-menu -->
