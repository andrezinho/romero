$(function() 
{   
    $("#fechad, #fechah").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $( "#idpersonal" ).css({'width':'180px'});
    
    $( "#descripcion" ).focus();    
    $("#estados").buttonset();
    
    $("#proform").on('click','#reporte_prof',function(){ReporteProf(); });
    
    $("#hojar").on('click','#reporte_hr',function(){ReporteHojaR(); });

    $("#ingreso").on('click','#reporte_ing',function(){ReporteIngreso(); });

    //PROFORMAS - MOSTRAR DETALLE QUE SALE EN EL REPORTE
    $("#proform").on('click','#print_rpt',function(){
        
        fechai=$("#fechad").val();
        fechaf=$("#fechah").val();
        if($("#idpersonal").val()=='')
        {
          idper=0
        }else
          {
            idper=$("#idpersonal").val();
          }

        var ventana=window.open('index.php?controller=proformas&action=print_rpt&fechad='+idper+'&fechai='+fechai+'&fechaf='+fechaf, 'Imprimir Proforma, width=600, height=600, resizable=no, scrollbars=yes, status=yes,location=yes'); 
        ventana.focus();
        
    });
    
    
});

//PROFORMAS
function ReporteProf()
{
    //alert('');
    fechai=$("#fechad").val();
    fechaf=$("#fechah").val();
    if($("#idpersonal").val()=='')
        {
          idper=0
        }else
          {
            idper=$("#idpersonal").val();
          }
    
    $.get('index.php','controller=proformas&action=load_proformas&idper='+idper+'&fechai='+fechai+'&fechaf='+fechaf,function(r){
      
      $("#load_resultado").empty().append(r);

    });
}

//HOOJA DE RUTAS
function ReporteHojaR()
{
  fechai=$("#fechad").val();
  fechaf=$("#fechah").val();  
    //alert('');
    if($("#idpersonal").val()=='')
        {
          idper=0
        }else
          {
            idper=$("#idpersonal").val();
          }
    //alert(idper);
    $.get('index.php','controller=hojaruta&action=load_hojarutas&idper='+idper+'&fechai='+fechai+'&fechaf='+fechaf,function(r){
      
      $("#load_resultado").empty().append(r);

    });
}

//INGRESOS DE MATERIALES
function ReporteIngreso()
{
  fechai=$("#fechad").val();
  fechaf=$("#fechah").val();  
  
    $.get('index.php','controller=ingresom&action=load_ingresos&fechai='+fechai+'&fechaf='+fechaf,function(r){
      
      $("#load_resultado").empty().append(r);

    });
}




