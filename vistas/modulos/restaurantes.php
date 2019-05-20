<?php
if ($_SESSION["C-RESTAURANTES"] == 1) {
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Restaurantes <?php
                                

                                ?>
            </h1>
            <ol class="breadcrumb">
                <li><a href="inicio"><i class="fa fa-dashboard"></i> Configuración</a></li>
                <li class="active">Restaurantes</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
                            <?php
                            if (isset($_GET["nomHotel"])) {
                                $nombreHotel = $_GET["nomHotel"];
                                $verRestaurantes = $_GET["nomHotel"];
                            } else {
                                $nombreHotel = "Todos los hoteles";
                                $verRestaurantes = "Ver Restaurantes";
                            }
                            ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-hotel"></i> <?php echo $nombreHotel ?></a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-xs-6">
                            <a href="#" class="btn btn-success btn-flat" data-toggle="modal" data-target="#nuevoRestaurante"><i class="fas fa-utensils"></i> Nuevo Restaurante</a>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="dropdown">

                                <button class="btn btn-primary btn-flat dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-hotel"></i> <?php echo $verRestaurantes ?>
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <?php
                                    $listaHoteles = new ControladorRestaurantes();
                                    $listaHoteles->ctrListaHotelesUsuario();
                                    ?>
                                    <!-- <li idHotel="TODOS"><a href="restaurantes">TODOS</a></li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <select class="form-control" name="hotelElige" id="hotelElige2" required>
                                <option value="">Genera PDF</option>
                                <?php
                                $listaHoteles = new ControladorRestaurantes();
                                $listaHoteles->ctrListaHotelesUsuarioSelectOption();
                                ?>
                                <!-- <option value="TODOS">TODOS</option> -->
                            </select>
                        </div>
                        <div class="col-md-offset-1 col-md-2 col-xs-6">
                            <?php
                            if (isset($_GET["idHotel"])) {
                                $estadoBoton = "";
                            } else {
                                $estadoBoton = "hidden";
                            }
                            ?>
                            <a href="restaurantes" class="btn btn-warning btn-block btn-flat <?php echo $estadoBoton; ?>"><i class="fa fa-undo"></i> Descartar</a>
                        </div>
                    </div>
                    <br>

                    <!-- <h3 class="box-title">Title</h3> -->
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <div id="restaurantes" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div>
                            <table id="tablaRestaurantes" class="table table-striped dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nombre</th>
                                        <!-- <th>Especialidad</th> -->
                                        <th>MaximoPaxDia</th>
                                        <th>Estado</th>
                                        <th>Herramientas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- aqui va mis consultas en un datatable -->
                                    <?php
                                    if (isset($_GET["idHotel"])) {

                                        $campoTabla = "idHotel";
                                        $valorCampoTabla = $_GET["idHotel"];
                                    } else {

                                        $campoTabla = null;
                                        $valorCampoTabla = null;
                                    }

                                    $respuesta = ControladorRestaurantes::ctrMostrarListaRestaurantes($campoTabla, $valorCampoTabla);
                                    $contador = 1;
                                    foreach ($respuesta as $fila => $elemento) {
                                        echo '
                                        <tr id="' . $elemento["id"] . '">
                                            <td>' . $contador . '</td>
                                            <td>' . $elemento["nombre"] . '</td>                        
                                            <td>' . $elemento["paxMaximoDia"] . '</td>';

                                        if ($elemento["estado"] != 0) {

                                            echo '<td><button class="btn btn-success btn-xs btnActivarRstrnt" idRstrnt="' . $elemento["id"] . '" estadoRstrt="0">Activado</button></td>';
                                        } else {
                                            echo '<td><button class="btn btn-danger btn-xs btnActivarRstrnt" idRstrnt="' . $elemento["id"] . '" estadoRstrt="1">Desactivado</button></td>';
                                        }
                                        echo '<td>
                              <a href="#" class="btn btn-success editRestaurante" data-toggle="modal" data-target="#editRestaurante" idRstrnt="' . $elemento["id"] . '"><i class="fa fa-edit"></i> </a>
                              
                              <button class="btn btn-danger eliminarRestaurante" idRstrnt="' . $elemento["id"] . '" disabled><i class="fa fa-trash "></i></button>               
                        </td>
                        <td></td>
                    </tr>';
                                        $contador = $contador + 1;
                                    }
                                    ?>
                                </tbody>
                            </table>


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


    <!-- MODAL PARA EL REGISTRO DE UN NUEVO RESTAURANTE -->
    <!-- Modal -->
    <div id="nuevoRestaurante" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-header-personalizado">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fas fa-edit"></i> Registrar Nuevo Restaurante</h4>
                </div>
                <div class="modal-body">
                    <div class="register-box-body">
                        <!-- formulario -->
                        <form method="post">
                            <div class="form-group has-feedback">
                                <input type="number" class="form-control hidden" id="idHotelReg" name="idHotelReg" placeholder="id" required readonly>

                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Elige a que hotel pertenece</strong>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-hotel"></i></span>
                                        <select class="form-control" name="hotelElige" id="hotelElige" required>
                                            <option value=""></option>
                                            <?php
                                            $listaHoteles = new ControladorReservas();
                                            $listaHoteles->ctrTraerListaDeHoteles();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Nombre del Restaurante</strong>
                                    <div class="input-group has-feedback">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                        <input type="text" class="form-control" id="regRestaurante" name="regRestaurante" placeholder="Nombre Completo" required>
                                        <span class="glyphicon glyphicon-cutlery form-control-feedback"></span>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Hora maxima para reservas</strong><br>
                                    <label class="radio-inline"><input type="radio" name="horarioCierreRadio" id="radioSI" value="SI">SI</label>
                                    <label class="radio-inline"><input type="radio" name="horarioCierreRadio" id="radioNO" value="NO" checked>NO</label>
                                </div>
                                <div class="col-md-6">
                                    <strong>Indique una hora (formato 24 hrs)</strong><br>
                                    <div class="input-group" id="lstHoraCierreRestaurante">
                                        <div class="input-group-addon"><i class="fas fa-clock"></i></div>
                                        <input type="text" class="form-control hidden" id="horarioCierre" />
                                        <input type="text" class="form-control" id="sinHorario" name="horarioCierre" value="SIN HORARIO" required readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Límite de pax por dia</strong><br>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                        <input type="number" class="form-control" id="paxMaximoDia" name="paxMaximoDia" required />
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="form-group">
                                <label for="comment">Especialidad-Descripcion:</label>
                                <textarea class="form-control" rows="3" id="regEspecialidad" name="regEspecialidad" required></textarea>
                            </div><br>
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="restaurantes" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo"></i> Descartar</a>
                                </div>
                                <!-- /.col -->
                                <div class="col-xs-4 col-xs-offset-4">
                                    <!-- CREO UNA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL REGISTRO DEL USUARIO -->
                                    <?php
                                    $registro = new ControladorRestaurantes();
                                    $registro->ctrRegistroRestaurante();
                                    ?>
                                    <button type="submit" id="btnRegistrarRest" class="btn btn-primary btn-block btn-flat"><i class="fas fa-share-square"></i> Registrar</button>

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
                                                                                                                          MODAL PARA EDITAR AL HOTEL
                                                                                                                          =============================================-->
    <div id="editRestaurante" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-header-personalizado">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fas fa-edit"></i> Editar restaurante</h4>
                </div>
                <div class="modal-body">
                    <!--======= FORMULARIO PARA EDITAR EL HOTEL==================-->
                    <div class="register-box-body">
                        <!-- formulario -->
                        <form method="post">
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control hidden" id="idRstrntEditar" name="idRstrntEditar" placeholder="id">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Nombre del Restaurante</strong>
                                    <div class="input-group has-feedback">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-file-signature"></i></span>
                                        <input type="text" class="form-control" id="editarNombre" name="editarNombre" placeholder="nombre" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Horario maximo reservas </strong>

                                    <div class="input-group has-feedback">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                        <input type="text" class="form-control" id="horaCierreResult" name="horaCierreResult" readonly />
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Cambiar hr max. reservas</strong><br>
                                    <label class="radio-inline"><input type="radio" name="horaCierreRadioEdit" id="radioSIEdit" value="SI">SI</label>
                                    <label class="radio-inline"><input type="radio" name="horaCierreRadioEdit" id="radioNOEdit" value="NO" checked>NO</label>
                                    <label class="radio-inline"><input type="radio" name="horaCierreRadioEdit" id="radioNOEdit" value="SIN HORARIO">Sin Horario</label>
                                </div>
                                <div class="col-md-6">
                                    <strong>Horario (formato 24 hrs)</strong><br>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-clock"></i></div>
                                        <input type="text" class="form-control hidden" id="horarioCierreEdit" />
                                        <input type="text" class="form-control" id="noModificarHorarioEdit" name="horarioCierreEdit" readonly required />
                                        <input type="text" class="form-control hidden" id="sinHorarioCierreNuevo" readonly />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <strong>Límite de pax por dia</strong><br>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                        <input type="number" class="form-control" id="paxMaximoDiaEditar" name="paxMaximoDiaEditar" required />
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment">Especialidad:</label>
                                <textarea class="form-control" rows="3" id="editarEspecialidad" name="editarEspecialidad" required></textarea>
                            </div>
                            <div class="form-group has-feedback">
                                <input type="text" class="form-control hidden" id="estadoRestaurante" name="estadoRestaurante" placeholder="estado" required>
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
                                        <button type="submit" class="btn btn-primary btn-block btn-flat "><i class="fa fa-edit"></i> Enviar</button>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                        <!--===== FIN DEL FORMULARIO PARA EDITAR EL RESTAURANTE======-->

                        <!-- AQUI VA LA INSTANCIA PARA LLAMAR AL CONTROLADOR EDITOR DEL RESTAURANTE -->
                        <?php
                        $editRestaurante = new ControladorRestaurantes();
                        $editRestaurante->ctrEditarRestaurante();

                        ?>
                        <!--FIN DEL CONTROLADOR PARA EDITAR AL RESTAURANTE -->
                    </div>
                </div>
                <!-- <div class="modal-footer">
                                                                                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                                                  </div> -->
            </div>

        </div>
    </div>
    <!--===== FIN DEL MODAL PARA EDITAR EL RESTAURANTE======-->
    <!-- AQUI VA LA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL BORRADO DEL RESTAURANTE -->
    <?php
    $borrarRestaurante = new ControladorRestaurantes();
    $borrarRestaurante->ctrBorrarRestaurante();
    //  FIN LA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL BORRADO DEL RESTAURANTE
} else {
    require "sinAcceso.php";
}
?>
<script src="vistas/plugins/datatable/script.js"></script>
<input type="text" class="form-control" id="sinHorarioCierreEdit" readonly required />