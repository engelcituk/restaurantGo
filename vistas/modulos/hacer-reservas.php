<?php
if ($_SESSION["HACER RESERVAS"] == 1) {
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- imprimo el nombre del hotel -->
            <h1> <?php echo $_SESSION["nombreHotel"] ?></h1>

            <ol class="breadcrumb">
                <li><a href="inicio"><i class="fa fa-dashboard"></i> <?php echo $_SESSION["nombreHotel"]; ?></a></li>
                <li id="nombreRestaurante" class="active">Restaurante</li>
                <li id="nombreRestaurante"><a href="hacer-reservas" class="btn btn-warning btn-sm "><i class="fas fa-undo"></i></a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="box box-info">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-6 col-xs-6">
                            <a href="#" class="btn btn-success btn-flat" data-toggle="modal" data-target="#rsvExternos"><i class="fas fa-plus"></i> Clientes externos</a>
                        </div>
                    </div>
                    <!-- <a href="#" class="btn btn-success" data-toggle="modal" data-target="#nuevaReserva"><i class="fa fa-plus"></i> Nueva Reserva</a> -->
                    <form>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <h4><strong>Elija el restaurante e indique el numero de habitación:</strong></h4>
                                <?php
                                date_default_timezone_set('America/Bogota');
                                $obtenerHora = date("H:i:s");
                                $horaActual = $obtenerHora;
                                ?>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <span><strong>Hotel</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-heading"></i></div>
                                    <input type="text" class="form-control" name="hotel" id="hotel" value="<?php echo $_SESSION["nombreHotel"]; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <span><strong>Elija restaurante</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-utensils"></i></div>
                                    <!-- traigo los restaurantes de acuerdo al id del hotel -->
                                    <?php
                                    if (isset($_GET["nomRest"])) {
                                        $nombreRestaurante = $_GET["nomRest"];
                                    } else {
                                        $nombreRestaurante = "";
                                    }
                                    $campoTabla = "idHotel";
                                    $valorCampoTabla = $_SESSION["idHotel"];
                                    $respuesta = ControladorRestaurantes::ctrMostrarListaRestaurantesActivos($campoTabla, $valorCampoTabla);
                                    echo '<select class="form-control" id="lstRestaurantes" required><option value="' . $nombreRestaurante . '">' . $nombreRestaurante . '</option>';
                                    foreach ($respuesta as $fila => $elemento) {
                                        echo '                              
                                            <option paxMaximoDia="' . $elemento["paxMaximoDia"] . '" horaCierre="' . $elemento["horaCierre"] . '" idRestaurante="' . $elemento["id"] . '" value="' . $elemento["id"] . '">' . $elemento["nombre"] . '</option>                            
                              ';
                                    }
                                    echo '</select>';
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <span><strong>Numero de habitación</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                    <input type="text" class="form-control" name="campoBuscaHabitacion" id="campoBuscaHabitacion" required>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <span><strong>Buscar datos habitación</strong></span><br><br>
                                <span class="btn btn-success buscarReserva" id="btnBuscarReserva"><i class="fa fa-search"></i> Buscar</span>
                            </div>
                            <div class="col-md-3 col-xs-12 hidden">
                                <span><strong>Id hotel</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                    <input type="text" class="form-control" name="idHotelVar" id="idHotelVar" value="<?php echo $valorCampoTabla; ?>">
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12 hidden">
                                <span><strong>Id restaurante</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                    <input type="text" class="form-control" name="idRestauranteVar" id="idRestauranteVar">
                                </div>
                            </div>
                        </div><br><br>
                        <div id="rowMensajeResultados"></div>
                    </form>

                </div>
                <div class="box-body">
                    <!-- puedo poner texto aquí -->
                    <form method="post" class="form-inline" id="formularioReserva">
                        <div class="row hidden" id="datosHuesped">
                            <div class="col-md-12 col-xs-12">
                                <h4><strong>Datos de la habitación proporcionada y desglose de ocupantes:</strong></h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-condensed">
                                        <thead>
                                            <tr class="info ">
                                                <th>Reserva</th>
                                                <th>Apellido</th>
                                                <th>Habitación</th>
                                                <th>Ocupantes</th>
                                                <th>Noches</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="reserva" id="reserva" readonly>
                                                <td>
                                                    <input type="text" class="form-control" name="apellido" id="apellido" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="numHabitacion" id="numHabitacion" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="ocupantes" id="ocupantes" readonly>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" name="noches" id="noches" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-condensed">
                                        <thead>
                                            <tr class="info">
                                                <th>Cuna</th>
                                                <th>Niño</th>
                                                <th>Junior</th>
                                                <th>Adultos</th>
                                                <th>Senior</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="number" class="form-control paxDesglose" name="paxCuna" id="paxCuna" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control paxDesglose" name="paxNinio" id="paxNinio" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control paxDesglose" name="paxJunior" id="paxJunior" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control paxDesglose" name="paxAdultos" id="paxAdultos" readonly>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control paxDesglose" name="paxSenior" id="paxSenior" readonly>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <?php
                        $respuestaFechaHoy = ControladorFechas::ctrObtnerFechaHoy();
                        $respuestaFechaHoyDMY = ControladorFechas::ctrObtnerFechaHoyDMY();
                        if (isset($_GET["fechaEnviada"])) {
                            // asignar w1 y w2 a dos variables
                            $fechaObtenida = $_GET["fechaEnviada"];
                            $fechaFormateada = strtotime($fechaObtenida);
                            $resultadoFecha = date('Y-m-d', $fechaFormateada);
                        }
                        ?>
                        <div id="camposParaLaReserva" class="hidden">                        
                            <div class="row">
                                <div class="col-md-12 col-xs-12">
                                    <h4><strong>Selecciona una fecha con reservas disponibles a partir de hoy: <?php echo $respuestaFechaHoyDMY; ?></strong></h4>
                                </div><br><br>

                                <div class="col-md-12 col-xs-12">
                                    <div id="msjReservasHechasSeating">
                                    </div>
                                </div>

                                <div class="col-md-3 col-xs-6">
                                    <span><strong>Fecha:</strong></span><br>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                                        <input type="date" class="form-control" id="fechaReserva" name="fechaReserva" required onchange="restauranteAbierto()">
                                    </div>
                                </div>
                                <div class="col-md-2 col-xs-6">
                                    <span><strong>Horario:</strong></span><br>
                                    <div class="input-group" id="horarioReserva">
                                        <div class="input-group-addon"><i class="fas fa-clock"></i></div>

                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <span><strong>Pax:</strong></span><br>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-users"></i></div>
                                        <input type="number" class="form-control" id="numeroDePax" name="numeroDePax" required>
                                    </div>
                                </div>
                                <div class="col-md-3 col-xs-6">
                                    <span><strong>Encabezado/pie ticket:</strong></span><br>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-language"></i></div>
                                        <select class="form-control" name="ticketElige" id="ticketElige" required>
                                            <option value=""></option>
                                            <?php
                                            $listaTickets = new ControladorTicket();
                                            $listaTickets->ctrTraerListaTicketsSelectOption();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6"><br><br>
                                    <span><strong>Observaciones:</strong></span><br>
                                    <textarea name="observaciones" class="form-control" id="observaciones" rows="3"></textarea>
                                </div>
                                <div class="col-md-12">
                                    <div id="msjRsvPaxRestantes">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div id="msjReservasHechas">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- <button type="submit" id="validarReserva" class="btn btn-primary"><i class="glyphicon glyphicon-list-alt"></i>  Reservar</button> -->
                                <button id="btnGuardarReserva" class="btn btn-success pull-right" style="margin:20px;" disabled><i class="fas fa-table"></i> Reservar</button>
                            </div>
                            <!-- campos de tipo hidden para traer los pax reservas maximos y mas datos-->
                            <input type="number" class="form-control hidden" id="idHotel2" name="idHotel2" readonly>
                            <input type="number" class="form-control hidden" id="idRestaurante2" name="idRestaurante2" readonly>
                            <input type="text" class="form-control hidden" id="fechaMaximaRSV" name="fechaMaximaRSV" readonly>
                            <input type="text" class="form-control hidden" id="campoNombreRestaurante" name="campoNombreRestaurante" readonly>
                            <input type="text" class="form-control hidden" id="maxRsvHuesped" name="maxRsvHuesped" readonly>
                            <input type="number" class="form-control hidden" id="numReservasMax" name="numReservasMax" readonly>
                            <input type="number" class="form-control hidden" id="numDePaxMaxima" name="numDePaxMaxima" readonly>
                            <input type="number" class="form-control hidden" id="totalReservasHechas" name="totalReservasHechas" readonly>
                            <input type="number" class="form-control hidden" id="totalPaxAcumulados" name="totalPaxAcumulados" readonly>
                            <input type="number" class="form-control hidden" id="numDePaxMaximaRestaurante" name="paxLimiteRestaurante" readonly>
                            <input type="number" class="form-control hidden" id="numDePaxDiaRestaurante" name="numDePaxDiaRestaurante" readonly>
                            <!-- campos de tipo  para traer los pax reservas maximos -->
                            <?php
                            $reservar = new ControladorReservas();
                            $reservar->ctrRealizarLaReserva();
                            ?>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>



    <?php
    include 'partials/hacerReservas/ticketImprimir.php';
    include 'partials/hacerReservas/clienteExterno.php';
} else {
    require "sinAcceso.php";
}
?>
<script src="vistas/plugins/datatable/script.js"></script>