$(function() 
{    
    $( "#idfinanciamiento" ).css({'width':'140px'});
    $("#Fecha, #FechaDocumento").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $( "#idalmacen" ).css({'width':'150px'});
    $("#div_activo").buttonset();
    $("#idtipodocumento").css({'width':'150px'});
    $("#idtipodocumento").change(function(){load_correlativo($(this).val());});

    $("#idtipopago").change(function(){
        load_campos($(this).val()); 
    });
      
    //buscar cliente
    $("#Ruc").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=clientes&action=get&tipo=1',
        focus: function( event, ui ) 
        {
            $( "#dni" ).val( ui.item.dni );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idcliente").val(ui.item.idcliente);
            $( "#Ruc" ).val( ui.item.dni );
            $( "#Clientes" ).val( ui.item.nomcliente );                                    
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.dni +" - " + item.nomcliente + "</a>" )
            .appendTo(ul);
      };

    //buscar producto
    $("#producto").autocomplete({        
        minLength: 0,
        source: 'index.php?controller=subproductosemi&action=get&tipo=2',
        focus: function( event, ui ) 
        {
            $( "#producto" ).val( ui.item.producto );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idsubproductos_semi").val(ui.item.idsubproductos_semi);           
            $( "#producto" ).val( ui.item.producto );
            $( "#precio" ).val( ui.item.precio );                                    
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.producto + "</a>" )
            .appendTo(ul);
      };

    $( "#divFinanciamiento" ).dialog({
      autoOpen: false,
      width: 400,
      
    });

});


function load_correlativo(idtp)
{
  if(idtp!="")
  {    
    $.get('index.php','controller=tipodocumento&action=Correlativo&idtp='+idtp,function(r){
          
          $("#Serie").val(r.serie);
          $("#Numero").val(r.numero);

      },'json');
  }else
    {
      $("#Serie").val('');
      $("#Numero").val('');
    }
}

/**/

function load_campos(idtipo)
{

  if(idtipo== 2)
  {
    //alert(idtipo);    
    $( "#TbF" ).show();
    $( "#TrCredito" ).show();
  }else
    {
      $( "#TbF" ).hide();
      $( "#TrCredito" ).hide();
    }
}

function load_finaciamiento(idfinanc)
{
  if(idfinanc!="")
  {    
    $.get('index.php','controller=financiamiento&action=RecFinanciamiento&idfinanc='+idfinanc,function(r){
      
      var html = '';      
      html += '<table align="center" width="263" border="1" cellspacing="0" class="ui-widget ui-widget-content" id="TbFactores">';
      html += '<thead class="ui-widget-header">';
      html += '<tr title="Cabecera">';
      html += '<th scope="col" width="104" align="center">Nro Meses</th>';
      html += '<th scope="col" width="114" align="center">Importe Cuota</th>';           
      html += '</tr>';
      html += '</thead>';
      html += '<tbody>';

      var cont=0;
      $.each(r,function(i,j){
        cont=cont +1;
        
        html += '<tr id="'+cont+'" style="background-color:#FFFFFF" class="factornum" >';
        html += '<td align="center"><label class="Mes">'+j.meses+'</label></td>';
        html += '<td align="right"><label class="Factor">'+j.factor+'</label><label class="Importe"></label></td>';
        html += '</tr>';
        //alert(html);      
      });

      html += '<input type="hidden" id="NroFactores" value="'+cont+'" />';
      html += '<input type="hidden" id="Adicional" value="'+r[0].adicional+'" />';
      html += '</tbody>';
      html += '<table>';
      

      $("#divFinanciamiento").empty().append(html);

    },'json');
  }
}

/**/

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