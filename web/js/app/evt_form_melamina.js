$(function() 
{    
    $( "#tipoproducto" ).focus();       
    $( "#idlinea" ).css({'width':'210px'});
    $( "#idmaderba" ).css({'width':'210px'});
    $( "#idunidad_medida" ).css({'width':'210px'});
    $("#estados").buttonset();
});

function save()
{
  bval = true;        
  bval = bval && $( "#idlinea" ).required();
  bval = bval && $( "#idmaderba" ).required();        
  bval = bval && $( "#idunidad_medida" ).required();
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