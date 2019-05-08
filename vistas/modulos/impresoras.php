<?php 
  if($_SESSION["C-IMPRESORAS"]==1){
 ?>
<!-- =============================================== --> 
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Gestor Impresoras
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fas fa-print"></i> Configuración</a></li>
        <li class="active">Impresoras</li>
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
                    $hotel=$_GET["nomHotel"];                        
                  } else {
                    $nombreHotel="Elige Hotel";                       
                    $hotel="Todos hoteles";                       
                }
              ?>
            <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="#"><i class="fas fa-hotel"></i> <?php echo $hotel?></a></li>                                                        
                </ol>
              </nav> 
            </div>                        
          </div>
          <div class="row">  
             <form action="">
              <div class="col-md-4 col-xs-12">
                <a href="#" class="btn btn-success btn-flat" data-toggle="modal" data-target="#nuevaImpresora"><i class="fa fa-plus"></i> Nueva Impresora</a> 
              </div>
              <div class="col-md-3 col-xs-12">                
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                  <select class="form-control" name="lstSelectHotelPrinters" id="lstSelectHotelPrinters" required>
                      <option value=""><?php echo $nombreHotel?></option>
                      <?php 
                        $listaHoteles= new ControladorImpresoras();
                        $listaHoteles->ctrListaDeHotelesSelect();
                      ?>   
                      <option idhotelLstPrinter="TODOS" value="TODOS"><a href="impresoras">TODOS</a></option>                 
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
              <a href="impresoras" class="btn btn-warning btn-flat <?php echo $estadoBoton; ?>"><i class="fa fa-undo"></i> Descartar</a> 
              </div>                        
             </form>                        
          </div>
        </div>
        <div class="box-body">
          <!-- Tabla de reservas -->
          <div id="configs" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
           <div>
            <table id="tblCrudImpresoras" class="table table-striped dt-responsive nowrap">
              <thead>
                <tr>
                  <th>No.</th>
                  <th>Hotel</th>
                  <th>Ip Impresora</th>
                  <th>impresora</th>
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
                                    
                   $respuesta = ControladorImpresoras::ctrMostrarListaCompletaImpresoras($campoTabla,$valorCampoTabla);
                   $contador=1;

                  foreach ($respuesta as $fila => $elemento) {
                    echo '
                    <tr>
                        <td>'.$contador.'</td>
                        <td>'.$elemento["nombreHotel"].'</td>
                        <td>'.$elemento["ipImpresora"].'</td>
                        <td>'.$elemento["nombreImpresora"].'</td>'
                        ;
                        if ($elemento["estadoImpresora"]!=0) {

                          echo '<td><button class="btn btn-success btn-xs btnActivarImpresora" idImpresora="'.$elemento["idImpresora"].'" attrEstadoImpresora="0">Activado</button></td>';
                        }else{
                          echo'<td><button class="btn btn-danger btn-xs btnActivarImpresora" idImpresora="'.$elemento["idImpresora"].'" attrEstadoImpresora="1">Desactivado</button></td>';

                        }
                        echo '<td>
                              <a href="#" class="btn btn-success editImpresora" data-toggle="modal" data-target="#editImpresora" nombreHotel="'.$elemento["nombreHotel"].'" idImpresora="'.$elemento["idImpresora"].'"><i class="fa fa-edit"></i> </a>
                              
                              <button class="btn btn-danger eliminarImpresora hidden" idImpresora="'.$elemento["idImpresora"].'" disabled><i class="fa fa-trash "></i></button>               
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

    <!-- =============================================
  MODAL PARA REGISTRAR UNA NUEVA IMPRESORA
  =============================================-->
<div id="nuevaImpresora" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fas fa-edit"></i> Registrar nueva impresora</h4>
      </div>
      <div class="modal-body">
        <div class="register-box-body">              
          <form method="post">                    
                        
            <div class="row">
              <div class="col-md-6 col-xs-12">
                <label for="usr">Hotel</label>
                <div class="input-group">                 
                  <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                  <select class="form-control" name="newLstHotelesModal" id="newLstHotelesModal" required>
                      <option value="">Elige Hotel</option>                      
                      <?php 
                        $listaHoteles= new ControladorReservaEstancia();
                        $listaHoteles->ctrListaDeHotelesSelect();
                        ?>  
                        <!-- <option value="TODOS">TODOS</option>                  -->
                  </select>
                </div>
              </div>
              <div class="col-md-6 col-xs-12 hidden">
                <label for="usr">IDhotel</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-hotel"></i></div>
                  <input type="number" class="form-control" id="idHotelImpresora" name="idHotelImpresora" min="1" max="100" required readonly>
                </div>
              </div>
            </div><br>
            <div id="ipValidoMensaje"></div>
            <div class="row" >
              <div class="col-md-6 col-xs-12">
                <label for="usr">Ip de la impresora</label>
                <div class="input-group hidden" id="ipImpresoraOcultoCampo">
                  <div class="input-group-addon"><i class="fas fa-network-wired"></i></div>
                  <input type="text" class="form-control " id="regIpImpresora" name="regIpImpresora" required>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                  <label for="usr">Nombre de la impresora</label>
                <div class="input-group hidden" id="nombreImpresoraOcultoCampo">
                  <div class="input-group-addon"><i class="fas fa-print"></i></div>
                  <input type="text"  class="form-control nombreImpresora" id="regNombreImpresora" name="regNombreImpresora" required>
                </div>
              </div>
            </div><br><span id="rowNuevaImpresora"></span>
                 
            <div class="row">
              <div class="col-xs-4">
                <div class="checkbox icheck">
                  <label>
                  <a href="impresoras" class="btn btn-warning btn-block btn-flat" ><i class="fa fa-undo "></i> Descartar</a> 
                  </label>
                </div>
              </div>
              <div class=" col-sm-offset-4 col-xs-4">
                <div class="checkbox icheck">
                  <button type="submit" id="btnImpresoraGuardar" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-save"></i> Guardar
                  </button>
                </div>
              </div>                   
            </div>                    
          </form>
          <?php 
            $registrarImpresora = new ControladorImpresoras();
            $registrarImpresora->ctrRegistrarImpresora();
          ?>               
        </div>
      </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
    </div>

  </div>
</div>
<!--===== MODAL PARA REGISTRAR UNA NUEVA IMPRESORA======-->
<!-- =============================================
  MODAL PARA EDITAR UNA IMPRESORA
  =============================================-->
<div id="editImpresora" class="modal fade" role="dialog">
  <div class="modal-dialog">
<!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-header-personalizado">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><i class="fas fa-edit"></i> Editar impresora</h4>
      </div>
      <div class="modal-body">
<!--======   FORMULARIO PARA EDITAR la impresora ==-->
        <div class="register-box-body">              
          <form method="post">                    
            
            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="well well-sm">
                  <h4 id="nombreHotelImpresora"></h4>
                  <ul class="list-group">                    
                    <li class="list-group-item"><strong>IP Actual: </strong><span id="ipImpresoraSpan"></span></li>
                    <li class="list-group-item"><strong>Nombre Impresora Actual:</strong> <span id="nombreImpresoraSpan"></span></li>                                       
                  </ul>
                  <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>¡Nota!</strong> Sí va cambiar la dirección ip, asegurese de ocupar uno que NO esté en la base de datos. Sí cambia el nombre de la impresora, mantener la dirección IP actual.
                  </div>
                </div>
              </div>                                     
            </div>
            <div class="row hidden">
              <div class="col-md-12 col-xs-12 ">
                <div class="form-group">
                    <label for="usr">idImpresora</label>
                    <input type="number" class="form-control" id="idImpresoraEdit" name="idImpresoraEdit" readonly>
                </div>
              </div>
            </div><br><div id="ipValidoMensajeEditar"></div>
            <div class="row">              
               <div class="col-md-6 col-xs-12"> 
                <label for="usr">Nueva dirección IP</label>
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-network-wired"></i></div>
                  <input type="text" class="form-control " id="nuevaDireccionIP" name="nuevaDireccionIP" required>
                </div>
              </div>
              <div class="col-md-6 col-xs-12">
                  <label for="usr">Nuevo nombre impresora</label>
                <div class="form-group" id="nombreImpresoraOcultoModal">
                  <input type="text" class="form-control nombreImpresora" id="nuevoNomImpresora" name="nuevoNomImpresora" required>
                </div>
              </div>
            </div><br><span id="rowEditarImpresora"></span>              
            <div class="row">
              <div class="col-xs-4">
                <div class="checkbox icheck">
                  <label>
                  <a href="impresoras" class="btn btn-warning btn-block btn-flat" ><i class="fa fa-undo "></i> Descartar</a> 
                  </label>
                </div>
              </div>
              <div class=" col-sm-offset-4 col-xs-4">
                <div class="checkbox icheck">
                  <button type="submit" id="btnNuevaImpresoraEdit" class="btn btn-primary btn-block btn-flat" disabled><i class="fas fa-save"></i> Guardar
                  </button>
                </div>
              </div>                   
            </div>                    
          </form>
          <?php 
            $editarImpresora = new ControladorImpresoras();
            $editarImpresora->ctrEditarImpresora();
          ?>               
        </div>
      </div>
          <!-- <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div> -->
    </div>

  </div>
</div>
<!--===== FIN DEL MODAL PARA EDITAR UNA IMPRESORA======-->
<?php 
    $borrarImpresora = new ControladorImpresoras();
    $borrarImpresora->ctrEliminarImpresora();
  }
  else{
    require "sinAcceso.php";
}
?>
  <!-- /.content-wrapper -->
 <script src="vistas/plugins/datatable/script.js"></script>