 /*======================================
= PARA QUE NO SE REPITA LOS TICKETS
--VALIDAR TICKET
======================================*/
$("#idioma").change(function(){    
    $(".alert").remove();
    var idiomaCampo = $("#idioma").val();      

    var datos = new FormData();
    datos.append("idioma",idiomaCampo);

    if (idiomaCampo != '') {

        $.ajax({
            url:"ajax/tickets.ajax.php", //enviamos a este archivo el nombreUsuario para que lo procese
            method: "POST", //el envio es por POST
            data: datos, //datos es la instancia de ajax por el que se envia el id
            cache: false,
            contentType: false,
            processData: false,
            dataType:"json", //los datos son de tipo json
            success:function(respuesta){ //obtengo una respuesta tipo json          
                // console.log("respuesta",respuesta);
                if (respuesta){ //si respuesta es true (si me trae resultados)..
                //coloco una alerta despues del elemento con el columnaIdioma en su elemento padre.
                    $("#columnaIdioma").after('<div class="alert alert-warning"><strong>Nota: </strong> Este nombre de ticket ya existe</div>');
                    $("#idioma").val(""); //limpiamos el value con el identificador idioma
                    $("#btnNuevoTicket").attr("disabled",true);   
                }else {
                    $("#columnaIdioma").after('<div class="alert alert-success"><strong>Nota: </strong> Nombre disponible para crear Ticket</div>');                    
                }
            }
        })
    }
    else
         {
          swal ( "Oops","Escriba un nombre", "error")
          $("#idioma").val("");
          $("#btnNuevoTicket").attr("disabled",true);           
    }              
})
 /*======================================
= PARA QUE NO SE DEJE VACIO EL CAMPO DE
TEXTO
======================================*/
$("#pieDePagina").change(function(){
    
      var pieDePagina = $("#pieDePagina").val();
      if (pieDePagina != '') {

        $("#btnNuevoTicket").removeAttr("disabled");
    }else
        {
          swal ( "Oops","No dejes el area de texto vacio", "error")
          $("#idioma").val("");
          $("#btnNuevoTicket").attr("disabled",true);           
    }     
})

 /*======================================
=            VER DATO DEL TICKET
======================================*/
 $(document).on("click", ".verTicket", function(){
    // ^--cuando se le da clic a la clase (verTicket) obtengo el atributo id
    var idTicket = $(this).attr("idTicket");
    // console.log("idTicket",idTicket);

    var datos = new FormData();
    datos.append("idTicket", idTicket);

    $.ajax({
        url:"ajax/tickets.ajax.php", //enviamos a este archivo el id para que lo procese
        method: "POST", //el envio es por POST
        data: datos, //datos es la instancia de ajax por el que se envia el id
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json", //los datos son de tipo json

        success:function(respuesta){ //obtengo una respuesta tipo json
            // console.log("respuesta",respuesta);          
            $("#idiomaModalTicket").html(respuesta["ticketTipo"]); //le cargo en esos campos los resultados
            $("#encabezadoModalTicket").html(respuesta["encabezado"]);            
            $("#pieModalTicket").html(respuesta["pie"]);//Siendo option ponemos eso en el html           
            
        }
    })
})
/*=====  FIN VER DATO DEL TICKET**/

 /*======================================
=            VER DATO DEL TICKET
Y MOSTAR LOS DATOS DEL TICKET QUE SE VAN A 
EDITAR
======================================*/
 $(document).on("click", ".editarTicket", function(){
    // ^--cuando se le da clic a la clase (editRestaurante) obtengo el atributo id
    var idTicket = $(this).attr("idTicketEditar");
    // console.log("idTicket",idTicket);
    var datos = new FormData();
    datos.append("idTicket", idTicket);

    $.ajax({
        url:"ajax/tickets.ajax.php", //enviamos a este archivo el id para que lo procese
        method: "POST", //el envio es por POST
        data: datos, //datos es la instancia de ajax por el que se envia el id
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json", //los datos son de tipo json
        success:function(respuesta){ //obtengo una respuesta tipo json
            // console.log("respuesta",respuesta);          
            $("#idiomaModalEditar").html('<strong>Idioma: </strong>'+respuesta["ticketTipo"]); //le cargo en esos campos los resultados
            $("#encabezadoModalEditar").html('<strong>Encabezado: </strong>'+respuesta["encabezado"]);            
            $("#pieModalEditar").html('<strong>Pie: </strong>'+respuesta["pie"]);//Siendo option ponemos eso en el html           
            $("#idTicketModalEditar").val(respuesta["id"]);
            $("#headerModalEditar").val(respuesta["encabezado"]);//Siendo option ponemos 
            $("#footModalEditar").val(respuesta["pie"]);//Siendo option ponemos 
            
            
        }
    })
})
/*=====  FIN VER DATO DEL TICKET Y MOSTAR LOS DATOS DEL TICKET QUE SE VAN A 
EDITAR**/
/*======================================
= PARA QUE NO SE DEJE VACIO EL textarea

======================================*/
$("#footModalEditar").change(function(){
    
      var footModalEditar = $("#footModalEditar").val();
      if (footModalEditar != '') {

        $("#btnGuardaEditTicket").removeAttr("disabled");
    }else
        {
          swal ( "Oops","No dejes el area de texto vacio", "error")
          $("#idioma").val("");
          $("#btnGuardaEditTicket").attr("disabled",true);           
    }     
})

/*======================================
=            ELIMINAR/BORRAR TICKET            =
======================================*/
$(document).on("click", ".eliminarTicket", function(){
    
    var idTicketEliminar = $(this).attr("idTicketEliminar");

    console.log("idTicketEliminar", idTicketEliminar);
    swal({
          title: "¡Atención!",
          text: "¿Esta seguro de eliminar el ticket?",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          cancelButtonText: "Cancelar",
          confirmButtonText: "Confirmar",
          closeOnConfirm: false,
          closeOnCancel: false
        },
        function(isConfirm) {
          if (isConfirm) {
        //Si se confirma la eliminacion se ejecuta el reenvio al php encargado
            window.location.href="index.php?ruta=configuracion-tickets&idTicketEliminar="+idTicketEliminar;
          } else {
        //Si se cancela se emite un mensaje
            swal("Cancelado", "Ha cancelado la eliminacion del ticket", "error");
          }
        });
})
/*=====  FIN DE  ELIMINAR Ticket   ======*/

/*===============================================
=            PARA ACTIVAR UN TICKET         =
===============================================*/
$(document).on("click", ".btnActivarTicket", function(){

    var idTicketEstado = $(this).attr("idTicketEstado");
    var estadoTicket = $(this).attr("estadoTicket");  

    var datos = new FormData();

    datos.append("idTicketEstado", idTicketEstado);
    datos.append("estadoTicket", estadoTicket);

    $.ajax({
        url:"ajax/tickets.ajax.php", //enviamos a este archivo el id para que lo procese
        method: "POST", //el envio es por POST
        data: datos, //datos es la instancia de ajax 
        cache: false,
        contentType: false,
        processData: false,
        dataType:"json", //los datos son de tipo json
        success:function(respuesta){ //obtengo una respuesta tipo json          
            
            console.log("respuesta",respuesta);
        }
    })        
        if (estadoTicket == 0) {
            $(this).removeClass('btn-success');
            $(this).addClass('btn-warning');
            $(this).html('<i class="fas fa-ban"></i>');
            $(this).attr('estadoTicket', 1);
            $(this).attr({title: "Activar Ticket"});
            // $('#ticketEstado').tooltip('dispose');            
        }
        else {
            $(this).removeClass('btn-warning');
            $(this).addClass('btn-success');
            $(this).html('<i class="fas fa-check"></i>');
            $(this).attr('estadoTicket', 0);
            $(this).attr({title: "Desactivar Ticket"});
            // $('#ticketEstado').tooltip('dispose'); 
            
        }

})
/*=====  END OF PARA ACTIVAR UN TICKET  ======*/
// PARA MOSTRAR TOOLTIPS A LOS BOTONES
// $(document).ready(function(){
//   $('[data-toggle="tooltip"]').tooltip();     
// });

