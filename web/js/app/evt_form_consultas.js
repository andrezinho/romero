$(function() 
{   
    $("#fechad, #fechah").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $( "#idpersonal" ).css({'width':'180px'});
    
    $( "#descripcion" ).focus();    
    $("#estados").buttonset();
    
    $("#proform").on('click','#reporte_prof',function(){ReporteProf(); }); 
    
});

function ReporteProf()
{
    //alert('');
    fechai=$("#fechad").val();
    fechaf=$("#fechah").val();
    idper= $("#idpersonal").val();
    
    if(idper=='')
        {
            idper=0;
        }else
            {
               idper=idper; 
            }
    //alert(fechai);
    $.get('index.php','controller=proformas&action=load_proformas&idper='+idper+'&fechai='+fechai+'&fechaf='+fechaf,function(r){
      
      $("#load_resultado").empty().append(r);

    });
}

function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();        
  //bval = bval && $( "#orden" ).required();
  var str = $("#frm").serialize();
  if ( bval ) 
  {
      $.post('index.php',str,function(res)
      {
        if(res[0]==1){
          $("#box-frm").dialog("close");
          gridReload(); 
        }
        else
        {
          alert(res[1]);
        }
        
      },'json');
  }
  return false;
}