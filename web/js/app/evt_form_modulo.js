$(function() 
{    
    $( "#idpadre" ).focus();
    $( "#idpadre" ).css({'width':'210px'});
    $("#div_activo").buttonset();
/*    $( "#delete" ).click(function(){
        if(confirm("Confirmar Eliminacion de Registro"))
            {
                $("#frm").submit();
            }
    });*/
});
function save()
{
  bval = true;        
  bval = bval && $( "#descripcion" ).required();        
  bval = bval && $( "#orden" ).required();
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