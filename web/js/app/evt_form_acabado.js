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
                       this.tipo.clear();
                       this.idalmacen.clear();
                       this.almacen.clear();
                       this.idproducto.clear();
                       this.descripcion.clear();
                       this.stock.clear();
                       this.cantidad.clear();
                       this.estado.clear();
                       this.nitem = 0;
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
                      this.materiap[this.item] = new Object();
                      this.materiap[this.item] = materia;
                      this.estado[this.item] = true;
                      this.item += 1;                                            
                      return true;
                    },
     listar         : function()
                    {
                      html = '';                     
                      for(ii=0;ii<this.item;ii++)
                      {
                         if(this.estado[ii])
                         {                            
                            html += '<div class="box-item">';
                            html += '<span class="title-head"><strong>'+this.cantidad[ii]+' '+this.descripcion[ii]+' </strong><a id="item-prod-'+ii+'-edit" href="javascript:" class="edit-produccion link-oper">Editar</a> <a id="item-prod-'+ii+'-delete" href="javascript:" class="delete-produccion link-oper">Eliminar</a></span>';
                            html += '<div id="materia-'+ii+'">';                            
                            var ni = this.materiap[ii].getNumItems();                            
                            if(ni>0)
                              {                                
                                 html += '<ul class="ul-items">';
                                 ni = this.materiap[ii].nitem;
                                 for(j=0;j<ni;j++)
                                  {
                                     estado = this.materiap[ii].estado[j];
                                     if(estado)
                                     {
                                        html += '<li>(Almacen: '+this.materiap[ii].almacen[j]+') '+this.materiap[ii].tipo[j]+' '+this.materiap[ii].descripcion[j]+', '+this.materiap[ii].cantidad[j]+'pies <a href="javascript:" id="item-prod-'+ii+'-'+j+'-mp" class="delete-produccion-mp link-oper">Quitar</a></li>';
                                     }                                  
                                  }
                                 html += '</ul>';
                              }                              
                            html += '</div>';
                            html += '</div>';
                         }
                      }
                      $("#div-detalle").empty().append(html);
                    },
    getTotalP   : function(idproducto,almacen)
                  {
                      var t = 0;
                      for(ii=0;ii<this.item;ii++)
                      {
                        if(this.estado[ii])
                        {
                           for(k=0;k<this.materiap[ii].nitem;k++)
                           {                              
                              if(this.materiap[ii].estado[k]&&this.materiap[ii].idproducto[k]==idproducto&&this.materiap[ii].idalmacen[k]==almacen)
                              {
                                 t += parseFloat(this.materiap[ii].cantidad[k]);
                              }
                            }                          
                        }
                      }
                      return t;
                  },
    edit        : function(itm)
                  {
                    $("#idproductos_semi").val(this.idps[itm]);
                    load_subproducto(this.idps[i],this.idsps[itm]);
                    $("#cantidad").val(this.cantidad[itm]);                    
                  },
    getMateriaPrimaP : function(itm)
                  {                     
                     return this.materiap[itm];
                  },
    eliminar    : function(i)
                    {
                      this.estado[i] = false;                        
                    },
    eliminar_mp : function(i,j)
                    {
                      this.materiap[i].estado[j] = false;
                    },
    getNumItems : function()
                    {
                      var n = 0;
                      for(i=0;i<this.item;i++)
                      {
                        if(this.estado[i])
                          n += 1;
                      }
                      return n;
                    }
}
$(function() 
{     
    //Basic events
    $("input[type=text]").focus(function(){this.select();});
    $("#fechai,#fechaf").datepicker({dateFormat:'dd/mm/yy','changeMonth':true,'changeYear':true});    
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

    //Eventos dentro de fildset produccion
    $("#btn-add-mp").click(function(){ $("#box-add-mp").dialog("open");});
    $("#idsubproductos_semi").change(function(){$("#cantidad").focus(); load_title_produccion();});    
    $("#idproductos_semi").change(function(){load_subproducto($(this).val()); $("#idsubproductos_semi").focus();});    
    $("#idmateriales").change(function(){getUnidad($(this).val());});              
    $("#cant_ma").change(function(){valida_cant($(this).val(),1)});
    $("#table-me").on('click','#addDetail_me',function(){addDetailMe();});    
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();})    
    $("#tabs-1").on('click','#btn-add-ma',function(){addNewMadera();});
    $("#table-detalle-materia").on('click','.item-mp',function(){
      var i = $(this).attr("id");
      i = i.split("-");
      materia.eliminar(i[1]);
      materia.listar();
    });
    $("#btn-add-detalle-prod").click(function(){addDetalleProd();});
    $("#idlinea").change(function(){load_melamina($(this).val());});
    $("#idmelamina").change(function(){getStock($("#idmelamina").val(),2);});
    $("#cant_me").change(function(){valida_cant($(this).val(),2)});
    $("#tabs-2").on('click','#btn-add-me',function(){addNewMelamina();});
    //Eventos para detalle produccion
    $("#div-detalle").on('click','.edit-produccion',function(){
        var i = $(this).attr("id"); i = i.split("-");
        editProduccion(i[2]);
    });
    $("#div-detalle").on('click','.delete-produccion',function(){
        var i = $(this).attr("id"); i = i.split("-");
        produccion.eliminar(i[2]);
        produccion.listar();
    });
    $("#div-detalle").on('click','.delete-produccion-mp',function(){
        var i = $(this).attr("id"); i = i.split("-");
        produccion.eliminar_mp(i[2],i[3]);
        produccion.listar();
    });
});

function editProduccion(i)
{
   materia.limpiar();
   produccion.eliminar(i);   
   produccion.edit(i);
   produccion.listar();
   materia = clone(produccion.getMateriaPrimaP(i));
   materia.listar();
}

function addDetalleProd()
{
  bval = true;
  bval = bval && $("#idsubproductos_semi").required();
  bval = bval && $("#cantidad").required();
  if(bval)
  {
      var idps = $("#idproductos_semi").val(),
          idsps = $("#idsubproductos_semi").val(),
          desc = $("#idproductos_semi option:selected").html()+' '+$("#idsubproductos_semi option:selected").html(),
          cant = $("#cantidad").val(),
          items = materia.getNumItems();
      if(cant>0)
      {
        if(items>0)
        {
           //clonamos materia para enviar para enviar una copia más nó una referencia
           var clon_materia = clone(materia);
           produccion.nuevo(idps,idsps,desc,cant,clon_materia);
           materia.limpiar();
           materia.listar();
           produccion.listar();
           limpiar_ps(); //Limpiamos cabecera de produccion
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

function addNew()
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

      if(valida_cant(c,1))
      {
        if(c>0)
        {
          materia.nuevo(1,ida,a,idm,m,stk,c);
          materia.listar();                        
          getStock(idm,1);
          $("#cant_ma").val('0.00').focus();
        }
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
         if(type==1)  
          $("#cant_ma").focus();
         else 
          $("#cant_me").focus();         
         return false;
      }
  }
  else 
  {
     alert("La cantidad debe ser mayo que cero (0)");
     if(type==1)  
      $("#cant_ma").focus();
     else 
      $("#cant_me").focus();
     
     return false;
  }
  return true;
  
}

function getUnidad(id)
{  
   $.get('index.php','controller=unidadmedida&action=getUnidades&id='+id,function(r){
        var html = "<option value=''>Seleccione undiad de Medida...</option>";
        $.each(r,function(i,j)
        {
            html += '<option value="+j.id+">'+j.descripcion+'</option>';
        })
        $("#idunidad_medida").empty().append(html);
   },'json');
}
function load_title_produccion()
{


}
function load_subproducto(idl)
{ 
  
}
function load_subproducto(idl,idsps)
{ 
 
}

function clearMe()
{

}


function save()
{
   var c = $( "#controller" ).val(),
       a = $( "#action" ).val();

  if(typeof(c)=="undefined"||typeof(a)=="undefined")
  {
     alert("No se puede realizar esta operacion.");
     return 0;
  }

  bval = true;
  fl = true;
  bval = bval && $( "#descripcion" ).required();
  bval = bval && $( "#fechai" ).required();
  bval = bval && $( "#fechaf" ).required();
  bval = bval && $( "#dni" ).required();

  if ( bval ) 
  {
      if($("#idproduccion").val()=="")
      {
          var ni = produccion.getNumItems();          
          if(ni<=0)
          { 
            var fl = false;
            if(confirm("Aun no a ingresado ninguna produccion al detalle, deseas continuar de todas formas?"))
            {
              fl = true;
            }
          }
      }      
      if(fl)
      {
        
            var str = $("#frm-produccion").serialize();
            var prod = json_encode(produccion);
            $.post('index.php',str+'&prod='+prod,function(res)
            {
              if(res[0]==1)
              { 
                $("#box-frm").dialog("close");          
                gridReload();
              }
              else
              {
                alert(res[1]);
              }
              
            },'json');
     
      }
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

function limpiar_ps()
{  

}
function load_melamina(idl)
{ 
  
}