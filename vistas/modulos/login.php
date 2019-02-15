<div class="login-box">

  <div class="login-logo">
    <!-- <img src="vistas/img/plantilla/logo.png" class="img-responsive" style="padding:10px 50px;"> -->
  </div>
  <!-- /.login-logo -->  

  <div class="login-box-body">
    
  <img src="vistas/img/plantilla/logo.png" class="img-responsive center" style="padding:20px 80px;">
    <!-- <p class="login-box-msg">Ingresar al sistema</p> -->
    <form  method="post">
      
      <div class="form-group has-feedback">
        <span><strong>Primero elija su hotel</strong></span>
          <select class="form-control" name="eligeAccesoHotel" id="eligeAccesoHotel">
              <option value=""></option>
              <?php 
                $lstPermisosNivelHotel = new ControladorPermisos();
                $lstPermisosNivelHotel ->ctrMostrarPermisosTipoHotel();
              ?>
          </select>
      </div>
      <div class="form-group has-feedback">
        <!-- <span><strong>Usuario</strong></span><br><br> -->
        <input type="text" class="form-control" placeholder="Nombre De Usuario" id="ingNombreDeUsuario" name="ingNombreDeUsuario"  readonly required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div id="verificarUser"></div>
      <div class="form-group has-feedback">
        <!-- <span><strong>Contraseña</strong></span><br><br> -->
        <input type="password" class="form-control" placeholder="Password" id="ingPassword" name="ingPassword" readonly required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback hidden">
        <!-- <span><strong>Contraseña</strong></span><br><br> -->
        <input type="text" class="form-control" id="idHotel" name="idHotel" readonly required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div id="msjUserPermisoHotel"></div>
      <div class="form-group">
        <span><strong>Elija su impresora</strong></span>
        <select class="form-control" id="listaImpresoras" name="impresoras" required>   
          <!-- TRAIGO LA LISTA DE IMPRESORAS DISPONIBLES DEL CUAL AL SER ELEGIDA UNA, LO GUARDO EN UNA VARIABLE DE SESION PARA QUE SE VUELVA PREDETERMINADA esto los cargo con ajax mediante js -->
             
          </select>
      </div>
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-offset-7 col-xs-5">
          <button type="submit" id="btnLogin" class="btn btn-primary btn-block btn-flat btnIngreso" disabled><i class="fas fa-sign-in-alt"></i> Ingresar</button>
        </div>
        <!-- /.col -->
      </div>

      <?php

        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuarios();

      ?>

    </form>
    

  </div>
  <!-- /.login-box-body -->

</div>
<!-- /.login-box -->
