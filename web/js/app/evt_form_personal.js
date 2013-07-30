$(function() 
{    
    $( "#nombres" ).focus();
    //$( "#idpadre" ).css({'width':'210px'});
    $("#estados").buttonset();
});

function save()
{
  bval = true;        
  bval = bval && $( "#dni" ).required();
  bval = bval && $( "#nombres" ).required();        
  bval = bval && $( "#apellidos" ).required();
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