<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>
<div style="padding:10px 20px">
<form id="frm" >
    <input type="hidden" name="controller" value="Moneda" />
    <input type="hidden" name="action" value="save" />             
    <label for="descripcion" class="labels">Descripcion:</label>
    <input type="text" id="descripcion" maxlength="100" name="descripcion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
    <br/>
    
    <label for="simbolo" class="labels">Simbolo:</label>
    <input type="text" id="simbolo" maxlength="100" name="simbolo" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->simbolo; ?>" />
    <br/>

    <label for="estado" class="labels">Nacional:</label>
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