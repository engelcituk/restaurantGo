  <?php
    if ($_SESSION["C-SEATINGS"] == 1) {
        ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
          <!-- Content Header (Page header) -->
          <section class="content-header">
              <h1>
                  Configuración Seatings
              </h1>
              <ol class="breadcrumb">
                  <li><a href="inicio"><i class="fa fa-dashboard"></i> Seatings</a></li>
                  <li class="active"><span id="nombreRstMiga">Configuración Seatings</span></li>
              </ol>
          </section>

          <!-- Main content -->
          <section class="content">

              <!-- Default box -->
              <div class="box box-success">
                  <div class="box-header with-border">
                      <!-- <h3 class="box-title">Title</h3> -->

                      <!-- <div class="box-tools pull-right">
                                                                                                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                                                                                                    title="Collapse">
                                                                                                              <i class="fa fa-minus"></i></button>
                                                                                                            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                                                                                              <i class="fa fa-times"></i></button>
                                                                                                          </div> -->
                      <div class="row">
                          <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
                              <?php

                                if (isset($_GET["nomHotel"])) {
                                    $nombreHotel = $_SESSION["nombreHotel"];
                                    $nombreRestaurante = $_GET["nomRest"];
                                } else {
                                    $nombreHotel = $_SESSION["nombreHotel"];
                                    $nombreRestaurante = "Restaurante";
                                }
                                ?>
                              <nav aria-label="breadcrumb">
                                  <ol class="breadcrumb">
                                      <li class="breadcrumb-item" id="tituloReporte"><a href="#" id="migaHotelSeating"><i class="fas fa-hotel"></i> <?php echo $nombreHotel ?></a></li>
                                      <li class="breadcrumb-item"><a href="#" id="migaRestauranteSeating"> <i class="fas fa-utensils"></i> <?php echo $nombreRestaurante ?></a></li>
                                  </ol>
                              </nav>
                          </div>
                      </div>
                      <div class="row">
                          <form action="">
                              <div class="col-md-3 col-xs-12">
                                  <a href="#" class="btn btn-success btn-flat" data-toggle="modal" data-target="#nuevoSeating"><i class="fa fa-plus"></i> Nuevo Seating</a>
                              </div>

                              <?php

                                if (isset($_GET["nomHotel"])) {
                                    $nombreHotelSelect = $_GET["nomHotel"];
                                    $nombreRestauranteSelect = $_GET["nomRest"];
                                } else {
                                    $nombreHotelSelect = "Elige Hotel";
                                    $nombreRestauranteSelect = "Elige Restaurante";
                                }
                                ?>


                              <div class="col-md-3 col-xs-12">
                                  <div class="input-group">
                                      <div class="input-group-addon"><i class="fas fa-utensils"></i></div>
                                      <select class="form-control" name="lstSeatingRestaurante" id="lstSeatingRestaurante" required>
                                          <?php
                                            $datos = $_SESSION["idHotel"];
                                            $respuesta = ControladorRestaurantes::ctrMostrarRestsHotelTrabajo($datos);
                                            echo "<option value='volvo'>" . $nombreRestauranteSelect . "</option>";
                                            foreach ($respuesta as $fila => $elemento) {
                                                echo '<option value=' . $elemento["id"] . '>' . $elemento["nombre"] . '</option>';
                                            }
                                            ?>

                                      </select>
                                  </div>
                              </div>
                              <div class="col-md-3 col-xs-12">
                                  <?php
                                    if (isset($_GET["idRestaurante"])) {
                                        $estadoBoton = "";
                                    } else {
                                        $estadoBoton = "hidden";
                                    }
                                    ?>
                                  <a href="configuracion-seatings" class="btn btn-warning btn-flat <?php echo $estadoBoton; ?>"><i class="fa fa-undo"></i> Descartar</a>
                              </div>
                          </form>
                      </div>
                  </div>
                  <div class="box-body">
                      <!-- TABLA DE seatings -->
                      <div class="row">
                          <div id="seatings" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                              <table id="tblCrudSeatings" class="table table-striped dt-responsive nowrap">
                                  <thead>
                                      <tr>
                                          <th>No.</th>

                                          <th>Restaurante</th>
                                          <th>Día</th>
                                          <th>Hora</th>
                                          <th>Pax</th>
                                          <th>Rsv Max</th>
                                          <th>Estado</th>
                                          <th>Editar</th>
                                          <th></th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      <!-- LLAMO AL CONTROLADOR PARA TRAER LA LISTA DE SEATINGS -->
                                      <?php
                                        if (isset($_GET["idRestaurante"])) {
                                            $campoTabla = "idRestaurante";
                                            $valorCampoTabla = $_GET["idRestaurante"];
                                        } else {
                                            $campoTabla = null;
                                            $valorCampoTabla = null;
                                        }
                                        $respuesta = ControladorSeatings::ctrMostrarListaSeatings($campoTabla, $valorCampoTabla);
                                        $contador = 1;
                                        foreach ($respuesta as $fila => $elemento) {
                                            $cadenaHora = $elemento["hora"];
                                            $cadenaHoraCorta = substr($cadenaHora, 0, 8);
                                            echo '
                          <tr>
                              <td>' . $contador . '</td>
                              <td>' . $elemento["nomRestaurante"] . '</td>                            
                             
                              <td>' . $elemento["diaSemana"] . '</td>
                              <td>' . $cadenaHoraCorta . '</td>
                              <td>' . $elemento["pm"] . '</td>
                              <td>' . $elemento["rm"] . '</td>';
                                            if ($elemento["estadoSeating"] != 0) {
                                                //si el estado es activado se habilita el botón de editar
                                                echo '
                              <td>
                                <button class="btn btn-success btn-xs btnActivarSeating" idSeating="' . $elemento["idSeating"] . '" estadoSeating="0">Activado
                                </button>
                              </td>
                              <td>
                                <button class="btn btn-success editarSeating" data-toggle="modal" data-target="#editarSeating" idSeatingEditar="' . $elemento["idSeating"] . '"><i class="fa fa-edit"></i>
                                </button>
                              </td>';
                                            } else {
                                                echo '
                                <td>
                                  <button class="btn btn-danger btn-xs btnActivarSeating" idSeating="' . $elemento["idSeating"] . '" estadoSeating="1">Desactivado
                                  </button>
                                </td>
                                <td>
                                  <button class="btn btn-warning editarSeating" data-toggle="modal" data-target="#editarSeating" idSeatingEditar="' . $elemento["idSeating"] . '"disabled><i class="fa fa-edit"></i>
                                  </button>
                                </td>';
                                            }
                                            echo '<td></td> 
                          </tr>';
                                            $contador++;
                                        }
                                        ?>
                                  </tbody>
                              </table>
                          </div>
                      </div>
                      <!-- FIN TABLA DE SEATINGS -->
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                      Footer
                  </div>
                  <!-- /.box-footer-->
              </div>
              <!-- /.box -->

          </section>
          <!-- /.content -->
      </div>

      <!-- /.content-wrapper-->
      <!-- =============================================
                                                                                                  MODAL PARA UN NUEVO SEATING
                                                                                                  =============================================-->
      <div id="nuevoSeating" class="modal fade" role="dialog">
          <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header modal-header-personalizado">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fas fa-edit"></i> Nuevo seating :: Crear nuevo horario</h4>
                  </div>
                  <div class="modal-body">
                      <!--======   FORMULARIO PARA registrar un nuevo seating ==-->
                      <div class="register-box-body">
                          <form method="post">
                              <div class="row">
                                  <div class="col-md-6 col-xs-12">
                                      <span><strong>Hotel</strong></span>
                                      <div class="input-group">
                                          <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                                          <select class="form-control" name="lstHotelNuevoSeating" id="lstHotelNuevoSeating" required>
                                              <option value=""></option>
                                              <?php
                                                $listaHotelesSeatings = new ControladorSeatings();
                                                $listaHotelesSeatings->ctrListaDeHotelesSelect();
                                                ?>
                                          </select>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-xs-12">
                                      <span><strong>Restaurante</strong></span>
                                      <div class="input-group">
                                          <div class="input-group-addon"><i class="fas fa-utensils"></i></div>
                                          <select class="form-control" name="lstNuevoSeatingRest" id="lstNuevoSeatingRest" required>
                                              <option value=""></option>
                                          </select>
                                      </div>
                                  </div>
                              </div><br>
                              <div class="row" id="elegirHorarioSeating">
                                  <div class="col-md-6 col-xs-12">
                                      <span><strong>Hora en formato 24 hrs</strong></span>
                                      <div class="input-group hidden" id="lstHoraSeating">
                                          <div class="input-group-addon"><i class="fas fa-clock"></i></div>
                                          <input type="text" class="form-control" id="catalogoHorarios" name="catalogoHorarios" id="catalogoHorarios" required />
                                          <!-- <select class="form-control" name="catalogoHorarios" id="catalogoHorarios" required>
                                                                                                                                        <option value=""></option>
                                                                                                                                        <?php
                                                                                                                                        // $nuevoSeatingHorario = new ControladorSeatings();
                                                                                                                                        // $nuevoSeatingHorario->ctrTraerCatalogoHorario();
                                                                                                                                        ?>                                    
                                                                                                                                    </select>                 -->
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-xs-12">
                                      <span><strong>Nota</strong></span>
                                      <div id="mensajeHoraDisponible">
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 col-xs-12">
                                      <span><strong>Cantidad de Pax</strong></span>
                                      <div class="input-group hidden" id="campoPaxModal">
                                          <div class="input-group-addon"><i class="fas fa-users"></i></div>
                                          <input type="number" class="form-control" id="numPaxModal" name="numPaxModal" min="1" max="100" required>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-xs-12">
                                      <span><strong>Cantidad de Reservas</strong></span>
                                      <div class="input-group hidden" id="campoPaxRSV">
                                          <div class="input-group-addon"><strong>RSV</strong></div>
                                          <input type="number" class="form-control" id="numRSVModal" name="numRSVModal" min="1" max="30" required>
                                      </div>
                                  </div>
                              </div>
                              <div class="row hidden">
                                  <div class="col-md-6 col-xs-12">
                                      <span><strong>IDHotel</strong></span>
                                      <div class="input-group">
                                          <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                          <input type="number" class="form-control" id="idHotelfield" name="idHotelfield" required>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-xs-12">
                                      <span><strong>IdRestaurante</strong></span>
                                      <div class="input-group">
                                          <div class="input-group-addon"><i class="fas fa-sort-numeric-up"></i></div>
                                          <input type="number" class="form-control" id="idRestaurantefield" name="idRestaurantefield" required>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-xs-5">
                                      <div class="checkbox icheck">
                                          <label>
                                              <a href="configuracion-seatings" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo "></i> Descartar</a>
                                          </label>
                                      </div>
                                  </div>
                                  <div class=" col-xs-offset-3 col-xs-4">
                                      <div class="checkbox icheck">
                                          <button type="submit" id="btnNuevoSeating" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-share-square"></i> Registrar
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                          <?php
                            $registrarSeating = new ControladorSeatings();
                            $registrarSeating->ctrRegistrarNuevoSeating();
                            ?>
                      </div>
                  </div>
                  <!-- <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                          </div> -->
              </div>

          </div>
      </div>
      <!--===== FIN DEL  MODAL PARA UN NUEVO SEATING======-->
      <!-- =============================================
                                                                                                  MODAL PARA EDITAR EL seating
                                                                                                  =============================================-->
      <div id="editarSeating" class="modal fade" role="dialog">
          <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                  <div class="modal-header modal-header-personalizado">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title"><i class="fas fa-edit"></i> Editar el seating</h4>
                  </div>
                  <div class="modal-body">
                      <!--======   FORMULARIO PARA EDITAR EL USUARIO ==-->
                      <div class="register-box-body">
                          <form method="post">

                              <div class="row">
                                  <div class="col-md-12 col-xs-12">
                                      <div class="well">
                                          <h4 id="nombreHotel"></h4>
                                          <ul class="list-group">
                                              <li class="list-group-item"><strong>Restaurante: </strong><span id="nombreRestaurante"></span></li>
                                              <li class="list-group-item"><strong>Día: </strong><span id="diaSeating"></span> <strong>Hora:</strong> <span id="horaSeating"></span> <strong>Num. de Pax: </strong><span id="numeroPax"></span> <strong>Num. de Reservas: </strong><span id="numeroReservas"></span></li>
                                          </ul>
                                      </div>
                                  </div>
                              </div>
                              <div class="row hidden">
                                  <div class="col-md-12 col-xs-12">
                                      <div class="form-group">
                                          <label for="usr">idSeating</label>
                                          <input type="number" class="form-control" id="idSeating" name="idSeating" readonly>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-6 col-xs-12">
                                      <div class="form-group">
                                          <label for="usr">Num. de Pax</label>
                                          <input type="number" class="form-control" id="numPaxEditar" name="numPaxEditar" min="1" max="100" required>
                                      </div>
                                  </div>
                                  <div class="col-md-6 col-xs-12">
                                      <div class="form-group">
                                          <label for="usr">Num. de Reservas</label>
                                          <input type="number" class="form-control" id="numRsvEditar" name="numRsvEditar" min="1" max="30" required>
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-xs-4">
                                      <div class="checkbox icheck">
                                          <label>
                                              <a href="configuracion-seatings" class="btn btn-warning btn-block btn-flat"><i class="fa fa-undo "></i> Descartar</a>
                                          </label>
                                      </div>
                                  </div>
                                  <div class=" col-sm-offset-4 col-xs-4">
                                      <div class="checkbox icheck">
                                          <button type="submit" id="regNuevoSeating" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-share-square"></i> Enviar
                                          </button>
                                      </div>
                                  </div>
                              </div>
                          </form>
                          <?php
                            $editarSeating = new ControladorSeatings();
                            $editarSeating->ctrEditarSeating();
                            ?>
                      </div>
                  </div>
                  <!-- <div class="modal-footer">
                                                                                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                                                                          </div> -->
              </div>

          </div>
      </div>
      <!--===== FIN DEL MODAL PARA EDITAR EL SEATING======-->
  <?php
} else {
    require "sinAcceso.php";
}
?>
  <script src="vistas/plugins/datatable/script.js"></script>