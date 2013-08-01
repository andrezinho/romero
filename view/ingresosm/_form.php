<?php  include("../lib/helpers.php"); include("../view/header_form.php"); ?>
<div style="padding:10px 20px">
<form id="frm" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
    <legend>Datos</legend>
        <input type="hidden" name="controller" value="ingresom" />
        <input type="hidden" name="action" value="save" />             
        <label for="idmodulo" class="labels">Codigo:</label>
        <input type="text" id="idmodulo" name="idmodulo" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->idmodulo; ?>" readonly />                
        <label for="fecha" class="labels">Fecha:</label>
        <input type="text" name="fecha" id="fecha" class="ui-widget-content ui-corner-all text" />
        <br/>
        <label for="referencia" class="labels">Referencia:</label>
        <input type="text" name="referencia" id="referencia" class="ui-widget-content ui-corner-all text" style="width:500px" />
    </fieldset>
</form>
</div>