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
                            <input type="text" class="form-control hidden" id="idRstrntEditar" name="idRstrntEditar" readonly>
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
        </div>

    </div>
</div>