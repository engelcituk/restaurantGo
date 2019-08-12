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
                            <div class="col-md-6 col-xs-6 hidden">
                                <label for="usr">Pax</label>
                                <div class="input-group">
                                    <span class="input-group-addon" id="basic-addon1"><i class="fas fa-users"></i></span>
                                    <input type="number" class="form-control" id="nuevoPax" name="nuevoPax" min="1">
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
                            <div class="col-md-12 col-xs-12">
                                <h5><strong>Desglosar pax:</strong></h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-condensed">
                                        <thead>
                                            <tr class="info">
                                                <th>AD</th>
                                                <th>JR</th>
                                                <th>NI</th>
                                                <th>CU</th>
                                                <th>SE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="number" class="form-control paxDesgloseEdit" name="paxAdultosEdit" id="paxAdultosEdit" value="0" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control paxDesgloseEdit" name="paxJuniorEdit" id="paxJuniorEdit" value="0" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control paxDesgloseEdit" name="paxNinioEdit" id="paxNinioEdit" value="0" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control paxDesgloseEdit" name="paxCunaEdit" id="paxCunaEdit" value="0" min="0" required>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control paxDesgloseEdit" name="paxSeniorEdit" id="paxSeniorEdit" value="0" min="0" required>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
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