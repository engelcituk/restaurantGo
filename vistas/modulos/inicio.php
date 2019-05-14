<?php
if ($_SESSION["HACER RESERVAS"] == 1 || $_SESSION["SUBMENU LATERAL"] == 1) {
  ?>
  <!--=====================================
                    PÁGINA DE INICIO 
                    ======================================-->
  <!-- content-wrapper -->
  <div class="content-wrapper">

    <!-- content-header -->
    <section class="content-header">

      <h1>
        Huespedes del hotel
        <?php
        $idHotel = $_SESSION["idHotel"];
        ?>
        <small><?php echo $_SESSION["nombreHotel"]; ?> </small>
      </h1>

      <ol class="breadcrumb">

        <li><a href="inicio"><i class="fa fa-dashboard"></i> Inicio</a></li>
        <li class="active">Huespedes del hotel</li>

      </ol>

    </section>
    <!-- content-header -->

    <!-- content -->
    <section class="content">
      <div class="box box-success">
        <div class="box-header with-border">

          <!-- <h3 class="box-title">Title</h3> -->

          <div class="pull-right">
            <!-- <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                  <i class="fa fa-minus"></i></button> -->
            <!-- <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                  <i class="fa fa-times"></i></button> -->
            <div id="btnDocsListaDatatable">

            </div>
          </div>
        </div>
        <div class="box-body">
          <!-- Start creating your amazing application! -->
          <!-- Tabla de reservas -->
          <div id="ReservasReservix" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div>
              <table id="tablaReservasReservix" class="table table-striped dt-responsive nowrap">
                <thead>
                  <tr>
                    <th>Reserva</th>
                    <th>Hotel</th>
                    <th>Apellido</th>
                    <th>Habitacion</th>
                    <th>Ocupantes</th>                    
                    <th>Noches</th>
                    <th>Fecha Entrada</th>
                    <th>Fecha Salida</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>

                  <?php

                  $dbo = "dbo.";
                  $empresa = $_SESSION["empresaSQLSRV"];
                  $simboloDollar = '$';
                  $cadena = str_replace(' ', '', $dbo . $empresa . $simboloDollar); //Quito espacios para obtener->  dbo.CARACOL$                  
                  $tabla = $cadena . "Reservas"; // dbo.CARACOL$Reservas
                  $valorCampo = null; //seria el campo de habitacion
                  $ocupantes = $cadena . "Ocupantes"; // dbo.CARACOL$Ocupantes                                   
                  $hotel = $_SESSION["hotelSQLSRV"]; //lo ocupo para el where con el and

                  $reservasRestaurantGo = ControladorHuesped::ctrMostrarListasHuesped($tabla, $valorCampo, $ocupantes, $hotel);

                  foreach ($reservasRestaurantGo as $fila => $elemento) {

                    $cadenaFechaEntrada = $elemento["FechaEntrada"];
                    $fechaEntradaCorta = substr($cadenaFechaEntrada, 0, 10);

                    $cadenaFechaSalida = $elemento["FechaSalida"];
                    $fechaSalidadaCorta = substr($cadenaFechaSalida, 0, 10);

                    echo '<tr>
                                <td>' . $elemento["Reserva"] . '</td>
                                <td>' . $elemento["Hotel"] . '</td>
                                <td>' . $elemento["Apellido"] . '</td>
                                <td>' . $elemento["Habitacion"] . '</td>
                                <td>' . $elemento["Ocupantes"] . '</td>                                
                                <td>' . $elemento["Noches"] . '</td>
                                <td>' . $fechaEntradaCorta . '</td>
                                <td>' . $fechaSalidadaCorta . '</td>
                    <td></td>
                  </tr>';
                  }
                  ?>

                </tbody>
              </table>
            </div>

          </div>
          <!-- Fin tabla de reservas -->
          <?php
          // echo $_SESSION["HACER RESERVAS"];
          // echo $_SESSION["ACTIVAR RESERVAS"]; 
          // echo $_SESSION["REIMPRIMIR TICKET"];
          // echo $_SESSION["EDITAR RESERVAS"];            
          // echo $_SESSION["BORRAR RESERVAS"];
          // echo $_SESSION["REPORTES"];
          // echo $_SESSION["CONFIGURACION"];
          ?>
        </div>
        <!-- /.box-body -->
        <!-- <div class="box-footer">
                              Footer
                            </div> -->
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->


    </section>
    <!-- content -->

  </div>
  <!-- content-wrapper -->
<?php
} else {
  require "sinAcceso.php";
}
?>
<script src="vistas/plugins/datatable/script.js"></script>