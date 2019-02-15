  <!-- para desactivar el warning que me genera el foreach cuando le viene vacio
  GET id usuario -->
  <?php error_reporting(0); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Permisos del Usuario
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Configuración</a></li>
        <li class="active">Usuarios</li>
        <li class="active">Permisos</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Default box -->
      <div class="box box-info">

        <div class="box-header with-border">                  
          <div class="box-tools pull-right">
          </div>      
          <a href="usuarios" class="btn btn-warning btn-flat pull-right"><i class="fas fa-undo"></i> Descartar / Volver</a>
        </div>
        <div class="box-body">
          
            <?php
                if (isset($_GET["idUsuario"])) {                    
                    $idUsuario=$_GET["idUsuario"];
                    $nombreDeUsuario=$_GET["nomUsuario"];
                    } else {
                      $idUsuario =null;
                      $nombreDeUsuario=null;                      
                    }            
                //creo un arreglo para guardar los permisos que tiene ese usuario
                $valoresPermisos=array();
                //Traigo todo sobre la tabla usuario_permisos pasandole el paremtro idUsuario
                $respuestaUser = ControladorUsuarioPermisos::ctrMostrarPermisosUsuario();
                //con el foreach voy llenando el arreglo con el de los permisos
                foreach ($respuestaUser as $filaUser => $elementoUser) {
                //cargo el array $valoresPermisos con valores
                 array_push($valoresPermisos, $elementoUser["idPermiso"]);
                }
                //traigo todos los permisos en general
                $respuesta = ControladorPermisos::ctrPermisosCheckboxesParaEditar();

                 echo '<strong><h4> <span class="label label-success">Usuario: '.$nombreDeUsuario.'</span></h4></strong><br>';                   
                 echo'<div class="row">';

                     foreach ($respuesta as $fila => $elemento) {
                    /*con el foreach voy comprobando si $elemento["id"] existe en el array $valoresPermisos
                    si exite, marcho checkbox, sino dejo vacío*/
                     $check=in_array($elemento["id"], $valoresPermisos)?'checked':'';
                      echo '
                       <div class="col-md-4 col-xs-6">
                          <input type="checkbox" class="permisoCheck" name="permiso[]" '.$check.' value="'.$elemento["id"].'"> '.$elemento["nombrePermiso"].'<br><br>
                       </div> ';                                                               
                      }
                  echo '</div><hr>';
              ?>
                    <div class="row">
                      <button type="submit" attidUsuario="<?php echo $idUsuario;  ?>" class="btn btn-danger delNewPermisos btn-flat pull-right" style="margin:20px;" idUserEditPermisos="<?php echo $idUsuario; ?>"><i class="fas fa-save"></i> Guardar Permisos</button>
                                     
                    </div>
                    
                    <?php

                // $borraryNuevosPermisos = new ControladorUsuarioPermisos();
                // $borraryNuevosPermisos->ctrBorrarPermisosUsuario();

                $nuevosPermisos = new ControladorUsuarioPermisos();
                $nuevosPermisos->ctrRegistroNuevosPermisosUsuario();
           ?>
         
                           
        </div>
      </div>    
    </section>
  </div>

   
