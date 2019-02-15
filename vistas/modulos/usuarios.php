<?php 
  if($_SESSION["CONFIGURACION"]==1){
 ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Lista de Usuarios
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Utilerías</a></li>
        <li class="active">Gestor Usuarios</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-success">
        <div class="box-header with-border">
          <a href="#" class="btn btn-success" data-toggle="modal" data-target="#nuevoUsuario"><i class="fa fa-plus"></i> Nuevo Usuario</a>
          <!-- <h3 class="box-title">Title</h3> -->

          <div class="box-tools pull-right">
            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button> -->
            <!-- <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button> -->
          </div>
        </div>
        <div class="box-body">
          <!-- Start creating your amazing application! -->
          <!-- Tabla de reservas -->
          <div id="Usuarios" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <div>
            <table id="tablaUsuarios" class="table table-striped dt-responsive nowrap">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Nombre</th>
                  <th>Nombre de usuario</th>
                 
                  <th>Estado</th>
                  <th>Herramientas</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              <?php 
                  $item = null;
                  $valor = null;
                  $usuarios = ControladorUsuarios::ctrMostrarListaUsuarios($item,$valor);
                  $contador=1;
                  // $usuarios = new ControladorUsuarios();
                  // $usuarios->ctrMostrarListaUsuarios();
                  foreach ($usuarios as $fila => $elemento) {
                    echo '
                    <tr id="'.$elemento["id"].'">
                        <td>'.$contador.'</td>
                        <td>'.$elemento["nombre"].'</td>
                        <td>'.$elemento["nombreDeUsuario"].'</td>';

                        if ($elemento["estado"]!=0) {

                          echo '<td><button class="btn btn-success btn-xs btnActivarUsuario" idUsuario="'.$elemento["id"].'" estadoUsuario="0">Activado</button></td>';
                        }else{
                          echo'<td><button class="btn btn-danger btn-xs btnActivarUsuario" idUsuario="'.$elemento["id"].'" estadoUsuario="1">Desactivado</button></td>';

                        }
                        echo '<td>                              
                               <a href="#" class="btn btn-success editarUsuario" data-toggle="modal" data-target="#editarUsuario" idUsuario="'.$elemento["id"].'" idUsuarioHotel="'.$elemento["id"].'"><i class="fa fa-edit"></i> </a>
                              
                              <button class="btn btn-danger eliminarUsuario" idUsuario="'.$elemento["id"].'"><i class="fa fa-trash "></i></button>               
                        </td>
                        <td></td>
                    </tr>';
                    $contador=$contador +1;
                }
              ?>
              </tbody>
            </table>

           <!--  <button class="btn btn-info pull-right" style="margin:20px;"><i class="fa fa-print"></i> Imprimir Usuarios</button> -->
            </div>

            </div>
          <!-- Fin tabla de reservas -->
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer">
          Footer
        </div> -->
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

  <!-- MODAL PARA EL REGISTRO DE UN NUEVO USUARIO -->
    <!-- Modal -->
      <div id="nuevoUsuario" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header modal-header-personalizado">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title"><i class="fas fa-edit"></i> Registrar Nuevo Usuario</h4>
            </div>
            <div class="modal-body">
              <div class="register-box-body">
                <!-- formulario -->
                  <form method="post" onsubmit="return registroUsuario()">
                    <div id="mnsjUsuarioMensajeError"></div>
                    <div class="row">
                      <div class="col-md-6 col-xs-12">
                          <strong>Nombre Completo</strong>
                          <div class="input-group has-feedback">
                            <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                            <input type="text" class="form-control" id="regUsuario" name="regUsuario" placeholder="Nombre Completo" required>
                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                         </div>
                      </div>
                      <div class="col-md-6 col-xs-12">
                        <strong>Nombre de Usuario</strong>
                        <div class="input-group has-feedback">
                          <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                          <input type="text" class="form-control" id="regNombreUsuario" name="regNombreUsuario" placeholder="Nombre de usuario" required>
                          <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                      </div>
                    </div><br><div id="mnsjUsuarioValido"></div>
                    <div class="row" id="rowPaswordMsj">
                      <div class="col-md-6 col-xs-12">
                         <strong>Contraseña</strong>
                          <div class="form-group has-feedback">                            
                            <input type="password" class="form-control" id="regPassword" name="regPassword" placeholder="Contraseña" min="6" max="10" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                          </div>
                      </div>
                      <div class="col-md-6 col-xs-12">
                         <strong>Repita la Contraseña</strong>
                          <div class="input-group has-feedback">                        
                            <span class="input-group-addon" id="basic-addon1"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="regPassword2" name="regPassword2" placeholder="Repetir Contraseña" min="6" max="10" required>
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                          </div>
                      </div>
                    </div>
                                         
                        <strong>Hoteles de trabajo</strong><hr>                 
                      <?php 
                        $mostrarPermisosHotel = new ControladorPermisosHotel();
                        $mostrarPermisosHotel->ctrMostrarPermisosCheckboxesHoteles();
                       ?>                        
                       <strong>Elige permisos para el usuario</strong><hr>                 
                      <?php 
                        $mostrarPermisos = new ControladorPermisos();
                        $mostrarPermisos->ctrMostrarPermisosCheckboxes();
                       ?> <hr>          
                      <div class="row">
                        <div class="col-xs-4">                                                      
                          <a href="usuarios" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo"></i> Descartar</a>                          
                        </div>
                        <!-- /.col -->
                        <div class="col-xs-4 col-lg-offset-4">
                          <!-- CREO UNA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL REGISTRO DEL USUARIO -->
                          <?php 
                            $registro = new ControladorUsuarios();
                            $registro->ctrRegistroUsuario();
                           ?>
                          <button type="submit" id="btnRegUsuario" class="btn btn-primary btn-block btn-flat validaCheck"><i class="fas fa-save"></i> Guardar</button>
                         
                        </div>
                        <!-- /.col -->
                      </div>
                  </form>
                <!-- fin de formulario -->
                </div>
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="fas fa-sign-in-alt"></i>Close</button>
            </div> -->
          </div>

        </div>
      </div>
    <!-- fIN DE MODAL PARA REGISTRO DE UN NUEVO USUARIO -->

  <!-- =============================================
  MODAL PARA EDITAR AL USUARIO
  =============================================-->
    <div id="editarUsuario" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header modal-header-personalizado">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"> <i class="fas fa-edit"></i> Editar el usuario</h4>
          </div>
          <div class="modal-body">
              <!--==========================================
              =   FORMULARIO PARA EDITAR EL USUARIO          =
              =============================================-->
                <div class="register-box-body">
                <!-- formulario -->
                  <form method="post">
                    <div class="form-group has-feedback">
                      <input type="text" class="form-control hidden" id="idUsuarioEditar" name="idUsuarioEditar">
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-xs-12">
                        <strong>Nombre Completo</strong>
                        <div class="input-group has-feedback">
                          <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                          <input type="text" class="form-control" id="editarNombre" name="editarNombre" required>
                          <span class="glyphicon glyphicon-user form-control-feedback"></span>
                        </div>
                      </div>                      
                    </div><br>
                    <div class="row">
                    <div class="col-md-6 col-xs-12">
                          <strong>Nombre De Usuario</strong>
                            <div class="input-group has-feedback">
                              <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                              <input type="text" class="form-control" id="editarNombreDeUsuario" name="editarNombreDeUsuario" required>
                              <span class="glyphicon glyphicon-user form-control-feedback"></span>
                            </div>
                      </div>                       
                       <div class="col-md-6 col-xs-12">
                         <strong>Nueva Contraseña</strong>
                          <div class="input-group has-feedback">
                            <span class="input-group-addon" id="basic-addon1"><i class="fas fa-key"></i></span>
                            <input type="password" class="form-control" id="editarPassword" name="editarPassword">
                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                            <input type="text" class="form-control hidden" id="passwordActual" name="passwordActual" value="">
                          </div>
                       </div>
                    </div>                   
                    <br>
                    <strong>Editar accesos  hotel</strong><hr>
                    <div id="listaChecksPermisosHotel">
                      
                    </div><br>

                    <strong>Editar los permisos</strong><hr>
                    <div id="listaChecksPermisos">
                      
                    </div><br>
                    
                    <hr>
                    <div class="row">
                      <div class="col-xs-4">
                        <div class="checkbox icheck">
                          <label>
                            <a href="usuarios" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo "></i> Descartar</a> 
                          </label>
                        </div>
                      </div>
                      <!-- /.col -->
                      <div class=" col-sm-offset-4 col-xs-4">
                        <div class="checkbox icheck">
                          <button type="submit" class="validaCheck btn btn-primary btn-block btn-flat "><i class="fas fa-save"></i> Guardar</button>
                      </div>
                      </div>
                      <!-- /.col -->
                    </div>
                  </form>

             <!--===== FIN DEL FORMULARIO PARA EDITAR EL USUARIO======-->
              <!-- AQUI VA LA INSTANCIA PARA LLAMAR AL CONTROLADOR EDITOR DEL USUARIO -->
                  <?php 
                    $editarUsuario = new ControladorUsuarios();
                    $editarUsuario->ctrEditarUsuario();

                  ?>
                <!--FIN DEL CONTROLADOR PARA EDITAR AL USUARIO -->
                </div>
          </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
        </div>

      </div>
    </div>
<!--===== FIN DEL MODAL PARA EDITAR EL USUARIO======-->
  <!-- para borrar al usuario -->
  <?php 
      $borrarUsuario = new ControladorUsuarios();
      $borrarUsuario -> ctrBorrarUsuario();
  }
  else{
    require "sinAcceso.php";
}
?>                                          
<script src="vistas/plugins/datatable/script.js"></script>
  

    
    
