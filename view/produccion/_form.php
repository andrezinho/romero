<?php  include("../lib/helpers.php");     ?>
<style>
    .link-oper { margin-left: 10px; color: green !important; }
    span.title-head { text-transform: uppercase; display: block; padding: 5px}
</style>
<div style="padding:10px 20px; width:950px">
<form id="frm-produccion" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
    <legend>Datos - <b><?php echo date('d/m/Y'); ?></b></legend>
        <input type="hidden" name="controller" value="Produccion" />
        <input type="hidden" name="action" value="save" />             
        <input type="hidden" id="idproduccion" name="idproduccion" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->idproduccion; ?>" readonly />                
        
        <label for="descripcion" class="labels">Descripcion:</label>
        <input type="text" name="descripcion" id="descripcion" class="ui-widget-content ui-corner-all text" style="width:635px" value="<?php echo $obj->descripcion; ?>" />
        <br/>

        <label for="fechai" class="labels">Fecha, desde:</label>
        <input type="text" name="fechai" id="fechai" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fechaini)?$obj->fechaini:  date('d/m/Y')); ?>" style="width:70px; text-align:center" />        
        Hasta <input type="text" name="fechaf" id="fechaf" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fechafin)?$obj->fechafin:  date('d/m/Y')); ?>" style="width:70px; text-align:center" />
        
        
        <label for="idpersonal" class="labels">Personal Enc.:</label>
        <input type="hidden" name="idpersonal" id="idpersonal" value="<?php echo $obj->idpersonal; ?>" />        
        <input type="text" name="dni" id="dni" class="ui-widget-content ui-corner-all text" style="width:80px" value="<?php echo $obj->dni; ?>" maxlength="11" onkeypress="return permite(event,'num')" />
        <input type="text" name="personal" id="personal" class="ui-widget-content ui-corner-all text" style="width:250px" value="<?php echo $obj->personal; ?>" />
        <br/> 
    </fieldset>    
    <fieldset id="box-melamina" class="ui-corner-all ui-widget-content" style="padding: 2px 10px 7px;">  
        <legend>Produccion</legend>      
        <div id="box-1">
            <table id="table-me" class="table-form" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>Almacen</td>
                    <td><label for="idmelamina" class="labels" style="width:auto">Seleccion el tipo de Producto a Producir</label></td>
                    <td><label for="cantidad_me" class="labels" style="width:auto">Cant. <label class="text-backinfo">Unid</label></label></td>                    
                </tr>
                <tr>
                    <td><?php echo $almacenma; ?></td>
                    <td><?php echo $ProductoSemi; ?>
                    <select name="idsubproductos_semi" id="idsubproductos_semi" class="ui-widget-content ui-corner-all text" style="width:150px">
                        <option value="">Seleccione....</option>
                    </select>
                    </td>
                    <td><input type="text" name="cantidad" id="cantidad" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" onkeypress="return permite(event,'num')" /> </td>                                        
                </tr>
            </table>                        

            <div class=" ui-corner-all" style="padding:10px">
                <h4 id="title-produccion" style="text-align:center">Materia Prima a Usar</h4>                
                <div id="tabs">
                    <ul style="background:#DADADA !important; border:0 !important">
                        <li><a href="#tabs-1">Madera</a></li>
                        <li><a href="#tabs-2">Melamina</a></li>
                    </ul>
                    <div id="tabs-1">
                        <div>Agregar la el tipo y la cantidad de <b>Madera</b> a emplear para la produccion.</div>
                        <label>Madera: </label>                             
                        <?php echo $idmadera; ?>
                        <span id="label-stock-ma" class="box-info">Stock Max: * pies</span>
                        <input type="hidden" name="stock_ma" id="stock_ma" value="0" />
                        <input type="text" name="cant_ma" id="cant_ma" value="0.00" class="ui-widget-content ui-corner-all text" style="text-align:center; width:50px" maxlength="7" onkeypress="enter(event);return permite(event,'num');" />
                        <a href="javascript:" id="btn-add-ma" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar Madera</a>                         
                    </div>
                    <div id="tabs-2">
                        <div>Agregar la el tipo y la cantidad de <b>Melamina</b> a emplear para la produccion.</div                    
                        <label>Melamina: </label> <?php echo $linea; ?>
                        <select name="idmelamina" id="idmelamina" class="ui-widget-content ui-corner-all text" style="width:200px">
                            <option value="">Seleccione....</option>
                        </select>
                        <span id="label-stock-me" class="box-info">Stock Max: * Unid.</span>
                        <input type="hidden" name="stock_me" id="stock_me" value="0" />
                        <input type="text" name="cant_me" id="cant_me" value="0.00" class="ui-widget-content ui-corner-all text" style="text-align:center; width:50px" maxlength="7" onkeypress="enter(event);return permite(event,'num');" />
                        <a href="javascript:" id="btn-add-me" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar Melamina</a> 
                    </div>
                </div>
                <div style="padding:3px 0 0 0">
                    <div class="contain" style="width:600px; float:left;">
                        <table id="table-detalle-materia" class="ui-widget ui-widget-content" style="margin: 0 auto; width:100% " border="0" >
                            <thead>
                                <tr>                                
                                    <td width="100px" align="center">Tipo</td>                             
                                    <td >Descripcion de Materia Prima</td>
                                    <td width="100px" align="center">Almacen</td>
                                    <td width="100px" align="center">Cant. (Pies)</td>
                                    <td width="30px">&nbsp;</td>
                                </tr>
                            </thead> 
                            <tbody>
                            </tbody>
                        </table>
                    </div> 
                    <div style="text-align:right; width:290px; float:left">
                        <a href="javascript:" id="btn-clear-detalle-prod" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-minus"></span>Limpiar</a> 
                        <a href="javascript:" id="btn-add-detalle-prod" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset ui-state-active"><span class="ui-icon ui-icon-plusthick"></span>Agregar a Produccion</a> 
                    </div>
                </div>
            </div>
        </div>
    </fieldset>
    <div id="div-detalle" class="ui-corner-all" style="background:#FAFAFA; padding: 10px 15px">
        <!-- <div class="box-item">
            <span class="title-head"><strong>100 Sillas Talladas </strong><a href="" class="link-oper">Ver Materiales</a> <a href="" class="link-oper">Editar</a> <a href="" class="link-oper">Eliminar</a></span>
            <div id="materia-">
                <ul class="ul-items">
                    <li>(Almacen: Tarapoto Norte) Madera Caoba, 100pies <a href="" class="link-oper">Quitar</a></li>
                    <li>(Almacen: Tarapoto Norte) Madera Caoba, 100pies <a href="" class="link-oper">Quitar</a></li>
                </ul>
            </div>
        </div>    --> 
         
    </div>
</form>
</div>

<div id="dialogConf">

</div>
<div id="box-add-mp">
    
</div>