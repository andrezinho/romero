$(function() 
{       
    $("#referencia").focus();
    $("#idmadera").change(function(){$("#cantidad_ma").focus();});
    $("#idmelamina").change(function(){$("#cantidad_me").focus();});
    $("#idlinea").change(function(){load_melamina($(this).val()););
    $("#table-ma").on('click','#addDetail_ma',function(){addDetailMa();})
    $("#table-ma").on('keyup','#precio_ma,#cantidad_ma',function(){var st = calcSubTotalMa(); $("#total_ma").val(st);})
    $("#fecha").datepicker({dateFormat:'dd/mm/yy'});
    $("#table-me").on('click','#addDetail_me',function(){addDetailMe();});
    $("#table-me").on('keyup','#precio_me,#cantidad_me,#peso_me',function(){
        var st = calcSubTotalMe(); $("#total_me").val(st);
        var tp = calcTotalPeso(); $("#peso_t_me").val(tp);
    });
    $("#table-detalle").on('click','.boton-delete',function(){var v = $(this).parent().parent().remove();caltotal();})


});
function load_melamina(idl)
{
  if(idl!="")
  {
    $.get('index.php','controller=melamina&action=getList&idl='+idl,function(){    
      
    });
  }
}
function calcSubTotalMa()
{
    var cant=parseFloat($("#cantidad_ma").val()),
        prec=parseFloat($("#precio_ma").val()),
        total = 0;
    total = cant*prec;
    return total.toFixed(2);
}
function calcSubTotalMe()
{
    var cant=parseFloat($("#cantidad_me").val()),
        prec=parseFloat($("#precio_me").val()),
        total = 0;
    total = cant*prec;
    return total.toFixed(2);
}
function calcTotalPeso()
{
    var cant=parseFloat($("#cantidad_me").val()),
        peso=parseFloat($("#peso_me").val()),
        total = 0;
    total = cant*peso;
    return total.toFixed(2);
}
function addDetailMa()
{
    bval = true;
    bval = bval && $("#idmadera").required();
    bval = bval && $("#cantidad_ma").required();
    bval = bval && $("#precio_ma").required();
    if(!bval) return 0;
    var tipo=1,        
        idma=$("#idmadera").val(),
        made=$("#idmadera option:selected").html(),
        cant=parseFloat($("#cantidad_ma").val()),
        prec=parseFloat($("#precio_ma").val()),
        total=calcSubTotalMa();
    if(cant<=0) {alert('La cantidad debe ser mayor que 0'); $("#cantidad_ma").focus(); return 0;}   
    if(prec<=0) {alert('La precio debe ser mayor que 0'); $("#precio_ma").focus(); return 0;}
    addDetalle(tipo,idma,made,cant,'','',prec,total);
    clearMa();
}
function addDetailMe()
{
    bval = true;
    bval = bval && $("#idmelamina").required();
    bval = bval && $("#cantidad_me").required();
    bval = bval && $("#precio_me").required();
    if(!bval) return 0;
    var tipo=2,        
        idma=$("#idmelamina").val(),
        made=$("#idmelamina option:selected").html(),
        cant=parseFloat($("#cantidad_me").val()),
        prec=parseFloat($("#precio_me").val()),
        total=calcSubTotalMe(),
        peso=parseFloat($("#peso_me").val()),
        pesot=calcTotalPeso();
    if(cant<=0) {alert('La cantidad debe ser mayor que 0'); $("#cantidad_me").focus(); return 0;}   
    if(prec<=0) {alert('La precio debe ser mayor que 0'); $("#precio_me").focus(); return 0;}
    addDetalle(tipo,idma,made,cant,peso,pesot,prec,total);
    clearMe();    
}
function addDetalle(tipo,idtipo,dtipo,cant,peso,pesot,precio,total)
{
    ntipo = '';
    if(tipo==1) ntipo = 'MADERA'; 
      else ntipo = 'MELAMINA';
    var html = '';
    html += '<tr class="tr-detalle"><td align="left">'+ntipo+'<input type="hidden" name="tipod[]" value="'+tipo+'" /></td>';
    html += '<td>'+dtipo+'<input type="hidden" name="idtipod[]" value="'+idtipo+'" /></td>';
    html += '<td align="center">'+cant.toFixed(2)+'<input type="hidden" name="cantd[]" value="'+cant+'" /></td>';
    html += '<td align="right">'+precio.toFixed(2)+'<input type="hidden" name="preciod[]" value="'+precio+'" /></td>';
    if(peso!="") html += '<td align="right">'+peso.toFixed(2)+'<input type="hidden" name="pesod[]" value="'+peso+'" /></td>';
      else html += '<td>&nbsp;</td>';
    if(peso!="") html += '<td align="right">'+pesot+'<input type="hidden" name="pesotd[]" value="'+pesot+'" /></td>';
      else html += '<td>&nbsp;</td>'
    html += '<td align="right">'+total+'</td>';
    html += '<td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>';
    html += '</tr>';    
    $("#table-detalle").find('tbody').append(html);
    caltotal();
}
function caltotal()
{
   var st = 0;
   $("#table-detalle tbody tr").each(function(idx,j){
      mont = parseFloat($(j).find('td:eq(6)').html());     
      if(!isNaN(mont)) st += mont;      
   });
   $("#table-detalle tfoot td:eq(1)").empty().append('<b>'+st.toFixed(2)+'</b>');
}
function clearMa()
{
  $("#idmadera").val("");
  $("#cantidad_ma,#precio_ma,#total_ma").val("0.00");
  $("#idmadera").focus();
}
function clearMe()
{
  $("#idmelamina").val("");
  $("#cantidad_me,#precio_me,#peso_me,#peso_t_me,#total_me").val("0.00");  
  $("#idmelamina").focus();
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
  bval = bval && $( "#fecha" ).required();
  bval = bval && $( "#referencia" ).required();          
  if ( bval ) 
  {
      var ni = nItems();
      if(ni<=0) { alert("Aun no a ingresado ningun tipo de producto al detalle"); return 0; }
      var str = $("#frm-ingresom").serialize();
      $.post('index.php',str,function(res)
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
  return false;
}