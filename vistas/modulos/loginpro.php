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
        <!-- <span><strong>Usuario</strong></span><br><br> -->
        <input type="text" class="form-control" placeholder="Nombre De Usuario" id="ingUsuarioPro" name="ingUsuarioPro"   required>
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div id="verificarUser"></div>
      <div class="form-group has-feedback">
        <!-- <span><strong>Contraseña</strong></span><br><br> -->
        <input type="password" class="form-control" placeholder="Password" id="ingPasswordPro" name="ingPasswordPro"  required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>                  
      <div class="row">
        <!-- /.col -->
        <div class="col-xs-offset-7 col-xs-5">
          <button type="submit" id="btnLogin" class="btn btn-primary btn-block btn-flat btnIngreso"><i class="fas fa-sign-in-alt"></i> Ingresar</button>
        </div>
        <!-- /.col -->
      </div>

      <?php

        $login = new ControladorUsuarios();
        $login -> ctrIngresoUsuarioPro();

      ?>

    </form>
    

  </div>
  <!-- /.login-box-body -->

</div>
<!-- /.login-box -->
