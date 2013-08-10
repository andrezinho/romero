$(function() 
{    
    $( "#idpadre" ).focus();
    $("#Fecha, #FechaDocumento").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $( "#idpadre" ).css({'width':'210px'});
    $("#div_activo").buttonset();

    $("#idtipodocumento").change(function(){load_correlativo($(this).val());});

    $("#Ruc").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=clientes&action=get&tipo=1',
        focus: function( event, ui ) 
        {
            $( "#Ruc" ).val( ui.item.ruc );
            return false;
        },
        select: function( event, ui ) 
        {
            $( "#idcliente" ).val(ui.item.idcliente);
            $( "#Ruc" ).val( ui.item.ruc );
            $( "#Clientes" ).val( ui.item.razonsocial);                                    
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.ruc +" - " + item.razonsocial + "</a>" )
            .appendTo(ul);
      };

});

function load_correlativo(idtp)
{
  if(idtp!="")
  {    
    $.get('index.php','controller=tipodocumento&action=Correlativo&idtp='+idtp,function(r){
          var html = '';
          $.each(r,function(i,j){
            html += '<option value="'+j.codigo+'">'+j.descripcion+'</option>'
            //alert(html);
          })
          $("#iddistrito").empty().append(html);

      },'json');
  }
}

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