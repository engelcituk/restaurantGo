<div id="cierreRestaurante" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header modal-header-personalizado">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fas fa-edit"></i> Cierre restaurante</h4>
            </div>
            <div class="modal-body">
                <!--======= FORMULARIO PARA EDITAR EL HOTEL==================-->
                <div class="register-box-body">
                    <!-- formulario -->
                    <form method="post">
                        <!-- <div class="form-group has-feedback">
                            <input type="number" class="form-control hidden" id="idRestCierre" name="idRestCierre" readonly>
                        </div> -->
                        <div class="row">
                            <table id="cierresRestaurante" class="table table-hover" cellspacing="0" width="100%" style="width:100%">
                                <thead>
                                    <tr class="info">
                                        <th>Restaurante</th>
                                        <th>Fecha Inicio</th>
                                        <th>Fecha Fin</th>
                                        <th>Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            <div class="table-responsive">
                                <table class="table table-bordered" id="fechaDinamica">
                                    <button type="button" name="addFecha" id="add" class="btn btn-success pull-right"><i class="fas fa-plus-square"></i> Agregar</button>
                                    <tr>
                                        <td><strong>Fecha Inicio</strong></td>
                                        <td><strong>Fecha fin</strong></td>
                                        <td><strong>Borrar</strong></td>
                                        <td><strong>Guardar</strong></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">
                                <div class="checkbox icheck">
                                    <label>
                                        <a href="#" class="btn btn-warning btn-block btn-flat" data-dismiss="modal"><i class="fa fa-undo "></i> Salir</a>
                                    </label>
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class=" col-sm-offset-4 col-xs-4">
                                <div class="checkbox icheck">
                                    <button type="submit" class="btn btn-primary btn-block btn-flat hidden"><i class="fa fa-edit"></i> Enviar</button>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>
                    
                    <?php
                    // AQUI VA LA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL BORRADO DEL RESTAURANTE -->
                    $borrarFechasCierre = new ControladorRestaurantes();
                    $borrarFechasCierre->ctrBorrarFechasCierre();
                    // FIN LA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL BORRADO DEL RESTAURANTE
                    ?>
                   

                    
                </div>
            </div>
        </div>

    </div>
</div>