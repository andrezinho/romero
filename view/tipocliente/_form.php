<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>
 
<form id="frm_tipocliente" >
    <input type="hidden" name="controller" value="TipoCliente" />

    <input type="hidden" name="action" value="save" />
    
        <label for="idtipos_clientes" class="labels">Codigo:</label>
        <input id="idtipos_clientes" name="idtipos_clientes" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idtipos_clientes; ?>" readonly />
        <br/>
        
        <label for="descripcion" class="labels">Descripcion:</label>
        <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
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
