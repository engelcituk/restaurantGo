<?php
if ($_SESSION["C-RESTAURANTES"] == 1) {
    ?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Restaurantes
            </h1>
            <ol class="breadcrumb">
                <li><a href="inicio"><i class="fa fa-dashboard"></i> Configuración</a></li>
                <li class="active">Restaurantes</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box box-success">
                <div class="box-header with-border">
                    <div class="row">
                        <div class="col-md-6 col-xs-12 col-lg-6 col-sm-6">
                            <?php
                            if (isset($_GET["nomHotel"])) {
                                $nombreHotel = $_GET["nomHotel"];
                                $verRestaurantes = $_GET["nomHotel"];
                            } else {
                                $nombreHotel = "Todos los hoteles";
                                $verRestaurantes = "Ver Restaurantes";
                            }
                            ?>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#"><i class="fas fa-hotel"></i> <?php echo $nombreHotel ?></a></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 col-xs-6">
                            <a href="#" class="btn btn-success btn-flat" data-toggle="modal" data-target="#nuevoRestaurante"><i class="fas fa-utensils"></i> Nuevo Restaurante</a>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <div class="dropdown">

                                <button class="btn btn-primary btn-flat dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-hotel"></i> <?php echo $verRestaurantes ?>
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <?php
                                    $listaHoteles = new ControladorRestaurantes();
                                    $listaHoteles->ctrListaHotelesUsuario();
                                    ?>
                                    <!-- <li idHotel="TODOS"><a href="restaurantes">TODOS</a></li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-3 col-xs-6">
                            <select class="form-control" name="hotelElige" id="hotelElige2" required>
                                <option value="">Genera PDF</option>
                                <?php
                                $listaHoteles = new ControladorRestaurantes();
                                $listaHoteles->ctrListaHotelesUsuarioSelectOption();
                                ?>
                                <!-- <option value="TODOS">TODOS</option> -->
                            </select>
                        </div>
                        <div class="col-md-offset-1 col-md-2 col-xs-6">
                            <?php
                            if (isset($_GET["idHotel"])) {
                                $estadoBoton = "";
                            } else {
                                $estadoBoton = "hidden"; 
                            }
                            ?>
                            <a href="restaurantes" class="btn btn-warning btn-block btn-flat <?php echo $estadoBoton; ?>"><i class="fa fa-undo"></i> Descartar</a>
                        </div>
                    </div>
                    <br>

                    <!-- <h3 class="box-title">Title</h3> -->
                    <div class="box-tools pull-right">
                    </div>
                </div>
                <div class="box-body">
                    <div id="restaurantes" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div>
                            <table id="tablaRestaurantes" class="table table-striped dt-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nombre</th>
                                        <!-- <th>Especialidad</th> -->
                                        <th>MaximoPaxDia</th>
                                        <th>Estado</th>
                                        <th>Herramientas</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- aqui va mis consultas en un datatable -->
                                    <?php
                                    if (isset($_GET["idHotel"])) {

                                        $campoTabla = "idHotel";
                                        $valorCampoTabla = $_GET["idHotel"];
                                    } else {

                                        $campoTabla = null;
                                        $valorCampoTabla = null;
                                    }

                                    $respuesta = ControladorRestaurantes::ctrMostrarListaRestaurantes($campoTabla, $valorCampoTabla);
                                    $contador = 1;
                                    foreach ($respuesta as $fila => $elemento) {
                                        $nombreRestaurante = $elemento["nombre"];
                                        echo '
                                        <tr id="' . $elemento["id"] . '">
                                            <td>' . $contador . '</td>
                                            <td>' . $elemento["nombre"] . '</td>                        
                                            <td>' . $elemento["paxMaximoDia"] . '</td>';

                                        if ($elemento["estado"] != 0) {

                                            echo '<td><button class="btn btn-success btn-xs btnActivarRstrnt" idRstrnt="' . $elemento["id"] . '" estadoRstrt="0">Activado</button></td>';
                                        } else {
                                            echo '<td><button class="btn btn-danger btn-xs btnActivarRstrnt" idRstrnt="' . $elemento["id"] . '" estadoRstrt="1">Desactivado</button></td>';
                                        }
                                        echo '<td>
                                            <a href="#" class="btn btn-success editRestaurante" data-toggle="modal" data-target="#editRestaurante" idRstrnt="' . $elemento["id"] . '"><i class="fa fa-edit"></i> </a>
                                            <a href="#" class="btn btn-warning" data-toggle="modal" data-target="#cierreRestaurante" nRestaurante="'.$elemento["nombre"] . '" idRstrnt="' . $elemento["id"] . '" onclick="cierreRestaurante('.$elemento["id"]. ', `'.$nombreRestaurante.'`,'.$elemento["idHotel"].')"><i class="fas fa-calendar-times"></i> </a>

                                            <button class="btn btn-danger eliminarRestaurante"  idRstrnt="' . $elemento["id"] . '" disabled><i class="fa fa-trash "></i></button>                                            
                                            </td>
                                            <td></td>
                                        </tr>';
                                        $contador = $contador + 1;
                                    }
                                    ?>
                                </tbody>
                            </table>


                        </div>

                    </div>
                    <!-- Fin tabla de reservas -->
                </div>                
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <?php 

    // modales para crear y editar restaurantes 
    include 'partials/restaurantes/create.php';
    include 'partials/restaurantes/edit.php';
    include 'partials/restaurantes/cierreRestaurantes.php';
    // AQUI VA LA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL BORRADO DEL RESTAURANTE -->    
    $borrarRestaurante = new ControladorRestaurantes();
    $borrarRestaurante->ctrBorrarRestaurante();
    //  FIN LA INSTANCIA PARA LLAMAR AL CONTROLADOR DEL BORRADO DEL RESTAURANTE
} else {
    require "sinAcceso.php";
}
?>
<script src="vistas/plugins/datatable/script.js"></script>
<input type="text" class="form-control" id="sinHorarioCierreEdit" readonly required />