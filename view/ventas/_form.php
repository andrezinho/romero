<?php
include("../lib/helpers.php"); 
include("../view/header_form.php");
?>

<form id="frm_ventas">
    <table width="730px" border="0" cellspacing="0" cellpadding="0">  
      <tr>
          <td width="105px">
            <label for="idalmacen" class="labels">Almacen:</label>
          </td>
          <td>
            <?php echo $Almacen; ?>
            
            <label class="labels">Fecha:</label>
            <input type="text" class="ui-widget-content ui-corner-all text" name="Fecha" id="Fecha" value="<?php echo date('d/m/Y') ?>" />
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
          <input type="text" class="ui-widget-content ui-corner-all text" title="Razon Social" id="Clientes" style="width:150px;" />
        
          <label for="idalmacen" class="labels">Forma de Pago :&nbsp;&nbsp;</label>          
          <?php echo $formapago; ?>    
              
      </td>
      </tr>
      <tr>
        <td ><label class="labels">Moneda:</label></td>
        <td>
          <?php echo $moneda; ?>
          
          <label class="labels">Tipo de Cambio:</label>
          <input name="0form1_tipocambio" value="" id="TipoCambio" title="Tipo de Cambio" type="text" class="ui-widget-content ui-corner-all text" style="width:40px;"  />

          <label class="labels">Descuento:</label>
          <input name="porcentajedescuento" value="" id="Dscto" onkeypress="ValidarDscto(this,event)" title="Porcentaje de Descuento" type="text" class="ui-widget-content ui-corner-all text" style="width:40px;" />%
        </td>
      </tr>
     <tr>
        <td ><label class="labels">Observaciones:</label></td>
        <td >
          <textarea name="0form1_obs" class="ui-widget-content ui-corner-all text" id="Obs" title="Observaciones" ></textarea>
        </td>
      </tr>
      <tr id="TrMotivoAnulacion" style="display:none">
        <td >Motivo Anulaci&oacute;n : </td>
        <td ><textarea style="width:400px" name="0form1_motivoanulacion" cols="60" class="ui-widget-content ui-corner-all text" id="MotivoAnulacion"  placeholder="Digite el Motivo de la Anulación">ssss</textarea></td>
      </tr>
      <tr>
        <td colspan="2">      
        </td>
      </tr> 
</table>

<fieldset id="box-melamina" class="ui-corner-all" style="padding: 2px 10px 7px;">  
        <legend>Detalle de la venta</legend>
        <div id="box-1">
            <table id="table-per" class="table-form" border="0" cellpadding="0" cellspacing="0" width="600px" >
                <tr>
                    <td width="100px"><label for="tipopago" class="labels">Tipo pago:</label></td>
                    <td><?php echo $tipopago; ?></td>
                    <td>
                        <div id="TbF" style="display: none;">
                            <label for="financiamiento" class="labels">Financiamiento:</label>
                            <?php echo $Financiamiento; ?>
                            <input type="checkbox" title="Considerar Adicional" checked="checked" id="ChkAdicional">   
                        </div>
                        
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><label for="productos" class="labels">Buscar Producto:</label></td>
                    <td colspan="2">
                        <input type="text" name="producto" id="producto" value="" class="ui-widget-content ui-corner-all text" style="width:240px;" />
                        <input type="hidden" name="idsubproductos_semi" id="idsubproductos_semi" value="" />
                        <label for="igv" class="labels" style="width:80px;">Afecto IGV:</label>
                        <?php $ck = ""; if($obj->afecto==1) $ck = "checked"; ?>
                        <input type="checkbox" name="aigv" id="aigv" value="1" <?php echo $ck; ?> />
                        <input type="hidden" name="igv_val" id="igv_val" value="<?php if($obj->igv!="") echo $obj->igv; else echo "18"; ?>" />
                    </td>
                    <td rowspan="2" align="center">
                        <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
                    </td>                    
                </tr>
                <tr>
                    <td><label for="idcliente" class="labels">Precio Cash:</label></td>
                    <td>
                        <input type="text" name="precio" id="precio" value="" class="ui-widget-content ui-corner-all text" style="width:80px;" />
                    </td>                    
                    <td>
                        <label for="Cantidad" class="labels">Cantidad:</label> 
                        <input type="text" name="cantidad" id="cantidad" onkeypress="return permite(event,'num')" value="" class="ui-widget-content ui-corner-all text" style="width:80px;" /> 
                    </td>
                </tr>
                <tr id="TrCredito" style="display: none;">
                    <td><label for="Iniciales" class="labels">Inicial:</label></td>
                    <td><input type="text" name="inicial" id="inicial" value="" class="ui-widget-content ui-corner-all text" style="width:80px;" /></td>                    
                    <td>
                        <label for="nromes" class="labels">N° Meses:</label>
                        <input id="NroMeses" class="ui-widget-content ui-corner-all text" type="text" style="width:40px;text-align:right" size="2" onkeypress="Calcular3(event)">
                        <img id="calcularfi" src="../web/images/calculadora.png" width="18" height="18" />
                        Mensual:
                        <input id="Mensual" class="ui-widget-content ui-corner-all text" type="text" style="width:60px;text-align:right" size="8" onkeypress="">
                    </td>
                    <td>&nbsp;</td> 
                </tr>
            </table>                     
        </div>
    </fieldset>
    <div id="div-detalle">
        <div>
            <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:840px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">          
                        <th align="center" width="120">Tipo Pago</th>
                        <th>Producto</th>
                        <th align="center" width="80">Precio</th>
                        <th align="center" width="80">Cantidad</th>
                        <th align="center" width="80">Inicial</th>
                        <th align="center" width="80">Mensual</th>
                        <th align="center" width="90">N° Meses</th>
                        <th align="center" width="80px">IMPORTE S/.</th>
                        <th width="20px">&nbsp;</th>
                    </tr>
                </thead>  
                <tbody>
                    <?php 
                        if(count($rowsd)>0)
                        {    
                            foreach ($rowsd as $i => $r) 
                            {
                                $tipop=$r['tipo'];
                                if($tipop==1)
                                {                                    
                                    $pre= $r['preciocash'];
                                    $cant= $r['cantidad'];
                                    $subt= floatval($pre) * floatval($cant);
                                }else
                                    {
                                        $nro= $r['nromeses'];
                                        $men= $r['cuota'];                                        
                                        $ini= $r['inicial'];
                                        $subt= (floatval($nro) * floatval($men))+ $ini;
                                    }
                                ?>
                                <tr class="tr-detalle">
                                    <td align="left"><?php echo $r['descripcion']; ?><input type="hidden" name="idtipopago[]" value="<?php echo $r['tipo']; ?>" /></td>
                                    <td><?php echo $r['producto']; ?>
                                        <input type="hidden" name="idproducto[]" value="<?php echo $r['idproducto']; ?>" />
                                        <input type="hidden" name="producto[]" value="<?php echo $r['producto']; ?>" />
                                        <input type="hidden" name="idfinanciamiento[]" value="<?php echo $r['idfinanciamiento']; ?>" />
                                    </td>
                                    <td align="rigth">
                                        <?php echo $r['preciocash']; ?><input type="hidden" name="precio[]" value="<?php echo $r['preciocash']; ?>" />
                                    </td>
                                    <td align="rigth">
                                        <?php echo $r['cantidad']; ?><input type="hidden" name="cantidad[]" value="<?php echo $r['cantidad']; ?>" />
                                    </td>
                                    <td>
                                        <?php echo $r['inicial']; ?><input type="hidden" name="inicial[]" value="<?php echo $r['inicial']; ?>" />
                                    </td>
                                    <td>
                                        <?php echo $r['cuota']; ?><input type="hidden" name="mensual[]" value="<?php echo $r['cuota']; ?>" />
                                    </td>
                                    <td>
                                        <?php echo $r['nromeses']; ?><input type="hidden" name="nromeses[]" value="<?php echo $r['nromeses']; ?>" />
                                    </td>
                                    <td><?php echo $subt; ?></td>
                                    <td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>
                                </tr>
                                <?php    
                                } 
                        }
                     ?>                      
                </tbody>
                 <tfoot>
                    <tr>
                        <td colspan="7" align="right"><b>SUB TOTAL S/.</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="7" align="right"><b>IGV S/.</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="7" align="right"><b>TOTAL S/.</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div> 

</form>
