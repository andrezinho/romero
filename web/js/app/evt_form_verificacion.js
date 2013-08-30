$(function() 
{       
    $("#dnicliprof").focus();

    $("#sexo, #idestado_civil,#idgradinstruccion, #idtipovivienda").css({'width':'210px'});
    $("#fecha").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $("#tabs").tabs();

    $("#desproducto").on('keyup','#valorcuota',function(){CalcTotalCre(); });
    $("#IngresosPare").on('keyup','#ingresocli',function(){CalcTotalIng(); }); 
    
    // Buscar Cliente con DNI
    $("#dni").autocomplete({
        minLength: 0,
        source: 'index.php?controller=clientes&action=get&tipo=1',
        focus: function( event, ui ) 
        {
            $( "#dni" ).val( ui.item.dni );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idcliente").val(ui.item.idpersonal);
            $("#dni" ).val( ui.item.dni );
            $("#nomcliente" ).val( ui.item.nomcliente );
            $("#sexo").val(ui.item.sexo);
            $("#direccion" ).val( ui.item.direccion );
            $("#referencia" ).val( ui.item.referencia ); 
            $("#telefono").val(ui.item.telefono);            
            $("#ocupacion" ).val( ui.item.ocupacion ); 
            $("#idestado_civil").val(ui.item.idestado_civil);
            $("#idgradinstruccion" ).val( ui.item.idgradinstruccion ); 
            $("#trabajo").val(ui.item.trabajo);
            $("#dirtrabajo").val(ui.item.dirtrabajo);
            $("#teltrab").val(ui.item.teltrab);
            $("#ingresocli").val(ui.item.ingreso);
            $("#cargafam").val(ui.item.carga_familiar);
            $("#dnicon").val(ui.item.con_dni);
            $("#nomconyugue").val(ui.item.nomconyugue);
            $("#con_ocupacion").val(ui.item.con_ocupacion);
            $("#con_trabajo").val(ui.item.con_trabajo);
            $("#con_dirtrabajo").val(ui.item.con_dirtrabajo);
            $("#con_cargo").val(ui.item.con_cargo);
            $("#ingresocon").val(ui.item.con_ingreso);
            $("#con_teltrab").val(ui.item.con_teltrab);

            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.dni +" - " + item.nomcliente + "</a>" )
            .appendTo(ul);
      };

    // Buscar Cliente con nombres
    $("#nomcliente").autocomplete({
        minLength: 0,
        source: 'index.php?controller=clientes&action=get&tipo=2',
        focus: function( event, ui ) 
        {
            $( "#nomcliente" ).val( ui.item.nomcliente );
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idcliente").val(ui.item.idpersonal);
            $("#dni" ).val( ui.item.dni );
            $("#nomcliente" ).val( ui.item.nomcliente );
            $("#sexo").val(ui.item.sexo);
            $("#direccion" ).val( ui.item.direccion );
            $("#referencia" ).val( ui.item.referencia ); 
            $("#telefono").val(ui.item.telefono);            
            $("#ocupacion" ).val( ui.item.ocupacion ); 
            $("#idestado_civil").val(ui.item.idestado_civil);
            $("#idgradinstruccion" ).val( ui.item.idgradinstruccion ); 
            $("#trabajo").val(ui.item.trabajo);
            $("#dirtrabajo").val(ui.item.dirtrabajo);
            $("#teltrab").val(ui.item.teltrab);
            $("#ingresocli").val(ui.item.ingreso);
            $("#cargafam").val(ui.item.carga_familiar);
            $("#dnicon").val(ui.item.con_dni);
            $("#nomconyugue").val(ui.item.nomconyugue);
            $("#con_ocupacion").val(ui.item.con_ocupacion);
            $("#con_trabajo").val(ui.item.con_trabajo);
            $("#con_dirtrabajo").val(ui.item.con_dirtrabajo);
            $("#con_cargo").val(ui.item.con_cargo);
            $("#ingresocon").val(ui.item.con_ingreso);
            $("#con_teltrab").val(ui.item.con_teltrab);

            return false;
        }
    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.nomcliente +" - " + item.dni + "</a>" )
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
            //$( "#precio" ).val( ui.item.precio );                                    
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

function CalcTotalCre()
{

  //$("#inicial" ).required();
  //$("#nrocuota" ).required();
  //$("#valorcuota" ).required();
  
  //CalcularCre()
  var Ini=$("#inicial").val()
  var Nro=$("#nrocuota").val()
  var Val=$("#valorcuota").val()
  Val=Val.replace(",","");
  Ini=Ini.replace(",","");
  Total=((Nro) * (parseFloat(Val))) + parseFloat(Ini);

  $("#total").val(parseFloat(Total).toFixed(2));
}

function CalcTotalIng()
{
  var InigC=$("#ingresocon").val()
  var InigI=$("#ingresocli").val()
  
  InigI=InigI.replace(",","");
  InigC=InigC.replace(",","");
  Total= (parseFloat(InigI)) + (parseFloat(InigC));

  $("#totaling").val(parseFloat(Total).toFixed(2));
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