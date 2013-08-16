<?php  
include("../lib/helpers.php"); 
include("../view/header_form.php"); 
?>
<div style="padding:10px 20px">
<form id="frm-produccion" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
    <legend>Datos Produccion - <b><?php echo date('d/m/Y'); ?></b></legend>
        <input type="hidden" name="controller" value="Produccion" />
        <input type="hidden" name="action" value="save" />             
        <input type="hidden" id="idproduccion" name="idproduccion" class="text ui-widget-content ui-corner-all" style=" width: 50px; text-align: left;" value="<?php echo $obj->idproduccion; ?>" readonly />                
        
        <label for="descripcion" class="labels">Descripcion:</label>
        <input type="text" name="descripcion" id="descripcion" class="ui-widget-content ui-corner-all text" style="width:500px" value="<?php echo $obj->descripcion; ?>" />
        <br/>

        <label for="fechai" class="labels">Fecha Inicio:</label>
        <input type="text" name="fechai" id="fechai" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fechaini)?$obj->fechaini:  date('d/m/Y')); ?>" style="width:70px; text-align:center" />
        
        <label for="fechaf" class="labels" style="width:80px">Fecha Final:</label>
        <input type="text" name="fechaf" id="fechaf" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fechafin)?$obj->fechafin:  date('d/m/Y')); ?>" style="width:70px; text-align:center" />
        
        <br/>
        <label for="idpersonal" class="labels">Personal Enc.:</label>
        <input type="hidden" name="idpersonal" id="idpersonal" value="<?php echo $obj->idpersonal; ?>" />        
        <input type="text" name="dni" id="dni" class="ui-widget-content ui-corner-all text" style="width:80px" value="<?php echo $obj->dni; ?>" maxlength="11" onkeypress="return permite(event,'num')" />
        <input type="text" name="personal" id="personal" class="ui-widget-content ui-corner-all text" style="width:300px" value="<?php echo $obj->personal; ?>" />
        <br/> 
    </fieldset>
    
    <fieldset id="box-melamina" class="ui-corner-all" style="padding: 2px 10px 7px;">  
        <legend>Fabricacion</legend>      
        <div id="box-1">
            <table id="table-me" class="table-form" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td><label for="idmelamina" class="labels" style="width:auto">Producto Semi</label></td>
                    <td><label for="cantidad_me" class="labels" style="width:auto">Cant. <label class="text-backinfo">Unid</label></label></td>                    
                    <td>&nbsp;</td>
                    <td>&nbsp;</td> 
                    <td rowspan="2"><a href="javascript:" id="addDetail_me" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> </td>                    
                </tr>
                <tr>
                    <td><?php echo $ProductoSemi; ?>
                    <select name="idsubproductos_semi" id="idsubproductos_semi" class="ui-widget-content ui-corner-all text" style="width:150px">
                        <option value="">Seleccione....</option>
                    </select>
                    </td>
                    <td><input type="text" name="cantidad_me" id="cantidad_me" value="0.00" class="ui-widget-content ui-corner-all text" style="width:68px; text-align:center" /> </td>                    
                    <td>&nbsp;</td> 
                    <td>&nbsp;</td>                     
                </tr>
            </table>                        
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