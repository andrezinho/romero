<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>
<div style="padding:10px 20px">
<form id="frm" >
        <input type="hidden" name="controller" value="Madera" />
        <input type="hidden" name="action" value="save" />

        <label for="idmadera" class="labels">Codigo:</label>
        <input type="text" id="idmadera" name="idmadera" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idmadera; ?>" readonly />
        
        <label for="descripcion" class="labels">Descripcion:</label>
        <input type="text" id="descripcion" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
        <br/>

        <label for="idunidad_medida" class="labels">Unidad Medida:</label>
        <?php echo $idunidad_medida; ?>
        
        <label for="tipoproducto" class="labels">Tipo Producto:</label>
   		<input id="tipoproducto" name="tipoproducto" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->tipoproducto; ?>"  />
        <br/>

        <label for="precio_unitario" class="labels">Precio Uunitario:</label>
   		<input type="text" id="precio_unitario" name="precio_unitario" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->precio_unitario; ?>" />
        
        <label for="stock" class="labels">Stock:</label>
   		<input type="text" id="stock" name="stock" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->stock; ?>" />
        <br/>
        
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