<?php include("../lib/helpers.php"); ?>
<div style="padding:10px 20px; width:900px">
<form id="frm_ventas" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
      <legend>Ventas </legend>
        <input type="hidden" name="controller" id="controller" value="ventas" />
        <input type="hidden" name="action" id="action" value="save" />       
        <label class="labels" for="idalamacen">Almacen: </label>      
        <?php echo $Almacen; ?>   
        <!-- <label class="labels" for="fecha">Fecha: </label>      
        <input type="text" name="Fecha" id="Fecha" value="<?php echo date('d/m/Y') ?>" class="ui-widget-content ui-corner-all text text-date"  disabled="" />  -->        
        <label class="labels" for="idtipopago">Tipo de Venta: </label>      
        <?php echo $tipopago; ?>        
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
        <input type="text" id="cliente" name="cliente" class="ui-widget-content ui-corner-all text" title="Razon Social" style="width:300px;" placeholder="Nombre / Razon social" />        
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
        <label for="igv" class="labels" style="width:80px;">Afecto IGV:</label>
        <?php $ck = ""; if($obj->afecto==1) $ck = "checked"; ?>
        <input type="checkbox" name="aigv" id="aigv" value="1" <?php echo $ck; ?> />
        <input type="hidden" name="igv_val" id="igv_val" value="<?php if($obj->igv!="") echo $obj->igv; else echo "18"; ?>" />
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
        <label class="labels" for="stock" style="width:50px">Stock: </label>                    
        <input type="text" name="stock" id="stock" value="0.00" class="ui-widget-content ui-corner-all text text-num" />
        <label class="labels" for="precio" style="width:50px">Precio: </label>                    
        <input type="text" name="precio" id="precio" value="0.00" class="ui-widget-content ui-corner-all text text-num" />
        <label class="labels" for="cantidad" style="width:70px">Cantidad: </label>                    
        <input type="text" name="cantidad" id="cantidad" value="0.00" class="ui-widget-content ui-corner-all text text-num" />
        </div>
    </fieldset>
    <div id="div-detalle">
        <div>
            <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:100%" border="0" >
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
                                }
                                else
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
</div>