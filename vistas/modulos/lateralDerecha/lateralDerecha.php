<aside class="control-sidebar control-sidebar-dark "> <!-- control-sidebar-open mantiene abierta el sidebar -->
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">      
      <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab" aria-expanded="true"><i class="fas fa-utensils"></i></a></li>
      <li class=""><a href="#control-sidebar-home-tab2" data-toggle="tab" aria-expanded="false"><i class="fas fa-clock"></i> </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">

      <!-- Home tab content -->
      <div class="tab-pane active" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Reservas todo el día por restaurante</h3>
        
        <ul class="control-sidebar-menu">
        <?php 
          $item="idHotel";
          $valor=$_SESSION["idHotel"];
          /*Traigo la lista de restaurantes*/
          $respuesta = ControladorEstadisticas::ctrMostrarListaRestaurantes($item, $valor);                   
          /*recorro la lista de restaurantes*/
          $contador=1;
          foreach ($respuesta as $fila => $elemento) {

            date_default_timezone_set('UTC');
            $hoy = date("Y-m-d");
            
            $valorDeMiCampo =$_SESSION["idHotel"];
            $valorDeMiCampo2=$elemento["id"]; /*es el id del restaurante*/
            $valorDeMiCampo3=$hoy;
           /*traigo los pax y total reservas juntados en el día de acuerdo al restaurane, de la tabla reservas*/
            $respuestaCount = ControladorEstadisticas::ctrContarPaxAcumulados($valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3);

             //convierto el día de hoy a un valor numerico.
            $dias = array('', '1','2','3','4','5','6', '7');
            $miFecha = $valorDeMiCampo3;
            $diaResultado = $dias[date('N', strtotime($miFecha))];
             //el día convertido se ocupará para hacer una consulta             
            $valorDeMiCampoPax=$_SESSION["idHotel"];
            $valorDeMiCampoPax2=$elemento["id"];/*es el id del restaurante*/
            $valorDeMiCampoPax3=$diaResultado;
            /*traigo los pax y total reservas maximas del restaurante de acuerdo al día que le paso, de la tabla seatings*/
            $respuestaPax = ControladorEstadisticas::ctrCapacidadMaximaPaxDia($valorDeMiCampoPax,$valorDeMiCampoPax2,$valorDeMiCampoPax3);         
            /**$respuestaCount lo guardo en otra variable */          
            $sumaPax=$respuestaCount["sumaPax"];
            $totalReservas=$respuestaCount["totalReservas"];
              if($sumaPax==null){
                  $sumaPax=0;
                }else{
                  $sumaPax=$sumaPax;
                }
              /*guardo la suma de pax totales de todo el día, osea todos los horarios del restaurante*/           
              $paxTotalesDia= $respuestaPax["sumaPax"];
              $rsvTotalesdia= $respuestaPax["totalReservas"];
              /*hago un calculo con regla de tres para general porcentajes de ocupación */
              $porcentaje =100;
              $porcentajeValor=($sumaPax * $porcentaje) / $paxTotalesDia;
              $cutPercentCeros = bcdiv($porcentajeValor, '1', 0);/*corto el porcentaje para tomar solo 2 decimales */              
              if($cutPercentCeros<90){
                $colorPercet="success";
              }else{
                $colorPercet="danger";
              }
              // Reservas : '.$rsvTotalesdia.'
             echo '<li>
                      <a href="#restauranteSidebar'.$contador.'" style="text-decoration:none;color:white;" data-toggle="collapse"><i class="menu-icon fas fa-hotel bg-green"></i>
                      <div class="menu-info">
                            <h4 class="control-sidebar-subheading"><strong>'.$elemento["nombre"].'</strong></h4>
                            <div id="restauranteSidebar'.$contador.'" class="collapse">                        
                            Pax acumulados: '.$sumaPax.'<br>
                            Total de Reservas: '.$totalReservas.'<br>
                            Capacidad Pax día: '.$paxTotalesDia.' <br>
                            <span class="label label-'.$colorPercet.' pull-right">'.$cutPercentCeros.' %</span>
                              <br>
                              <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-'.$colorPercet.'" style="width: '.$cutPercentCeros.'%">
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
        <h3 class="control-sidebar-heading">Reservas a detalle</h3>
        <ul class="control-sidebar-menu">
        <?php 
          $item="idHotel";
          $valor=$_SESSION["idHotel"];
          /*Traigo la lista de restaurantes guardados en respuesta*/
          $respuesta = ControladorEstadisticas::ctrMostrarListaRestaurantes($item, $valor);                   
          /*recorro la lista de restaurantes con el foreach*/
          $contador2=1;
          foreach ($respuesta as $fila => $elemento) {
            /*genero la fecha de hoy para las consultas*/
            date_default_timezone_set('UTC');
            $hoy = date("Y-m-d");                                 
             //convierto el día de hoy a un valor numerico.
            $dias = array('', '1','2','3','4','5','6', '7');
            $miFecha = $hoy;
            $diaResultado = $dias[date('N', strtotime($miFecha))];/* tranformo el valor del dia en un valor numerico*/            
            $idRestaurante=$elemento["id"];
            echo '<li>
                    <a href="#restauranteSidebar2'.$contador2.'" style="text-decoration:none;color:white;" data-toggle="collapse"><i class="menu-icon fas fa-hotel bg-green"></i>
                      <div class="menu-info">
                            <h4 class="control-sidebar-subheading"><strong>'.$elemento["nombre"].'</strong><br><br></h4>
                            <div id="restauranteSidebar2'.$contador2.'" class="collapse">'; /*corto el cho aqui para generar una subconsulta */                            
                            $valorDeMiCampo=$_SESSION["idHotel"];/*idHotel*/
                            $valorDeMiCampo2=$idRestaurante;/*id del restaurante*/
                            $valorDeMiCampo3=$diaResultado;/*id del dia de la semana*/
                            /*Traigo los horarios del restaurante*/
                            $respuestaSeatingDia=ControladorEstadisticas::ctrMostrarSeatingDelDia($valorDeMiCampo,$valorDeMiCampo2,$valorDeMiCampo3);

                              foreach ($respuestaSeatingDia as $filaSeating => $elementoSeating) {
                                $horaLarga=$elementoSeating["horaSeating"];
                                $hora = substr($elementoSeating["horaSeating"], 0, 5);
                                $paxMaximo=$elementoSeating["paxMaximo"];
                                /*variables parametros para traer los pax acumulados de la hora*/
                                $idHotel2=$_SESSION["idHotel"];
                                $idRestaurante2=$idRestaurante;
                                $fechaHoy=$miFecha;
                                $horaSeating=$horaLarga;
                                /*ejecuto la consulta*/
                                $respuestaPaxHora=ControladorEstadisticas::ctrTraerPaxAcumuladoHora($idHotel2,$idRestaurante2,$fechaHoy,$horaSeating);
                                /*guardo los valores obtenidos en variables y se imprimen en cada hora*/
                                $sumaPaxHora=$respuestaPaxHora["sumaPax"];
                                $sumaRsvHora=$respuestaPaxHora["totalReservas"];
                                  if($sumaPaxHora==null){                                  
                                    $sumaPaxHora=0;
                                  }else{
                                    $sumaPaxHora=$sumaPaxHora;
                                  }
                                  $paxDisponible=$paxMaximo-$sumaPaxHora;
                                echo '<strong>Hora: '.$hora.' Cupo: '.$paxMaximo.'</strong> PaxAcumulados: '.$sumaPaxHora.'<br> Total de Reservas: '.$sumaRsvHora.'<br>Pax Disponibles: '.$paxDisponible.' <br><br>';

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
      <!-- /.tab-pane -->
    </div>
  </aside>