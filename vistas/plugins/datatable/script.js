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
$(document).ready(function() {
$('#tablaReservasReservix').DataTable({
  dom: 'Blfrtip',
    buttons: [
      {
        extend:    'pdfHtml5',
        className: 'btn colorBoton',            
        title :'Lista de huespedes',
        text:      '<i class="fas fa-file-pdf"> PDF</i>',
        titleAttr: 'PDF'                            
        },{
        extend:'excelHtml5',
        className: 'btn btn-success',
        title :'Lista de huespedes',
        text:      '<i class="fas fa-file-excel"> Excel</i>',
        titleAttr: 'Excel'
        }                                  
    ],
  "lengthMenu": [[10,25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
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
  $("#tablaReservasReservix_wrapper > .dt-buttons").appendTo("#btnDocsListaDatatable");
});
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

