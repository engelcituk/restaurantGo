<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reservas | Panel de Control</title>

    <link rel="icon" href="vistas/img/plantilla/icono.png">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css">
    <!-- Ionicons -->
    <!-- <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="vistas/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="vistas/dist/css/skins/skin-blue.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="vistas/plugins/iCheck/square/blue.css">
    <!-- Morris chart -->
    <!-- <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css"> -->
    <!-- jvectormap -->
    <!-- <link rel="stylesheet" href="vistas/bower_components/jvectormap/jquery-jvectormap.css"> -->
    <link rel="stylesheet" href="vistas/dist/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="vistas/dist/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/estilo.css">
    <!-- <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/buttons.dataTables.min.css"> -->
    <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/sweetalert.css">



    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 3 -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vistas/bower_components/bootstrap/dist/js/sweetalert.min.js"></script>
    <!-- AdminLTE App -->
    <script src="vistas/dist/js/adminlte.min.js"></script>

    <!-- iCheck -->
    <!-- <script src="vistas/plugins/iCheck/icheck.min.js"></script> -->
    <!-- Morris.js charts -->
    <!-- <script src="vistas/bower_components/raphael/raphael.min.js"></script> -->
    <!-- <script src="vistas/bower_components/morris.js/morris.min.js"></script> -->
    <!-- jQuery Knob Chart -->
    <script src="vistas/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
    <!-- jvectormap -->
    <!-- <script src="vistas/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script> -->
    <!-- <script src="vistas/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script> -->
    <!-- datatables -->
    <script src="vistas/plugins/datatable/jquery.dataTables.min.js"></script>
    <script src="vistas/plugins/datatable/dataTables.bootstrap.min.js"></script>
    <script src="vistas/plugins/datatable/dataTables.responsive.min.js"></script>
    <script src="vistas/plugins/datatable/responsive.bootstrap.min.js"></script>
    <script src="vistas/plugins/usuarios.js"></script>
    <script src="vistas/plugins/bootstrap-notify.min.js"></script>

    <!-- botones para reportes -->
    <script src="vistas/plugins/datatable/buttons/dataTables.buttons.min.js"></script>
    <script src="vistas/plugins/datatable/buttons/jszip.min.js"></script>
    <script src="vistas/plugins/datatable/buttons/pdfmake.min.js"></script>
    <script src="vistas/plugins/datatable/buttons/vfs_fonts.js"></script>
    <script src="vistas/plugins/datatable/buttons/buttons.html5.min.js"></script>

    <!-- ChartJS -->
    <!-- <script src="vistas/bower_components/Chart.js/Chart.js"></script> -->

    <script>
        $(function() {
            // $('input').iCheck({
            //   checkboxClass: 'icheckbox_square-blue',
            //   radioClass: 'iradio_square-blue',
            //   increaseArea: '20%' // optional
            // });
            /* jQueryKnob */
            $('.knob').knob();
            /* SideBar Menu */
            $('.sidebar-menu').tree();
        });
    </script>

</head>

<body class="hold-transition skin-blue sidebar-mini login-page">
    <?php 
    if (isset($_SESSION["validarSesionBackend"]) && $_SESSION["validarSesionBackend"] === "ok") {
      echo '<div class="wrapper">';
      /*===============  MENU SUPERIOR==============*/
      include "modulos/cabezote.php";
      /*=========== menú LATERAL======*/
      include "modulos/lateral.php";
      /*======   CONTENIDO=============*/
      if (isset($_GET["ruta"])) {
        if (
          $_GET["ruta"] == "inicio" ||
          $_GET["ruta"] == "hacer-reservas" ||
          $_GET["ruta"] == "hoteles" ||
          $_GET["ruta"] == "restaurantes" ||
          $_GET["ruta"] == "por-habitacion" ||
          $_GET["ruta"] == "reportes-reservacion" ||
          $_GET["ruta"] == "administrar-reservas" ||
          $_GET["ruta"] == "reportes-huespedes" ||
          $_GET["ruta"] == "permisos" ||
          $_GET["ruta"] == "usuarioPermisos" ||
          $_GET["ruta"] == "configuracion-mesas" ||
          $_GET["ruta"] == "configuracion-seatings" ||
          $_GET["ruta"] == "configuracion-mesas-seatings" ||
          $_GET["ruta"] == "configuracion-tickets" ||
          $_GET["ruta"] == "config-reservas-estancia" ||
          $_GET["ruta"] == "usuarios" ||
          $_GET["ruta"] == "ingreso" ||
          $_GET["ruta"] == "ingresopro" ||
          $_GET["ruta"] == "impresoras" ||
          $_GET["ruta"] == "conector" ||
          $_GET["ruta"] == "salir"
        ) {
          include "modulos/" . $_GET["ruta"] . ".php";
        } else {
          include "modulos/404.php";
        }
      } else {
        include "modulos/inicio.php";
      }
      include "modulos/footer.php";
      include "modulos/lateralDerecha/lateralDerecha.php";
      echo '</div>';
    } else {
      if ($_GET["ruta"] != "ingresopro") {
        include "modulos/login.php";
      } else {
        include "modulos/loginpro.php";
      }
    }
    ?>
    <!-- <script defer src="https://use.fontawesome.com/releases/v5.4.1/js/all.js" integrity="sha384-L469/ELG4Bg9sDQbl0hvjMq8pOcqFgkSpwhwnslzvVVGpDjYJ6wJJyYjvG3u8XW7" crossorigin="anonymous"></script> -->
    <script src="vistas/plugins/login.js"></script>
    <script src="vistas/plugins/consultaSqlServer.js"></script>
    <script src="vistas/plugins/crudUsuarios.js"></script>
    <script src="vistas/plugins/crudHoteles.js"></script>
    <script src="vistas/plugins/crudRestaurantes.js"></script>
    <script src="vistas/plugins/crudReservas.js"></script>
    <script src="vistas/plugins/crudSeatings.js"></script>
    <script src="vistas/plugins/crudTickets.js"></script>
    <script src="vistas/plugins/crudConfigEstancia.js"></script>
    <script src="vistas/plugins/crudImpresoras.js"></script>
    <script src="vistas/plugins/crudPermisos.js"></script>
    <script src="vistas/plugins/reporteReservas.js"></script>
    <script src="vistas/plugins/reservaRestaurantes.js"></script>
    <script src="vistas/plugins/rsvExternosRestaurantes.js"></script>
    <script src="vistas/plugins/timepicker/bootstrap-timepickerr.js"></script>
    <script src="vistas/plugins/hora.js"></script>

</body>

</html> 