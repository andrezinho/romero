<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>
<div style="padding:10px 20px">
<form id="frm" >
        <input type="hidden" name="controller" value="Personal" />
        <input type="hidden" name="action" value="save" />
        <!--             
        <label for="idmodulo" class="labels">Codigo:</label>
        <input type="text" id="idmodulo" name="idmodulo" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idmodulo; ?>" readonly />
        <label for="idpadre" class="labels">Padre:</label>
        <?php echo $ModulosPadres; ?>
        <br/>
    -->
        
        <label for="dni" class="labels">DNI:</label>
   		<input id="dni" name="dni" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->dni; ?>"  />
        
        <label for="nombres" class="labels">Nombres:</label>
        <input type="text" id="nombres" maxlength="100" name="nombres" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->nombres; ?>" />
        <br/>
        <label for="apellidos" class="labels">Apellidos:</label>
   		<input type="text" id="apellidos" name="apellidos" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->apellidos; ?>" />
        
        <label for="telefono" class="labels">Telefono:</label>
   		<input type="text" id="telefono" name="telefono" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefono; ?>" />
        <br/>
        <label for="direccion" class="labels">Dirección:</label>
   		<input id="direccion" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
        
        <label for="estcivil" class="labels">Estado civil:</label> 
        <input id="estcivil" name="estcivil" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->estcivil; ?>" />
        <br/>
        
        <label for="sexo" class="labels">Sexo:</label> 
        <input id="sexo" name="sexo" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->sexo; ?>" />
        
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