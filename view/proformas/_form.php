<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>

   
<form id="frm_maderba" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
        <input type="hidden" name="controller" value="Caja" />
        <input type="hidden" name="action" value="save" />
    
        <label for="idcaja" class="labels">Codigo:</label>
        <input id="idcaja" name="idcaja" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->idcaja; ?>" readonly />        
        <br>
        
        <label for="sucursales" class="labels">Sucursal:</label>
        <?php echo $Sucursal; ?>

        <label for="fecha" class="labels">Fecha:</label>
        <input type="text" name="fecha" id="fecha" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->fecha)?$obj->fecha:  date('d/m/Y')); ?>" style="width:70px;" />        
        
        <label for="hora" class="labels">Hora:</label>
        <input type="text" name="hora" id="hora" class="ui-widget-content ui-corner-all text" value="<?php echo (isset($obj->hora)?$obj->hora:  date('H:i:s')); ?>" style="width:70px;" />        
        <br />

        <label for="idcliente" class="labels">Cliente:</label>
        <input type="hidden" name="idcliente" id="idcliente" value="<?php echo $obj->idcliente; ?>" />        
        <input type="text" name="dni" id="dni" class="ui-widget-content ui-corner-all text" style="width:80px" value="<?php echo $obj->dni; ?>" maxlength="8" onkeypress="return permite(event,'num')" />
        <input type="text" name="cliente" id="cliente" class="ui-widget-content ui-corner-all text" style="width:250px" value="<?php echo $obj->cliente; ?>" />
        <br/> 
    </fieldset>
<!-- 
    <div id="box-tipo-ma" class="ui-widget-header ui-state-hover" style="color: #000000;text-align:center">
        <label for="tipo1">ASIGNACIÓN DE CAJA</label>        
    </div>
     -->
    <fieldset id="box-melamina" class="ui-corner-all" style="padding: 2px 10px 7px;">  
        <legend>Detalle de la proforma</legend>
        <div id="box-1">
            <table id="table-per" class="table-form" border="0" cellpadding="0" cellspacing="0" >
                <tr>
                    <td>Tipo</td>
                    <td><?php echo $tipopago; ?></td>
                    <td>
                        <div id="TbF" style="display: none;">
                            Financiamiento
                            <?php echo $Financiamiento; ?>
                            <input type="checkbox" title="Considerar Adicional" checked="checked" id="ChkAdicional">   
                        </div>
                        
                    </td>
                    <td>&nbsp;</td>
                </tr>
                
                <tr>
                    <td>Buscar Producto</td>
                    <td colspan="2">
                      <input type="text" name="cliente" id="cliente" value="" class="ui-widget-content ui-corner-all text" style="width:250px;" />
                      <input type="hidden" name="idcliente" id="idcliente" value="" />                    </td>
                    <td rowspan="2" align="center">
                        <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
                    </td>                    
                </tr>
                <tr>
                    <td>Precio Cash</td>
                    <td><input type="text" name="precio" id="precio" value="" class="ui-widget-content ui-corner-all text" style="width:80px;" /> </td>                    
                    <td>&nbsp;</td>
                </tr>
                <tr id="TrCredito" style="display: none;">
                    <td>Inicial</td>
                    <td><input type="text" name="inicial" id="inicial" value="" class="ui-widget-content ui-corner-all text" style="width:80px;" /> </td>                    
                    <td>
                        N° Meses:
                        <input id="NroMeses" class="ui-widget-content ui-corner-all text" type="text" style="width:40px;text-align:right" size="2" onkeypress="Calcular3(event)">
                    
                        Mensual:
                        <input id="Mensual" class="ui-widget-content ui-corner-all text" type="text" style="width:60px;text-align:right" size="8" onkeypress="">
                    </td>
                    <td>&nbsp;</td> 
                </tr>
            </table>                     
        </div>
    </fieldset>
    <div id="div-detalle">
        <div>
            <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:100% " border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">          
                        <th align="center" width="150">DNI</th>
                        <th>Nombre y Apellidos</th>
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
                                    <td align="left"><?php echo $r['dni']; ?><input type="hidden" name="idcajaxcliente[]" value="<?php echo $r['idcajaxcliente']; ?>" /></td>
                                    <td><?php echo $r['cliente']; ?><input type="hidden" name="idcliente[]" value="<?php echo $r['idcliente']; ?>" /></td>                                    
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
