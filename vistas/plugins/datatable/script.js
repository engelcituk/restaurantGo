// script para el datatable de las reservas
$('#tablaReservas').DataTable({
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
        }
});
//script para el datatable de hoteles
$('#tablaHoteles').DataTable({
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
        }
});
//script para el datatable de restaurantes
$('#tablaRestaurantes').DataTable({
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": { 
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
  }
});
// script para el datatable de los usuarios

$('#tablaUsuarios').DataTable({
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
  }
});
// probando a mostrar consulta en inicio
$('#tablaReservasReservix').DataTable({
  "lengthMenu": [[25, 50, 100, 200, -1], [25, 50, 100, 200, "Todos"]],
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }
  }
           
});
// datatable para generar el report de las reservas
// $( document ).ready(function() {
//   
// });

$(document).ready(function() {
  $('#tblReservasReporte').DataTable({  
    dom: 'Blfrtip',
          buttons: [
            {
              extend:    'pdfHtml5',
              className: 'btn btn-info',            
              title :'Reporte de reservas',
              text:      '<i class="fas fa-file-pdf"> PDF</i>',
              titleAttr: 'PDF',
              customize: function ( doc ) {
                doc.content.splice( 1, 0, {
                    // margin: [ 0, 0, 0, 12 ],
                    alignment: 'left',
                    image: 'data:image/png;base64,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'
                  } );
            }
              // download: 'open'
            }, 
            {
              extend:    'excelHtml5',
              className: 'btn btn-success',
              title :'Reporte de reservas',
              text:      '<i class="fas fa-file-excel"> Excel</i>',
              titleAttr: 'Excel'
            } 
                                 
          ],
    "language": {
              "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst":    "Primero",
          "sLast":     "Último",
          "sNext":     "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
    }               
  });
  //pongo los botones en el lugar que quiero
  $("#tblReservasReporte_wrapper > .dt-buttons").appendTo("#botonesReportePdfExcel");
});

// datatable para generar el report de las reservas
$('#tblCrudReservas').DataTable({
  "lengthMenu": [[15, 25, 50, 100, -1], [15, 25, 50, 100, "Todos"]],
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }      
  }
           
});

// datatable para generar el report de las reservas
$('#tblCrudSeatings').DataTable({
  "lengthMenu": [[25, 50, 100, 150, -1], [25, 50, 100, 150, "Todos"]],
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }      
  }
           
});

// datatable para mostar la configuraciones de reservas por noches de estancia
$('#tblCrudConfigs').DataTable({
  "lengthMenu": [[25, 50, 100, 150, -1], [25, 50, 100, 150, "Todos"]],
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }      
  }
           
});
// datatable para mostar la lita de impresoras
$('#tblCrudImpresoras').DataTable({
  "lengthMenu": [[15, 25, 50, 100, -1], [15, 25, 50, 100, "Todos"]],
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }      
  }
           
});

// datatable para mostar la lita de impresoras
$('#tblCrudPermisos').DataTable({
  "lengthMenu": [[15, 25, 50, 100, -1], [15, 25, 50, 100, "Todos"]],
  "language": {
            "sProcessing":     "Procesando...",
      "sLengthMenu":     "Mostrar _MENU_ registros",
      "sZeroRecords":    "No se encontraron resultados",
      "sEmptyTable":     "Ningún dato disponible en esta tabla",
      "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
      "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix":    "",
      "sSearch":         "Buscar:",
      "sUrl":            "",
      "sInfoThousands":  ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst":    "Primero",
        "sLast":     "Último",
        "sNext":     "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }      
  }
           
});

//para generar reportes

