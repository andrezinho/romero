<fieldset>
    <legend>Datos de Pago</legend>            
    <label class="labels" id="text_totale_venta">Total Venta: </label>
    <label class="text-super" id="total_pago">S/. 0.00</label>
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
         <input type="text" name="monto_efectivo" id="monto_efectivo" value="0.00"  class="ui-widget-content ui-corner-all text text-num" />
         S/. <a href="javascript:" id="add-fp" style="color:green">Agregar</a>
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
                <tfoot>
                    <tr>
                        <td align="right" colspan="2"><b>Total de Pago:</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>                        
                    </tr>
                    <tr>
                        <td align="right" colspan="2">Monto Faltante:</td>
                        <td align="right">0.00</td>
                        <td>&nbsp;</td>
                    </tr>
                </tfoot>
            </table>  
          </div> 