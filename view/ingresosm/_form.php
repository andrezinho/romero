<?php  include("../lib/helpers.php"); include("../view/header_form.php"); ?>
<div style="padding:10px 20px">
<form id="frm-ingresom" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
    <legend>Datos Compra - <b><?php echo date('d/m/Y'); ?></b></legend>
        <input type="hidden" name="controller" value="ingresom" />
        <input type="hidden" name="action" value="save" />             
        <input type="hidden" id="idmodulo" name="idmodulo" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->idmodulo; ?>" readonly />                
        <input type="hidden" name="igv_val" id="igv_val" value="18" />
        <label for="idtipodocumento" class="labels">Documento:</label>
        <?php echo $tipodocumento; ?>        
        <label for="" class="labels" style="width:50px;">Nro:</label>
        <input type="text" id="serie" name="serie" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->serie; ?>" />                
        <input type="text" id="numero" name="numero" class="text ui-widget-content ui-corner-all" style=" width: 80px; text-align: left;" value="<?php echo $obj->numero; ?>" />                
        <label for="fecha" class="labels">Fecha Emision:</label>
        <input type="text" name="fechae" id="fechae" class="ui-widget-content ui-corner-all text" value="<?php echo date('d/m/Y') ?>" style="width:70px; text-align:center" />
        <br/>
        <label for="idproveedor" class="labels">Proveedor:</label>
        <input type="hidden" name="idproveedor" id="idproveedor" value="1" />
        <input type="text" name="ruc" id="ruc" class="ui-widget-content ui-corner-all text" style="width:80px" value="" maxlength="11" onkeypress="return permite(event,'num')" />
        <input type="text" name="proveedor" id="proveedor" class="ui-widget-content ui-corner-all text" style="width:300px" value="" />
        <label for="idformapago" class="labels">Forma Pago:</label>
        <?php echo $formapago; ?>
        <br/>
        <label for="guiaserie" class="labels">Guia Nro:</label>
        <input type="text" id="guiaserie" name="guiaserie" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->guiaserie; ?>" />                
        <input type="text" id="guianumero" name="guianumero" class="text ui-widget-content ui-corner-all" style=" width: 80px; text-align: left;" value="<?php echo $obj->guianumero; ?>" />                
        <label for="fechaguia" class="labels" style="width:80px">Fecha Guia:</label>
        <input type="text" name="fechaguia" id="fechaguia" class="ui-widget-content ui-corner-all text" value="<?php echo date('d/m/Y') ?>" style="width:70px; text-align:center" />
        <label for="igv" class="labels" style="width:80px;">Afecto IGV:</label>
        <input type="checkbox" name="aigv" id="aigv" value="1" />
        <label for="idalmacen" class="labels" style="width:80px">Almacen:</label>
        <?php echo $almacen; ?>
        <br/>
        <label for="referencia" class="labels">Referencia:</label>
        <input type="text" name="referencia" id="referencia" class="ui-widget-content ui-corner-all text" style="width:500px" />        
    </fieldset>
    <div id="box-tipo-ma" class="ui-widget-header ui-state-hover" style="text-align:center">
        <label class="labels" for="tipo1" style="width:50px">Madera</label>
        <input class="tipo_material" type="radio" name="tipo" id="tipo1" value="1" checked="" />
        <label style="margin-left:20px;" for="tipo2">Melamina</label>
        <input class="tipo_material" type="radio" name="tipo" id="tipo2" value="2" />
    </div>
    <fieldset id="box-madera" class="ui-corner-all" style="padding: 2px 10px 7px">  
        <legend>Madera</legend>      
        <div id="box-1">
            <table id="table-ma" class="table-form" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><label for="idmadera" class="labels" style="width:auto">Tipo de Madera</label></td>
                    <td><label for="cantidad_ma" class="labels" style="width:auto">Cant. <label class="text-backinfo">Pies</label></label></td>                    
                    <td><label for="precio_ma" class="labels" style="width:auto">Precio <label class="text-backinfo">(S/.)</label></label></td>
                    <td><label for="total_ma" class="labels" style="width:auto">Total <label class="text-backinfo">(S/.)</label></label></td>
                    <td style="width:84px">&nbsp;</td>
                    <td style="width:70px">&nbsp;</td>
                    <td rowspan="2"><a href="javascript:" id="addDetail_ma" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> </td>                    
                </tr>
                <tr>
                    <td><?php echo $idmadera; ?></td>
                    <td><input type="text" name="cantidad_ma" id="cantidad_ma" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" /> </td>                    
                    <td><input type="text" name="precio_ma" id="precio_ma" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" /> </td>                    
                    <td><input type="text" name="total_ma" id="total_ma" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" readonly=""/> </td>                    
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>                        
        </div>
    </fieldset>
    <fieldset id="box-melamina" class="ui-corner-all" style="padding: 2px 10px 7px; display:none">  
        <legend>Melamina</legend>      
        <div id="box-1">
            <table id="table-me" class="table-form" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><label for="idmelamina" class="labels" style="width:auto">Tipo de Melamina</label></td>
                    <td><label for="cantidad_me" class="labels" style="width:auto">Cant. <label class="text-backinfo">Pies</label></label></td>                    
                    <td><label for="precio_me" class="labels" style="width:auto">Precio <label class="text-backinfo">(S/.)</label></label></td>
                    <td><label for="peso_me" class="labels" style="width:auto">Peso <label class="text-backinfo">(Unit)</label></label></td>
                    <td><label for="peso_t_me" class="labels" style="width:auto">Peso <label class="text-backinfo">(Total)</label></label></td>
                    <td><label for="total_me" class="labels" style="width:auto">Total <label class="text-backinfo">(S/.)</label></label></td>
                    <td rowspan="2"><a href="javascript:" id="addDetail_me" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> </td>                    
                </tr>
                <tr>
                    <td><?php echo $linea; ?>
                    <select name="idmelamina" id="idmelamina" class="ui-widget-content ui-corner-all text" style="width:150px">
                        <option value="">Seleccione....</option>
                    </select>
                    </td>
                    <td><input type="text" name="cantidad_me" id="cantidad_me" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" /> </td>                    
                    <td><input type="text" name="precio_me" id="precio_me" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" /> </td>                                        
                    <td><input type="text" name="peso_me" id="peso_me" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" /> </td>
                    <td><input type="text" name="peso_t_me" id="peso_t_me" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" readonly="" /></td>
                    <td><input type="text" name="total_me" id="total_me" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" readonly=""/> </td>                    
                </tr>
            </table>                        
        </div>
    </fieldset>
    <div id="div-detalle">
    <div>
        <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:100% " >
                <thead class="ui-widget ui-widget-content" >
                <tr class="ui-widget-header" style="height: 23px">            
                    <th width="80px">PRODUCTO</th>            
                    <th>DESCRIPCION</th>                             
                    <th width="80px">CANTIDAD</th>
                    <th width="80px">PREC<label class="text-backinfo">(Unit S/.)</label></th>            
                    <th width="80px">PESO<label class="text-backinfo">(Unit)</label></th>            
                    <th width="80px">PESO<label class="text-backinfo">(Total)</label></th>            
                    <th width="80px">IMPORTE S/.</th>
                    <th width="20px">&nbsp;</th>
                 </tr>
                 </thead>  
                 <tbody>
                                  
                 </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6" align="right"><b>SUB TOTAL S/.</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6" align="right"><b>IGV S/.</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="6" align="right"><b>TOTAL S/.</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>
                    </tr>

                </tfoot>
        </table>
        </div>
        </div>
</form>
</div>