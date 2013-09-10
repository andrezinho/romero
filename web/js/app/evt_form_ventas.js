var afecto = false;
var producto = 
  { 
      nitem       : 0,
      idproducto  : new Array(), //Id tipo de producto                  
      producto    : new Array(),
      precio      : new Array(),
      stock      : new Array(),
      cantidad    : new Array(),
      estado      : new Array(),
      nuevo      : function(idproducto,producto,precio,stock,cantidad)
                    { 

                      this.idproducto[this.nitem] = idproducto;
                      this.producto[this.nitem] = producto;
                      this.precio[this.nitem] = precio;
                      this.stock[this.nitem] = stock;                                            
                      this.cantidad[this.nitem]  = cantidad;                      
                      this.estado[this.nitem] = true;
                      this.nitem += 1;

                    },
      //Mostrar en el detalle todos los items agregados
      listar      : function()
                    {
                       var html = "";
                       var cont = 0;
                       for(i=0;i<this.nitem;i++)
                       {                          
                          if(this.estado[i])
                          {
                            html += '<tr>';
                            html += '<td align="center">'+(cont+1)+'</td>';                            
                            html += '<td>'+this.producto[i]+'</td>';                            
                            p = parseFloat(this.precio[i]);
                            html += '<td align="center">'+p.toFixed(2)+'</td>';                              
                            c = parseFloat(this.cantidad[i]);
                            html += '<td align="center">'+c.toFixed(2)+'</td>';
                            t = this.precio[i]*this.cantidad[i];
                            html += '<td align="right">'+t.toFixed(2)+'</td>';
                            html += '<td><a id="item-'+i+'" class="item-mp box-boton boton-anular" href="#" title="Quitar" ></a></td>';
                            html += "</tr>";
                            cont += 1;

                          }
                       }                                            
                       $("#table-detalle-venta").find('tbody').empty().append(html);
                       this.totales();
                    },
      eliminar    : function(i)
                    {
                      this.estado[i] = false;                        
                    },
      limpiar     : function()
                    {   
                        this.idproducto.clear();this.producto.clear();this.precio.clear();
                        this.stock.clear();this.cantidad.clear();this.estado.clear();this.nitem = 0;
                    },
      //Obtenemos la cantidad total agregada en el detalle por producto
      getTotalP   : function(idproducto)
                    {
                       var t = 0;
                       for(i=0;i<this.nitem;i++)
                       {
                          if(this.estado[i]&&this.idproducto[i]==idproducto&&this.idalmacen[i]==idalmacen)                          
                             t += parseFloat(this.cantidad[i]);                          
                       }
                        return t;
                    },
      getNumItems : function(){var n = 0; for(i=0;i<this.nitem;i++){if(this.estado[i]) n += 1;} return n;},
      totales     : function()
                    {
                       var st = 0,
                           igv = $("#igv_val").val(),
                           tigv = 0,
                           t = 0;                           
                       for(i=0;i<this.nitem;i++)
                       {
                          if(this.estado[i]) 
                            st += this.cantidad[i]*this.precio[i];
                       } 
                       if(afecto)
                       {
                          tigv = st*igv/100;
                          t = st+tigv;
                       }
                       else 
                       {
                          tigv = 0;
                          t = st+tigv;
                       }
                       
                       $("#table-detalle-venta tfoot tr:eq(0) td:eq(1)").empty().append('<b>'+st.toFixed(2)+'</b>');
                       $("#table-detalle-venta tfoot tr:eq(1) td:eq(1)").empty().append('<b>'+tigv.toFixed(2)+'</b>');
                       $("#table-detalle-venta tfoot tr:eq(2) td:eq(1)").empty().append('<b>'+t.toFixed(2)+'</b>');

                       $("#tventatext").empty().append("S/. "+t.toFixed(2));
                       $("#monto_efectivo").val(t.toFixed(2));
                      return t;
                    }
  };
$(function() 
{   
    
    $("#fechaemision,#fechai,#fechav").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $("#idalmacen,#idtipodocumento" ).css({'width':'150px'});    
    $("#idtipodocumento").change(function(){load_correlativo($(this).val());});
    $("#idformapago").change(function(){$("#idformapago2").val($(this).val());change_fp();});
    $("#idformapago2").change(function(){change_fp();});
    $("#idtipopago").change(function(){change_tp($(this).val());})
    $( "#tabs" ).tabs({                          
                          // heightStyle:'auto',
                          activate: function( event, ui ) 
                          { 
                                var i = $(this).tabs( "option", "active" );
                                validar_tabs(i);
                          }
                         });  
    $("#btn-add-ma").click(function(){addnewproducto();});
    $("#table-detalle-venta").on('click','.item-mp',function(){
      var i = $(this).attr("id");
      i = i.split("-");
      producto.eliminar(i[1]);
      producto.listar();
    });
    verifAfecto();
    $("#aigv").click(function(){
       verifAfecto();
    });
    $("#gen-cronograma").click(function(){
      genCronograma();
    });
    $("#ruc").autocomplete({
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
            $( "#ruc" ).val( ui.item.dni );
            $( "#cliente" ).val( ui.item.nomcliente );
            $("#direccion").val(ui.item.direccion);
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
            $( "#producto" ).val( ui.item.producto);
            $("#precio").val("0.00");
            return false;
        },
        select: function( event, ui ) 
        {
            $("#idsubproductos_semi").val(ui.item.idsubproductos_semi);           
            $( "#producto" ).val( ui.item.producto );
            $( "#precio" ).val( ui.item.precio );     
            loadstock();                               
            return false;
        },
        search: function( event, ui ) { },
        change: function(event, ui) { }

    }).data( "ui-autocomplete" )._renderItem = function( ul, item ) {        
        return $( "<li></li>" )
            .data( "item.autocomplete", item )
            .append( "<a>"+ item.producto + "</a>" )
            .appendTo(ul);
      };
});
function load_correlativo(idtp)
{
  if(idtp!="")
  {    
    $.get('index.php','controller=tipodocumento&action=Correlativo&idtp='+idtp,function(r){
          
          $("#serie").val(r.serie);
          $("#numero").val(r.numero);

      },'json');
  }else
    {
      $("#serie").val('');
      $("#numero").val('');
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


function validar_tabs(i)
{
  var bval = true;  
  switch(i)
  {
    
    case 0: break;
    case 1: 
            bval = bval && $("#idtipopago").required();
            //Faltaria validar la cantidad de items agregados al detalle
            var ni = producto.getNumItems();
            if(ni==0)
            {
                alert("Debe ingresar los producto a vender en el detalle.");
                $( "#tabs" ).tabs( "option", "active", 0 );                
            }
            if(!bval)
            {
                alert("Para pasar a la pestaña de Registro de Pagos debe completar los datos en la pestaña Registro de Ventas")
                $( "#tabs" ).tabs( "option", "active", 0 );
            }
              
            break;
    case 2: break;
  }  
  return bval;
}

function change_fp()
{
   var i = $("#idformapago2").val(); 
   if(i!=1)  
   {
      if(i==4||i==5)
      {
         $("#box-pay-cheque").css("display","none");
         $("#box-pay-tarjeta").css("display","inline");
         $("#nrotarjeta,#nrovoucher,#nrocheque,#banco,#fechav").val("");
      }
      else
      {
          if(i==6)
          {
             $("#box-pay-cheque").css("display","inline");
             $("#box-pay-tarjeta").css("display","none");
             $("#nrotarjeta,#nrovoucher,#nrocheque,#banco,#fechav").val("");
          }
          else
          {
             $("#box-pay-tarjeta,#box-pay-cheque").css("display","none");
             $("#nrotarjeta,#nrovoucher,#nrocheque,#banco,#fechav").val("");
          }
      }
      
   }
   else
   {
      $("#box-pay-tarjeta,#box-pay-cheque").css("display","none");
      $("#nrotarjeta,#nrovoucher,#nrocheque,#banco,#fechav").val("");
   }
}
function change_tp(i)
{
  if(i!="")
  {
    if(i==1) $("#box-pay-doc").css("display","none");
    if(i==2) $("#box-pay-doc").css("display","inline");
  }
}

function loadstock()
{
   var a = $("#idalmacen").val(),
        i = $("#idsubproductos_semi").val();
    if(a!=""&&i!="")
    {
       $("#load-stock").css("display","inline");
       $.get('index.php','controller=subproductosemi&action=getstock&i='+i+'&a='+a,function(stk){
            $("#load-stock").css("display","none");
            $("#stock").val(stk);
            $("#cantidad").focus();
       })
    }
}
function addnewproducto()
{
  bval = true;
  bval = bval && $("#idsubproductos_semi").required();
  bval = bval && $("#producto").required();
  bval = bval && $("#precio").required();
  bval = bval && $("#stock").required();
  bval = bval && $("#cantidad").required();
  
  if(bval) 
  {
      var   p1   = $("#idsubproductos_semi").val(),
            p2   = $("#producto").val(),
            p3  = $("#precio").val(),
            p4  = $("#stock").val(),          
            p5   = $("#cantidad").val();
        if(p5>0)
        {
          producto.nuevo(p1,p2,p3,p4,p5);
          producto.listar();          
          $("#cantidad").val('0.00').focus();
        }      
        else 
        {
          alert("Cantidad debe ser mayor a cero (0)");
          $("#cantidad").focus();
        }
  }
}
function verifAfecto()
{
  if($('#aigv').is(':checked')) afecto = true;
   else afecto = false;       
  producto.totales();
}

function genCronograma()
{
   var bval = true;
   bval = bval && $("#monto_inicial").required();
   bval = bval && $("#interes").required();
   if(bval)
   {
        var ncuotas = $("#nrocuota").val(),
           inicial = $("#monto_inicial").val(),
           interes = $("#interes").val(),
           tinteres = $("#tipoi").val(),
           periodo = $("#periodo").val(),
           fechai = $("#fechai").val();
           tventa = producto.totales();

           neto = (tventa-inicial)/ncuotas;

           fechas = " "+fechai;
           fechac = fechai;
           html = 
           for(i=1;i<ncuotas;i++)
           {              
              var d = 0;
              if(periodo==1) d = 1;
              if(periodo==2) d = 7;
              if(periodo==3) 
              {
                fechac = fechac.toString();
                fecha = fechac.split("/");
                anio = fecha[2];
                mes  = fecha[1];
                d = finMes(mes,anio);
              }          
              prox_fecha =  UpdateFecha(fechac,d)
              fechas += prox_fecha;
              fechac = prox_fecha;
           }
   }
   
}


function trCronograma(i,fecha,monto,interes)
{
  var html = ''  ;
  html = '</tr>';
    html += '<td align="center">'+i+'</td>';
    html += '<td align="center"><input type="text" name="fechacuota[]" value="'+fecha+'" class="ui-widget-content ui-corner-all text text-date" /></td>';
    html += '<td align="right"><input type="text" name="montocouta[]" value="'+monto+'" class="ui-widget-content ui-corner-all text text-num" /></td>';
    html += '<td align="right"><input type="text" name="interescouta[]" value="'+interes+'" class="ui-widget-content ui-corner-all text text-num" /></td>';
    t = monto+interes;
    html += '<td align="right"><input type="text" name="totalcouta[]" value="'+t+'" class="ui-widget-content ui-corner-all text text-num" /></td>';    
  html += '<tr>';
  return html;
}