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