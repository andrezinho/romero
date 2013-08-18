<?php  
include("../lib/helpers.php"); 
include("../view/header_form.php"); 
?>
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
    <fieldset id="box-melamina" class="ui-corner-all" style="padding: 2px 10px 7px;">  
        <legend>Produccion</legend>      
        <div id="box-1">
            <table id="table-me" class="table-form" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><label for="idmelamina" class="labels" style="width:auto">Seleccion el tipo de Producto a Producir</label></td>
                    <td><label for="cantidad_me" class="labels" style="width:auto">Cant. <label class="text-backinfo">Unid</label></label></td>
                </tr>
                <tr>
                    <td><?php echo $ProductoSemi; ?>
                    <select name="idsubproductos_semi" id="idsubproductos_semi" class="ui-widget-content ui-corner-all text" style="width:150px">
                        <option value="">Seleccione....</option>
                    </select>
                    </td>
                    <td><input type="text" name="cantidad_me" id="cantidad_me" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" /> </td>                    
                </tr>
            </table>                        
            <div class="ui-widget-content ui-corner-all" style="padding:10px">
                <h4 id="title-produccion" style="text-align:center">Materia Prima a Usar</h4>
                <br/>
                <div id="tabs">
                    <ul style="background:#DADADA !important; border:0 !important">
                        <li><a href="#tabs-1">Madera</a></li>
                        <li><a href="#tabs-2">Melamina</a></li>
                    </ul>
                    <div id="tabs-1">
                        <p id="">Agregar la el tipo y la cantidad de <b>Madera</b> a emplear para la produccion.
                            <br/>
                            <label>Almacen: </label> 
                            <?php echo $almacenma; ?>
                            <?php echo $idmadera; ?>
                            <span class="box-info">Stock Max: 20 pies</span>
                            <input type="hidden" name="stock_ma" id="stock_ma" value="0" />
                            <input type="text" name="cant_ma" id="cant_ma" value="0.00" class="ui-widget-content ui-corner-all text" style="text-align:center; width:50px" maxlength="7" />
                            <a href="javascript:" id="" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
                        </p>
                    </div>
                    <div id="tabs-2">
                        <p>Agregar la el tipo y la cantidad e Melamina a emplear para la produccion.</p>
                    </div>
                </div>
                <div>
                    <div class="contain">
                        <table id="table-detalle-materia" class="ui-widget ui-widget-content" style="margin: 0 auto; width:100% " border="0" >
                            <thead>
                                <tr>                                
                                    <td width="100px" align="center">Tipo</td>                             
                                    <td >Descripcion de Materia Prima</td>
                                    <td width="100px" align="center">Cant. (Pies)</td>
                                    <td width="20px">&nbsp;</td>
                                </tr>
                            </thead> 
                            <tbody>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
            <div style="padding:5px; text-align:right">
                <a href="javascript:" id="" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Limpiar</a> 
                <a href="javascript:" id="addDetail_me" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset ui-state-active"><span class="ui-icon ui-icon-plusthick"></span>Agregar al Detalle</a> 
            </div>
        </div>
    </fieldset>
    <div id="div-detalle">
    <div class="contain">
        <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:100% " border="0" >
            <thead class="ui-widget ui-widget-content" >
                <tr class="ui-widget-header" style="height: 23px">                                
                    <th>DESCRIPCION</th>                             
                    <th width="80px">CANTIDAD</th>                    
                    <th width="20px">&nbsp;</th>
                </tr>
            </thead>  
            <tbody>
                <?php 
                    
                    if(count($rowsd)>0)
                        {    
                            foreach ($rowsd as $i => $r) 
                            {
                                
                                ?>
                                <tr class="tr-detalle">
                                    <td align="left"><?php echo $r['descripcion']; ?><input type="hidden" name="idsubproductos_semi[]" value="<?php echo $r['idsubproductos_semi']; ?>" /></td>
                                    <td><?php echo $r['cantidad']; ?><input type="hidden" name="cantd[]" value="<?php echo $r['cantidad']; ?>" /></td>                                    
                                    <td align="center"><a class="box-boton boton-delete" href="#" title="Quitar" ></a></td>
                                </tr>
                                <?php    
                            }
                        }
                ?>                     
            </tbody>
            <tfoot>
                <tr>
                    <td align="right">&nbsp;</td>
                    <td align="right">&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>               
            </tfoot>
        </table>
        </div>
        </div>
</form>
</div>

<div id="dialogConf">

</div>