<?php  include("../lib/helpers.php"); include("../view/header_form.php"); ?>
<div style="padding:10px 20px">
<form id="frm" >
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
        <!-- 
        <br/>
        <label class="labels">Tipo Material: </label>        
        <select class="ui-widget-content ui-corner-all text" name="tipo_producto" id="tipo_producto">
            <option value="1">MADERA</option>
            <option value="2">MELAMINA</option>
        </select> 
        -->
    </fieldset>
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">  
        <legend>Madera</legend>      
        <div id="box-1">
            <label for="idmadera" class="labels" style="width:80px">Tipo: </label>
            <?php echo $idmadera; ?>
            <label for="idtipomadera" class="labels" style="width:70px">Cantidad: </label>
            <input type="text" name="cantidad" id="cantidad" value="0.00" class="ui-widget-content ui-corner-all text" style="width:50px; text-align:center" /> Pies
            <label for="idtipomadera" class="labels" style="width:70px">Precio: </label>
            <input type="text" name="precio" id="precio" value="0.00" class="ui-widget-content ui-corner-all text" style="width:50px; text-align:center" />
            <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset" style="margin-left:20px"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
        </div>
    </fieldset>
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">  
        <legend>Melamina</legend>      
        <div id="box-1">
            <label for="idmadera" class="labels" style="width:80px">Tipo: </label>
            <?php echo $idmelamina; ?>
            <label for="idtipomadera" class="labels" style="width:90px">Cant (Piezas): </label>
            <input type="text" name="cantidad" id="cantidad" value="0.00" class="ui-widget-content ui-corner-all text" style="width:50px; text-align:center" /> <label class="text-backinfo">PIES</label>
            <label for="peso" class="labels" style="width:90px">Peso (Unit): </label>
            <input type="text" name="peso" id="peso" value="0.00" class="ui-widget-content ui-corner-all text" style="width:50px; text-align:center" /> 
            <label for="idtipomadera" class="labels" style="width:70px">Precio: </label>
            <input type="text" name="precio" id="precio" value="0.00" class="ui-widget-content ui-corner-all text" style="width:50px; text-align:center" /> 
            <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset" style="margin-left:20px"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
        </div>
    </fieldset>
    <div id="div-detalle">
    <div>
        <table class=" ui-widget ui-widget-content" style="margin: 0 auto; width:100% " >
            <thead class="ui-widget ui-widget-content" >
                <tr class="ui-widget-header" style="height: 23px">            
                    <th width="80px">PRODUCTO</th>            
                    <th >DESCRIPCION</th>         
                    <th width="50px">UNIDAD</th>
                    <th width="80px">CANTIDAD</th>
                    <th width="80px">PREC.UNIT S/.</th>            
                    <th width="80px">IMPORTE S/.</th>
                    <th width="20px">&nbsp;</th>
                 </tr>
                 </thead>  
                 <tbody>
                   <tr>
                        <td align="center">MADERA</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="center">PIES</td>
                        <td></td>
                        <td></td>
                   </tr>
                 </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" align="right"><b>TOTAL S/.</b></td>
                        <td align="right"><b><?php echo number_format($t, 2); ?></b></td>
                        <td>&nbsp;</td>
                    </tr>
                </tfoot>
        </table>
        </div>
        </div>
</form>
</div>