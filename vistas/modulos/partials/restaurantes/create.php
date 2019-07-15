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