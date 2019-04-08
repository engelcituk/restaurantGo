<?php 
if ($_SESSION["C-HOTELES"] == 1) {

  ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Lista de Hoteles
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Configuración</a></li>
            <li class="active">Gestor Hoteles</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box box-success">
            <div class="box-header with-border">
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#nuevoHotel"><i class="fa fa-plus"></i> Nuevo Hotel</a>
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
                <div id="hoteles" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div>
                        <table id="tablaHoteles" class="table table-striped dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Estado</th>
                                    <th>Herramientas</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $item = null;
                                $valor = null;
                                $hoteles = ControladorHoteles::ctrMostrarListaHoteles($item, $valor);
                                $contador = 1;
                                // $HOTELs = new ControladorHOTELs();
                                // $HOTELs->ctrMostrarListaHOTELs();
                                foreach ($hoteles as $fila => $elemento) {

                                  //corto la cadena de descripcion para que se acomode al datatable
                                  $cadenaDescripcion = $elemento["descripcion"];
                                  $cadenaDescCorta = substr($cadenaDescripcion, 0, 25);
                                  echo '
                    <tr idH="' . $elemento["id"] . '">
                        <td>' . $contador . '</td>
                        <td>' . $elemento["nombre"] . '</td>
                        <td>' . $cadenaDescCorta . '</td>';

                                  if ($elemento["estado"] != 0) {

                                    echo '<td><button class="btn btn-success btn-xs btnActivarHotel" idHotelEstado="' . $elemento["id"] . '" estadoHotel="0">Activado</button></td>';
                                  } else {
                                    echo '<td><button class="btn btn-danger btn-xs btnActivarHotel" idHotelEstado="' . $elemento["id"] . '" estadoHotel="1">Desactivado</button></td>';
                                  }
                                  echo '<td>
                              <a href="#" class="btn btn-success editarHotel" data-toggle="modal" data-target="#editarHotel" idHotelEditar="' . $elemento["id"] . '"><i class="fa fa-edit"></i> </a>
                              
                              <button class="btn btn-danger eliminarHotel" idHotelBorrar="' . $elemento["id"] . '" disabled><i class="fa fa-trash "></i></button>               
                        </td>
                        <td></td>
                    </tr>';
                                  $contador = $contador + 1;
                                }
                                ?>
                            </tbody>
                        </table>

                        <!--  <button class="btn btn-info pull-right" style="margin:20px;"><i class="fa fa-print"></i> Imprimir Hoteles</button>
            </div> -->

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

<!-- MODAL PARA EL REGISTRO DE UN NUEVO HOTEL -->
<!-- Modal -->
<div id="nuevoHotel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-personalizado">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-edit"></i> Registrar Nuevo Hotel</h4>
            </div>
            <div class="modal-body">
                <div class="register-box-body">
                    <!-- formulario -->
                    <form method="post">
                        <strong>Nombre Del Hotel</strong>
                        <div class="input-group has-feedback">
                            <span class="input-group-addon" id="basic-addon1"><i class="fas fa-hotel"></i></span>
                            <input type="text" class="form-control" id="nombreHotel" name="nombreHotel" placeholder="Nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Descripción:</label>
                            <textarea class="form-control" rows="3" id="descripcion" name="descripcion" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <a href="hoteles" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo"></i> Descartar</a>
                            </div>
                            <!-- /.col -->
                            <div class="col-xs-4 col-xs-offset-4">
                                <!-- CREO UNA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL REGISTRO DEL Hotel -->
                                <?php 
                                $registroHotel = new ControladorHoteles();
                                $registroHotel->ctrRegistroHotel();
                                ?>
                                <button type="submit" class="btn btn-primary btn-block btn-flat "><i class="fas fa-share-square"></i> Registrar</button>


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
<!-- fIN DE MODAL PARA REGISTRO DE UN NUEVO HOTEL -->

<!-- =============================================
  MODAL PARA EDITAR AL HOTEL
  =============================================-->
<div id="editarHotel" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-personalizado">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-edit"></i> Editar el Hotel</h4>
            </div>
            <div class="modal-body">
                <!--==========================================
              =   FORMULARIO PARA EDITAR EL HOTEL          =
              =============================================-->
                <div class="register-box-body">
                    <!-- formulario -->
                    <form method="post">
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control hidden" id="idhotelEditar" name="idhotelEditar">
                        </div>
                        <strong>Nombre del Hotel</strong>
                        <div class="input-group has-feedback">
                            <span class="input-group-addon" id="basic-addon1"><i class="fas fa-hotel"></i></span>
                            <input type="text" class="form-control" id="editarNombre" name="editarNombre" placeholder="nombre" required>
                        </div>
                        <div class="form-group has-feedback">
                            <input type="text" class="form-control hidden" id="estadoHotel" name="estadoHotel" placeholder="nombre" required>
                        </div>
                        <div class="form-group">
                            <label for="comment">Descripción:</label>
                            <textarea class="form-control" rows="5" id="editarDescripcion" name="editarDescripcion" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="checkbox icheck">
                                    <label>
                                        <a href="#" class="btn btn-warning btn-block btn-flat" data-dismiss="modal"><i class="fa fa-undo "></i> Descartar</a>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class=" col-sm-offset-4 col-xs-4">
                                <div class="checkbox icheck">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat "><i class="fas fa-share-square"></i> Enviar</button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    <!--===== FIN DEL FORMULARIO PARA EDITAR EL HOTEL======-->

                    <!-- AQUI VA LA INSTANCIA PARA LLAMAR AL CONTROLADOR EDITOR DEL HOTEL -->
                    <?php 
                    $editarHotel = new ControladorHoteles();
                    $editarHotel->ctrEditarhotel();

                    ?>
                    <!--FIN DEL CONTROLADOR PARA EDITAR AL HOTEL -->
                </div>
            </div>
            <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
        </div>

    </div>
</div>
<!--===== FIN DEL MODAL PARA EDITAR EL HOTEL======-->
<!-- AQUI VA LA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL BORRADO DEL hotel -->
<?php
$borrarHotel = new ControladorHoteles();
$borrarHotel->ctrBorrarHotel();
  //  FIN LA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL BORRADO DEL HOTEL
} else {
  require "sinAcceso.php";
}
?>
<script src="vistas/plugins/datatable/script.js"></script> 