   <!-- ==================MODAL PARA REGISTRAR NUEVO CLIENTE SIN RESERVACION EN EL HOTEL=============-->
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
                                       <input type="date" min="<?php echo $respuestaFechaHoy; ?>" class="form-control" id="fechaReservaExternos" name="fechaReservaExternos" onchange="restauranteAbiertoExternos()" required readonly>
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
                                   <h5><strong>Desglozar los pax:</strong></h5>
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
                                                       <input type="number" class="form-control paxDesglose" name="paxCunaExt" id="paxCunaExt" value="0" min="0" required>
                                                   </td>
                                                   <td>
                                                       <input type="number" class="form-control paxDesglose" name="paxNinioExt" id="paxNinioExt" value="0" min="0" required>
                                                   </td>
                                                   <td>
                                                       <input type="number" class="form-control paxDesglose" name="paxJuniorExt" id="paxJuniorExt" value="0" min="0" required>
                                                   </td>
                                                   <td>
                                                       <input type="number" class="form-control paxDesglose" name="paxAdultosExt" id="paxAdultosExt" value="0" min="0" required>
                                                   </td>
                                                   <td>
                                                       <input type="number" class="form-control paxDesglose" name="paxSeniorExt" id="paxSeniorExt" value="0" min="0" required>
                                                   </td>
                                               </tr>
                                           </tbody>
                                       </table>
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