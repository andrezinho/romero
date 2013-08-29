$(function() 
{       
    $("#descripcion").focus();    
    $("#sexo, #idestado_civil,#idgradinstruccion, #idtipovivienda").css({'width':'210px'});

    $("#idsubproductos_semi").change(function(){$("#cantidad_me").focus(); load_title_produccion();});

    $("#idproductos_semi").change(function(){load_subproducto($(this).val());});

    $("#fecha, #fechanac").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});

    $("#table-me").on('click','#addDetail_me',function(){addDetailMe();});

    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})

    $("#tabs").tabs();

    $("#idmadera").change(function(){$("#cant_ma").focus();getStock($(this).val(),1);});

    $("#dni").autocomplete({
        minLength: 0,
        source: 'index.php?controller=personal&action=get&tipo=1',
        focus: function( event, ui ) 
        {
            $( "#dni" ).val( ui.item.dni );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idpersonal").val(ui.item.idpersonal);
            $( "#dni" ).val( ui.item.dni );
            $( "#personal" ).val( ui.item.nompersonal );                                    
            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.dni +" - " + item.nompersonal + "</a>" )
            .appendTo(ul);
      };
});
function getStock(id,tipo)
{   
   var c = "madera",
       a = $("#idalmacenm").val();
   if(tipo==2) c = "melamina";
   $.get('index.php','controller='+c+'&action=getStock&id='+id+'&a='+a,function(p){
      if(tipo==1) { }
        else {}
   })
}

function load_title_produccion()
{
  var p = $("#idsubproductos_semi").val();
  if(p!="")
  {
    var t1 = $("#idproductos_semi option:selected").html(),
        t2 = $("#idsubproductos_semi option:selected").html();
    $("#title-produccion").empty().append("Materia Prima a usar para la produccion de  "+t1+" "+t2);
  }
  else
  {
    $("#title-produccion").empty().append("Materia Prima a usar para la produccion" ); 
  }

}
function load_subproducto(idl)
{ 
  if(idl!="")
  {    
    $("#idsubproductos_semi").empty().append('<option value="">Cargando...</option>');
    $.get('index.php','controller=subproductosemi&action=getList&idl='+idl,function(r){    
      html = '<option value="">Seleccione...</option>';
      $.each(r,function(i,j){
        html += '<option value="'+j.idsubproductos_semi+'">'+j.descripcion+'</option>';
      });      
      $("#idsubproductos_semi").empty().append(html);
    },'json');
  }
}

function addDetailMe()
{
    bval = true;
    bval = bval && $("#idsubproductos_semi").required();
    bval = bval && $("#cantidad_me").required();    
    if(!bval) return 0;         
        idma=$("#idsubproductos_semi").val(),
        mela=$("#idproductos_semi option:selected").html()+', '+$("#idsubproductos_semi option:selected").html(),
        cant=parseFloat($("#cantidad_me").val())
        
    if(cant<=0) {alert('La cantidad debe ser mayor que 0'); $("#cantidad_me").focus(); return 0;}
    addDetalle(idma,mela,cant);
    clearMe();    
}

function addDetalle(idtipo,dtipo,cant)
{
    
    var html = '';
    html += '<tr class="tr-detalle">';
    html += '<td>'+dtipo+'<input type="hidden" name="idsubproductos_semi[]" value="'+idtipo+'" /></td>';
    html += '<td align="center">'+cant.toFixed(2)+'<input type="hidden" name="cantd[]" value="'+cant+'" /></td>';    
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);
    //caltotal();
}

function clearMe()
{
  $("#idproductos_semi").val("");
  $("#idsubproductos_semi").val("");
  $("#cantidad_me").val("0.00");  
  $("#idproductos_semi").focus();
}

function nItems()
{
  var c = 0;
  $("#table-detalle tbody tr").each(function(idx,j){c += 1;});
  return c;
}

function save()
{
  bval = true;
  bval = bval && $( "#fechai" ).required();
  bval = bval && $( "#fechaf" ).required();          
  if ( bval ) 
  {
      var ni = nItems();
      if(ni<=0) { alert("Aun no a ingresado ningun tipo de producto al detalle"); return 0; }
      var str = $("#frm-produccion").serialize();
      $.post('index.php',str,function(res)
      {
        if(res[0]==1)
        {
          //$("#box-frm").dialog("close");
          //alert();
          if (confirm("Desea ingresar su materiales que utilizará en la produccion ")) {
          // Respuesta afirmativa...
            $('#dialogConf').dialog('open');
          }
          
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