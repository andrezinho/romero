$(function() 
{    
    $( "#tipoproducto" ).focus();       
    $( "#idlinea" ).css({'width':'210px'});
    $( "#idmaderba" ).css({'width':'210px'});
    $( "#idunidad_medida" ).css({'width':'210px'});
    $("#estados").buttonset();
    $("#box-frm-linea").dialog({
      modal:true,
      autoOpen:false,
      width:'auto',
      height:'auto',
      resizing:true,
      title:'Formulario de Linea',
      buttons: {'Registrar Linea':function(){save_linea();}}
    });
    $("#frm_melamina").on('click','#newLine',function(){
        $.get('index.php?controller=Linea&action=create',function(html)
        {           
           $("#box-frm-linea").empty().append(html);
           $("#box-frm-linea").dialog("open");
           $("#descripcion").focus();
           //$("#box-frm-linea").find("#estados").buttonset();
        });
    })
});
function save_linea()
{
    bval = true;        
    bval = bval && $( "#descripcion" ).required();
    if(bval)    
    {
       var str = $("#frm").serialize();       
       $.post('index.php',str,function(res)
       {
          if(res[0]==1)
          {
             $("#idlinea").append('<option value="'+res[2]+'">'+$("#descripcion").val()+'</option>');
             $("#box-frm-linea").dialog('close');
             $("#idlinea").val(res[2]);
          }
       },'json');
    }
}
function save()
{
  bval = true;        
  bval = bval && $( "#idlinea" ).required();
  bval = bval && $( "#idmaderba" ).required();        
  bval = bval && $( "#idunidad_medida" ).required();
  var str = $("#frm_melamina").serialize();
  if ( bval ) 
  {
      $.post('index.php',str,function(res)
      {
        if(res[0]==1)
        {
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