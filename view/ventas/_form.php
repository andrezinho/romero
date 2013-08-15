<?php
include("../lib/helpers.php"); 
include("../view/header_form.php");
?>

<form id="frm_ventas">
<table width="700px" border="0" cellspacing="0" cellpadding="0">  
  
      <tr>
          <td>
            <label for="idalmacen" class="labels">Almacen:</label>
          </td>
          <td>
            <?php echo $Almacen; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            Fecha&nbsp;: &nbsp;<input type="text" class="ui-widget-content ui-corner-all text" name="Fecha" id="Fecha" value="<?php echo date('d/m/Y') ?>" />
            <input type="hidden" name="1form1_idmovimiento" id="Id" value="" />
            <input type="hidden" name="0form1_idmovimientotipo" id="IdTipo" value="2" />
            <input type="hidden" name="0form1_estado" id="Estado" value=""/>
         </td>
      </tr>
      <tr>
        <td ><label class="labels">Documento:</label></td>
        <td >
          <?php echo $tipodocumento; ?>
          <span class="ui-icon-refres" title="Refrescar Tipo Documento" onclick="RefreshTipoDocumento(this)"></span>
          <span class="ui-icon-loading"></span>
          <span class="ui-icon-add" title="Nuevo Tipo Documento" onclick="AddTipoDocumento(this)"></span>

          &nbsp;N&deg;
          <input name="documentoserie" value="" id="Serie" title="Serie" type="text" class="ui-widget-content ui-corner-all text" style="width:40px;"  />
          -
          <input name="documentonumero" value="" id="Numero" title="N&uacute;mero" type="text" class="ui-widget-content ui-corner-all text" style="width:70px;"  />
          &nbsp;Fecha Emisi&oacute;n &nbsp;: &nbsp;
          <input type="text" class="ui-widget-content ui-corner-all text" name="FechaDocumento" id="FechaDocumento" value="<?php echo date('d/m/Y') ?>" />
     
      </td>
      </tr>
      <tr>
        <td ><label class="labels">Cliente:</label></td>
        <td >
          <input name="idcliente" type="hidden" id="idcliente" value="" />  
          <input type="text"  class="ui-widget-content ui-corner-all text" name="Ruc" id="Ruc" maxlength="11" size="11"  />
          <span class="ui-icon-buscar" title="Buscar Cliente" onclick="BuscarCliente()"></span>
          <span class="ui-icon-add" title="Nuevo Cliente" onclick="AddCliente(this)"></span>
          <input type="text" class="ui-widget-content ui-corner-all text" title="Razon Social" id="Clientes" style="width:150px;" />
        
          <label for="idalmacen" class="labels">Forma de Pago :&nbsp;&nbsp;</label>          
          <?php echo $formapago; ?>    
              
      </td>
      </tr>
      <tr>
        <td ><label class="labels">Moneda:</label></td>
        <td >
          <?php echo $moneda; ?>
          <div id="DivTipoCambio" style="display:inline">
            &nbsp;&nbsp;&nbsp;&nbsp;<label class="labels">Tipo de Cambio &nbsp; : &nbsp;</label>
            <input name="0form1_tipocambio" value="" id="TipoCambio" title="Tipo de Cambio" type="text" class="ui-widget-content ui-corner-all text" style="width:40px;"  />

          </div>
          <div id="DivIgv" style="display:inline">
            &nbsp;&nbsp;&nbsp;&nbsp;<label class="labels">Afecto IGV &nbsp; : &nbsp;</label>
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
        <td ><label class="labels">Observaciones:</label></td>
        <td >
          <textarea name="0form1_obs" class="ui-widget-content ui-corner-all text" id="Obs" title="Observaciones" ><?=$row['obs']?></textarea>
           &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descuento &nbsp; : &nbsp;
            <input name="0form1_porcentajedescuento" value="" id="Dscto" onkeypress="ValidarDscto(this,event)" onblur="ValidarDsctoO(this)"  title="Porcentaje de Descuento" type="text" class="ui-widget-content ui-corner-all text" style="width:40px;"  />%
          <div id="DivSave">sss</div>
        </td>
      </tr>
      <tr id="TrMotivoAnulacion" style="display:none">
        <td >Motivo Anulaci&oacute;n : </td>
        <td ><textarea style="width:400px" name="0form1_motivoanulacion" cols="60" class="ui-widget-content ui-corner-all text" id="MotivoAnulacion"  placeholder="Digite el Motivo de la Anulación">ssss</textarea></td>
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
                      <input type="text" class="ui-widget-content ui-corner-all text" title="C&oacute;digo de Barras del Producto" id="Barras" style="width:80px"  />
                      <span class="ui-icon-buscar" title="Buscar Producto" onclick="BuscarProducto(this)"></span>
                      <input type="text" class="ui-widget-content ui-corner-all text" style="width:250px" title="Descripci&oacute;n del Producto" id="Producto"  />
                      <input type="text" id="Cantidad" title="Cantidad" class="ui-widget-content ui-corner-all text" value="1"  style="width:50px" />
                      <span id="UnidadMedida"></span>
                      
                      <input type="text" id="Precio" title="Precio" class="ui-widget-content ui-corner-all text" value=""  style="width:50px" onkeypress="ValidarEnter(event,1);"/>
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
                    
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="5" align="right" >Sub Total :</td>
                      <td align="right" >
                        <input type="text" id="SubTotal" name="0form1_subtotal" value="" class="ui-widget-content ui-corner-all text" readonly="readonly" style="text-align:right;width:60px"  /> 
                      </td>
                      <td >&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="5" align="right" >Dscto:</td>
                      <td align="right" >
                        
                        <input type="text" id="vDscto"  value="" class="ui-widget-content ui-corner-all text" readonly="readonly" style="text-align:right;width:60px"  /> 
                      </td>
                      <td >&nbsp;</td>
                    </tr>
                    <tr id="TrvIgv">
                      <td colspan="5" align="right" >IGV:</td>
                      <td align="right" >
                        <input type="hidden" id="PorcentajeIgv" name="0form1_porcentajeigv" value="">
                        <input type="text" id="IGV"  value="" class="ui-widget-content ui-corner-all text" readonly="readonly" style="text-align:right;width:60px"  /> 
                      </td>
                      <td >&nbsp;</td>
                    </tr>
                    <tr>
                      <td colspan="5" align="right" >Total :</td>
                      <td align="right" >
                        <input type="text" id="Total" name="0form1_total" value="" class="ui-widget-content ui-corner-all text" readonly="readonly" style="text-align:right;width:60px"  /> 
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
    

</table>
</form>
