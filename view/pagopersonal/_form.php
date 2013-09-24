<?php include("../lib/helpers.php"); ?>
<style type="text/css">
    .motivo{
        margin-left: 20px;
    }
</style>

<div style="padding:10px 20px; width:700px;">
<form id="frm_pagoxpersonal" >
    <div id="tabs">
        <ul style="background:#DADADA !important; border:0 !important">
            <li><a href="#tabs-1">Registro Ventas</a></li>
            <li><a href="#tabs-2">Registro Pagos</a></li>
        </ul>
        <div id="tabs-1">
            <fieldset>
                <legend>Datos Generales</legend>

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
                <input type="text" name="anio" id="anio" value="<?php echo $obj->anio; ?>" class="ui-widget-content ui-corner-all text" style="width:80px"  maxlength="11" onkeypress="return permite(event,'num')" placeholder="Año" />
                
                <select class="text ui-widget-content ui-corner-all">
                    <option>.:: Seleccione ::.</option>
                    <option>Enero</option>
                    <option>Febrero</option>
                    <option>Marzo</option>
                    <option>Abril</option>
                    <option>Mayo</option>
                    <option>Junio</option>
                    <option>Julio</option>
                    <option>Agosto</option>
                    <option>Setiembre</option>
                    <option>Octubre</option>
                    <option>Noviembre</option>
                    <option>Diciembre</option>
                </select>                
                <br />
                <textarea name="motivopago" id="motivopago" class="ui-widget-content ui-corner-all text motivo"  title="Motivo del pago" rows="2" placeholder="Motivo del pago" style="width:85%"></textarea>
                
            </fieldset>
        </div>
    
        <div id="tabs-2">
            
        </div>

    </div>
</form>
</div>
