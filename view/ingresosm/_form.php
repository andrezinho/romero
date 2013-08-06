<?php  include("../lib/helpers.php"); include("../view/header_form.php"); ?>
<div style="padding:10px 20px">
<form id="frm-ingresom" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
    <legend>Datos</legend>
        <input type="hidden" name="controller" value="ingresom" />
        <input type="hidden" name="action" value="save" />             
        <label for="idmodulo" class="labels">Codigo:</label>
        <input type="text" id="idmodulo" name="idmodulo" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->idmodulo; ?>" readonly />                
        <label for="fecha" class="labels">Fecha:</label>
        <input type="text" name="fecha" id="fecha" class="ui-widget-content ui-corner-all text" value="<?php echo date('d/m/Y') ?>" style="width:70px; text-align:center" />
        <br/>
        <label for="referencia" class="labels">Referencia:</label>
        <input type="text" name="referencia" id="referencia" class="ui-widget-content ui-corner-all text" style="width:500px" />
    </fieldset>
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">  
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
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">  
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
                    <td><?php echo $linea." ".$idmelamina; ?></td>
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