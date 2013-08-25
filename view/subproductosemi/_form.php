<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>

<form id="frm_SubProductoSemi" >
    <input type="hidden" name="controller" value="SubProductoSemi" />

    <input type="hidden" name="action" value="save" />
    
        <label for="idsubproductos_semi" class="labels">Codigo:</label>
        <input id="idsubproductos_semi" name="idsubproductos_semi" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idsubproductos_semi; ?>" readonly />
                
        <label for="descripcion" class="labels">Descripcion:</label>
        <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
        <br>
        
        <label for="productos_semi" class="labels">Producto Semi</label>
        <?php echo $productos_semi; ?>

        <label for="precio" class="labels">Precio:</label>
        <input id="precio" maxlength="100" name="precio" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->precio; ?>" />
        <br>

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
