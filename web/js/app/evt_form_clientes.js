$(function() 
{   
    $("#tabs").tabs();
    $( "#nombres" ).focus();
    $( "#Departamento" ).css({'width':'210px'});
    $( "#iddistrito" ).css({'width':'210px'});
    $( "#idprovincia" ).css({'width':'210px'});
    $("#estados").buttonset();
    //$("#fechanaci").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $("#Departamento").change(function(){
      idd=$(this).val();
      $.get('index.php','controller=Ubigeo&action=Provincia&idd='+idd,function(r){
          var html = '';
          $.each(r,function(i,j){
            html += '<option value="'+j.codigo+'">'+j.descripcion+'</option>'
            //alert(html);
          })
          $("#idprovincia").empty().append(html);
          IdPro=$("#idprovincia").val();
          loadDistrito(IdPro);
      },'json');
    });

});

$("#idprovincia").change(function(){
      IdPro=$(this).val();
      loadDistrito(IdPro);
});

function loadDistrito(IdPro)
{
      //$("#idprovincia").change(function(){
      //idd1=$(this).val();
      $.get('index.php','controller=Ubigeo&action=Distrito&idd1='+IdPro,function(r){
          var html = '';
          $.each(r,function(i,j){
            html += '<option value="'+j.codigo+'">'+j.descripcion+'</option>'
            //alert(html);
          })
          $("#iddistrito").empty().append(html);

      },'json');
   // });

}
function save()
{
  bval = true;        
  bval = bval && $( "#dni" ).required();
  /*bval = bval && $( "#nombres" ).required();        
  bval = bval && $( "#apellidos" ).required();*/
  var str = $("#frm_proveedor").serialize();
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