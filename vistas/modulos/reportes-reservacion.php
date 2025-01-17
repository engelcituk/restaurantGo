<?php
if ($_SESSION["REPORTES"] == 1) {

  ?>
  <!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $_SESSION["nombreHotel"]; ?> : Reportes
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Reportes</a></li>
        <li class="active"><?php echo $_SESSION["nombreHotel"]; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-info">
        <div class="box-header with-border">
          <div class="row">
            <?php
            if (isset($_GET["nomRest"])) {
              $nombreRestaurante = $_GET["nomRest"];
              $fechaInicio = $_GET["fechaInicio"];
              $fechaFinal = $_GET["fechaFinal"];
              $nombreRestauranteSelec = $nombreRestaurante;
            } else {
              $nombreRestaurante = "Restaurante";
              $fechaInicio = "Fecha Inicio";
              $fechaFinal = "Fecha Final";
              $nombreRestauranteSelec = "Elija restaurante";
            }
            ?>
            <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-hotel"></i> <?php echo $_SESSION["nombreHotel"]; ?></a></li>
                  <li class="breadcrumb-item"><a href="#"> <i class="fas fa-list-ul"></i> <?php echo $nombreRestaurante ?></a></li>
                  <li class="breadcrumb-item"><i class="fas fa-calendar-alt"></i> <?php echo $fechaInicio . " / " . $fechaFinal ?></li>
                </ol>
              </nav>
            </div>
            <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
              <?php
              if (isset($_GET["idRest"])) {
                $estadoBoton = "";
              } else {
                $estadoBoton = "hidden";
              }
              ?>
              <a href="reportes-reservacion" id="btnResetearFiltro" class="btn btn-sm btn-warning <?php echo $estadoBoton; ?>">
                <i class="fas fa-undo"></i> Descartar Filtro
              </a>
            </div>
          </div>

        </div>
        <div class="box-body">
          <form action="#" id="filtroFormulario">
            <div class="row">
              <form action="">
                <div class="col-md-3 col-xs-12 hidden">
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fas fa-heading"></i></div>
                    <input type="text" class="form-control" name="hotel" id="hotel" value="<?php echo $_SESSION["nombreHotel"]; ?>" readonly>
                  </div>
                </div>
                <div class="col-md-3 col-xs-12">
                  <span><strong>Restaurantes y ordenar por</strong></span><br><br>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fas fa-utensils"></i></div>
                    <!-- traigo los restaurantes de acuerdo al id del hotel -->
                    <?php
                    $campo = "idHotel";
                    $valorCampo = $_SESSION["idHotel"];
                    $respuesta = ControladorRestaurantes::ctrMostrarListaRestaurantes($campo, $valorCampo);
                    echo '<select class="form-control" id="lstRestaurantesReportes" required>
                      <option value="">' . $nombreRestauranteSelec . '</option>';
                    foreach ($respuesta as $fila => $elemento) {
                      echo '                              
                        <option idRestaurante="' . $elemento["id"] . '" value="' . $elemento["id"] . '">' . $elemento["nombre"] . '</option>                            
                              ';
                    }
                    echo '</select>';
                    ?>
                  </div>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fas fa-sort-amount-up"></i></div>
                    <select class="form-control" id="ordenFiltroDatos">
                      <option value="fechaDeLaReserva ASC, hora ASC">Fecha Reserva ASC</option>
                      <option value="fechaDeLaReserva DESC, hora ASC">Fecha Reserva DESC</option>
                      <option value="habitacion ASC">No. Hab ASC</option>
                      <option value="habitacion DESC">No. Hab DESC</option>
                      <option value="apellido ASC">Apellido ASC</option>
                      <option value="apellido DESC">Apellido DESC</option>
                      <option value="nombreRestaurante ASC">Restaurante ASC</option>
                      <option value="nombreRestaurante DESC">Restaurante DESC</option>
                      <option value="fechaDeLaReserva ASC, hora ASC">Hora ASC</option>
                      <option value="fechaDeLaReserva ASC, hora DESC">Hora DESC</option>
                      <option value="usuario ASC">Usuario ASC</option>
                      <option value="usuario DESC">Usuario DESC</option>
                    </select>
                  </div>
                </div>

                <div class="col-md-3 col-xs-12">
                  <?php
                  date_default_timezone_set('UTC');
                  $hoy = date("Y-m-d");

                  if (isset($_GET["fechaInicio"])) {
                    $fechaInicioCampo = $_GET["fechaInicio"];
                    $fechaFinalCampo = $_GET["fechaFinal"];
                  } else {
                    $fechaInicioCampo = "";
                    $fechaFinalCampo = "";
                  }
                  ?>
                  <span><strong>Fecha Inicio</strong></span><br><br>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                    <input type="date" class="form-control" id="fechaReporte" name="fechaReporte" value="<?php echo $fechaInicioCampo; ?>">
                  </div>

                </div>
                <div class="col-md-3 col-xs-12">
                  <span><strong>Fecha final</strong></span><br><br>
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                    <input type="date" class="form-control" id="fechaReporteFin" name="fechaReporte" value="<?php echo $fechaFinalCampo; ?>">
                  </div>


                </div>
                <div class="col-md-3 col-xs-6">
                  <span><strong>Ver/descargar reporte</strong></span><br><br>
                  <?php
                  if (isset($_GET["idRest"]) || isset($_GET["fechaInicio"])) {
                    $estadoBoton = "";
                    $mostrarBotones = "";
                    $mostrarBotonesPdfExcel = "hidden";
                  } else {
                    $estadoBoton = "hidden";
                    $mostrarBotones = "hidden";
                    $mostrarBotonesPdfExcel = "";
                  }
                  ?>
                  <div class="input-group <?php echo  $mostrarBotones; ?>">
                    <a href="#" id="btnReporte" class="btn btn-info <?php echo  $estadoBoton; ?> "><i class="fas fa-file-pdf"></i> PDF</a><span>&nbsp &nbsp</span>
                    <?php
                    if (isset($_GET["fechaInicio"])) {
                      $idRestauranteInforme = $_GET["idRest"];
                      $nombreRestaurante = $_GET["nomRest"];
                      $fechaInformeInicio = $_GET["fechaInicio"];
                      $fechaInformefinal = $_GET["fechaFinal"];
                      $ordenamiento = $_GET["orden"];
                    } else {
                      $idRestauranteInforme = "";
                      $nombreRestaurante = "";
                      $fechaInformeInicio = "";
                      $fechaInformefinal = "";
                      $ordenamiento = "";
                    }
                    ?>
                    <a href="vistas/modulos/descargar-excel.php?reporte=reporte&idRest=<?php echo $idRestauranteInforme ?>&fechaInicio=<?php echo $fechaInformeInicio ?>&fechaFinal=<?php echo $fechaInformefinal ?>&nomRest=<?php echo $nombreRestaurante ?>&orden=<?php echo $ordenamiento ?>" id="btnReporteExcel" class="btn btn-success <?php echo  $estadoBoton; ?>"><i class="fas fa-file-excel"></i> EXCEL</a>
                  </div>
                  <div id="botonesReportePdfExcel" class=" <?php echo  $mostrarBotonesPdfExcel; ?>"></div>
                </div>
              </form>
            </div>
          </form>
          <br><br>

          <!-- TABLA DE RESERVAS -->
          <div class="row">
            <div id="reservas" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <table id="tblReservasReporte" class="table table-striped dt-responsive nowrap">
                <thead>
                  <tr>
                    <th>No.</th>
                    <th>Fecha Reserva</th>
                    <th>No. Hab</th>
                    <th>Apellido</th>
                    <th>Restaurante</th>
                    <th>Pax</th>
                    <th>Hora</th>
                    <th>NombreTicket</th>
                    <th>Usuario</th>
                    <th>Comentarios</th>

                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- LLAMO AL CONTROLADOR PARA TRAER LA LISTA DE RESERVAS -->
                  <?php
                  if (!isset($_GET["idRest"]) && isset($_GET["fechaInicio"]) && isset($_GET["fechaFinal"])) {
                    $valorCampoTabla = 0;
                    $valorCampoTabla2 = $_GET["fechaInicio"];
                    $valorCampoTabla3 = $_GET["fechaFinal"];
                    $valorCampoTabla4 = $_GET["orden"];
                  } elseif (isset($_GET["idRest"]) && isset($_GET["fechaInicio"]) && isset($_GET["fechaFinal"])) {
                    $valorCampoTabla = $_GET["idRest"];
                    $valorCampoTabla2 = $_GET["fechaInicio"];
                    $valorCampoTabla3 = $_GET["fechaFinal"];
                    $valorCampoTabla4 = $_GET["orden"];
                  } else {
                    $valorCampoTabla = 0;
                    $valorCampoTabla2 = null;
                    $valorCampoTabla3 = null;
                    $valorCampoTabla4 = "fechaDeLaReserva ASC";
                  }


                  $respuesta = ControladorReportes::ctrMostrarListaReservas($valorCampoTabla, $valorCampoTabla2, $valorCampoTabla3, $valorCampoTabla4);
                  $contador = 1;
                  foreach ($respuesta as $fila => $elemento) {
                    $cortarCadenaHora = substr($elemento["hora"], 0, 8);
                    echo '
                          <tr id="' . $elemento["id"] . '">
                              <td>' . $contador . '</td>
                              <td>' . $elemento["fechaDeLaReserva"] . '</td>
                              <td>' . $elemento["habitacion"] . '</td>
                              <td>' . $elemento["apellido"] . '</td>
                              <td>' . $elemento["nombreRestaurante"] . '</td>
                              <td>' . $elemento["pax"] . '</td>
                              <td>' . $cortarCadenaHora . '</td>                                              
                              <td>' . $elemento["ticket"] . '</td> 
                              <td>' . $elemento["usuario"] . '</td> 
                              <td>' . $elemento["observaciones"] . '</td>
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
<?php
} else {
  require "sinAcceso.php";
}
?>
<script src="vistas/plugins/datatable/script.js"></script>