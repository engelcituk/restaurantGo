 <?php 
  if($_SESSION["C-RSVXESTANCIA"]==1){
 ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reservas por noches de estancia
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fas fa-tachometer-alt"></i> Configuracion</a></li>
        <li class="active">Reservas por estancia</li>
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
          <?php 
                if (isset($_GET["nomHotel"])) {
                    $nombreHotel=$_GET["nomHotel"];
                    $hotel="Filtro ".$_GET["nomHotel"];                        
                  } else {
                    $nombreHotel="Elige Hotel";                       
                    $hotel="Todos los hoteles";                       
                }
              ?>
            <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-hotel"></i> <?php echo $hotel ?></a></li>                                                        
                </ol>
              </nav> 
            </div>                        
          </div>
          <div class="row">  
             <form action="">
              <div class="col-md-4 col-xs-12">
                <a href="#" class="btn btn-success btn-flat" data-toggle="modal" data-target="#nuevoConfigModal"><i class="fa fa-plus"></i> Nueva Configuracion</a> 
              </div>
              <div class="col-md-3 col-xs-12">
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                  <select class="form-control" name="lstSelectHotelConfig" id="lstSelectHotelConfig" required>
                      <option value=""><?php echo $nombreHotel ?></option>
                      <?php 
                        $listaHoteles= new ControladorReservaEstancia();
                        $listaHoteles->ctrListaDeHotelesSelect();
                      ?>                    
                  </select>
                </div>
              </div>             
              
              <div class="col-md-4 col-xs-12" >
                <?php 
                  if (isset($_GET["idHotel"])) {
                    $estadoBoton="";
                    } else {
                      $estadoBoton="hidden";
                    }
                 ?>
              <a href="config-reservas-estancia" class="btn btn-warning btn-flat <?php echo $estadoBoton; ?>"><i class="fa fa-undo"></i> Descartar</a> 
              </div>                        
             </form>                        
          </div>
        </div>
        <div class="box-body">
          <!-- Tabla de reservas -->
          <div id="configs" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <div>
            <table id="tblCrudConfigs" class="table table-striped dt-responsive nowrap">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Hotel</th>
                  <th>Noches</th>
                  <th>Reservas</th>
                  <th>Estado</th>
                  <th>Herramientas</th>
                  <th></th>

                </tr>
              </thead>
              <tbody>
                <!-- aqui va mis consultas en un datatable -->
                <?php 
                  if (isset($_GET["idHotel"])) {

                    $campoTabla ="idHotel";
                    $valorCampoTabla =$_GET["idHotel"];
                    } else {

                      $campoTabla =null;
                      $valorCampoTabla =null;
                    }
                                    
                  $respuesta = ControladorReservaEstancia::ctrMostrarListaConfiguraciones($campoTabla,$valorCampoTabla);
                  $contador=1;
                  foreach ($respuesta as $fila => $elemento) {
                    echo '
                    <tr>
                        <td>'.$contador.'</td>
                        <td>'.$elemento["nombreHotel"].'</td>
                        <td>'.$elemento["nocheEstancia"].'</td>
                        <td>'.$elemento["numMaxRsv"].'</td>'
                        ;
                        if ($elemento["state"]!=0) {

                          echo '<td><button class="btn btn-success btn-xs btnActivarConfig" idRsvEstancia="'.$elemento["idConfig"].'" estadoConfig="0">Activado</button></td>';
                        }else{
                          echo'<td><button class="btn btn-danger btn-xs btnActivarConfig" idRsvEstancia="'.$elemento["idConfig"].'" estadoConfig="1">Desactivado</button></td>';

                        }
                        echo '<td>
                              <a href="#" class="btn btn-success editConfigRsv" data-toggle="modal" data-target="#editConfigRsv" nombreHotel="'.$elemento["nombreHotel"].'" idRsvEstancia="'.$elemento["idConfig"].'"><i class="fa fa-edit"></i> </a>
                              
                              <button class="btn btn-danger eliminarConfig" idRsvEstancia="'.$elemento["idConfig"].'" disabled><i class="fa fa-trash "></i></button>               
                        </td>

                        <td></td>
                    </tr>';
                    $contador++;
                }
              ?>
              </tbody>
            </table>        
            </div>
            </div>
          <!-- Fin tabla de config -->
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
  MODAL PARA EDITAR LA CONFIGURACION DE RESERVAS
  POR NOCHES DE ESTANCIA
  =============================================-->
<div id="editConfigRsv" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fas fa-edit"></i> Editar configuración: <span id="nombreHotelModal"></span> </h4>
      </div>
      <div class="modal-body">                        
        <div class="register-box-body">              
          <form method="post">                                        
            <div class="row hidden">
              <div class="col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="usr">idConf NochexEstancia</label>
                    <input type="number" class="form-control" id="idRsvPorEstancia" name="idRsvPorEstancia" readonly>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6 col-xs-12">
                  <label for="usr">Noches de Estancia</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-moon"></i></div>
                  <input type="number" class="form-control" id="numNochesEstancia" name="numNochesEstancia" min="1" max="100" required readonly>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                  <label for="usr">Nuevo Num. máximo de Reservas</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-list-ol"></i></div>
                  <input type="number"  class="form-control" id="numNuevoTotalRsvs" name="numNuevoTotalRsvs" min="1" max="100" required>
                </div>
              </div>
            </div><br>
            <div class="row">
              <div class="col-md-6 col-xs-12">
                  <label for="usr">Num. máximo de Reservas Anterior</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-list-ol"></i></div>
                  <input type="number" class="form-control" id="numAnteriorTotalRsvs" name="numAnteriorTotalRsvs" min="1" max="100" required readonly>
                </div>
              </div>              
            </div>                
            <div class="row">
              <div class="col-xs-4">
                <div class="checkbox icheck">
                  <label>
                  <a href="config-reservas-estancia" class="btn btn-warning btn-block btn-flat" ><i class="fa fa-undo "></i> Descartar</a> 
                  </label>
                </div>
              </div>
              <div class=" col-sm-offset-4 col-xs-4">
                <div class="checkbox icheck">
                  <button type="submit" id="btnConfigNocheEstancia" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-save"></i> Guardar
                  </button>
                </div>
              </div>                   
            </div>                    
          </form>
          <?php 
            $editarConfRvsEstancia = new ControladorReservaEstancia();
            $editarConfRvsEstancia->ctrEditarReservaEstancia();
          ?>               
        </div>
      </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
    </div>

  </div>
</div>
<!--===== MODAL PARA EDITAR LA CONFIGURACION DE RESERVAS POR NOCHES DE ESTANCIA======-->
  <!-- =============================================
  MODAL PARA crear una CONFIGURACION DE RESERVAS
  POR NOCHES DE ESTANCIA
  =============================================-->
<div id="nuevoConfigModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fas fa-edit"></i> Crear nueva configuración</h4>
      </div>
      <div class="modal-body">
        <div class="register-box-body">              
          <form method="post">                    
                        
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <label for="usr">Hotel</label>
                <div class="input-group">                 
                  <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                  <select class="form-control" name="newLstSelectHotelConfig" id="newLstSelectHotelConfig" required>
                      <option value="">Elige Hotel</option>
                      <?php 
                        $listaHoteles= new ControladorReservaEstancia();
                        $listaHoteles->ctrListaDeHotelesSelect();
                      ?>                    
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-xs-12 hidden">
                <label for="usr">IDhotel</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-moon"></i></div>
                  <input type="number" class="form-control" id="idHotelNoches" name="idHotelNoches" min="1" max="100" required readonly>
                </div>
              </div>
            </div><br>
            <div class="row" >
              <div class="col-md-6 col-xs-12">
                <label for="usr">Núm. Noches de Estancia</label>
                <div class="input-group hidden" id="nochesEstanciaOculto">
                  <div class="input-group-addon"><i class="fas fa-moon"></i></div>
                  <input type="number" class="form-control " id="regNochesEstancia" name="regNochesEstancia" min="1" max="100" required>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                  <label for="usr">Num. máximo de Reservas</label>
                <div class="input-group hidden" id="numMaxRsvOculto">
                  <div class="input-group-addon"><i class="fas fa-list-ol"></i></div>
                  <input type="number"  class="form-control" id="regNuevoNumMaxRsvs" name="regNuevoNumMaxRsvs" min="0" max="100" required>
                </div>
              </div>
            </div><br><span id="rowNumNochesEstancia"></span>
                            
            <div class="row">
              <div class="col-xs-4">
                <div class="checkbox icheck">
                  <label>
                  <a href="config-reservas-estancia" class="btn btn-warning btn-block btn-flat" ><i class="fa fa-undo "></i> Descartar</a> 
                  </label>
                </div>
              </div>
              <div class=" col-sm-offset-4 col-xs-4">
                <div class="checkbox icheck">
                  <button type="submit" id="btnConfEstanciaGuardar" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-save"></i> Guardar
                  </button>
                </div>
              </div>                   
            </div>                    
          </form>
          <?php 
            $registrarConf = new ControladorReservaEstancia();
            $registrarConf->ctrRegConfiguracionEstancia();
          ?>               
        </div>
      </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
    </div>

  </div>
</div>
<!--===== MODAL PARA crear LA CONFIGURACION DE RESERVAS POR NOCHES DE ESTANCIA======-->

  <!--CONTROLADOR DEL BORRADO DE una configuracion reserva por estancia -->
 <?php 
    $borrarConfig = new ControladorReservaEstancia();
    $borrarConfig -> ctrBorrarConfiguracionEstancia();
}
  else{
    require "sinAcceso.php";
}
?>
<script src="vistas/plugins/datatable/script.js"></script>