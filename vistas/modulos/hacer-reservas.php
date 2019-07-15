<?php
if ($_SESSION["HACER RESERVAS"] == 1) {
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- imprimo el nombre del hotel -->
            <h1> <?php echo $_SESSION["nombreHotel"] ?></h1>
            <?php


            ?>
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
                                <a href="#" class="btn btn-success buscarReserva" id="btnBuscarReserva"><i class="fa fa-search"></i> Buscar</a>
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
                                <h4><strong>Se ha encontrado datos con el número de habitación proporcionado:</strong></h4>
                            </div>

                            <div class="col-md-3 col-xs-12">
                                <span><strong>Reserva</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-file-signature"></i></div>
                                    <input type="text" class="form-control" name="reserva" id="reserva" readonly>
                                </div>
                            </div>
                            <div class="col-md-3 col-xs-12">
                                <span><strong>Apellido</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-file-signature"></i></div>
                                    <input type="text" class="form-control" name="apellido" id="apellido" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <span><strong>Habitación</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-home"></i></div>
                                    <input type="text" class="form-control" name="numHabitacion" id="numHabitacion" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <span><strong>Ocupantes</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-users"></i></div>
                                    <input type="text" class="form-control" name="ocupantes" id="ocupantes" readonly>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-4">
                                <span><strong>Noches</strong></span><br><br>
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fas fa-moon"></i></div>
                                    <input type="text" class="form-control" name="noches" id="noches" readonly>
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
                            <hr>
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
                                        <input type="date" class="form-control" id="fechaReserva" name="fechaReserva" required>
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


    <div id="ticketImpresora" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-personalizado">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fas fa-list-alt"></i> Datos del ticket</h4>
                </div>
                <div class="modal-body">
                    <div class="register-box-body">
                        <!-- formulario -->
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <span><strong>Fecha</strong></span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                                        <input type="text" class="form-control" id="reservaFecha" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <span><strong>Hora</strong></span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-clock"></i></div>
                                        <input type="text" class="form-control" id="reservaHora" readonly>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <span><strong>Reserva hotel</strong></span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                                        <input type="text" class="form-control" id="reservaHotel" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <span><strong>Apellido</strong></span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-file-signature"></i></div>
                                        <input type="text" class="form-control" id="reservaApellido" readonly>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-4 col-xs-4">
                                    <span><strong>Habitacion</strong></span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                                        <input type="text" class="form-control" id="reservaHabitacion" readonly>
                                    </div>
                                </div>
                                <div class="col-md-4 col-xs-4">
                                    <span><strong>Num. Pax</strong></span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-users"></i></div>
                                        <input type="text" class="form-control" id="reservaPax" readonly>
                                    </div>
                                </div>

                            </div><br>
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <span><strong>Restaurante</strong></span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-utensils"></i></div>
                                        <input type="text" class="form-control" id="nombreRestauranteTicket" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <span><strong>Encabezado/Pie ticket</strong></span>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-ticket-alt"></i></div>
                                        <input type="text" class="form-control" id="reservaTicket" readonly>
                                    </div>
                                </div>
                                <input type="text" class="form-control hidden" name="esTermicaImpresora" id="esTermicaImpresora" value="<?php echo  $_SESSION["esTermica"] ?>" readonly>
                            </div><br>
                            <div class="row">
                                <div class="alert alert-success alert-dismissible">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    <strong>Al ingresar eligió su impresora predeterminada,</strong>puede elegir otras del listado.
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="hacer-reservas" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo"></i> Descartar</a>
                                </div>
                                <div class="col-xs-4">
                                    <div class="form-group">
                                        <select class="form-control" id="impresoras" name="impresoras" required>
                                            <?php
                                            echo '<option termica="' . $_SESSION["esTermica"] . '"value="' . $_SESSION["ipImpresora"] . '">PREDETERMINADA</option>';
                                            $listaImpresoras = new ControladorImpresoras();
                                            $listaImpresoras->ctrListaDeImpresoras();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-4 ">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat obtenerDatosTicket"><i class="fas fa-print"></i> Imprimir</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- =============================================
                                                                                                                                                                      MODAL PARA REGISTRAR NUEVO CLIENTE SIN RESERVACION EN EL HOTEL
                                                                                                                                                                      =============================================-->
    <div id="rsvExternos" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header modal-header-personalizado">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><i class="fas fa-edit"></i> Ingrese los datos del cliente</h4>
                </div>
                <div class="modal-body">
                    <div class="register-box-body">
                        <form method="post">
                            <div class="row">
                                <div class="col-md-6 col-xs-12 hidden">
                                    <label for="usr">Hotel</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="nombreHotelExterno" name="nombreHotelExterno" value="<?php echo $_SESSION["nombreHotel"]; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 hidden">
                                    <label for="usr">IDhotel</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                                        <input type="text" class="form-control " id="idHotelExterno" name="idHotelExterno" value="<?php echo $_SESSION["idHotel"]; ?>" readonly>
                                    </div>
                                </div>
                            </div><br>

                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <label for="usr">Elija restaurante</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-utensils"></i></div>
                                        <!-- traigo los restaurantes de acuerdo al id del hotel -->
                                        <?php
                                        $campoTabla = "idHotel";
                                        $valorCampoTabla = $_SESSION["idHotel"];
                                        $respuesta = ControladorRestaurantes::ctrMostrarListaRestaurantesActivos($campoTabla, $valorCampoTabla);
                                        echo '<select class="form-control" name="restauranteNombreExternos" id="lstRestaurantesExt" required><option value="Elija Restaurante">Elija Restaurante</option>';
                                        foreach ($respuesta as $fila => $elemento) {
                                            echo '                              
                                            <option  horaCierre="' . $elemento["horaCierre"] . '" idRestauranteExternos="' . $elemento["id"] . '" paxMaximoDia="' . $elemento["paxMaximoDia"] . ' "value="' . $elemento["nombre"] . '">' . $elemento["nombre"] . '</option>                            
                                  ';
                                        }
                                        echo '</select>';
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 hidden">
                                    <label for="usr">IDRestaurante</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                        <input type="text" class="form-control" id="idRestauranteEx" name="idRestauranteEx" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 hidden">
                                    <label for="usr">Reserva Generica</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                        <input type="text" class="form-control" id="rsvExternos" name="rsvExternos" value="RESERVAGENERICA" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 hidden">
                                    <label for="usr">Habitación</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                        <input type="text" class="form-control" id="habitacionExternos" name="habitacionExternos" value="0000" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="usr">Nombre Completo</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-signature"></i></div>
                                        <input type="text" class="form-control nombreCompletoClienteExterno" id="nombreCompleto" name="nombreCompleto" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <label for="usr">Fecha:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></div>
                                        <input type="date" min="<?php echo $respuestaFechaHoy; ?>" class="form-control" id="fechaReservaExternos" name="fechaReservaExternos" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="usr">Horario</label>
                                    <div class="input-group" id="horarioReservaExternos">
                                        <div class="input-group-addon"><i class="fas fa-clock"></i></div>
                                        <select class="form-control">
                                            <option> </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="usr">Pax</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                        <input type="number" class="form-control" id="paxExternos" name="paxExternos" min="1" max="100" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <label for="usr">Encabezado/Pie Ticket:</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-language"></i></div>
                                        <select class="form-control" name="ticketEligeExternos" id="ticketEligeExternos" required onchange="getPaxAcumuladosDia()">
                                            <option value=""></option>
                                            <?php
                                            $listaTickets = new ControladorTicket();
                                            $listaTickets->ctrTraerListaTicketsSelectOption();
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 hidden">
                                    <label for="usr">numDePaxmAximo</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                        <input type="number" class="form-control" id="numDePaxmAximo" name="numDePaxmAximo" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xs-12 hidden">
                                    <label for="usr">sumaPax</label>
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                        <input type="number" class="form-control" id="sumaPaxExternos" name="sumaPaxExternos" required readonly>
                                    </div>
                                </div>
                                <div class="col-md-12 col-xs-12">
                                    <label for="usr">Observaciones</label>
                                    <textarea class="form-control nombreCompletoClienteExterno" rows="3" id="observacionesExterno" name="observacionesExterno" onchange="getPaxAcumuladosDia()"></textarea>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-4">
                                    <div class="checkbox icheck">
                                        <label>
                                            <a href="hacer-reservas" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo "></i> Descartar</a>
                                        </label>
                                    </div>
                                </div>
                                <div class=" col-sm-offset-4 col-xs-4">
                                    <div class="checkbox icheck">
                                        <button id="btnClienteExternoGuardar" class="btn btn-success btn-block btn-flat"><i class="fas fa-save"></i> Reservar
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <?php
                            $registrarReservaExternos = new ControladorReservas();
                            $registrarReservaExternos->ctrRealizarLaReservaExternos();
                            ?>
                        </form>

                    </div>
                </div>
                <!-- <div class="modal-footer">
                                                                                                                                                                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                                                                                                    </div> -->
            </div>

        </div>
    </div>
    <!--===== MODAL PARA REGISTRAR UN NUEVO CLIENTE SIN RESERVACION EN EL HOTEL======-->

<?php
} else {
    require "sinAcceso.php";
}
?>
<script src="vistas/plugins/datatable/script.js"></script>