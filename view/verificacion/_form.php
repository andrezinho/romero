<?php  
include("../lib/helpers.php"); 
include("../view/header_form.php"); 
?>
<div style="padding:10px 20px; width:950px">
<form id="frm_verificacion" >
    <!-- <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
    <legend>Datos - <b><?php echo date('d/m/Y'); ?></b></legend>
        <input type="hidden" name="controller" value="Produccion" />
        <input type="hidden" name="action" value="save" />             
        <input type="hidden" id="idproduccion" name="idproduccion" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->idproduccion; ?>" readonly />                
        
        <label for="fecha" class="labels" style="width:120px;">Fecha de solicitud:</label>
        <input type="text" name="fecha" id="fecha" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fecha)?$obj->fecha:  date('d/m/Y')); ?>" style="width:70px; text-align:center" />        
        <br/> 
    </fieldset> -->    
    <fieldset id="box-melamina" class="ui-corner-all" style="padding: 2px 10px 7px;">  
        <!-- <legend>Produccion</legend> -->      
        <div id="box-1">
            <input type="hidden" name="controller" value="Produccion" />
            <input type="hidden" name="action" value="save" />             
            <input type="hidden" id="idproduccion" name="idproduccion" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->idproduccion; ?>" readonly />                
            
            <label for="fechas" class="labels" style="width:120px;">Fecha de solicitud:</label>
            <input type="text" name="fecha" id="fecha" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fecha)?$obj->fecha:  date('d/m/Y')); ?>" style="width:70px; text-align:center" />        
            <br/>

            <div class="ui-widget-content ui-corner-all" style="padding:10px">
                <h4 id="title-produccion" style="text-align:center">HOJA DE VERIFICACION</h4>
                <br/>
                <div id="tabs">
                    <ul style="background:#DADADA !important; border:0 !important">
                        <li><a href="#tabs-1">Datos del Cliente</a></li>
                        <li><a href="#tabs-2">Datos del Conyugue</a></li>
                        <li><a href="#tabs-3">Ingresos Familiares</a></li>
                        <li><a href="#tabs-4">Referencias Personales</a></li>
                        <li><a href="#tabs-5">Descripcion del Producto</a></li>
                    </ul>
                    <div id="tabs-1">
                        <p id="">Datos Generales del <b>Cliente :</b></p>
                        <br />
                        <label for="dni" class="labels">DNI:</label>
                        <input id="dni" name="dni" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->dni; ?>"  />
                        <input id="idcliente" name="idcliente" value="" type="hidden" />

                        <label for="cleinte" class="labels">Nombres y Ap:</label>                        
                        <input type="text" id="nomcliente" name="nomcliente" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="" />
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

                        <label for="fechanaci" class="labels">Fecha de Nac:</label>
                        <input type="text" name="fechanac" id="fechanac" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fechanac)?$obj->fechanac:  date('d/m/Y')); ?>" style="text-align:center" />
                        <br/>

                        <label for="estcivil" class="labels">Estado civil:</label>        
                        <select id="estcivil" name="estcivil" class="ui-widget-content ui-corner-all">
                            <?php $var="";
                                if($obj->estcivil=='Ninguno')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Ninguno">Ninguno</option>
                            
                            <?php $var="";
                                if($obj->estcivil=='Soltero')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Soltero">Soltero(a)</option>

                            <?php $var="";
                                if($obj->estcivil=='Conviviente')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Conviviente">Conviviente</option>

                            <?php $var="";
                                if($obj->estcivil=='Casado')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Casado">Casado(a)</option>

                            <?php $var="";
                                if($obj->estcivil=='Divorciado')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Divorciado">Divorciado(a)</option>

                            <?php $var="";
                                if($obj->estcivil=='Viudo')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Viudo">Viudo(a)</option>
                        </select>

                        <label for="cargafam" class="labels">Carga Familiar:</label>                        
                        <input type="text" id="cargafam" name="cargafam" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->cargafam; ?>" />
                        <br/>

                        <label for="estcivil" class="labels">Nivel de Educacion:</label>        
                        <select id="estcivil" name="estcivil" class="ui-widget-content ui-corner-all">
                            <?php $var="";
                                if($obj->estcivil=='Ninguno')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Ninguno">Ninguno</option>
                            
                            <?php $var="";
                                if($obj->estcivil=='Primaria Completa')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Primaria Completa">Primaria Completa</option>

                            <?php $var="";
                                if($obj->estcivil=='Primaria Incompleta')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Primaria Incompleta">Primaria Incompleta</option>

                            <?php $var="";
                                if($obj->estcivil=='Segundaria Completa')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Segundaria Completa">Segundaria Completa</option>

                            <?php $var="";
                                if($obj->estcivil=='Segundaria Incompleta')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Segundaria Incompleta">Segundaria Incompleta</option>
                            
                            <?php $var="";
                                if($obj->estcivil=='Seperior Universitario')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Seperior Universitario">Seperior Universitario</option>
                            
                            <?php $var="";
                                if($obj->estcivil=='Carrea Tecnica Completa')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Carrea Tecnica Completa">Carrea Tecnica Completa</option>
                            
                            <?php $var="";
                                if($obj->estcivil=='Carrea Tecnica Incompleta')
                                {$var="selected";}               
                            ?>
                            <option <?php echo $var; ?> value="Carrea Tecnica Incompleta">Carrea Tecnica Incompleta</option>

                        </select>

                        <label for="telefono" class="labels">Telefono:</label>                        
                        <input type="text" id="telefono" name="telefono" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefono; ?>" />
                        <br/>

                        <label for="tivovivienda" class="labels">Tipo Vivienda:</label>
                        <?php echo $tivovivienda; ?>

                        
                    </div>
                    <div id="tabs-2">
                        <p>Agregar la el tipo y la cantidad e Melamina a emplear para la produccion.</p>
                    </div>
                    <div id="tabs-3">
                        <p>Agregar la el tipo y la cantidad e Melamina a emplear para la produccion.</p>
                    </div>
                    <div id="tabs-4">
                        <p>Agregar la el tipo y la cantidad e Melamina a emplear para la produccion.</p>
                    </div>
                    <div id="tabs-5">
                        <p>Agregar la el tipo y la cantidad e Melamina a emplear para la produccion.</p>
                    </div>
                </div>
                
            </div>           
        </div>
    </fieldset>
    <!-- <div id="div-detalle">
    
    </div> -->
</form>
</div>

<div id="dialogConf">

</div>