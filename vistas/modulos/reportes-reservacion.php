<?php 
  if($_SESSION["REPORTES"]==1){

 ?>
<!-- =============================================== -->
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      <?php  echo $_SESSION["nombreHotel"]; ?> : Reportes
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Reportes</a></li>
        <li class="active"><?php  echo $_SESSION["nombreHotel"]; ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box box-info">
        <div class="box-header with-border">
          
          <!-- <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div> -->
            
            <div class="row">
                <?php 
                  if (isset($_GET["nomRest"])) {
                      $nombreRestaurante=$_GET["nomRest"];                  
                      $fechaInicio=$_GET["fechaInicio"];
                      $fechaFinal=$_GET["fechaFinal"];
                      $nombreRestauranteSelec=$nombreRestaurante;                  
                    } else {
                      $nombreRestaurante="Restaurantes";                  
                      $fechaInicio="Fecha Inicio";
                      $fechaFinal="Fecha Final";
                      $nombreRestauranteSelec="Elija restaurante";
                    }
                ?>
              <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-hotel"></i> <?php  echo $_SESSION["nombreHotel"]; ?></a></li>
                    <li class="breadcrumb-item"><a href="#"> <i class="fas fa-list-ul"></i> <?php echo $nombreRestaurante ?></a></li>
                    <li class="breadcrumb-item"><i class="fas fa-calendar-alt"></i> <?php echo $fechaInicio." / ".$fechaFinal ?></li>
                                    
                  </ol>
                </nav> 
              </div>
              <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
                <?php 
                  if (isset($_GET["idRest"])) {
                    $estadoBoton="";
                    } else {
                      $estadoBoton="hidden";
                    }
                 ?>
                <a href="reportes-reservacion" id="descartarReporte" class="btn btn-sm btn-warning <?php echo $estadoBoton; ?>">
                  <i class="fas fa-undo"></i> Descartar 
                  </a>
              </div>
            </div>
            
        </div>
        <div class="box-body">
          <div class="row">  
             <form action="">
              <div class="col-md-3 col-xs-12 hidden">                  
                  <div class="input-group">
                    <div class="input-group-addon"><i class="fas fa-heading"></i></div>
                    <input type="text" class="form-control" name="hotel" id="hotel" value="<?php  echo $_SESSION["nombreHotel"]; ?>" readonly>
                  </div>
              </div>
              <div class="col-md-3 col-xs-12"> 
              <span><strong>Restaurantes</strong></span><br><br>                  
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-utensils"></i></div>
                  <!-- traigo los restaurantes de acuerdo al id del hotel -->
                   <?php
                      $campo ="idHotel";
                      $valorCampo =$_SESSION["idHotel"];                                  
                      $respuesta = ControladorRestaurantes::ctrMostrarListaRestaurantes($campo,$valorCampo);
                      echo '<select class="form-control" id="lstRestaurantesReportes" required><option value="">'.$nombreRestauranteSelec.'</option>';
                      foreach ($respuesta as $fila => $elemento) {
                        echo '                              
                        <option idRestaurante="'.$elemento["id"].'" value="'.$elemento["id"].'">'.$elemento["nombre"].'</option>                            
                              ';
                      }
                      echo '</select>'; 
                     ?>                
                </div>               
              </div>
              
              <div class="col-md-3 col-xs-12">
                <?php
                  date_default_timezone_set('UTC');
                  $hoy = date("Y-m-d");
                ?>
                <span><strong>Fecha Inicio</strong></span><br><br> 
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                    <input type="date"  min="<?php echo $hoy; ?>" class="form-control" id="fechaReporte" name="fechaReporte" readonly required>                        
                </div>
                
              </div>
              <div class="col-md-3 col-xs-12">
                <?php
                  date_default_timezone_set('UTC');
                  $hoy = date("Y-m-d");
                ?>
                <span><strong>Fecha final</strong></span><br><br> 
                <div class="input-group">
                  <div class="input-group-addon"><i class="fas fa-calendar-alt"></i></div>
                    <input type="date" min="<?php echo $hoy; ?>" class="form-control" id="fechaReporteFin" name="fechaReporte"  readonly >                        
                </div>
                
              </div>
              <div class="col-md-3 col-xs-6">
              <span><strong>Ver/descargar reporte</strong></span><br><br> 
                <?php 
                  if (isset($_GET["idRest"])) {
                    $estadoBoton="";
                    } else {
                      $estadoBoton="hidden";
                    }
                 ?>
                <div class="input-group">                                    
                  <a href="#" id="btnReporte" class="btn btn-info <?php echo $estadoBoton; ?>"><i class="fas fa-file-pdf"></i> PDF</a><span>&nbsp &nbsp</span>
                  <?php
                    if(isset($_GET["fechaInicio"])){
                      $fechaInformeInicio =$_GET["fechaInicio"];
                      $fechaInformefinal =$_GET["fechaFinal"];
                      $idRestauranteInforme=$_GET["idRest"];
                      $nombreRestaurante=$_GET["nomRest"];
                    }else {
                      $fechaInformeInicio="";
                      $fechaInformefinal="";
                      $idRestauranteInforme="";
                      $nombreRestaurante="";
                    }
                  ?>
                  <a href="vistas/modulos/descargar-excel.php?reporte=reporte&idRest=<?php echo $idRestauranteInforme ?>&fechaInicio=<?php echo $fechaInformeInicio ?>&fechaFinal=<?php echo $fechaInformefinal ?>&nomRest=<?php echo $nombreRestaurante ?>" id="btnReporteExcel" class="btn btn-success <?php echo $estadoBoton; ?>"><i class="fas fa-file-excel"></i> EXCEL</a>
                </div>
              </div>             
             </form>                        
          </div>

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
                    <th>usuario</th>
                    <th>Idioma</th>
                    
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <!-- LLAMO AL CONTROLADOR PARA TRAER LA LISTA DE RESERVAS -->
                  <?php 
                    if (isset($_GET["idRest"])) {
                        $valorCampoTabla =$_GET["idRest"];                      
                        $valorCampoTabla2 =$_GET["fechaInicio"];                                            
                        $valorCampoTabla3 =$_GET["fechaFinal"];
                      } else {                        
                        $valorCampoTabla =null;                       
                        $valorCampoTabla2=null;                                                
                        $valorCampoTabla3=null; 
                      }
                                    
                      $respuesta = ControladorReportes::ctrMostrarListaReservas($valorCampoTabla,$valorCampoTabla2,$valorCampoTabla3);
                      $contador=1;                  
                        foreach ($respuesta as $fila => $elemento) {
                          $cortarCadenaHora = substr($elemento["hora"], 0, 8);
                          echo '
                          <tr id="'.$elemento["id"].'">
                              <td>'.$contador.'</td>
                              <td>'.$elemento["fechaDeLaReserva"].'</td>
                              <td>'.$elemento["habitacion"].'</td>
                              <td>'.$elemento["apellido"].'</td>
                              <td>'.$elemento["nombreRestaurante"].'</td>
                              <td>'.$elemento["pax"].'</td>
                              <td>'.$cortarCadenaHora.'</td>                                              
                              <td>'.$elemento["usuario"].'</td> 
                              <td>'.$elemento["ticket"].'</td>
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
  }
  else{
    require "sinAcceso.php";
  }
?>
<script src="vistas/plugins/datatable/script.js"></script>
