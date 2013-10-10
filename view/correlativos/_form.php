<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
       
?>
<div style="padding:10px 20px">
<form id="frm_tipodoc" >
    <input type="hidden" name="controller" value="Correlativos" />
    <input type="hidden" name="action" value="save" /> 

    <label for="idcorrelativo" class="labels">Codigo:</label>
    <input id="idcorrelativo" name="idcorrelativo" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idcorrelativo; ?>" readonly />

    <label for="idtipodocumento" class="labels">Tipo Documento:</label>
    <?php echo $Tipodocumento; ?>
    <br/>
    
    <label for="sucursal" class="labels">Sucursal</label>
    <?php echo $idsucursal; ?>
    
    <label for="serie" class="labels">Serie:</label>
    <input type="text" id="serie" maxlength="100" name="serie" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->serie; ?>" />
    <br />
    
    <label for="numero" class="labels">Número:</label>
    <input type="text" id="numero" maxlength="100" name="numero" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->numero; ?>" />
  
    <label for="valormaximo" class="labels">Valor Máximo:</label>
    <input type="text" id="valormaximo" maxlength="100" name="valormaximo" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->valormaximo; ?>" />
    <br />
    
    <label for="valorminimo" class="labels">Valor Mínimo:</label>
    <input type="text" id="valorminimo" maxlength="100" name="valorminimo" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->valorminimo; ?>" />
    
    <label for="incremento" class="labels">Incremento:</label>
    <input type="text" id="incremento" maxlength="100" name="incremento" onkeypress="return permite(event,'num');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->incremento; ?>" />
    <br />
    
    <label for="estado" class="labels">Estado:</label>
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