<?php
if ($_SESSION["HACER RESERVAS"] == 1 || $_SESSION["SUBMENU LATERAL"] == 1) {
    ?>
    <!-- =============================================== -->

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header)  -->
        <section class="content-header">
            <h1>
                <?php echo $_SESSION["nombreHotel"]; ?> : Administrar de reservas
            </h1>
            <ol class="breadcrumb">
                <li><a href="inicio"><i class="fa fa-dashboard"></i><?php echo $_SESSION["nombreHotel"]; ?></a></li>
                <li class="active">Reservas</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box box-info">
                <!-- <div class="box-header with-border">          
                              <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                  <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                  <i class="fa fa-times"></i></button>
                              </div>                                  
                            </div> -->
                <br>

                <div class="box-body">
                    <div class="row">
                        <?php
                        date_default_timezone_set('UTC');
                        $hoy = date("Y-m-d");
                        $hoyMiga = date("d-m-Y");
                        //al hacer el filtro por restaurante
                        if (isset($_GET["nomRest"])) {
                            $nombreRestaurante = $_GET["nomRest"];
                            $elijaRestaurante = $_GET["nomRest"];
                            $fecha = "a partir del " . $hoyMiga;
                        } else {
                            $nombreRestaurante = "Todos los restaurantes";
                            $elijaRestaurante = "Elija restaurante";
                            $fecha = "a partir del " . $hoyMiga;
                        }
                        //por si hace el filtro por por restaurante y fecha
                        if (isset($_GET["nomRest2"])) {
                            $nombreRestaurante = $_GET["nomRest2"];
                            $elijaRestaurante = $_GET["nomRest2"];
                            $fechaPorGet = $_GET["fechaFiltro"];
                            $fechaFormateada = date("d-m-Y", strtotime($fechaPorGet));
                            $fecha = $fechaFormateada;
                        }
                        ?>
                        <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"> <i class="fas fa-utensils"></i> <?php echo $nombreRestaurante; ?></a></li>
                                    <li class="breadcrumb-item"><a href="#"> <i class="fas fa-calendar-alt"></i> <?php echo $fecha; ?></a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <form action="">
                            <div class="col-md-3 col-xs-12">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-heading"></i></div>
                                    <input type="text" class="form-control" name="hotel" id="hotel" value="<?php echo $_SESSION["nombreHotel"]; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-utensils"></i></div>
                                    <!-- traigo los restaurantes de acuerdo al id del hotel -->
                                    <?php
                                    $campo = "idHotel";
                                    $valorCampo = $_SESSION["idHotel"];
                                    $respuesta = ControladorRestaurantes::ctrMostrarListaRestaurantes($campo, $valorCampo);
                                    echo '<select class="form-control" id="lstSelectRest" required><option value="">' . $elijaRestaurante . '</option>';
                                    foreach ($respuesta as $fila => $elemento) {
                                        echo '                              
                        <option idRestaurante="' . $elemento["id"] . '" value="' . $elemento["id"] . '">' . $elemento["nombre"] . '</option>                            
                              ';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                            </div>
                            <?php
                            if (isset($_GET["idRest"])) {
                                $estadoBtn = "";
                            } else {
                                $estadoBtn = "hidden";
                            }
                            //cuando aplica el segundo filtro (fecha)
                            if (isset($_GET["idRest2"])) {
                                $estadoBtn = "";
                            }
                            //para mostrar una fecha en el value de fecha al filtrar
                            if (isset($_GET["fechaFiltro"])) {
                                $fechaFiltro = $_GET["fechaFiltro"];
                            } else {
                                $fechaFiltro = $hoy;
                            }

                            ?>
                            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
                                <!-- muestro boton descargar si estoy recibiendo variables get -->
                                <div class="input-group <?php echo $estadoBtn; ?>">
                                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                    <input type="date" min="<?php echo $hoy; ?>" value="<?php echo $fechaFiltro; ?>" class="form-control" id="fechaFiltro" name="fechaFiltro">
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12 col-lg-3 col-sm-3">
                                <!-- muestro boton descargar si estoy recibiendo variables get -->
                                <a href="administrar-reservas" id="descartarFiltroBtn" class="btn btn-sm btn-warning <?php echo $estadoBtn; ?>"><i class="fas fa-undo"></i> Descartar
                                </a>
                            </div>
                        </form>
                    </div>

                    <br><br>
                    <!-- TABLA DE RESERVAS -->
                    <div class="row">
                        <div id="reservas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table id="tblCrudReservas" class="table table-striped dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Fecha Reserva</th>
                                        <th>No. Hab</th>
                                        <th>Apellido</th>
                                        <th>Restaurante</th>
                                        <th>Pax</th>
                                        <th>Hora</th>
                                        <!-- Si puede activar reservas le muestro columna estado -->
                                        <?php
                                        if ($_SESSION["ACTIVAR RESERVAS"] == 1) {
                                            echo '<th class="hidden">Estado</th> ';
                                        }
                                        if ($_SESSION["REIMPRIMIR TICKET"] == 1) {
                                            echo '<th class="hidden">Ticket</th>';
                                        }
                                        ?>
                                        <th>Herramientas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- LLAMO AL CONTROLADOR PARA TRAER LA LISTA DE RESERVAS -->
                                    <?php
                                    if (isset($_GET["idRest"])) {

                                        $valorCampoTabla = $_GET["idRest"];
                                        $valorCampoTabla2 = null;
                                    } else if (isset($_GET["fechaFiltro"])) {

                                        $valorCampoTabla = $_GET["idRest2"];
                                        $valorCampoTabla2 = $_GET["fechaFiltro"];
                                    } else {
                                        $valorCampoTabla = null;
                                        $valorCampoTabla2 = null;
                                    }
                                    $respuesta = ControladorReservas::ctrMostrarListaReservas($valorCampoTabla, $valorCampoTabla2);
                                    // var_dump($respuesta);
                                    $contador = 1;
                                    foreach ($respuesta as $fila => $elemento) {
                                        $cortarCadenaHora = substr($elemento["hora"], 0, 8);
                                        echo '
                          <tr id="' . $elemento["id"] . ' ">
                              <td>' . $contador . '</td>
                              <td>' . $elemento["fechaDeLaReserva"] . '</td>
                              <td>' . $elemento["habitacion"] . ' </td>
                              <td>' . $elemento["apellido"] . '</td>
                              <td>' . $elemento["nombreRestaurante"] . '</td>
                              <td>' . $elemento["pax"] . '</td>
                              <td>' . $cortarCadenaHora . '</td>';

                                        //si tiene permiso para activar reservas, muestro botón de activar
                                        if ($_SESSION["ACTIVAR RESERVAS"] == 1) {
                                            if ($elemento["estado"] != 0) {
                                                echo '<td class="hidden"><button class="btn btn-success btn-xs btnActivarRSV" idRsv="' . $elemento["id"] . '" estadoRsv="0">Activado</button></td>';
                                            } else {
                                                echo '<td class="hidden"><button class="btn btn-danger btn-xs btnActivarRSV" idRsv="' . $elemento["id"] . '" estadoRsv="1">Desactivado</button></td>';
                                            }
                                        }
                                        if ($_SESSION["REIMPRIMIR TICKET"] == 1) {
                                            echo '
                              <td>
                                <button class="btn btn-primary mostrarTicket" idReserva="' . $elemento["id"] . '" data-toggle="modal" data-target="#imprimirTicket"><i class="fa fa-print"></i>
                                </button>
                              </td>';
                                        }
                                        echo '<td>';
                                        if ($_SESSION["EDITAR RESERVAS"] == 1) {
                                            echo '<a href="#" class="btn btn-success editarReserva" data-toggle="modal" data-target="#editarReserva" idReserva="' . $elemento["id"] . '"><i class="fa fa-edit"></i> </a>';
                                        } else {
                                            echo '<a href="#" class="btn btn-warning" disabled><i class="fa fa-edit"></i></a>';
                                        }
                                        if ($_SESSION["BORRAR RESERVAS"] == 1) {
                                            echo '
                              <button class="btn btn-danger eliminarReserva" idReserva="' . $elemento["id"] . '"><i class="fa fa-trash "></i>
                              </button> ';
                                        } else {
                                            echo '
                              <button class="btn btn-warning" disabled><i class="fa fa-trash "></i>
                              </button> ';
                                        }
                                        echo '</td> 
                              <td></td>
                          </tr>';
                                        $contador++;
                                    }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- FIN TABLA DE RESERVAS -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer">

                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper=====-->
    <!-- =============================================
                      MODAL PARA EDITAR LA RESERVA
                      =============================================-->
    <div id="editarReserva" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-header-personalizado">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fas fa-edit"></i> Editar la reserva</h4>
                </div>
                <div class="modal-body">
                    <!--==========================================
                                  =   FORMULARIO PARA EDITAR EL USUARIO          =
                                  =============================================-->
                    <div class="register-box-body">
                        <!-- formulario -->
                        <form method="post">

                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="usr">Fecha elaboración</label>
                                        <input type="text" class="form-control" id="fechaElaboracion" name="fechaElaboracion" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="usr">Fecha de La reserva</label>
                                        <input type="date" class="form-control" id="fechaDeLaReserva" name="fechaDeLaReserva" readonly>
                                        <input type="text" class="form-control hidden" id="fechaLimiteMax" name="fechaLimiteMax" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-xs-6">
                                    <div class="form-group">
                                        <label for="usr">Reserva</label>
                                        <input type="text" class="form-control" id="reserva" name="reserva" readonly>
                                    </div>
                                </div>
                                <div class="col-md-5 col-xs-6">
                                    <div class="form-group">
                                        <label for="usr">Restaurante</label>
                                        <input type="text" class="form-control" id="nombreRestaurante" name="nombreRestaurante" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="usr">pax</label>
                                        <input type="number" class="form-control" id="pax" name="pax" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="usr">Habitacion</label>
                                        <input type="text" class="form-control" id="habitacion" name="habitacion" readonly>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <div class="form-group">
                                        <label for="usr">Hora</label>
                                        <input type="text" class="form-control" id="hora" name="hora" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="form-group">
                                        <label for="usr">Apellido</label>
                                        <input type="text" class="form-control" id="apellido" name="apellido" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <strong>Elija Restaurante y fecha</strong><br><br>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <?php
                                    $campo = "idHotel";
                                    $valorCampo = $_SESSION["idHotel"];
                                    $respuestaModal = ControladorRestaurantes::ctrMostrarListaRestaurantes($campo, $valorCampo);
                                    echo '<select class="form-control" id="lstSelectRestEdit" name="nuevoRestaurante" required><option value="">Elija restaurante</option>';
                                    foreach ($respuestaModal as $fila => $elemento) {
                                        echo '                              
                                        <option horaCierre="' . $elemento["horaCierre"] . '" idHotelEditar="' . $valorCampo . '" idRestauranteEditar="' . $elemento["id"] . '" value="' . $elemento["nombre"] . '">' . $elemento["nombre"] . '</option>                            
                                    ';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <!-- <label for="usr">Nueva Fecha</label> -->
                                    <div class="input-group">
                                        <?php
                                        date_default_timezone_set('UTC');
                                        $hoy = date("Y-m-d");
                                        ?>
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="date" class="form-control" min="<?php echo $hoy; ?>" id="nuevaFecha" name="nuevaFecha" readonly>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row" id="editarFechaHoraPax">

                                <div class="col-md-6 col-xs-6">
                                    <label for="usr">Nueva hora</label>
                                    <div class="input-group nuevoHorario" id="nuevoHorario">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-clock"></i></span>
                                        <select class="form-control">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <label for="usr">Pax</label>
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon1"><i class="fas fa-users"></i></span>
                                        <input type="number" class="form-control" id="nuevoPax" name="nuevoPax" min="1" max="99" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row hidden">
                                <div class="col-md-2">
                                    <input type="number" class="form-control" id="idDeLaReserva" name="idDeLaReserva" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" id="numReservasMax" name="numReservasMax" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" id="numDePaxMaxima" name="numDePaxMaxima" readonly>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" id="totalReservasHechas" name="totalReservasHechas" readonly>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" class="form-control" id="totalPaxAcumulados" name="totalPaxAcumulados" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="comment">Observaciones:</label>
                                        <textarea class="form-control" rows="2" id="observaciones" id="observaciones" name="observaciones"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="checkbox icheck">
                                        <label>
                                            <a href="administrar-reservas" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo "></i> Descartar</a>
                                        </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class=" col-sm-offset-4 col-xs-4">
                                    <div class="checkbox icheck">
                                        <button type="submit" id="enviarNuevaRsv" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-save"></i> Guardar</button>

                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>

                        </form>

                        <!--===== FIN DEL FORMULARIO PARA EDITAR EL USUARIO======-->
                        <!-- AQUI VA LA INSTANCIA PARA LLAMAR AL CONTROLADOR EDITOR DEL USUARIO -->
                        <?php
                        $editarReseva = new ControladorReservas();
                        $editarReseva->ctrEditarLaReserva();
                        ?>
                        <!--FIN DEL CONTROLADOR PARA EDITAR LA RESERVA -->
                    </div>
                </div>
                <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div> -->
            </div>

        </div>
    </div>
    <!--===== FIN DEL MODAL PARA EDITAR EL USUARIO======-->

    <!-- =============================================
                      MODAL PARA CARGAR EL TICKET LA RESERVA
                      =============================================-->
    <div id="imprimirTicket" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header modal-header-personalizado">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fas fa-list-alt"></i> Los datos de su ticket</h4>
                </div>
                <div class="modal-body">
                    <!--==========================================
                                  =   FORMULARIO PARA TRAER LOS DATOS PARA EL TICKET=
                                  =============================================-->
                    <div class="register-box-body">
                        <!-- formulario -->
                        <div class="row">
                            <div class="table-responsive panel panel-primary">
                                <div class="panel-heading"><strong>SANDOS HOTELS & RESORTS</strong></div>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="default">
                                            <th>Fecha</th>
                                            <th>Hora</th>
                                            <th>Apellido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="default">
                                            <td><input type="text" class="form-control" name="reservaFecha" id="reservaFecha" readonly></td>
                                            <td><input type="text" class="form-control" name="reservaHora" id="reservaHora" readonly></td>
                                            <td><input type="text" class="form-control" name="reservaApellido" id="reservaApellido" readonly></td>

                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="default">
                                            <th>Pax</th>
                                            <th>#Habitación</th>
                                            <!-- <th>#Mesa</th> -->
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="default">
                                            <td><input type="text" class="form-control" name="reservaPax" id="reservaPax" readonly></td>
                                            <td><input type="text" class="form-control" name="reservaHabitacion" id="reservaHabitacion" readonly></td>
                                            <!-- <td><input type="text" class="form-control" name="reservaMesa" id="reservaMesa" readonly></td> -->
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="default">
                                            <th>Restaurante</th>
                                            <th>Reserva Hotel</th>
                                            <th>Ticket</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="default">
                                            <td><input type="text" class="form-control" name="nombreRestauranteTicket" id="nombreRestauranteTicket" readonly></td>
                                            <td><input type="text" class="form-control" name="reservaHotel" id="reservaHotel" readonly></td>
                                            <td><input type="text" class="form-control" name="reservaTicket" id="reservaTicket" readonly></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <input type="text" class="form-control hidden" name="esTermicaImpresora" id="esTermicaImpresora" value="<?php echo  $_SESSION["esTermica"] ?>" readonly>
                            </div>
                        </div>
                        <div class="row alert alert-success alert-dismissible">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong>Al ingresar eligió su impresora predeterminada,</strong>puede elegir otras del listado.
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <a href="#" class="btn btn-warning " data-dismiss="modal"><i class="fa fa-undo "></i> Descartar</a>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group">
                                    <select class="form-control" id="impresoras" name="impresoras" required>
                                        <!-- traigo la lista de impresoras disponibles -->
                                        <?php
                                        echo '<option termica="' . $_SESSION["esTermica"] . '" value="' . $_SESSION["ipImpresora"] . '">PREDETERMINADA</option>';
                                        $tabla = "ticketimpresoras";
                                        $valorDeMiCampo = $_SESSION["idHotel"];
                                        $respuesta = ModeloImpresoras::mdlMostrarImpresorasHotelById($tabla, $valorDeMiCampo);

                                        foreach ($respuesta as $row => $item) {
                                            echo
                                                ' 
                                <option termica="' . $item["termica"] . '" value="' . $item["direccionIP"] . '">' . $item["nombreImpresora"] . '</option>         
                                ';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-4">
                                <button class="btn btn-primary obtenerDatosTicket"><i class="fa fa-print "></i> Imprimir</button>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div> -->
            </div>

        </div>
    </div>
    <!--===== FIN DEL MODAL PARA cargar modal del ticket======-->
    <?php
    $borrarReserva = new ControladorReservas();
    $borrarReserva->ctrBorrarReserva();
} else {
    require "sinAcceso.php";
}
?>
<script src="vistas/plugins/datatable/script.js"></script>