<?php
if(!session_start()){session_start();}
include("../clases/config.php");
include("../clases/clsSeguridad.php");
$ObjSeguridad = new clsSeguridad();
$Op = $_GET["Op"];
$ObjSeguridad->ValidarAcceso($Op,$_SESSION['IdSistema'],$_SESSION['IdPerfil'],$_GET['IdModulo'],$_SESSION['IdUsuario']);

$Id = isset($_GET["Id"])?$_GET["Id"]:'';
$Entidad='Venta';
$PorcentajeIgv='18.00';
$a=date ("Y"); 
$m=date ("m");
$d=date ("d");
$Fecha = DecFecha(date('Y-m-d'));
$Aigv=0;
$TipoCambio='1.00';
$Dscto='0.00';
if($Id!='')
{
	$Select 	= "SELECT m.*,em.descripcion as estadod 
    FROM public.movimiento  m
   INNER JOIN public.estadomovimiento em ON (em.idestado = m.estado) 
   WHERE idmovimiento = '".$Id."'";
	$Consulta 	= $conexion->query($Select);
	$row		= $Consulta->fetch();
	$Estado = $row['estado'];
  $EstadoD= $row['estadod'];
 	$Fecha = DecFecha($row['fecha']);
  $TipoCambio=$row['tipocambio'];
  $Dscto=$row['porcentajedescuento'];
  $Aigv=$row['igv'];

}
AddFiles();
?>
<style type="text/css">
.IdProducto { display: none;}
      
  
</style>
<script type="text/javascript">
$(document).ready(function(){
$( "#DivAfectoIgv" ).buttonset();
  $("#Barras").val('')
$('#Producto').autocomplete('../autocompletar/ProductoDe.php', {
          autoFill: true,
          width: 700,
          selectFirst: true,
          formatItem: FormatAuto1, 
          formatResult: FormatResult1,
          //mustMatch : true
          cacheLength: 0, //CACHE
          //extraParams: {"Al": function() { return $("#IdAlmacenEgreso").val();}, "IdProyecto": function() { return $("#IdProyecto").val();}  }
        }).result(function(event, item) {
           !item?'':RecibirProducto(item[0])
            }); 

        
        
        $('#Barras').autocomplete('../autocompletar/ProductoId.php', {
          //autoFill: true,
          width: 700,
          //selectFirst: true,
          formatItem: FormatAuto2, 
          formatResult: FormatResult1,
          //mustMatch : true
          cacheLength: 0, //CACHE
          //extraParams: {"Al": function() { return $("#IdAlmacen").val();}, "IdProyecto": function() { return $("#IdProyecto").val();} }
        }).result(function(event, item) {
           // MuestraProducto(item[0]);
            !item?'':RecibirProducto(item[2])
           
          }); 


  $('#RucProveedor').autocomplete('../autocompletar/ClienteRuc.php', {
          //autoFill: true,
          width: 700,
          //selectFirst: true,
          formatItem: FormatAuto2S, 
          formatResult: FormatResult0,
          //mustMatch : true
          cacheLength: 0 //CACHE
          //extraParams: {"Al": function() { return $("#IdAlmacen").val();}, "IdProyecto": function() { return $("#IdProyecto").val();} }
        }).result(function(event, item) {
            !item?'':RecibirCliente(item[0])
         });

    $('#DesProveedor').autocomplete('../autocompletar/ClienteRaz.php', {
          //autoFill: true,
          width: 700,
          //selectFirst: true,
          formatItem: FormatAuto2SM, 
          formatResult: FormatResult0,
          //mustMatch : true
          cacheLength: 0 //CACHE
          //extraParams: {"Al": function() { return $("#IdAlmacen").val();}, "IdProyecto": function() { return $("#IdProyecto").val();} }
        }).result(function(event, item) {
            !item?'':RecibirCliente(item[0])
         });

       $("#DivConfirmar").dialog({
              autoOpen: false,
              modal: true,
              width: 250,
              height:150,
              resizable: false,
              show: "scale",
              hide: "scale",
              close: function() {
                
                },
              buttons: {
              "Si": function() {
              $("#Estado").val(2);
               $( this ).dialog( "close" );    GuardarForm('<?=$Entidad?>',<?=$Op?>) },
              "No": function() {  $( this ).dialog( "close" );  GuardarForm('<?=$Entidad?>',<?=$Op?>) } 
            }
               //
             }); 
 });

function CargarSerie()
  {
    if ( <?=$Op?>==0) {
    var IdTipoDocumento = $("#IdTipoDocumento").val()
    $.ajax({
      url:'../clases/CargarSerie.php',
      type:'POST',
      async:true,
      data:'IdTipoDocumento=' + IdTipoDocumento + '&Serie=' + $('#Serie').val(),
      success:function(data)
      {
        $("#Numero").val(data);
      }
    })
    }
  }

function BuscarCliente()
  {
  var ventana=window.open('<?=$urlDir?>buscar/Cliente.php', 'BuscarCliente', 'width=730, height=380, resizable=no, scrollbars=no'); ventana.focus();
  }
  function RecibirCliente(Id)
  {
    $("#IdProveedor").val(Id)
     cProveedor()
  }
function cProveedor()
  {
    if ($("#IdProveedor").val()!="")
    {
      var Id = $("#IdProveedor").val()
      $.ajax({
        url:'../clases/dCliente.php',
         type:'POST',
         async:true,
         data:'Id=' + Id ,
         success:function (datos)
         {
          var r=datos.split("##");
              $("#DesProveedor").val(r[2]);
              $("#RucProveedor").val(r[1]);
         }
      })
      
    }
  }

  function vMoneda()
  {
    var Nacional = $("#IdMoneda option:selected").attr('class')
    if(Nacional==0)
    {
      $("#DivTipoCambio").show()
    }
    else
    {
      $("#DivTipoCambio").hide()
    }
    $("#TipoCambio").val('<?=$TipoCambio?>')
  }
  function vTipoDocumento()
  {
    var Impuesto = $("#IdTipoDocumento option:selected").attr('class')

    if(Impuesto==0)
    {
      $("#DivIgv").hide()
      $("#TrvIgv").hide()
      $("#Aigv0").attr("checked", true);
    }
    else
    {
      $("#DivIgv").show()
      $("#TrvIgv").show()
    }
    //$("#DivAfectoIgv" ).buttonset('refresh');
    $("#DivAfectoIgv").buttonset('refresh');
    CalcularTotal()
    // alert($('input[name="0form1_igv"]:checked').val())
    //$("#TipoCambio").val('1.00')
  }
  
  function BuscarProducto()
  {
    var ventana=window.open('<?=$urlDir?>buscar/Producto.php', 'Buscar Concepto', 'width=730, height=380, resizable=no, scrollbars=no'); ventana.focus();
  }
  function RecibirProducto(Id)
  {

    $.ajax({
       url:'../clases/dProducto.php',
         type:'POST',
         async:true,
         data:'Id=' + Id ,
         success:function(datos)
         {
            var r=datos.split("##");
            $("#IdProducto").val(Trim(r[0]));
            $("#Barras").val(Trim(r[1]));
            $("#Producto").val(Trim(r[2]));
            $("#UnidadMedida").html(Trim(r[3]));
            $("#Precio").val(Trim(r[4]));
             $("#Stock").val(Trim(r[6]));
            $("#Cantidad").focus();


         }
      })
  }
  function ValidarDscto(obj,evt)
  {
   if (VeriEnter(evt) )
    { 
      $(obj).removeClass( "ui-state-error" );
      var Cantidad = $(obj).val();
      Cantidad = str_replace(Cantidad, ',', '') ;
      if (Cantidad=="" || parseFloat(Cantidad)==0)
        { 
          $(obj).val('0.00');
          CalcularTotal()
          return false
        }
      else
        { 
          
          if (parseFloat(Cantidad) > parseFloat(100))
            {
              $(obj).val('0.00');
              CalcularTotal()
              Error(obj,'Descuento Invalido',1000,'right','error',true)
              $(obj).focus()
              return false;
            }
           Cantidad=parseFloat(Cantidad)
          $(obj).val(Cantidad.toFixed(2))
          CalcularTotal()
                   
        }
      
          
    }
    
  }
  
  function ValidarDsctoO(obj)//eventoOnblur
  {
    $(obj).removeClass( "ui-state-error" );
      var Cantidad = $(obj).val();
      Cantidad = str_replace(Cantidad, ',', '') ;
      if (Cantidad=="" || parseFloat(Cantidad)==0)
        { 
          $(obj).val('0.00');
          CalcularTotal()
          return false
        }
      else
        { 
          
          if (parseFloat(Cantidad) > parseFloat(100))
            {
              $(obj).val('0.00');
              CalcularTotal()
              Error(obj,'Descuento Invalido',1000,'right','error',true)
              $(obj).focus()
              return false;
            }
           Cantidad=parseFloat(Cantidad)
          $(obj).val(Cantidad.toFixed(2))
          CalcularTotal()
                   
        }
  }
  function ValidarEnter(e,op)
  {
    if (VeriEnter(e) )
      { 
      switch(op)
      {
        case 1: 
          AgregarItem();
        break;
        
      }
      e.returnValue = false;
    }
  }
  function AgregarItem()
  {
    var IdProducto   =$("#IdProducto").val();
    var Producto     =$("#Producto").val();
    var Cantidad     =$("#Cantidad").val();
    var UnidadMedida =$("#UnidadMedida").html();
    var Precio       =$("#Precio").val();
    var Stock        =$("#Stock").val();

   
    var j=parseInt($("#TbIndex tbody tr").length)

    for(var i1=1; i1<=j; i1++)
      { 
        Codigo = $("#TbIndex tbody tr#"+i1+" label.IdProducto").text() ;
        
        if (Codigo==IdProducto)
          {
            Error('#Barras','El Producto '+ Producto +' ya esta Agregado',1000,'right','',false)
            return false;
          }
      }

    if(IdProducto!="" && Producto!=""  )
    {
      if (parseFloat(Cantidad)==0)
      {
        Error('#Cantidad','Digite una Cantidad v&aacute;lida',1000,'right','',false)
        return false;
      }
      $("#Cantidad").removeClass( "ui-state-error" );
      if (parseFloat(Cantidad)>parseFloat(Stock))
      {
        Error('#Cantidad','Cantidad supera el Stock de : '+Stock,1000,'right','',false)
        return false;
      }
      $("#Cantidad").removeClass( "ui-state-error" );
      
      if (Precio=="" || parseFloat(Precio)==0)
        { 
              Error("#Precio",'Digite un Precio v&aacute;lido',1000,'right','error',true)
              return false;
        }
      $("#Precio").removeClass( "ui-state-error" );
      Precio= parseFloat(Precio)
      var Importe = Cantidad*Precio
      Cantidad=number_format(Cantidad,<?=$Presicion?>)
      Precio=number_format(Precio,<?=$Presicion?>)
      Importe=number_format(Importe,<?=$Presicion?>)
      var i=j+1;
      
      var tr='<tr id="'+i+'" onclick="SeleccionaId(this);">';
      tr+='<td align="center" ><label class="Item">'+i+'</label></td>';
      tr+='<td align="center" ><label class="UnidadMedida">'+UnidadMedida+'</label></td>';
      tr+='<td align="center"><label class="IdProducto">'+IdProducto+'</label>';
      tr+='<label class="Producto">'+Producto+'</label></td>';
      tr+='<td align="right"><input type="text" class="entero text inputtext ui-corner-all"  id="Cantidad'+i+'" ';
      tr+=' value= "' + Cantidad + '" size="3" ';
      tr+=' onkeypress="ValidarCant(this,event)" onblur="ValidarCantO(this)" style="text-align:center;width:60px" />';
      tr+='</td>';
      
      tr+='<td align="right"><input type="text" class="numeric text inputtext ui-corner-all"  id="PrecioPr'+i+'" ';
      tr+=' value= "' + Precio + '" size="3" ';
      tr+=' onkeypress="ValidarCant(this,event)" onblur="ValidarCantO(this)" style="text-align:center;width:60px" />';
      tr+='</td>';

   

      tr+='<td align="right"><label class="Importe">'+Importe+'</label></td>';
      tr+='<td align="center" ><a href="javascript:QuitaItemc('+i+')" class="Del" >';
      tr+='<span class="ui-icon-delete" title="Quitar Producto"></span> ';
      tr+='</a></td></tr>';
        //alert(Precio)
        
      $("#TbIndex tbody").append(tr);
      $("#IdProducto").val("");
      $("#Producto").val("");
      $("#Barras").val("");
      $('#Cantidad'+i).numeric({allow:"."});
      $('#PrecioPr'+i).numeric({allow:"."});
      $("#UnidadMedida").html('')
      $("#Stock").val('');
      $("#IdProducto").focus();
      CalcularTotal()
     }
     else
     {
       if(Trim(IdProducto)=="")
          {
          Error('#Barras','Seleccione un Producto',1000,'right','',false)
          return false;
        }
        else
        {
          Error('#Cantidad','Digite una  Cantidad v&aacute;lida',1000,'right','',false)
          return false;
        }
       
     }
    
  }
  function ValidarCant(obj,evt)
  {
    if (VeriEnter(evt) )
    { 
      
      var Cantidad = $(obj).val();
      var x=parseInt(obj.id.substr(8,(obj.id).length))
      
      $("#Cantidad"+x).removeClass( "ui-state-error" );
      $("#PrecioPr"+x).removeClass( "ui-state-error" );
      Cantidad = str_replace(Cantidad, ',', '') ;
      if (Cantidad=="" /*|| parseFloat(Cantidad)==0*/)
        { 
          $(obj).val(0);
          Error(obj,'Digite una Cantidad v&aacute;lida',1000,'right','error',true)
          $(obj).focus()
          return false;
        }
      else
        { 
          $(obj).val(number_format(Cantidad,<?=$Presicion?>))
          $(obj).removeClass( "ui-state-error" );
          var Cantidad=$("#Cantidad"+x).val()
          Cantidad = str_replace(Cantidad, ',', '') ;
          Cantidad=parseFloat(Cantidad)

          var Precio=  $("#PrecioPr"+x).val()
          Precio = str_replace(Precio, ',', '') ;
           if (Precio=="" || parseFloat(Precio)==0)
            { 
                  Error("#PrecioPr"+x,'Digite un Precio v&aacute;lido',1000,'right','error',true)
                  return false;
            }
            $("#PrecioProdu"+x).removeClass( "ui-state-error" );
          Precio=parseFloat(Precio)
          
          var Importe = Cantidad*Precio
          $("#TbIndex tbody tr#"+x+" label.Importe").text(number_format(Importe,<?=$Presicion?>))
            CalcularTotal()       
        }
      
          
    }
    
  }
  
  function ValidarCantO(obj)//eventoOnblur
  {
    var Cantidad = $(obj).val();
      var x=parseInt(obj.id.substr(8,(obj.id).length))
      
      $("#Cantidad"+x).removeClass( "ui-state-error" );
      $("#PrecioPr"+x).removeClass( "ui-state-error" );
      Cantidad = str_replace(Cantidad, ',', '') ;
      if (Cantidad=="" /*|| parseFloat(Cantidad)==0*/)
        { 
          $(obj).val(0);
          Error(obj,'Digite una Cantidad v&aacute;lida',1000,'right','error',true)
          $(obj).focus()
          return false;
        }
      else
        { 
          $(obj).val(number_format(Cantidad,<?=$Presicion?>))
          $(obj).removeClass( "ui-state-error" );
          var Cantidad=$("#Cantidad"+x).val()
          Cantidad = str_replace(Cantidad, ',', '') ;
          Cantidad=parseFloat(Cantidad)

          var Precio=  $("#PrecioPr"+x).val()
          Precio = str_replace(Precio, ',', '') ;
           if (Precio=="" || parseFloat(Precio)==0)
            { 
                  Error("#PrecioPr"+x,'Digite un Precio v&aacute;lido',1000,'right','error',true)
                  return false;
            }
            $("#PrecioProdu"+x).removeClass( "ui-state-error" );
          Precio=parseFloat(Precio)
          
          var Importe = Cantidad*Precio
          $("#TbIndex tbody tr#"+x+" label.Importe").text(number_format(Importe,<?=$Presicion?>))
            CalcularTotal()       
        }
  }
  function QuitaItemc(tr)
  {
    TrDelete=tr
    $( "#NombreItemDelete" ).html( $("#TbIndex tbody tr#"+tr+" label.Producto").text() );
    //$( "#Confirmar" ).dialog( "open" );
    QuitaItem(tr)
  }
  function QuitaItem(tr)
  { 
    var id=parseInt($("#TbIndex tbody tr").length);
    
    
      $("#TbIndex tbody tr#"+tr).remove();
      var nextfila=tr+1;
      var j;
      var IdMat="";
      for(var i=nextfila; i<=id; i++)
      {
        j=i-1;//alert(j);
        $("#TbIndex tbody tr#"+i+" label.Item").text(j);
        $("#TbIndex tbody tr#"+i+" a.Del").attr("href","javascript:QuitaItemc("+j+")");
             
        $("#Cantidad"+i).attr("id","Cantidad"+j);
        $("#PrecioPr"+i).attr("id","PrecioPr"+j);
        $("#TbIndex tbody tr#"+i).attr("id",j);
        
      }
      CalcularTotal()  

    }
  function CalcularTotal()
    { 
      var j=parseInt($("#TbIndex tbody tr").length);
      var Importe=0;
      var SubTotal=0;
      for(var i=1; i<=j; i++)
      { 
          Importe = $("#TbIndex tbody tr#"+i+" label.Importe").text()
          Importe = str_replace(Importe, ',', '') ;
          SubTotal+= parseFloat(Importe);
         
        
      }
      //DESCUENTO
      $('#SubTotal').val(number_format(SubTotal,<?=$Presicion?>));
      var Dscto=parseFloat($("#Dscto").val())
      Dscto = SubTotal * (Dscto/100);
      $("#vDscto").val(number_format(Dscto,<?=$Presicion?>))
      SubTotal = SubTotal - Dscto;
    
      //IGV
    var Igv=false
    var vIgv =0
    var Impuesto = $("#IdTipoDocumento option:selected").attr('class')
    if(Impuesto==1)
    {
      if($('input[name="0form1_igv"]:checked').val()==1)
        Igv=true
    }
    //alert(Igv)
      
      if(Igv)
      {
        vIgv = parseFloat($("#PorcentajeIgv").val())/100*SubTotal
        $('#IGV').val(number_format(vIgv,<?=$Presicion?>));
      }
      else
      {
        vIgv=0
        $('#IGV').val('0.00');
      }

      
      var Total = parseFloat(SubTotal)+parseFloat(vIgv)
      $('#Total').val(number_format(Total,<?=$Presicion?>));
    }
function ValidarForm()
    {
      
      var obj = $("#Fecha");
      if(!esdate(obj.val()))
      {
        Error(obj,'Fecha Incorrecta',1000,'above','error',true);
        return false;
      }
      obj.removeClass( "ui-state-error" );

      obj = $("#IdTipoDocumento");
      if(obj.val()=="")
      {
        Error(obj,'Seleccione Tipo Documento',1000,'above','error',true);
        return false;
      }
      obj.removeClass( "ui-state-error" );

      obj = $("#Serie");
      if(obj.val()=="")
      {
        Error(obj,'Ingrese Serie',1000,'above','error',true);
        return false;
      }
      obj.removeClass( "ui-state-error" );

      obj = $("#Numero");
      if(obj.val()=="")
      {
        Error(obj,'Ingrese Numero',1000,'above','error',true);
        return false;
      }
      obj.removeClass( "ui-state-error" );
      obj = $("#FechaDocumento");
      if(!esdate(obj.val()))
      {
        Error(obj,'Fecha Incorrecta',1000,'above','error',true);
        return false;
      }
      obj.removeClass( "ui-state-error" );
      obj = $("#IdProveedor");
      if (obj.val()=="") 
      {
        Error("#RucProveedor",'Seleccione Cliente',1000,'right','error',true);
        return false;
      };
      $("#RucProveedor").removeClass( "ui-state-error" );

      var Nacional = $("#IdMoneda option:selected").attr('class')
      if(Nacional==0)
      {
        obj = $("#TipoCambio");
        if(obj.val()=="")
        {
          Error(obj,'Ingrese Tipo Cambio',1000,'above','error',true);
          return false;
        }
      }

     

                 
    var id= parseInt($("#TbIndex tbody tr").length)
    if (id<= 0)
        {
          Error('#TbIndex','Agregue los Productos a Vender',1000,'above','error',false)
          return false;
        }
    
      
    for(var i=1; i<=id; i++)
        {
              
          elem = $('#Cantidad'+i); 
          if (elem.is (".ui-state-error")) 
          { 
              Error('#Cantidad'+i,'Digite una Cantidad v&aacute;lida',1000,'right','error',true)
            return false
            
          }
         
          elem = $('#PrecioPr'+i); 
          if (elem.is (".ui-state-error")) 
          { 
              Error('#PrecioPr'+i,'Digite una Precio v&aacute;lido',1000,'right','error',true)
            return false
            
          }
        }
        elem = $('#SubTotal'); 
        elem.val(str_replace(elem.val(), ',', ''));
        elem = $('#IGV'); 
        elem.val(str_replace(elem.val(), ',', ''));
        elem = $('#Total'); 
        elem.val(str_replace(elem.val(), ',', ''));
    if (<?=$Op?>==2)
    {
      obj = $("#MotivoAnulacion");
      if (Trim(obj.val())=='')
      {
        Error(obj,'Ingrese el Motivo Anulaci&oacute;n',1000,'right','error',true)
        return false;
        
      }
    }

    GenerarSave();
    
    
  }
  function GenerarSave()
  {
    if (<?=$Op?>!=2)
    {
      var id=parseInt($("#TbIndex tbody tr").length)
      var tr='';
      var IdProducto,Cantidad,Precio='';
      
      var IdMovimiento= $("#Id").val()
      for(var i=1; i<=id; i++)
      { 
        Cantidad = $("#Cantidad"+i).val();
        Cantidad = str_replace(Cantidad, ',', '') ;
        IdProducto=$("#TbIndex tbody tr#"+i+" label.IdProducto").text()
        Precio = $("#PrecioPr"+i).val();
        Precio = str_replace(Precio, ',', '') ;

        tr+='<input type="hidden" name="0farm'+i+'_item"  value="'+i+'"/>';
        tr+='<input type="hidden" name="0farm'+i+'_cantidad"  value="'+Cantidad+'"/>';
        tr+='<input type="hidden" name="0farm'+i+'_idproducto"  value="'+IdProducto+'"/>';
        tr+='<input type="hidden" name="0farm'+i+'_idmovimiento"  value="'+IdMovimiento+'"/>';
        tr+='<input type="hidden" name="0farm'+i+'_precio"  value="'+Precio+'"/>';
     
      }
      tr+='<input type="hidden" name="NroItems" id="Items"  value="'+id+'"/>';
      $("#DivSave").html(tr)

      
    }
    if('<?=$Op?>'!="2")
        $( "#DivConfirmar" ).dialog( "open" );
      else
        GuardarForm('<?=$Entidad?>',<?=$Op?>)
 
    
  
}

      
    
    
    
  
</script>
<div align="center">
<form id="form1" name="form1">
<table width="700" border="0" cellspacing="0" cellpadding="0" class="ui-widget-content">
  <?=TitMat($Entidad,$Op,4)?>
  <tbody>
      <tr>
          <td colspan="2" align="right">
            Fecha&nbsp;: &nbsp;<input type="text" class="fecha inputtext ui-corner-all text" name="3form1_fecha" id="Fecha" value="<?=DecFecha($row['fecha'])?>" />
            <input type="hidden" name="1form1_idmovimiento" id="Id" value="<?=$Id?>" />
            <input type="hidden" name="0form1_idmovimientotipo" id="IdTipo" value="2" />
            <input type="hidden" name="0form1_estado" id="Estado" value="<?=$Estado?>"/>
         </td>
      </tr>
      <tr>
        <td class="TitDetalle">Documento :</td>
        <td class="CampoDetalle">
          <select name="0form1_idtipodocumento" id="IdTipoDocumento" onchange="vTipoDocumento();CargarSerie()" class="requiere inputtext ui-corner-all text" title="Tipo Documento">
                  <?php 
                      $Sql = "SELECT * FROM public.tipodocumento WHERE estado = 1";
                      $Consulta = $conexion->query($Sql);
                      $cont = 0;
                      foreach($Consulta->fetchAll() as $row1)
                      {
                          $Selected = '';
                          if ($row['idtipodocumento'] == $row1[0])
                          {
                              $Selected = 'selected="selected"';
                          }
                    ?>
                        <option value="<?php echo $row1[0];?>" class="<?=$row1['impuesto']?>" <?php echo $Selected; ?> ><?php echo $row1["descripcion"];?></option>
                    <?php }?>
          </select>
          <span class="ui-icon-refres" title="Refrescar Tipo Documento" onclick="RefreshTipoDocumento(this)"></span>
          <span class="ui-icon-loading"></span>
          <span class="ui-icon-add" title="Nuevo Tipo Documento" onclick="AddTipoDocumento(this)"></span>

          &nbsp;N&deg;
          <input name="0form1_documentoserie" value="<?=$row['documentoserie']?>" id="Serie" title="Serie" type="text" class="entero text inputtext ui-corner-all" style="width:40px;"  />
          -
          <input name="0form1_documentonumero" value="<?=$row['documentonumero']?>" id="Numero" title="N&uacute;mero" type="text" class="entero text inputtext ui-corner-all" style="width:70px;"  />
          &nbsp;Fecha Emisi&oacute;n &nbsp;: &nbsp;
          <input type="text" class="fecha inputtext ui-corner-all text" name="3form1_documentofecha" id="FechaDocumento" value="<?=DecFecha($row['documentofecha'])?>" />

          
              
      </td>
      </tr>
      <tr>
        <td class="TitDetalle">Cliente :</td>
        <td class="CampoDetalle">
          <input name="0form1_idcliente" type="hidden" id="IdProveedor" value="<?=$row['idcliente']?>" />  
          <input type="text"  class="entero text inputtext ui-corner-all" id="RucProveedor" maxlength="11" size="11"  />
          <span class="ui-icon-buscar" title="Buscar Cliente" onclick="BuscarCliente()"></span>
          <span class="ui-icon-add" title="Nuevo Cliente" onclick="AddCliente(this)"></span>
          <input type="text" class="text inputtext ui-corner-all" title="Razon Social"  id="DesProveedor" style="width:150px;" />
        
          Forma de Pago :&nbsp;&nbsp;
          <select name="0form1_idformapago" id="IdFormaPago" class="requiere inputtext ui-corner-all text" title="Forma de Pago">
                  <?php 
                      $Sql = "SELECT * FROM public.formapago WHERE estado = 1";
                      $Consulta = $conexion->query($Sql);
                      $cont = 0;
                      foreach($Consulta->fetchAll() as $row1)
                      {
                          $Selected = '';
                          if ($row['idformapago'] == $row1[0])
                          {
                              $Selected = 'selected="selected"';
                          }
                    ?>
                        <option value="<?php echo $row1[0];?>" <?php echo $Selected; ?> ><?php echo $row1["descripcion"];?></option>
                    <?php }?>
          </select>
        
              
      </td>
      </tr>
      <tr>
        <td class="TitDetalle">Moneda :</td>
        <td class="CampoDetalle">
          <select name="0form1_idmoneda" id="IdMoneda" onchange="vMoneda()" class="requiere inputtext ui-corner-all text" title="Moneda">
                  <?php 
                      $Sql = "SELECT * FROM public.moneda WHERE estado = 1";
                      $Consulta = $conexion->query($Sql);
                      $cont = 0;
                      foreach($Consulta->fetchAll() as $row1)
                      {

                          $Selected = '';
                          if ($row['idmoneda'] == $row1[0])
                          {
                              $Selected = 'selected="selected"';
                          }
                          $Title="";


                    ?>
                        <option title="<?=$row1["descripcion"]?>" class="<?=$row1['nacional']?>" value="<?php echo $row1[0];?>" <?php echo $Selected; ?> ><?php echo $row1["descripcion"];?></option>
                    <?php }?>
          </select>
          <div id="DivTipoCambio" style="display:inline">
            &nbsp;&nbsp;&nbsp;&nbsp;Tipo de Cambio &nbsp; : &nbsp;
            <input name="0form1_tipocambio" value="<?=$row['tipocambio']?>" id="TipoCambio" title="Tipo de Cambio" type="text" class="numeric text inputtext ui-corner-all" style="width:40px;"  />

          </div>
          <div id="DivIgv" style="display:inline">
            &nbsp;&nbsp;&nbsp;&nbsp; Afecto IGV &nbsp; : &nbsp;
            <div id="DivAfectoIgv" style="display:inline">
              <input type="radio" id="Aigv1" name="0form1_igv" value='1' onchange="CalcularTotal()"/>
              <label for="Aigv1"   >SI</label>
              <input type="radio" id="Aigv0" name="0form1_igv" value='0' onchange="CalcularTotal()"/>
              <label for="Aigv0"  >NO</label>
            </div>
          </div>
        </td>
      </tr>
     <tr>
        <td class="TitDetalle">Observaciones :</td>
        <td class="CampoDetalle">
          <textarea name="0form1_obs" class="inputtext ui-corner-all text" id="Obs" title="Observaciones" ><?=$row['obs']?></textarea>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descuento &nbsp; : &nbsp;
            <input name="0form1_porcentajedescuento" value="<?=$Dscto?>" id="Dscto" onkeypress="ValidarDscto(this,event)" onblur="ValidarDsctoO(this)"  title="Porcentaje de Descuento" type="text" class="numeric text inputtext ui-corner-all" style="width:40px;"  />%
          <div id="DivSave"><?php echo $EstadoD;?></div>
        </td>
      </tr>

      <tr id="TrMotivoAnulacion" style="display:none">
        <td class="TitDetalle">Motivo Anulaci&oacute;n : </td>
        <td class="CampoDetalle"><textarea style="width:400px" name="0form1_motivoanulacion" cols="60" class="inputtext ui-corner-all text" id="MotivoAnulacion"  placeholder="Digite el Motivo de la Anulación"><?=$row['motivoanulacion']?></textarea></td>
      </tr>
      <tr>
    <td colspan="2">
      <fieldset>
        <legend class="ui-state-default ui-corner-all">Detalle de la Venta</legend>
          <table width="100%">
            <tr class="TrAddItem">
              <td colspan="2"  >
                <table width="100%" border="0" cellspacing="0" cellpadding="0" >
                  <tr>
                    <td align="center">
                      <input type="text" class="entero text inputtext ui-corner-all" title="C&oacute;digo de Barras del Producto" id="Barras" style="width:80px"  />
                      <span class="ui-icon-buscar" title="Buscar Producto" onclick="BuscarProducto(this)"></span>
                      <input type="text" class="text inputtext ui-corner-all" style="width:250px" title="Descripci&oacute;n del Producto" id="Producto"  />
                      <input type="text" id="Cantidad" title="Cantidad" class="numeric inputtext ui-corner-all text" value="1"  style="width:50px" />
                      <span id="UnidadMedida"></span>
                      
                      <input type="text" id="Precio" title="Precio" class="numeric inputtext ui-corner-all text" value=""  style="width:50px" onkeypress="ValidarEnter(event,1);"/>
                      <span class="ui-icon-add" title="Agregar Producto" onclick="AgregarItem()"></span>
                      <input type="hidden" id="Stock">
                      <input type="hidden" id="IdProducto">

                    </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td colspan="2" >
                <div style="height:auto; overflow:auto" align="left" id="DivDetalle">
                  <table width="700" border="0" align="center" cellspacing="0" class="ui-widget" id="TbIndex">
                    <thead class="ui-widget-header" >
                      <tr >
                        <th width="43" align="center" scope="col">Item</th>
                        <th width="100" align="center" scope="col">Unidad Medida</th>
                        <th align="center" scope="col">Producto</th>
                        <th width="50"  align="center" scope="col">Cantidad</th>
                        <th width="43"  align="center" scope="col">Precio</th>
                        <th width="43" rowspan="2" align="center" scope="col">Importe</th>
                        <th width="5" rowspan="2" align="center" scope="col">&nbsp;</th>
                      </tr>
                   
                    </thead>
                    <tbody>
              <?
          if($Id!='')
          {
          $SelectD = "SELECT md.idproducto, p.descripcion,  md.cantidad,
                            p.idunidadmedida,md.precio
                      FROM  public.movimientodetalle md
                      INNER JOIN public.producto p ON (md.idproducto = p.idproducto)";
          $SelectD .=" WHERE md.idmovimiento = '".$Id."'";
          $SelectD.=" ORDER BY md.item asc  ";
          //echo $SelectD;
          $ConsultaD=$conexion->query($SelectD);
                                                    //die($SelectD);    
          $i = 0;
          $tr="";
          $SubTotal=0;
          foreach($ConsultaD->fetchAll() as $rowD)
          {
            $i ++;
              $Importe = $rowD['cantidad']*$rowD['precio'];
              $SubTotal+=$Importe;
              $tr.='<tr id="'.$i.'" onclick="SeleccionaId(this);">';
              $tr.='<td align="center" ><label class="Item">'.$i.'</label></td>';
              $tr.='<td align="center" ><label class="UnidadMedida">'.$rowD['idunidadmedida'].'</label></td>';
              $tr.='<td align="center"><label class="IdProducto">'.$rowD['idproducto'].'</label>';
              $tr.='<label class="Producto">'.$rowD['descripcion'].'</label></td>';
              $tr.='<td align="right"><input type="text" class="entero text inputtext ui-corner-all"  id="Cantidad'.$i.'" ';
              $tr.=' value= "'.$rowD['cantidad'].'" size="3" ';
              $tr.=' onkeypress="ValidarCant(this,event)" onblur="ValidarCantO(this)" style="text-align:center;width:60px" />';
              $tr.=' </td>';
              $tr.='<td align="right"><input type="text" class="numeric text inputtext ui-corner-all"  id="PrecioPr'.$i.'" ';
              $tr.=' value= "'.$rowD['precio'].'" size="3" ';
              $tr.=' onkeypress="ValidarCant(this,event)" onblur="ValidarCantO(this)" style="text-align:center;width:60px" />';
              $tr.='</td>';
              $tr.='<td align="right"><label class="Importe">'.number_format($Importe,$Presicion).'</label></td>';

              $tr.='<td align="center" ><a href="javascript:QuitaItemc('.$i.')" class="Del" >';
              $tr.='<span class="ui-icon-delete" title="Quitar Producto"></span> ';
              $tr.='</a></td></tr>';

              
    
            
            
            
          }
        echo $tr;
          }
        ?>
                  </tbody>
                  <tfoot class="ui-widget-header">
                              <tr>
                                <td colspan="5" align="right" >Sub Total :</td>
                                <td align="right" >
                                  <input type="text" id="SubTotal" name="0form1_subtotal" value="<?=number_format($SubTotal,$Presicion)?>" class="text inputtext ui-corner-all" readonly="readonly" style="text-align:right;width:60px"  /> 
                                </td>
                                <td >&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="5" align="right" >Dscto:</td>
                                <td align="right" >
                                  
                                  <input type="text" id="vDscto"  value="<?=number_format($vDscto,$Presicion)?>" class="text inputtext ui-corner-all" readonly="readonly" style="text-align:right;width:60px"  /> 
                                </td>
                                <td >&nbsp;</td>
                              </tr>
                              <tr id="TrvIgv">
                                <td colspan="5" align="right" >IGV:</td>
                                <td align="right" >
                                  <input type="hidden" id="PorcentajeIgv" name="0form1_porcentajeigv" value="<?=$PorcentajeIgv?>">
                                  <input type="text" id="IGV"  value="<?=number_format($IGV,$Presicion)?>" class="text inputtext ui-corner-all" readonly="readonly" style="text-align:right;width:60px"  /> 
                                </td>
                                <td >&nbsp;</td>
                              </tr>
                              <tr>
                                <td colspan="5" align="right" >Total :</td>
                                <td align="right" >
                                  <input type="text" id="Total" name="0form1_total" value="<?=number_format($Total,$Presicion)?>" class="text inputtext ui-corner-all" readonly="readonly" style="text-align:right;width:60px"  /> 
                                </td>
                                <td >&nbsp;</td>
                              </tr>
                            </tfoot>
                </table>
              </div>
            </td>
          </tr>
        </table>
      </fieldset>
    </td>
  </tr>
    </tbody>

    <? include('../clases/ClaseConfirmar.php');?>

</table>
</form>
</div>

<div id="DivConfirmar" title="Confirmar Venta" style="display: none; font-size:14; font-weight:bold">
  &iquest;Desea Confirmar la Venta?
</div>
<script>
$("#Aigv<?=$Aigv?>").attr("checked", true);
cProveedor()
CargarSerie()
vMoneda()
vTipoDocumento()

Configurar()
</script>
<?php
if($Id!='')
	{
		 $conexion = null;
	}
?>