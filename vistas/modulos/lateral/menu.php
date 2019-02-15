<!--=====================================
MENU
======================================-->	

<ul class="sidebar-menu">
  <!-- <li class="active treeview"><a href="inicio"><i class="fa fa-home"></i> <span>Inicio</span></a></li> -->
<?php
  if($_SESSION["HACER RESERVAS"]==1 || $_SESSION["SUBMENU LATERAL"]==1){ 
    echo'
        <li class="treeview">      
            <a href="#">
              <i class="fa fa-home"></i>
              <span>Inicio</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="inicio"><i class="fas fa-list-ul"></i> Huespedes Hotel</a></li>
            </ul>
        </li>';
  }
if($_SESSION["HACER RESERVAS"]==1 || $_SESSION["SUBMENU LATERAL"]==1){
  
  echo '
  <li class="treeview">      
      <a href="#">
        <i class="fa fa-book"></i>
        <span>Reservas</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <li><a href="hacer-reservas"><i class="fa fa-utensils"></i> Hacer Reservas</a></li>
        <li><a href="administrar-reservas"><i class="fas fa-cogs"></i> Administrar Reservas</a></li>
      </ul>
  </li>';
  
}

  if($_SESSION["REPORTES"]==1 || $_SESSION["SUBMENU LATERAL"]==1){
    echo'
        <li class="treeview">      
            <a href="#">
              <i class="fas fa-file-alt"></i>
              <span>Reportes</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="reportes-reservacion"><i class="fas fa-file-word"></i> Reservas</a></li>
            </ul>
        </li>';
   }
  //menú configuracion 
  if($_SESSION["CONFIGURACION"]==1){
    echo '
          <li class="treeview">
              <a href="#">
                <i class="fa fa-cogs"></i>
                <span>Configuración</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="hoteles"><i class="fa fa-hotel"></i> Hoteles</a></li>
                <li><a href="usuarios"><i class="fas fa-users-cog"></i> Usuarios</a></li>
                <li><a href="restaurantes"><i class="fas fa-utensils"></i></i> Restaurantes</a></li>
                <li><a href="configuracion-seatings"><i class="fas fa-chair"></i> Seatings</a></li>               
                <li><a href="configuracion-tickets"><i class="fas fa-sticky-note"></i> Tickets</a></li>
                <li><a href="config-reservas-estancia"><i class="fas fa-book"></i> Reservas por estancia</a></li>
                <li><a href="impresoras"><i class="fas fa-print"></i> Impresoras</a></li>
                
              </ul>
          </li>
         ';
  }
?>       
</ul>	