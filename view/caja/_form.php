<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>

   
<form id="frm_maderba" >
    <input type="hidden" name="controller" value="Caja" />

    <input type="hidden" name="action" value="save" />
    
        <label for="idcaja" class="labels">Codigo:</label>
        <input id="idcaja" name="idcaja" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idcaja; ?>" readonly />
                
        <label for="nombre" class="labels">Nombre:</label>
        <input id="nombre" maxlength="100" name="nombre" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->nombre; ?>" />
        <br>
        
        <label for="descripcion" class="labels">Descripcion:</label>
        <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
        
        <label for="area" class="labels">Area:</label>
        <?php echo $Area; ?>
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
