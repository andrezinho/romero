$(function() 
{   
    $("#tabs").tabs();
    $( "#nombres" ).focus();
    $( "#Departamento" ).css({'width':'210px'});
    $( "#iddistrito" ).css({'width':'210px'});
    $( "#idprovincia" ).css({'width':'210px'});
    $( "#idgradinstruccion,#idestado_civil" ).css({'width':'208px'});
    $( "#idtipovivienda" ).css({'width':'208px'});
    $("#estados").buttonset();
    $("#fechanac").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
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
    
    $("#dnicon").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=clientes&action=get&tipo=1',
        focus: function( event, ui ) 
        {
            $( "#dnicon" ).val( ui.item.dni );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idpareja").val(ui.item.idcliente);
            $( "#dnicon" ).val( ui.item.dni );
            $( "#conyugue" ).val( ui.item.nomcliente );                                    
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.dni +" - " + item.nomcliente + "</a>" )
            .appendTo(ul);
      };
      
      $("#conyugue").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=clientes&action=get&tipo=2',
        focus: function( event, ui ) 
        {
            $( "#conyugue" ).val( ui.item.dni );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idpareja").val(ui.item.idcliente);
            $( "#dnicon" ).val( ui.item.dni );
            $( "#conyugue" ).val( ui.item.nomcliente );                                    
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.dni +" - " + item.nomcliente + "</a>" )
            .appendTo(ul);
      };

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
  var str = $("#frm_cliente").serialize();
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