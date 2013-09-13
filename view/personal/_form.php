<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>

<div style="padding:10px 20px">
<form id="frm" >
        <input type="hidden" name="controller" value="Personal" />
        <input type="hidden" name="action" value="save" />
        <input type="hidden" id="idpersonal" name="idpersonal" value="<?php echo $obj->idpersonal; ?>" />
        
        <label for="dni" class="labels">DNI:</label>
   		<input id="dni" name="dni" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->dni; ?>"  />
        
        <label for="ruc" class="labels">RUC:</label>
        <input id="ruc" name="ruc" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->ruc; ?>"  />
        <br/>

        <label for="nombres" class="labels">Nombres:</label>
        <input type="text" id="nombres" maxlength="100" name="nombres" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->nombres; ?>" />
        
        <label for="apellidos" class="labels">Apellidos:</label>
        <input type="text" id="apellidos" name="apellidos" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->apellidos; ?>" />
        <br/>    

        <label for="telefono" class="labels">Telefono:</label>
        <input type="text" id="telefono" name="telefono" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefono; ?>" />
        
        <label for="fechanaci" class="labels">Fecha Nac:</label>
        <input type="text" id="fechanaci" maxlength="10" name="fechanaci" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php if($obj->fechanaci=='') echo date('d/m/Y'); else echo fdate($obj->fechanaci,'ES'); ?>" />
        <br/>
        <label for="direccion" class="labels">Dirección:</label>
   		<input id="direccion" name="direccion" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
        
        <label for="estcivil" class="labels">Estado civil:</label>        
        <?php echo $EstadoCivil; ?>
        <br/>
        
        <label for="idarea" class="labels">Area:</label>
        <?php echo $idarea; ?>

        <label for="idcargo" class="labels">Cargo:</label>
        <?php echo $idcargo; ?>
        <br/>

        <label for="sexo" class="labels">Sexo:</label>        
        <select id="sexo" name="sexo" class="ui-widget-content ui-corner-all">
            <?php $var="";
                if($obj->sexo=='M')
                {$var="selected";}               
            ?>
            <option <?php echo $var; ?> value="M">Masculino</option>

            <?php $var="";
                if($obj->sexo=='F')
                {$var="selected";}               
            ?>
            <option <?php echo $var; ?> value="F">Femenino</option>
        </select>

        <label for="perfil" class="labels">Perfil:</label>
        <?php echo $Perfil; ?>        
        <br/>

        <label for="user" class="labels">Usuario:</label>
        <input id="usuario" name="usuario" value="<?php echo $obj->usuario; ?>" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;"  />
        
        <label for="clae" class="labels">Clave:</label>
        <input type="password" id="clave" name="clave" value="<?php echo $obj->clave; ?>" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;"  />
        
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