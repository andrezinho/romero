<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>

<form id="frm" >
    <input type="hidden" name="controller" value="UnidadMedida" />
    <input type="hidden" name="action" value="save" /> 

    <label for="idunidad_medida" class="labels">Codigo:</label>
        <input id="idunidad_medida" name="idunidad_medida" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idunidad_medida; ?>" readonly />
        <br/>

    <label for="descripcion" class="labels">Descripcion:</label>
    <input type="text" id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
    <br/>
    
    <label for="simbolo" class="labels">Simbolo:</label>
    <input type="text" id="simbolo" maxlength="100" name="simbolo" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->simbolo; ?>" />
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
