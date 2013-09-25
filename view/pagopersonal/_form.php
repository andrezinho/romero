<?php 
    include("../lib/helpers.php"); 
    $anio= date ("Y");
    $fecchaact= date("Y-m-d");
    $Hora_server = date('H:i:s');  
?>
<style type="text/css">
    .motivo{
        margin-left: 20px;
    }
</style>

<div style="padding:10px 20px; width:700px;">
<form id="frm_pagoxpersonal" >
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Registro Pagos</a></li>
            <li><a href="#tabs-2">Historial de su trabajo</a></li>
        </ul>
        <div id="tabs-1">
            <fieldset>
                <legend>Datos Generales</legend>
                <input type="hidden" name="controller" value="PagoPersonal" />
                <input type="hidden" name="action" value="save" />
                <input type="hidden" id="idpagos" name="idpagos" value="<?php echo $obj->idpagos; ?>" />
                <input type="hidden" id="fechacancelacion" name="fechacancelacion" value="<?php echo $fecchaact; ?>" />
                <input type="hidden" id="horapago" name="horapago" value="<?php echo $Hora_server; ?>" />
                
                <label for="personal" class="labeles">Personal Enc.:</label>
                <input type="hidden" name="idpersonal" id="idpersonal" value="<?php echo $obj->idpersonal; ?>" />        
                <input type="text" name="dni" id="dni" value="<?php echo $obj->dni; ?>" class="ui-widget-content ui-corner-all text" style="width:80px"  maxlength="11" onkeypress="return permite(event,'num')" placeholder="DNI / RUC" />
                <input type="text" name="personal" id="personal" value="<?php echo $obj->personal; ?>" class="ui-widget-content ui-corner-all text" style="width:250px" placeholder="Nombre / Razon social"  />
                <br />

                <label class="labeles">N° Recibo</label>
                <input type="text" name="nrorecibo" id="nrorecibo" value="<?php echo $obj->nrorecibo; ?>" class="ui-widget-content ui-corner-all text" style="width:100px"  maxlength="11" onkeypress="return permite(event,'num')" placeholder="N° Recibo" />
                <br />

                <label class="labeles">Monto a pagar (S/.)</label>
                <input type="text" name="montopag" id="montopag" value="<?php echo $obj->montopag; ?>" class="ui-widget-content ui-corner-all text" style="width:100px"  maxlength="11" onkeypress="return permite(event,'num')" placeholder="Monto a pagar" />
                
                <label class="labeles">Pago del mes :</label>
                <input type="text" name="anio" id="anio" value="<?php echo $anio; ?>" class="ui-widget-content ui-corner-all text" style="width:80px"  maxlength="11" onkeypress="return permite(event,'num')" placeholder="Año" />
                
                <select id="mes" class="text ui-widget-content ui-corner-all">
                    <option value="0">.:: Seleccione ::.</option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Setiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>                
                <br />
                <textarea name="motivopago" id="motivopago" class="ui-widget-content ui-corner-all text motivo"  title="Motivo del pago" rows="2" placeholder="Motivo del pago" style="width:85%"></textarea>
                
            </fieldset>
        </div>
    
        <div id="tabs-2">
            <div id="seleccionmes">
                <label class="labeles">Pago del mes :</label>
                <input type="text" name="anios" id="anios" value="<?php echo $anio; ?>" class="ui-widget-content ui-corner-all text" style="width:80px"  maxlength="11" onkeypress="return permite(event,'num')" placeholder="Año de trabajo" />
                
                <label class="labeles">Mes</label>
                <select id="meses" class="text ui-widget-content ui-corner-all">
                    <option value="0">.:: Seleccione ::.</option>
                    <option value="01">Enero</option>
                    <option value="02">Febrero</option>
                    <option value="03">Marzo</option>
                    <option value="04">Abril</option>
                    <option value="05">Mayo</option>
                    <option value="06">Junio</option>
                    <option value="07">Julio</option>
                    <option value="08">Agosto</option>
                    <option value="09">Setiembre</option>
                    <option value="10">Octubre</option>
                    <option value="11">Noviembre</option>
                    <option value="12">Diciembre</option>
                </select>                
                <br />
            </div>
            
            <div id="box-tipo-ma" class="ui-widget-header ui-state-hover" style="text-align:center">
                DETALLE DEL TRABAJO QUE REALIZO
            </div>
            <br />
            <fieldset id="box-trabajo" class="ui-corner-all" style="padding: 2px 10px 7px">  
                <legend></legend>
                <div id="divLoadTrabajo"></div>


            </fieldset>

        </div>

    </div>
</form>
</div>
