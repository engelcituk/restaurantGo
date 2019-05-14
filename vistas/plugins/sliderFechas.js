
 var posicion = 0;
 var fechasListado = new Array();
 
   //alert(jQuery('.texto').html());
   //var totalFechas = $(this).attr("totalFechas");
   //console.log("totalFechas", totalFechas);

   var numeroFechas = 10; //debo mejorar este script para obtner este numero dinamicamente a partir de mis consultas
   if(numeroFechas<=5){
    $('.derecha_flecha').css('display','none');
    $('.izquierda_flecha').css('display','none');
   }

     $('.izquierda_flecha').on('click',function(){
         if(posicion>0){
            posicion = posicion-1;
        }else{
            posicion = numeroFechas-5;
        }
        $(".carruselFechas").animate({"left": -($('#fecha_'+posicion).position().left)}, 600);
        return false;
     });

     $('.izquierda_flecha').hover(function(){
         $(this).css('opacity','0.5');
     },function(){
         $(this).css('opacity','1');
     });

     $('.derecha_flecha').hover(function(){
         $(this).css('opacity','0.5');
     },function(){
         $(this).css('opacity','1');
     });

     $('.derecha_flecha').on('click',function(){
        if(numeroFechas>posicion+5){
            posicion = posicion+1;
        }else{
            posicion = 0;
        }
        $(".carruselFechas").animate({"left": -($('#fecha_'+posicion).position().left)}, 600);
        return false;
     });

