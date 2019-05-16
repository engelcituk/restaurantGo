<aside class="control-sidebar control-sidebar-dark ">
  <!-- control-sidebar-open mantiene abierta el sidebar -->
  <!-- Create the tabs -->
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-sun"></i> <strong>Día</strong></a></li>
    <li class=""><a href="#control-sidebar-home-tab2" data-toggle="tab" aria-expanded="false"><i class="fas fa-clock"></i><strong> horas</strong></a></li>
    <li class=""><a href="#control-sidebar-home-tab3" data-toggle="tab" aria-expanded="false"><i class="fas fa-calendar-alt"></i><strong> Fecha</strong></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">

    <!-- Home tab content -->
    <div class="tab-pane active" id="control-sidebar-home-tab">
      <h4 class="control-sidebar-heading"><strong>Reservas todo el día</strong> </h4>
      <ul class="control-sidebar-menu">
        <?php
        $item = "idHotel";
        $valor = $_SESSION["idHotel"];
        /*Traigo la lista de restaurantes*/
        $respuesta = ControladorEstadisticas::ctrMostrarListaRestaurantes($item, $valor);
        /*recorro la lista de restaurantes*/
        $contador = 1;
        foreach ($respuesta as $fila => $elemento) {

          date_default_timezone_set('UTC');
          $hoy = date("Y-m-d");
          $valorDeMiCampo = $_SESSION["idHotel"];
          $valorDeMiCampo2 = $elemento["id"]; /*es el id del restaurante*/
          $valorDeMiCampo3 = $hoy;
          /*traigo los pax y total reservas juntados en el día de acuerdo al restaurane, de la tabla reservas*/
          $respuestaCount = ControladorEstadisticas::ctrContarPaxAcumulados($valorDeMiCampo, $valorDeMiCampo2, $valorDeMiCampo3);

          //convierto el día de hoy a un valor numerico.
          $dias = array('', '1', '2', '3', '4', '5', '6', '7');
          $miFecha = $valorDeMiCampo3;
          $diaResultado = $dias[date('N', strtotime($miFecha))];
          //el día convertido se ocupará para hacer una consulta             
          $valorDeMiCampoPax = $_SESSION["idHotel"];
          $valorDeMiCampoPax2 = $elemento["id"]; /*es el id del restaurante*/
          $valorDeMiCampoPax3 = $diaResultado;
          /*traigo los pax y total reservas maximas del restaurante de acuerdo al día que le paso, de la tabla seatings*/
          $respuestaPax = ControladorEstadisticas::ctrCapacidadMaximaPaxDia($valorDeMiCampoPax, $valorDeMiCampoPax2, $valorDeMiCampoPax3);
          /**$respuestaCount lo guardo en otra variable */
          $sumaPax = $respuestaCount["sumaPax"];
          $totalReservas = $respuestaCount["totalReservas"];
          if ($sumaPax == null) {
            $sumaPax = 0;
          } else {
            $sumaPax = $sumaPax;
          }
          /*guardo la suma de pax totales de todo el día, osea todos los horarios del restaurante*/
          $paxTotalesDiaSeatings = $respuestaPax["sumaPax"];
          $paxTotalesDiaRestaurante = $elemento["paxMaximoDia"];
          $rsvTotalesdia = $respuestaPax["totalReservas"];
          /*hago un calculo con regla de tres para general porcentajes de ocupación */
          $porcentaje = 100;
          if ($paxTotalesDiaRestaurante == 0) {
            $porcentajeValor = 0;
          } else {
            $porcentajeValor = ($sumaPax * $porcentaje) / $paxTotalesDiaRestaurante;
          }
          $cutPercentCeros = bcdiv($porcentajeValor, '1', 0); /*corto el porcentaje para tomar solo 2 decimales */
          if ($cutPercentCeros < 90) {
            $colorPercet = "success";
          } else {
            $colorPercet = "danger";
          }
          // Reservas : '.$rsvTotalesdia.'
          echo '<li>
                      <a href="#restauranteSidebar' . $contador . '" style="text-decoration:none;color:white;" data-toggle="collapse"><i class="menu-icon fas fa-hotel bg-green"></i>
                      <div class="menu-info">
                            <h4 class="control-sidebar-subheading"><strong>' . $elemento["nombre"] . '</strong></h4>
                            <div id="restauranteSidebar' . $contador . '" class="collapse">                        
                            Pax acumulados: ' . $sumaPax . '<br>
                            Total de Reservas: ' . $totalReservas . '<br>
                            CapacidadPaxDía: ' . $elemento["paxMaximoDia"] . '<br>
                            TotalPaxSeatings: ' . $paxTotalesDiaSeatings . ' <br>
                            <span class="label label-' . $colorPercet . ' pull-right">' . $cutPercentCeros . ' %</span>
                              <br>
                              <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-' . $colorPercet . '" style="width: ' . $cutPercentCeros . '%">
                                </div>
                              </div>
                            </div>                
                          </div>
                      </a>          
                    </li>';
          $contador++;
        }
        ?>
      </ul>

      <!-- /.form-group -->
    </div>
    <div class="tab-pane" id="control-sidebar-home-tab2">
      <h4 class="control-sidebar-heading"><strong>A detalle por seating</strong></h4>

      <ul class="control-sidebar-menu">
        <?php
        $item = "idHotel";
        $valor = $_SESSION["idHotel"];
        /*Traigo la lista de restaurantes guardados en respuesta*/
        $respuesta = ControladorEstadisticas::ctrMostrarListaRestaurantes($item, $valor);
        /*recorro la lista de restaurantes con el foreach*/
        $contador2 = 1;
        foreach ($respuesta as $fila => $elemento) {
          /*genero la fecha de hoy para las consultas*/
          date_default_timezone_set('UTC');
          $hoy = date("Y-m-d");
          //convierto el día de hoy a un valor numerico.
          $dias = array('', '1', '2', '3', '4', '5', '6', '7');
          $miFecha = $hoy;
          $diaResultado = $dias[date('N', strtotime($miFecha))]; /* tranformo el valor del dia en un valor numerico*/
          $idRestaurante = $elemento["id"];
          echo '<li>
                    <a href="#restauranteSidebar2' . $contador2 . '" style="text-decoration:none;color:white;" data-toggle="collapse"><i class="menu-icon fas fa-hotel bg-green"></i>
                      <div class="menu-info">
                            <h4 class="control-sidebar-subheading"><strong>' . $elemento["nombre"] . '</strong><br><br></h4>
                            <div id="restauranteSidebar2' . $contador2 . '" class="collapse">'; /*corto el cho aqui para generar una subconsulta */
          $valorDeMiCampo = $_SESSION["idHotel"]; /*idHotel*/
          $valorDeMiCampo2 = $idRestaurante; /*id del restaurante*/
          $valorDeMiCampo3 = $diaResultado; /*id del dia de la semana*/
          /*Traigo los horarios del restaurante*/
          $respuestaSeatingDia = ControladorEstadisticas::ctrMostrarSeatingDelDia($valorDeMiCampo, $valorDeMiCampo2, $valorDeMiCampo3);

          foreach ($respuestaSeatingDia as $filaSeating => $elementoSeating) {
            $horaLarga = $elementoSeating["horaSeating"];
            $hora = substr($elementoSeating["horaSeating"], 0, 5);
            $paxMaximo = $elementoSeating["paxMaximo"];
            /*variables parametros para traer los pax acumulados de la hora*/
            $idHotel2 = $_SESSION["idHotel"];
            $idRestaurante2 = $idRestaurante;
            $fechaHoy = $miFecha;
            $horaSeating = $horaLarga;
            /*ejecuto la consulta*/
            $respuestaPaxHora = ControladorEstadisticas::ctrTraerPaxAcumuladoHora($idHotel2, $idRestaurante2, $fechaHoy, $horaSeating);
            /*guardo los valores obtenidos en variables y se imprimen en cada hora*/
            $sumaPaxHora = $respuestaPaxHora["sumaPax"];
            $sumaRsvHora = $respuestaPaxHora["totalReservas"];
            if ($sumaPaxHora == null) {
              $sumaPaxHora = 0;
            } else {
              $sumaPaxHora = $sumaPaxHora;
            }
            $paxDisponible = $paxMaximo - $sumaPaxHora;
            echo '<strong>Hora: ' . $hora . ' Cupo: ' . $paxMaximo . '</strong> PaxAcumulados: ' . $sumaPaxHora . '<br> Total de Reservas: ' . $sumaRsvHora . '<br>Pax Disponibles: ' . $paxDisponible . ' <br><br>';
          }
          echo '      </div>                
                                    </div>
                                  </a>          
                                </li>';
          $contador2++;
        }
        ?>
      </ul>
    </div>
    <div class="tab-pane" id="control-sidebar-home-tab3">

      <h4 class="control-sidebar-heading"><strong>Indique una fecha</strong> <a href="hacer-reservas" class="btn btn-warning btn-sm"><i class="fas fa-undo"></i></a></h4>

      <?php
      date_default_timezone_set('UTC');
      $fechaMinimo = date("Y-m-d");
      date_default_timezone_set('UTC');
      // $hoy = date("Y-m-d");
      if (isset($_GET["fechaSeleccionada"])) {
        $hoy = $_GET["fechaSeleccionada"];
        $fechaMinimo = $_GET["fechaSeleccionada"];
      } else {
        $hoy = date("Y-m-d");
        $fechaMinimo = date("Y-m-d");
      }
      ?>
      <!-- <div class="input-group"> -->
      <!-- <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div> -->
      <input type="date" class="form-control" min="<?php echo  $fechaMinimo; ?>" id="fechaRsvFiltro" name="fechaRsvFiltro" value="<?php echo  $fechaMinimo; ?>">
      <!-- </div> -->
      <input type="number" class="form-control hidden" id="idHotelLateral" name="idHotelLateral" value="<?php echo  $_SESSION["idHotel"];; ?>" readonly>
      <ul class="control-sidebar-menu">
        <?php
        $item = "idHotel";
        $valor = $_SESSION["idHotel"];
        /*Traigo la lista de restaurantes guardados en respuesta*/
        $respuesta = ControladorEstadisticas::ctrMostrarListaRestaurantes($item, $valor);
        /*recorro la lista de restaurantes con el foreach*/
        $contador3 = 1;
        foreach ($respuesta as $fila => $elemento) {
          /*genero la fecha de hoy para las consultas*/

          //convierto el día de hoy a un valor numerico.
          $dias = array('', '1', '2', '3', '4', '5', '6', '7');
          $miFechaObtenida = $hoy;
          $diaResultado = $dias[date('N', strtotime($miFechaObtenida))]; /* tranformo el valor del dia en un valor numerico*/
          $idRestaurante = $elemento["id"];
          echo '<li>
        <a href="#restauranteSidebar3' . $contador3 . '" style="text-decoration:none;color:white;" data-toggle="collapse"><i class="menu-icon fas fa-hotel bg-green"></i>
            <div class="menu-info">
                <h4 class="control-sidebar-subheading"><strong>' . $elemento["nombre"] . '</strong><br><br></h4>
                <div id="restauranteSidebar3' . $contador3 . '" class="collapse">'; /*corto el cho aqui para generar una subconsulta */
          $valorDeMiCampo = $_SESSION["idHotel"]; /*idHotel*/
          $valorDeMiCampo2 = $idRestaurante; /*id del restaurante*/
          $valorDeMiCampo3 = $diaResultado; /*id del dia de la semana*/
          /*Traigo los horarios del restaurante*/
          $respuestaSeatingDia = ControladorEstadisticas::ctrMostrarSeatingDelDia($valorDeMiCampo, $valorDeMiCampo2, $valorDeMiCampo3);

          foreach ($respuestaSeatingDia as $filaSeating => $elementoSeating) {
            $horaLarga = $elementoSeating["horaSeating"];
            $hora = substr($elementoSeating["horaSeating"], 0, 5);
            $paxMaximo = $elementoSeating["paxMaximo"];
            /*variables parametros para traer los pax acumulados de la hora*/
            $idHotelFecha = $_SESSION["idHotel"];
            $idRestauranteFecha = $idRestaurante;
            $fechaValor = $miFechaObtenida;
            $horaSeating = $horaLarga;
            /*ejecuto la consulta*/
            $respuestaPaxHora = ControladorEstadisticas::ctrTraerPaxAcumuladoHora($idHotelFecha, $idRestauranteFecha, $fechaValor, $horaSeating);
            /*guardo los valores obtenidos en variables y se imprimen en cada hora*/
            $sumaPaxHora = $respuestaPaxHora["sumaPax"];
            $sumaRsvHora = $respuestaPaxHora["totalReservas"];
            if ($sumaPaxHora == null) {
              $sumaPaxHora = 0;
            } else {
              $sumaPaxHora = $sumaPaxHora;
            }
            $paxDisponible = $paxMaximo - $sumaPaxHora;
            echo '<strong>Hora: ' . $hora . ' Cupo: ' . $paxMaximo . '</strong> PaxAcumulados: ' . $sumaPaxHora . '<br> Total de Reservas: ' . $sumaRsvHora . '<br>Pax Disponibles: ' . $paxDisponible . ' <br><br>';
          }
          echo '      </div>                
                        </div>
                        </a>          
                    </li>';
          $contador3++;
        }
        ?>
      </ul>
    </div>
    <!-- /.tab-pane -->
  </div>
</aside>