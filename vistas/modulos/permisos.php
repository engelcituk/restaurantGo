<?php 
  if($_SESSION["C-HOTELES"]==1||$_SESSION["C-USUARIOS"]==1||$_SESSION["C-RESTAURANTES"]==1||$_SESSION["C-SEATINGS"]==1||$_SESSION["C-TICKETS"]==1||$_SESSION["C-RSVXESTANCIA"]==1||$_SESSION["C-IMPRESORAS"]==1){
 ?>
<!-- =============================================== --> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gestor Permisos
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fas fa-key"></i> Configuración</a></li>
        <li class="active">Permisos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-success">
        <div class="box-header with-border">
          <!-- <h3 class="box-title">Title</h3> -->

          <!-- <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div> -->
          <div class="row">  
              <div class="col-md-4 col-xs-12">
                <a href="#" class="btn btn-success btn-flat" data-toggle="modal" data-target="#nuevoPermiso"><i class="fa fa-plus"></i> Nuevo Permiso</a> 
              </div>                              
                                     
          </div>
        </div>
        <div class="box-body">
          <!-- Tabla de reservas -->
          <div id="permisos" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <div>
            <table id="tblCrudPermisos" class="table table-striped dt-responsive nowrap">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Permiso para</th>                                    
                  <th>Herramientas</th>
                  <th></th>

                </tr>
              </thead>
              <tbody>
                <!-- aqui va mis consultas en un datatable -->
                <?php 
                  
                  $respuesta = ControladorPermisos::ctrMostrarListaCompletaPermisos();
                  $contador=1;
                  foreach ($respuesta as $fila => $elemento) {                   
                  
                  echo '
                    <tr>
                        <td>'.$contador.'</td>
                        <td>'.$elemento["nombrePermiso"].'</td>';
                        
                        echo '<td>
                              <a href="#" class="btn btn-success editPermiso" data-toggle="modal" data-target="#editPermiso" nombrePermiso="'.$elemento["nombrePermiso"].'" idPermiso="'.$elemento["id"].'" style="pointer-events: none;"><i class="fa fa-edit"></i> </a>
                              
                              <button class="btn btn-danger eliminarPermiso" idPermiso="'.$elemento["id"].'" disabled><i class="fa fa-trash "></i></button>               
                        </td>
                        <td></td>
                    </tr>';
                $contador=$contador +1;
                }
              ?>
              
              </tbody>
            </table>        
            </div>
            </div>
          <!-- Fin tabla de config -->
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          Footer
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

    <!-- =============================================
  MODAL PARA REGISTRAR UN NUEVO PERMISO
  =============================================-->
<div id="nuevoPermiso" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fas fa-edit"></i> Registrar nuevo permiso</h4>
      </div>
      <div class="modal-body">
        <div class="register-box-body">              
          <form method="post">                                            
            <div class="row">              
              <div class="col-md-12 col-xs-12">
                <label for="usr">Nombre del permiso</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-key"></i></div>
                  <input type="text" class="form-control nombrePermiso" id="regNombrePermiso" name="regNombrePermiso" minlength="5" required>
                </div>
              </div>
            </div><br>
            <div id="nombreValidoMensaje"></div>                            
            <div class="row">
              <div class="col-xs-4">
                <div class="checkbox icheck">
                  <label>
                  <a href="permisos" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo "></i> Descartar</a> 
                  </label>
                </div>
              </div>
              <div class=" col-sm-offset-4 col-xs-4">
                <div class="checkbox icheck">
                  <button type="submit" id="btnPermisoGuardar" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-save"></i> Guardar
                  </button>
                </div>
              </div>                   
            </div>                    
          </form>
          <?php 
            $registrarPermiso = new ControladorPermisos();
            $registrarPermiso->ctrRegistrarPermiso();
          ?>               
        </div>
      </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
    </div>

  </div>
</div>
<!--===== MODAL PARA REGISTRAR UN NUEVO PERMISO======-->
<!-- =============================================
  MODAL PARA EDITAR UN PERMISO
  =============================================-->
<div id="editPermiso" class="modal fade" role="dialog">
  <div class="modal-dialog">
<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fas fa-edit"></i> Editar Permiso</h4>
      </div>
      <div class="modal-body">
<!--======   FORMULARIO PARA EDITAR la impresora ==-->
        <div class="register-box-body">              
          <form method="post">                    
            
            <div class="row">
              <div class="col-md-12 col-xs-12">
                  <h4 id="nombrePermisoImpresora"></h4>
                  <ul class="list-group">                    
                    <li class="list-group-item"><strong>Nombre Actual Permiso: </strong><span id="nombrePermisoSpan"></span></li>                                    
                  </ul>                
              </div>                                     
            </div>
            <div class="row hidden">
              <div class="col-md-12 col-xs-12 ">
                <div class="form-group">
                    <label for="usr">idPermiso</label>
                    <input type="number" class="form-control" id="idPermisoEdit" name="idPermisoEdit" readonly>
                </div>
              </div>
            </div>
            <div class="row">                                                                     
              <div class="col-md-12 col-xs-12">
                <label for="usr">Nuevo Nombre Permiso</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-key"></i></div>
                  <input type="text" class="form-control nombrePermiso" id="nuevoNombrePermiso" name="nuevoNombrePermiso" minlength="5" required>
                </div>
              </div>            
            </div><br><span id="rowEditarPermiso"></span>              
            <div class="row">
              <div class="col-xs-4">
                <div class="checkbox icheck">
                  <label>
                  <a href="permisos" class="btn btn-warning btn-block btn-flat" ><i class="fa fa-undo "></i> Descartar</a> 
                  </label>
                </div>
              </div>
              <div class=" col-sm-offset-4 col-xs-4">
                <div class="checkbox icheck">
                  <button type="submit" id="btnNuevoPermisoEdit" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-save"></i> Guardar
                  </button>
                </div>
              </div>                   
            </div>                    
          </form>
          <?php 
            $editarPermiso = new ControladorPermisos();
            $editarPermiso->ctrEditarPermiso();
          ?>               
        </div>
      </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
    </div>

  </div>
</div>
<!--===== FIN DEL MODAL PARA EDITAR UN PERMISO======-->
  <?php 
    $borrarPermiso = new ControladorPermisos();
    $borrarPermiso->ctrEliminarPermiso();
}
  else{
    require "sinAcceso.php";
}
?>
  <!-- /.content-wrapper -->
 <script src="vistas/plugins/datatable/script.js"></script>