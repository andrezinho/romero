<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>
<div style="padding:10px 20px">
<form id="frm" >
    <input type="hidden" name="controller" value="Almacen" />
    <input type="hidden" name="action" value="save" /> 

    <label for="idalmacen" class="labels">Codigo:</label>
    <input id="idalmacen" name="idalmacen" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idalmacen; ?>" readonly />
    <br/>    

    <label for="descripcion" class="labels">Descripcion:</label>
    <input type="text" id="descripcion" maxlength="100" name="descripcion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
    <br/>
    
    <label for="direccion" class="labels">direccion:</label>
    <input type="text" id="direccion" maxlength="100" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
    <br/>

    <label for="telefono" class="labels">telefono:</label>
    <input type="text" id="telefono" maxlength="100" name="telefono" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefono; ?>" />
    <br/>

    <label for="estado" class="labels">Estado:</label>
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