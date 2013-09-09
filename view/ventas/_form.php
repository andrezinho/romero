<?php include("../lib/helpers.php"); ?>
<div style="padding:10px 20px; width:900px">
<form id="frm_ventas" >
    <div id="tabs">
      <ul style="background:#DADADA !important; border:0 !important">
        <li><a href="#tabs-1">Registro Ventas</a></li>
        <li><a href="#tabs-2">Registro Pagos</a></li>
        <li><a href="#tabs-3">Cronograma</a></li>
      </ul>
      <div id="tabs-1">
        <div class="ui-widget-content" style="text-align:right; background:#">
            <a href="#" style="color:green; font-weight:bold;">Agregar de Proforma: </a>
            <input type="text" name="nroproforma" id="nroproforma" class="ui-widget-content ui-corner-all text" placeholder="N° de Proforma" onkeypress="return permite(event,'num')" maxlength="10" />
            <a href="javascript:popup('index.php?controller=proforma&action=lista',870,350)" class="box-boton boton-search" title="buscar Proforma">&nbsp;</a>
            <a href="#" class="box-boton boton-ok" title="Cargar Datos"></a>            
        </div>
        <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
              <legend>Datos Generales - Fecha <?php echo date('d/m/Y'); ?></legend>
                <input type="hidden" name="controller" id="controller" value="ventas" />
                <input type="hidden" name="action" id="action" value="save" />       
                <label class="labels" for="idalamacen">Almacen: </label>      
                <?php echo $Almacen; ?>   
                <!-- <label class="labels" for="fecha">Fecha: </label>      
                <input type="text" name="Fecha" id="Fecha" value="<?php echo date('d/m/Y') ?>" class="ui-widget-content ui-corner-all text text-date"  disabled="" />  -->        
                <label class="labels" for="idtipopago">Tipo de Venta: </label>      
                <?php echo $tipopago; ?>  
                <label for="igv" class="labels" style="width:80px;">Afecto IGV:</label>
                <?php $ck = ""; if($obj->afecto==1) $ck = "checked"; ?>
                <input type="checkbox" name="aigv" id="aigv" value="1" <?php echo $ck; ?> />
                <input type="hidden" name="igv_val" id="igv_val" value="<?php if($obj->igv!="") echo $obj->igv; else echo "18"; ?>" />      
                <br/>
                <label class="labels" for="idtipodocumento">Documento: </label>      
                <?php echo $tipodocumento; ?>
                <label class="labels">N&deg;</label>
                <input name="serie" value="" id="serie" title="Serie" type="text" class="ui-widget-content ui-corner-all text" style="width:40px;"  />-
                <input name="numero" value="" id="numero" title="N&uacute;mero" type="text" class="ui-widget-content ui-corner-all text" style="width:70px;"  />
                <label class="labels">Fecha Emision: </label>
                <input type="text" name="fechaemision" id="fechaemision" value="<?php echo date('d/m/Y') ?>" class="ui-widget-content ui-corner-all text text-date" />
                <br/>
                <label class="labels">Cliente: </label>
                <input name="idcliente" type="hidden" id="idcliente" value="" />  
                <input type="text" name="ruc" id="ruc"  class="ui-widget-content ui-corner-all text" maxlength="11" size="11"  placeholder="DNI / RUC" />
                <input type="text" id="cliente" name="cliente" class="ui-widget-content ui-corner-all text" title="Razon Social" style="width:250px;" placeholder="Nombre / Razon social" />        
                <input type="text" id="direccion" name="direccion" class="ui-widget-content ui-corner-all text" title="Direccion"  style="width:326px;" placeholder="Direccion" />        
                <br/>
                <label class="labels">Forma de Pago: </label>
                <?php echo $formapago; ?>
                <label class="labels" style="width:60px">Moneda: </label>
                <?php echo $moneda; ?>
                <label class="labels">Tipo de Cambio: </label>
                <input name="tipo_cambio" value="0.00" id="tipo_cambio" title="Tipo de Cambio" type="text" class="ui-widget-content ui-corner-all text text-num" />
                <label class="labels" style="width:60px">Dscto: </label>
                <input type="text" name="monto_descuento" id="monto_descuento" value="0.00"  title="Monto del descuento" class="ui-widget-content ui-corner-all text text-num" />
                <select name="tipod" id="tipod">
                    <option value="1">S/.</option>
                    <option value="2">%</option>
                </select>                
                <br/>
                <label class="labels">&nbsp; </label>
                <textarea name="observacion" id="observacion" class="ui-widget-content ui-corner-all text"  title="Observaciones" rows="2" placeholder="Observacion" style="width:85%"></textarea>
            </fieldset>
        </form>
        <fieldset id="box-melamina" class="ui-corner-all" style="padding: 2px 10px 7px;">  
                <legend>Detalle de la venta</legend>
                <div id="box-1">
                    <label class="labels" for="producto">Producto: </label>                    
                    <input type="text" name="producto" id="producto" value="" class="ui-widget-content ui-corner-all text" style="width:200px" />
                    <input type="hidden" name="idsubproductos_semi" id="idsubproductos_semi" value="" />
                    <a href="javascript:popup('index.php?controller=subproductosemi&action=lista',870,350)" class="box-boton boton-search" title="buscar Producto">&nbsp;</a>
                    <label class="labels" for="precio" style="width:50px">Precio: </label>                    
                    <input type="text" name="precio" id="precio" value="0.00" class="ui-widget-content ui-corner-all text text-num" />                    
                    <label class="labels" for="stock" style="width:50px">Stock: </label>                    
                    <input type="text" name="stock" id="stock" value="0.00" class="ui-widget-content ui-corner-all text text-num" readonly="readonly" />                
                    <img id="load-stock" src="images/loader.gif" style="display:none" />
                    <label class="labels" for="cantidad" style="width:70px">Cantidad: </label>                    
                    <input type="text" name="cantidad" id="cantidad" value="0.00" class="ui-widget-content ui-corner-all text text-num" />
                    <a href="javascript:" id="btn-add-ma" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a>                         
                </div>
            </fieldset>
            <div id="div-detalle">
                <div>
                    <table id="table-detalle-venta" class="ui-widget ui-widget-content" style="margin: 0 auto; width:100%" border="0" >
                        <thead class="ui-widget ui-widget-content" >
                            <tr class="ui-widget-header" style="height: 23px">          
                                <th align="center" width="50">Item</th>
                                <th>Producto</th>
                                <th align="center" width="80">Precio</th>
                                <th align="center" width="80">Cantidad</th>                                
                                <th align="center" width="80px">Importe S/.</th>
                                <th width="20px">&nbsp;</th>
                            </tr>
                        </thead>  
                        <tbody>
                                               
                        </tbody>
                         <tfoot>
                            <tr>
                                <td colspan="4" align="right"><b>SUB TOTAL S/.</b></td>
                                <td align="right"><b>0.00</b></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right"><b>IGV S/.</b></td>
                                <td align="right"><b>0.00</b></td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4" align="right"><b>TOTAL S/.</b></td>
                                <td align="right"><b>0.00</b></td>
                                <td>&nbsp;</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div> 
      </div>
      <div id="tabs-2">
          <fieldset>
            <legend>Datos de Pago</legend>            
            <label class="labels">Total Venta: </label>
            <label class="text-super" id="tventatext">S/. 300.00</label>
            <span id="box-pay-doc" style="display:none">
                <label class="labels">Documento: </label>
                <!-- <input type="text" name="document_recibo" id="document_recibo" value="RECIBO DE INGRESO" class="ui-widget-content ui-corner-all text" disabled="disabled" style="width:120px"/>             -->
                <label class="text-super">RECIBO DE INGRESO</label>
                <!-- <input name="seriep" value="" id="seriep" title="Serie" type="text" class="ui-widget-content ui-corner-all text" style="width:40px;"  />-
                <input name="numerop" value="" id="numerop" title="N&uacute;mero" type="text" class="ui-widget-content ui-corner-all text" style="width:70px;"  /> -->
            </span> 
            <br/>
            <span>
                <label class="labels">Forma de pago: </label>
                <?php echo $formapago2; ?>
            </span>
            <span id="box-pay-tarjeta" style="display:none">
             <input type="text" name="nrotarjeta" id="nrotarjeta" value="" class="ui-widget-content ui-corner-all text" placeholder="N&deg; de Tarjeta" />
             <input type="text" name="nrovoucher" id="nrovoucher" value="" class="ui-widget-content ui-corner-all text" placeholder="N&deg; de Voucher" style="width:200px" />
            </span>
            <span id="box-pay-cheque" style="display:none">
                <input type="text" name="nrocheque" id="nrocheque" value="" class="ui-widget-content ui-corner-all text" placeholder="N&deg; de Cheque" />
                <input type="text" name="banco" id="banco" value="" class="ui-widget-content ui-corner-all text" placeholder="Banco del cheque" style="width:200px" />                                
                <input type="text" name="fechav" id="fechav" value="" class="ui-widget-content ui-corner-all text text-date"  placeholder="Fecha Vencimiento" />
            </span>
            <br/> 
                 <label class="labels">Monto: </label>
                 <input type="text" name="monto_efectivo" id="monto_efectivo" value="300.00"  class="ui-widget-content ui-corner-all text text-num" />
                 S/. <a href="#" style="color:green">Agregar</a>
          </fieldset>
           <div class="contain" style="">
            <table id="table-detalle-pagos" class="ui-widget ui-widget-content" border="0" >
                <thead>
                    <tr class="ui-widget-header">
                        <td width="100px" align="center">Forma de Pago</td>                             
                        <td >Descripcion</td>
                        <td width="100" align="center">Monto</td>
                        <td width="30px">&nbsp;</td>
                    </tr>
                </thead> 
                <tbody>
                </tbody>
            </table>  
          </div>
      </div>
      <div id="tabs-3">
        <p>Cronograma de pagos</p>        
      </div>      
    </div>
</form>
</div>