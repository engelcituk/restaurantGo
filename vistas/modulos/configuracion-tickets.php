<?php 
if ($_SESSION["C-TICKETS"] == 1) {
  ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Configuración Tickets
        </h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-dashboard"></i> Configuracion</a></li>
            <li class="active">Tickets</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title"> Tickets disponibles</h3>

                <!-- <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div> -->
            </div>
            <div class="box-body">
                <!-- cuerpo de la aplicacion -->
                <div class="row">
                    <div class="col-md-6">
                        <a href="#" class="btn btn-success btn-flat" data-toggle="modal" data-target="#nuevoTicket"><i class="fa fa-plus"></i> Nuevo Ticket</a><br><br>
                    </div>
                </div>

                <?php 
                $verListaTicket = new ControladorTicket();
                $verListaTicket->ctrTraerListaDeTicket();

                ?>

                <!-- <div class="material-switch pull-right">
            <input id="someSwitchOptionPrimary" name="someSwitchOption001" type="checkbox"/>
            <label for="someSwitchOptionPrimary" class="label-primary"></label>
          </div> -->


            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <!-- Footer -->
            </div>
            <!-- /.box-footer-->
        </div>
        <!-- /.box -->

    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper
 =============================================
  MODAL PARA UN NUEVO SEATING
  =============================================-->
<div id="nuevoTicket" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-personalizado">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-edit"></i> Crear nuevo ticket para <?php echo $_SESSION["nombreHotel"]; ?> </h4>
            </div>
            <div class="modal-body">
                <!--======   FORMULARIO PARA registrar un nuevo seating ==-->
                <div class="register-box-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 hidden">
                                <span><strong>idHotel ticket</strong></span><br><br>
                                <?php $idHotel = $_SESSION["idHotel"]; ?>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-language"></i></div>
                                    <input type="text" class="form-control" name="idHotel" id="idHotel" value="<?php echo $idHotel; ?>" required readonly>
                                </div>

                            </div>
                            <div class="col-md-6 col-xs-12">
                                <span><strong>Nombre ticket</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-language"></i></div>
                                    <input type="text" class="form-control idiomaM" name="idioma" id="idioma" placeholder="Escribe el nombre " required>
                                </div>
                            </div>
                            <div class="col-md-6 col-xs-12">
                                <span><strong>Encabezado</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-heading"></i></div>
                                    <input type="text" class="form-control" name="encabezado" id="encabezado" value="SANDOS HOTELS & RESORTS." minlength="5" required>
                                </div>
                            </div>
                        </div><br><span id="columnaIdioma"></span>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <span><strong>Pie del ticket</strong></span>
                                <textarea class="form-control" name="pieDePagina" id="pieDePagina" rows="3" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="checkbox icheck">
                                    <label>
                                        <a href="configuracion-tickets" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo "></i> Descartar</a>
                                    </label>
                                </div>
                            </div>
                            <div class=" col-xs-offset-3 col-xs-4">
                                <div class="checkbox icheck">
                                    <button type="submit" id="btnNuevoTicket" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-share-square"></i> Registrar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php 
                    $registrarSeating = new ControladorTicket();
                    $registrarSeating->ctrRegistrarNuevoTicket();
                    ?>
                </div>
            </div>
            <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
        </div>

    </div>
</div>
<!--===== FIN DEL  MODAL PARA UN NUEVO SEATING======-->

<!--=============================================
  MODAL PARA CARGAR LA INFORMACION DEL TICKET
  =============================================-->
<div id="verTicket" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-personalizado">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-edit"></i> Datos de su ticket</h4>
            </div>
            <div class="modal-body">

                <div class="register-box-body">
                    <form method="post">

                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <span><strong>Idioma</strong></span>
                                <div class="well well-sm" id="idiomaModalTicket"></div>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <span><strong>Encabezado</strong></span>
                                <div class="well well-sm" id="encabezadoModalTicket"></div>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <span><strong>Pie de página</strong></span>
                                <div class="well well-sm" id="pieModalTicket"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="checkbox icheck">
                                    <label>
                                        <a href="configuracion-tickets" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo "></i> Descartar</a>
                                    </label>
                                </div>
                            </div>
                            <!-- <div class=" col-xs-offset-3 col-xs-4">
                <div class="checkbox icheck">
                  <button type="submit" id="btnNuevoTicket" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-share-square" ></i> Registrar
                  </button>
                </div>
              </div> -->
                        </div>
                    </form>
                </div>
            </div>
            <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
        </div>

    </div>
</div>
<!--===== FIN MODAL PARA CARGAR LA INFORMACION DEL TICKET=====-->

<!--=============================================
  MODAL PARA CARGAR LA INFORMACION DEL TICKET
  PARA LA EDICION
  =============================================-->
<div id="editarTicket" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-personalizado">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-edit"></i> Los datos de su ticket a Editar</h4>
            </div>
            <div class="modal-body">
                <!--======   FORMULARIO PARA GUARDAR EL TICKET EDITADO ==-->
                <div class="register-box-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="well well-sm">
                                    <p id="idiomaModalEditar"></p>
                                    <p id="encabezadoModalEditar"></p>
                                    <p id="pieModalEditar"></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-xs-12 hidden">
                                <span><strong>id ticket</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-language"></i></div>
                                    <input type="number" class="form-control" name="idTicketModalEditar" id="idTicketModalEditar" required readonly>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <span><strong>Encabezado</strong></span>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-heading"></i></div>
                                    <input type="text" class="form-control" name="headerModalEditar" id="headerModalEditar" minlength="20" required>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <span><strong>Escribir el Pie de Ticket</strong></span>
                                <textarea class="form-control" name="footModalEditar" id="footModalEditar" rows="5" required></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-5">
                                <div class="checkbox icheck">
                                    <label>
                                        <a href="configuracion-tickets" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo "></i> Descartar</a>
                                    </label>
                                </div>
                            </div>
                            <div class=" col-xs-offset-3 col-xs-4">
                                <div class="checkbox icheck">
                                    <button type="submit" id="btnGuardaEditTicket" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-share-square"></i> Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php 
                    $guardarEditTicket = new ControladorTicket();
                    $guardarEditTicket->ctrEditarTicket();
                    ?>
                </div>
            </div>
            <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
        </div>

    </div>
</div>
<!--===== FIN MODAL PARA CARGAR LA INFORMACION DEL TICKET para la edicion=====-->
<?php 
$borrarTicket = new ControladorTicket();
$borrarTicket->ctrEliminarTicket();
} else {
  require "sinAcceso.php";
}
?> 