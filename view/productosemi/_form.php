<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>

   
<form id="frm-ProductoSemi" >
    <input type="hidden" name="controller" value="ProductoSemi" />

    <input type="hidden" name="action" value="save" />
    
        <label for="idproductos_semi" class="labels">Codigo:</label>
            <input id="idproductos_semi" name="idproductos_semi" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idproductos_semi; ?>" readonly />
        <br/>
        
        <label for="descripcion" class="labels">Descripcion:</label>
            <input id="descripcion" maxlength="100" name="descripcion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
            <br>
        
        <!-- <label for="estado" class="labels">Activo:</label>
                <?php                   
                    if($obj->estado==true || $obj->estado==false)
                            {
                             if($obj->estado==true){$rep=1;}
                                else {$rep=0;}
                            }
                     else {$rep = 1;}                    
                     activo('activo',$rep);
                ?>   -->   

</form>
