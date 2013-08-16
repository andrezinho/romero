<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>
<div style="padding:10px 20px">
<form id="frm_melamina" >
        <input type="hidden" name="controller" value="Melamina" />
        <input type="hidden" name="action" value="save" />

        <label for="idmelamina" class="labels">Codigo:</label>
        <input type="text" id="idmelamina" name="idmelamina" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idmelamina; ?>" readonly />
                
        <label for="idmelamina" class="labels">Linea:</label>
        <?php echo $idlinea; ?>
        <a id="newLine" href="javascript:"><span class="box-boton">&nbsp;</span></a>
        <br/>

        <label for="idmaderba" class="labels">Maderba:</label>
        <select id="idmaderba" name="idmaderba">            
        </select>        
        <a id="newMaderba" href="javascript:"><span class="box-boton">&nbsp;</span></a>

        <label for="idunidad_medida" class="labels">Unidad Medida:</label>
        <?php echo $idunidad_medida; ?>
        <br/>
        
        <label for="precio_u" class="labels">Precio Uunitario:</label>
   		<input type="text" id="precio_u" name="precio_u" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->precio_u; ?>" />
        
        <label for="stock" class="labels">Stock:</label>
   		<input type="text" id="stock" name="stock" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->stock; ?>" />
        <br/>

        <label for="medidas" class="labels">Medidas:</label>
        <input type="text" id="medidas" name="medidas" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->medidas; ?>" />
        
        <label for="estado" class="labels">Activo:</label>
            <div id="estados" style="display:inline">
            <?php                   
                if($obj->estado==1 || $obj->estado==0)
                {
                    if($obj->estado==1){$rep=1;}
                    else {$rep=0;}
                }
                else {$rep = 1;}                    
                    activo('activo',$rep);
            ?>
    </div>
</form>
</div>

<div id="box-frm-linea">
</div>

<div id="box-frm-maderba">
</div>