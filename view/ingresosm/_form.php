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
        <br/>
        <label class="labels">Tipo Material: </label>
        <select class="ui-widget-content ui-corner-all text" name="tipo_producto" id="tipo_producto">
            <option value="1">MADERA</option>
            <option value="2">MELAMINA</option>
        </select>
    </fieldset>
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">  
        <legend>Madera</legend>      
        <div id="box-1">
            <label for="idmadera" class="labels">Tipo: </label>
            <?php echo $idmadera; ?>
            <label for="idtipomadera" class="labels" style="width:70px">Cantidad: </label>
            <input type="text" name="cantidad" id="cantidad" value="0.00" class="ui-widget-content ui-corner-all text" style="width:50px; text-align:center" /> Pies
            <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset" style="margin-left:20px"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
        </div>
    </fieldset>
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">  
        <legend>Melamina</legend>      
        <div id="box-1">
            <label for="idmadera" class="labels">Tipo: </label>
            <?php echo $idmadera; ?>
            <label for="idtipomadera" class="labels" style="width:70px">Cantidad: </label>
            <input type="text" name="cantidad" id="cantidad" value="0.00" class="ui-widget-content ui-corner-all text" style="width:50px; text-align:center" /> Pies
            <label for="idtipomadera" class="labels" style="width:70px">Precio: </label>
            <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset" style="margin-left:20px"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
        </div>
    </fieldset>
    <div id="div-detalle">
    <div>
        <table class=" ui-widget ui-widget-content" style="margin: 0 auto; width:100% " >
            <thead class="ui-widget ui-widget-content" >
                <tr class="ui-widget-header" style="height: 23px">            
                    <th >DESCRIPCION</th>            
                    <th width="80px">PRECIO S/.</th>            
                    <th width="80px">CANTIDAD</th>
                    <th width="80px">IMPORTE S/.</th>
                    <th width="20px">&nbsp;</th>
                 </tr>
                 </thead>  
                 <tbody>
                    <?php 
                        $c = 0;
                        $t = 0;
                        for($i=0;$i<$_SESSION['ventad']->item;$i++)
                        {   
                            if($_SESSION['ventad']->estado[$i])
                            {
                                $c +=1;
                                $t += $_SESSION['ventad']->precio[$i]*$_SESSION['ventad']->cantidad[$i];
                            ?>
                            <tr id="<?php echo $i; ?>">
                            
                            <td><?php echo $_SESSION['ventad']->itinerario[$i]; ?></td>                    
                            <td align="center" ><?php echo $_SESSION['ventad']->precio[$i]; ?></td>            
                            <td align="center" >
                                <?php echo number_format($_SESSION['ventad']->cantidad[$i],2); ?>
                            </td>
                            <td align="right" ><?php echo number_format($_SESSION['ventad']->precio[$i]*$_SESSION['ventad']->cantidad[$i],2); ?></td>                    
                            <td width="20px" align="center"><a class="quit box-boton boton-anular" title="Eliminar item <?php echo ($c); ?>" href="javascript:"></a></td>
                            </tr>
                            <?php
                            }
                        }                
                        for($i=0;$i<(2-$c);$i++)
                        {
                            ?>
                            <tr >
                                
                                <td>&nbsp;</td>
                                <td align="center" >&nbsp;</td>                                    
                                <td align="right" >&nbsp;</td>
                                <td align="right" >&nbsp;</td>                    
                                <td width="20px" align="center">&nbsp;</td>
                            </tr>
                            <?php
                        }
                    ?>
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