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
        
        <label for="fecha" class="labeles" style="width:120px;">Fecha de solicitud:</label>
        <input type="text" name="fecha" id="fecha" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fecha)?$obj->fecha:  date('d/m/Y')); ?>" style="width:70px; text-align:center" />        
        <br/> 
    </fieldset> -->    
    <fieldset id="box-melamina" class="ui-corner-all" style="padding: 2px 10px 7px;">  
        <!-- <legend>Produccion</legend> -->      
        <div id="box-1">
            <input type="hidden" name="controller" value="Produccion" />
            <input type="hidden" name="action" value="save" />             
            <input type="hidden" id="idproduccion" name="idproduccion" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->idproduccion; ?>" readonly />                
            
            <label for="fechas" class="labeles" style="width:120px;">Fecha de solicitud:</label>
            <input type="text" name="fecha" id="fecha" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fecha)?$obj->fecha:  date('d/m/Y')); ?>" style="width:70px; text-align:center" />        
            
            <label for="fechas" class="labeles" style="width:120px;">Buscar proforma:</label>
            <input type="text" name="dni" id="dnicliprof" value="" class="ui-widget-content ui-corner-all text" style="width:80px;" />
            <input type="text" name="personal" id="clienteprof" value="" class="ui-widget-content ui-corner-all text" style="width:250px;" />
            <input type="hidden" name="idpersonal" id="idclienteprof" value="" />
            <input type="hidden" name="idproforma" id="idproforma" value="" />
            <br/>
            
            <div class="ui-widget-content ui-corner-all" style="padding:10px">
                <h4 id="title-produccion" style="text-align:center">HOJA DE SOLICITUD</h4>
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
                        <label for="dni" class="labeles">DNI:</label>
                        <input type="text" name="dni" id="dni" value="" class="ui-widget-content ui-corner-all text" style="width:200px;" />
                        <input id="idcliente" name="idcliente" value="" type="hidden" />

                        <label for="cleinte" class="labeles">Nombres y Ap:</label>                        
                        <input id="nomcliente" name="nomcliente" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->dni; ?>"  />
                        
                        <br/>

                        <label for="sexo" class="labeles">Sexo:</label>        
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

                        <label for="fechanaci" class="labeles">Fecha de Nac:</label>
                        <input type="text" name="fechanac" id="fechanac" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fechanac)?$obj->fechanac:  date('d/m/Y')); ?>" style="text-align:center" />
                        <br/>

                        <label for="estcivil" class="labeles">Estado civil:</label>        
                        <?php echo $EstadoCivil; ?>

                        <label for="cargafam" class="labeles">Carga Familiar:</label>                        
                        <input type="text" id="cargafam" name="cargafam" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->cargafam; ?>" />
                        <br/>

                        <label for="nivel" class="labeles">Nivel Educacion:</label>        
                        <?php echo $NivelEducacion; ?>

                        <label for="telefono" class="labeles">Telefono:</label>                        
                        <input type="text" id="telefono" name="telefono" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefono; ?>" />
                        <br/>

                        <label for="tivovivienda" class="labeles">Tipo Vivienda:</label>
                        <?php echo $tivovivienda; ?>
                        
                        <label for="direccion" class="labeles">Dirección:</label>                        
                        <input type="text" id="direccion" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                        <br/>
                        
                        <label for="direccion" class="labeles">Ref. Ubicación:</label>                        
                        <input type="text" id="referencia_ubic" name="referencia_ubic" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->referencia_ubic; ?>" />
                        
                        <label for="direccion" class="labeles">Actividad Econ.:</label>                        
                        <input type="text" id="direccion" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                        <br/>
                        
                        <label for="direccion" class="labeles">Empresa que trabaja:</label>                        
                        <input type="text" id="referencia_ubic" name="referencia_ubic" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->referencia_ubic; ?>" />
                        
                        <label for="direccion" class="labeles">Cargo Actual:</label>                        
                        <input type="text" id="direccion" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                        <br/>
                        
                        <label for="direccion" class="labeles">Telefono del trabaja:</label>                        
                        <input type="text" id="referencia_ubic" name="referencia_ubic" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->referencia_ubic; ?>" />
                        
                        <label for="direccion" class="labeles">Direccion del trabajo:</label>                        
                        <input type="text" id="direccion" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                        <br/>
                    </div>
                    <div id="tabs-2">
                        <p>Datos Generales del <b>Cliente :</b></p>
                        <br />
                        <label for="dni" class="labeles">DNI:</label>
                        <input type="text" name="dni" id="dni" value="" class="ui-widget-content ui-corner-all text" style="width:200px;" />
                        <input id="idcliente" name="idcliente" value="" type="hidden" />

                        <label for="cleinte" class="labeles">Nombres y Apellidos:</label>                        
                        <input id="nomcliente" name="nomcliente" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->dni; ?>"  />
                        <br/>
                        
                        <label for="direccion" class="labeles">Empresa que trabaja:</label>                        
                        <input type="text" id="referencia_ubic" name="referencia_ubic" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->referencia_ubic; ?>" />
                        
                        <label for="direccion" class="labeles">Cargo Actual:</label>                        
                        <input type="text" id="direccion" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                        <br/>
                        
                        <label for="direccion" class="labeles">Telefono del trabaja:</label>                        
                        <input type="text" id="referencia_ubic" name="referencia_ubic" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->referencia_ubic; ?>" />
                        
                        <label for="direccion" class="labeles">Direccion del trabajo:</label>                        
                        <input type="text" id="direccion" name="direccion" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->direccion; ?>" />
                        <br/>
                    </div>
                    <div id="tabs-3">
                        <p>Registre los ingresos de la pareja:</p>
                        <br/>
                        <label for="dni" class="labeless">Ingreso del cliente:</label>
                        <input type="text" name="ingresocli" id="ingresocli" value="" class="ui-widget-content ui-corner-all text" value="<?php echo $obj->ingresocli; ?>" style="width:80px;" />
                        &nbsp;&nbsp;&nbsp;
                        <label for="dni" class="labeless">Ingreso del conyugue:</label>
                        <input type="text" name="ingresocon" id="ingresocon" value="" class="ui-widget-content ui-corner-all text" value="<?php echo $obj->ingresocon; ?>" style="width:80px;" />
                        &nbsp;&nbsp;&nbsp;
                        <label for="dni" class="labeless">Total de ingresos:</label>
                        <input type="text" name="totaling" id="totaling" value="" class="ui-widget-content ui-corner-all text" value="<?php echo $obj->totaling; ?>" style="width:80px;" />

                    </div>
                    <div id="tabs-4">
                        <p>Ingrese alguna referencia:</p>
                        <br/>
                        <label for="cleinte" class="labeles">Nombres y Apellidos:</label>                        
                        <input id="nomcliente" name="nomcliente" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->dni; ?>"  />
                                                
                        <label for="direccion" class="labeles">Relación:</label>                        
                        <input type="text" id="referencia_ubic" name="referencia_ubic" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->referencia_ubic; ?>" />
                        <br/>
                        
                        <label for="telefono" class="labeles">Telefono:</label>                        
                        <input type="text" id="telefono" name="telefono" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->telefono; ?>" />
                        
                    </div>
                    <div id="tabs-5">
                        <p>Ingrese el producto:</p>
                        <br />
                        <label class="labels">Producto:</label>
                        <input type="text" name="producto" id="producto" value="" class="ui-widget-content ui-corner-all text" style="width:250px;" />
                        <input type="hidden" name="idsubproductos_semi" id="idsubproductos_semi" value="" />
                        
                        <span style="float: right;">
                            <label class="labels">Producto:</label>
                            <input type="text" name="producto" id="producto" value="" class="ui-widget-content ui-corner-all text" style="width:250px;" />
                        
                        </span>
                        <label class="labels">Observaciones:</label><br />
                        <textarea class="ui-widget-content ui-corner-all text"></textarea>
                        
                        
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