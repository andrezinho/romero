var materia = 
  { 
      nitem       : 0,
      idt         : new Array(), //Id tipo de producto
      tipo        : new Array(), //Descripcion de tipo de producto
      idalmacen   : new Array(), //Id de Almacen
      almacen     : new Array(), 
      idproducto  : new Array(),
      descripcion : new Array(),
      stock       : new Array(),
      cantidad    : new Array(),
      estado      : new Array(),
      nuevo      : function(tipo,idalmacen,almacen,idproducto,descripcion,stock,cantidad)
                    {
                      if(tipo==1) this.tipo[this.nitem] = "Madera";
                        else this.tipo[this.nitem] = "Melamina";
                      this.idt[this.nitem] = tipo;
                      this.idalmacen[this.nitem] = idalmacen;
                      this.almacen[this.nitem] = almacen;
                      this.idproducto[this.nitem] = idproducto;                      
                      this.descripcion[this.nitem]  = descripcion;
                      this.stock[this.nitem] = stock;
                      this.cantidad[this.nitem]     = cantidad;
                      this.estado[this.nitem] = true;
                      this.nitem += 1;
                    },
      //Mostrar en el detalle todos los items agregados
      listar      : function()
                    {
                       var html = "";
                       for(i=0;i<this.nitem;i++)
                       {
                          if(this.estado[i])
                          {
                            html += '<tr>';
                            html += '<td align="center">'+this.tipo[i]+'</td>';
                            html += '<td>'+this.descripcion[i]+'</td>';
                            html += '<td>'+this.almacen[i]+'</td>';
                            c = parseFloat(this.cantidad[i]);
                            html += '<td align="center">'+c.toFixed(2)+'</td>';
                            html += '<td><a id="item-'+i+'" class="item-mp box-boton boton-anular" href="#" title="Quitar" ></a></td>';
                            html += "</tr>";
                          }
                       }                                            
                       $("#table-detalle-materia").find('tbody').empty().append(html);
                    },
      eliminar    : function(i)
                    {
                      this.estado[i] = false;  
                      getStock(this.idproducto[i],this.idt[i]);                    
                    },
      limpiar     : function()
                    {                       
                       this.tipo        = new Array();
                       this.idalmacen   = new Array();
                       this.almacen     = new Array();
                       this.idproducto  = new Array();
                       this.descripcion = new Array();
                       this.stock       = new Array();
                       this.cantidad    = new Array();
                       this.estado      = new Array();
                       this.nitem       = 0;
                    },
      //Obtenemos la cantidad total agregada en el detalle por producto
      getTotalP   : function(idproducto,idalmacen)
                    {
                       var t = 0;
                       for(i=0;i<this.nitem;i++)
                       {
                          if(this.estado[i]&&this.idproducto[i]==idproducto&&this.idalmacen[i]==idalmacen)
                          {
                             t += parseFloat(this.cantidad[i]);
                          }
                        }
                        return t;
                    },
      getNumItems : function()
                    {
                      var n = 0;
                      for(i=0;i<this.nitem;i++)
                      {
                        if(this.estado[i])
                          n += 1;
                      }
                      return n;
                    }
  };
var produccion = {
    item          : 0,
    idps          : new Array(),
    idsps         : new Array(),
    descripcion   : new Array(),
    cantidad      : new Array(),
    materiap      : new Array(),
    estado        : new Array(),
    nuevo         : function(idps,idsp,descripcion,cantidad,materia)
                    {
                      this.idps[this.item] = idps;
                      this.idsps[this.item] = idsp;
                      this.descripcion[this.item] = descripcion;
                      this.cantidad[this.item] = cantidad;
                      this.materiap[this.item] = materia;
                    },
    listar        : function()
                    {
                      html = '';
                      for(i=0;i<this.item;i++)
                      {
                         if(this.estado[i])
                         {
                            html += '';
                         }
                      }
                    }
}
$(function() 
{     
    $("input[type=text]").focus(function(){this.select();});
    $("#descripcion").focus();
    $("#fechai,#fechaf").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});
    $("#tabs").tabs();    
    $("#box-add-mp").dialog({
      modal:false,
      autoOpen:false,
      width:'auto',
      height:'auto',
      resizing:false,      
      title:'Agregar materia prima',
      buttons: {
                  'Cerrar': function(){ $(this).dialog('close');}                  
                }  
    });

    //*
    //Events change
    //*
    //Actualizamos el titulo de la cabecera de materia prima a usar
      $("#idsubproductos_semi").change(function(){$("#cantidad_me").focus(); load_title_produccion();});
    //Obtener los sub productos
      $("#idproductos_semi").change(function(){load_subproducto($(this).val()); $("#idsubproductos_semi").focus();});
    //Obtenemos el stock de la madera
      $("#idalmacenma,#idmadera").change(function(){getStock($("#idmadera").val(),1);});          
    //Validar la cantidad con el stock disponible de la madera
      $("#cant_ma").change(function(){valida_cant($(this).val(),1)});
    
    //*
    //Events On 
    //*
    //Agregar al detalle de produccion
      $("#table-me").on('click','#addDetail_me',function(){addDetailMe();});
    //Quitar del detalle de produccion
      $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})
    //Agregar madera al detalle de Materia prima a usar
      $("#tabs-1").on('click','#btn-add-ma',function(){addNewMadera();});
    //Quitar del detalle de materia prima a usar
      $("#table-detalle-materia").on('click','.item-mp',function(){
        var i = $(this).attr("id");
        i = i.split("-");
        materia.eliminar(i[1]);
        materia.listar();        
      })
    
    $("#btn-add-detalle-prod").click(function(){
       // m = json_encode(materia);
       // $.get('index.php','controller=produccion&action=test&m='+m,function(data){
       //    alert(data);
       // })
       addDetalleProd();
    })

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

function addDetalleProd()
{
  bval = true;
  bval = bval && $("#idsubproductos_semi").required();
  bval = bval && $("#cantidad").required();
  if(bval)
  {
      var idps = $("#idproductos_semi").val(),
          idsps = $("#idsubproductos_semi").val(),
          desc  = $("#idproductos_semi option:selected").html()+' '+$("#idsubproductos_semi option:selected").html(),
          cant = $("#cantidad").val(),
          items = materia.getNumItems();
      if(cant>0)
      {
        if(items>0)
        {
           produccion.nuevo(idps,idsps,desc,cant,materia);
        }
        else
        {
          alert("Debe agregar la cantidad de materia prima a usar para esta produccion.");
          $("#idmadera").focus();
          return 0;
        }
      }
      else
      {
         alert("la cantidad de la produccion debe ser mayor que cero (0)");
         $("#cantidad").focus();
      }
  }
}
function addNewMadera()
{
  bval = true;
  bval = bval && $("#idmadera").required();
  bval = bval && $("#cant_ma").required();
  bval = bval && $("#stock_ma").required();

  if(bval) 
  {
      var ida = $("#idalmacenma").val(),
            a = $("#idalmacenma option:selected").html(),
          idm = $("#idmadera").val(),
            m = $("#idmadera option:selected").html(),
          stk = $("#stock_ma").val(),
            c = $("#cant_ma").val();

      valida_cant(c,1);            
      if(c>0)
      {
        materia.nuevo(1,ida,a,idm,m,stk,c);
        materia.listar();
        getStock(idm,1);
        $("#cant_ma").val('0.00').focus();
      }

  }
}

function valida_cant(v,type)
{
  if(type==1)  
      var stk = $("#stock_ma").val();
  else 
      var stk = $("#stock_me").val();

  var stk = stk.replace(",","");
      stk = parseFloat(stk);  
  if(v>0)
  {  
      if(v>stk)
      {
         alert("Alerta: La cantidad supera el stock maximo.");
         $("#cant_ma").focus();
         return 0;
      }
  }
  else 
  {
     alert("La cantidad debe ser mayo que cero (0)");
     $("#cant_ma").focus();
     return 0;
  }
  
}

function getStock(id,tipo)
{   
   var c = "madera",
       a = $("#idalmacenma").val();
   if(tipo==2) c = "melamina";   
   $("#label-stock-ma").empty().append("Obteniendo Stock...");
   $("#cant_ma").val('0.00');
   $.get('index.php','controller='+c+'&action=getStock&id='+id+'&a='+a,function(stk){
      total_reservado = materia.getTotalP(id,a);
      stk = stk - total_reservado;
      if(tipo==1) 
      { 
        $("#label-stock-ma").empty().append('Stock Max: '+stk+' pies'); 
        $("#stock_ma").val(stk);
        $("#cant_ma").focus();
      }
      else 
      {
        //Melamina
      }
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

function enter(evt)
{
    var keyPressed = (evt.which) ? evt.which : event.keyCode
    if (keyPressed==13)
    {
        addNewMadera();
    }
}