<?php 
  if($_SESSION["C-HOTELES"]==1||$_SESSION["C-USUARIOS"]==1||$_SESSION["C-RESTAURANTES"]==1||$_SESSION["C-SEATINGS"]==1||$_SESSION["C-TICKETS"]==1||$_SESSION["C-RSVXESTANCIA"]==1||$_SESSION["C-IMPRESORAS"]==1){
 ?>
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Datos del conector SQLSRV para php en uso 
      </h1>
      <ol class="breadcrumb">
        <li><a href="inicio"><i class="fa fa-dashboard"></i> Configuracion</a></li>
        <li class="active">Conector activo</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
    
      <!-- Default box -->
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title"> Conector a SQL SERVER ocupado para obtener datos de los huespedes</h3>
          <!-- <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div> -->
        </div>
        <div class="box-body">
          <!-- cuerpo de la aplicacion -->                  
          <?php 
              $item = "idHotel";
              $valor = $_SESSION["idHotel"];
              $respuesta = ControladorConectorSQLSRV::ctrMostrarDatosConector($item,$valor);

              // var_dump($respuesta);
                  $_SESSION["servidorSQLSRV"] = $respuesta["ipServidor"];
                  $_SESSION["bdSQLSRV"] = $respuesta["baseDeDatos"];
                  $_SESSION["usuarioSQLSRV"] = $respuesta["usuario"];
                  $_SESSION["passwordSQLSRV"] = $respuesta["password"];
                  
                echo '
                <div class="well well-sm col-md-6 col-xs-12"> <strong>IP del servidor SQL: </strong>'.$_SESSION["servidorSQLSRV"].'</div>
                <div class="well well-sm col-md-6 col-xs-12"> <strong>Base de datos: </strong>'.$_SESSION["bdSQLSRV"].'</div>                
                <div class="well well-sm col-md-6 col-xs-12"> <strong>Usuario: </strong>'. $_SESSION["usuarioSQLSRV"].'<br><br></div>
                <div class="well well-sm col-md-6 col-xs-12"><strong><span style="cursor: pointer;" onclick="mostrar(this); return false"/><i class="fas fa-eye"></i> Ver contraseña</span> </strong><div id="oculto" style="visibility:hidden; cursor: pointer;">'.$_SESSION["passwordSQLSRV"].'
                </div></div>
                ';                                
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
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper==========================-->
 
  
<!--===== FIN MODAL PARA CARGAR LA INFORMACION DEL TICKET para la edicion=====-->
<?php  
}
  else{
    require "sinAcceso.php";
}
?>
<script>
function mostrar(enla) {
  obj = document.getElementById('oculto');
  obj.style.visibility = (obj.style.visibility == 'hidden') ? 'visible' : 'hidden';
  enla.innerHTML = (enla.innerHTML == '<i class="fas fa-eye-slash"></i> Ocultar contraseña') ? '<i class="fas fa-eye"></i> Ver contraseña' : '<i class="fas fa-eye-slash"></i> Ocultar contraseña';
}
</script>