<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>

<div style="padding:10px 20px">
<form id="frm_cliente" >
        <input type="hidden" name="controller" value="Clientes" />
        <input type="hidden" name="action" value="save" />
                     
        <label for="idcliente" class="labels">Codigo:</label>
        <input type="text" id="idcliente" name="idcliente" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idcliente; ?>" readonly />
        
        <div id="tabs">
            <ul style="background:#DADADA !important; border:0 !important">
                <li><a href="#tabs-1">Datos Básicos</a></li>
                <li><a href="#tabs-2">Datos de Trabajo</a></li>
                <li><a href="#tabs-3">Referencias Personales</a></li>
                <!--<li><a href="#tabs-4">Descripcion del Producto</a></li>-->
            </ul>   
                <div id="tabs-1">
                    <label for="dni" class="labels">RUC / DNI:</label>
                    <input id="dni" name="dni" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->dni; ?>"  />
                    <br/>

                    <label for="nombres" class="labels">Nombres:</label>
                    <input id="nombres" name="nombres" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->nombres; ?>"  />

                    <label for="apepaterno" class="labels">Apellido Paterno:</label>
                    <input id="apepaterno" name="apepaterno" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->apepaterno; ?>"  />
                    <br/>

                    <label for="apematerno" class="labels">Apellido Materno:</label>
                    <input type="text" id="apematerno" maxlength="100" name="apematerno" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->apematerno; ?>" />

                    <label for="direccion" class="labels">Dirección:</label>
                    <input id="direccion" name="direccion" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                    <br/>    

                    <label for="Sector" class="labels">Sector:</label>
                    <input id="sector" name="sector" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->sector; ?>" />

                    <label for="ocupacion" class="labels">Ocupación:</label>         
                    <input id="ocupacion" name="ocupacion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->ocupacion; ?>" />
                    <br/>

                    <label for="telefono" class="labels">Telefono:</label>
                    <input type="text" id="telefono" name="telefono" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefono; ?>" />

                    <label for="fecha" class="labels">Fecha Nacim.:</label>
                    <input type="text" name="fechanac" id="fechanac" class="ui-widget-content ui-corner-all text" value="<?php if($obj->fechanac!=""){echo fdate($obj->fechanac,'ES');} else {echo date('d/m/Y');} ?>" style="width:70px; text-align:right" />
                    <br/>
                    
                    <label for="Departamento" class="labels">Departamento:</label>
                    <?php echo $Departamento; ?>

                    <label for="Provincia" class="labels">Provincia:</label>
                    <select id="idprovincia" name="idprovincia" class="ui-widget-content ui-corner-all">            
                    </select>
                    <br/>

                    <label for="distrito" class="labels">Distrito:</label>        
                    <select id="iddistrito" name="iddistrito" class="ui-widget-content ui-corner-all">            
                    </select>
                </div>
                <div id="tabs-2">
                    <label for="Profesion" class="labels">Profesión:</label>
                    <input id="profesion" name="profesion" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->profesion; ?>" />

                    <label for="antitrab" class="labels">Anterior trab. :</label>         
                    <input id="antitrab" name="antitrab" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->antitrab; ?>" />
                    <br/>

                    <label for="trabajo" class="labels">Trabajo:</label>         
                    <input id="trabajo" name="trabajo" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->trabajo; ?>" />

                    <label for="dirtrabajo" class="labels">Direc. trabajo:</label>
                    <input id="dirtrabajo" name="dirtrabajo" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->dirtrabajo; ?>" />
                    <br/>

                    <label for="cargo" class="labels">Cargo:</label>         
                    <input id="cargo" name="cargo" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->cargo; ?>" />

                    <label for="teltrab" class="labels">Telefono trab.:</label>         
                    <input id="teltrab" name="teltrab" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->teltrab; ?>" />
                    <br/>
                </div>
                <div id="tabs-3">
                    <label for="ingreso" class="labels">Ingreso:</label>         
                    <input id="ingreso" name="ingreso" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->ingreso; ?>" />

                    <label for="teltrab" class="labels">Tipo vivienda:</label>         
                    <?php echo $idtipovivienda; ?>
                    <br/>

                    <label for="rlegal" class="labels">Represent. legal:</label>         
                    <input id="rlegal" name="rlegal" onkeypress="return permite(event,'car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->rlegal; ?>" />

                    <label for="nropartida" class="labels">N° partida.:</label>         
                    <input id="nropartida" name="nropartida" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->nropartida; ?>" />
                    <br/>
                </div>
            
        </div>
        
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