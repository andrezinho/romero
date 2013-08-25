<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>

   
<form id="frm_maderba" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
        <input type="hidden" name="controller" value="Proformas" />
        <input type="hidden" name="action" value="save" />
    
        <label for="idproforma" class="labels">Codigo:</label>
        <input id="idproforma" name="idproforma" class="text ui-widget-content ui-corner-all" style=" width: 100px; text-align: left;" value="<?php echo $obj->idproforma; ?>" readonly />        
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

        <label for="observacion" class="labels">Observacion:</label>
        <input type="text" name="observacion" id="observacion" class="ui-widget-content ui-corner-all text" value="<?php echo $obj->observacion; ?>" style="width:250px;" />        
        
    </fieldset>

    <fieldset id="box-melamina" class="ui-corner-all" style="padding: 2px 10px 7px;">  
        <legend>Detalle de la proforma</legend>
        <div id="box-1">
            <table id="table-per" class="table-form" border="0" cellpadding="0" cellspacing="0" width="600px" >
                <tr>
                    <td width="100px"><label for="tipopago" class="labels">Tipo pago:</label></td>
                    <td><?php echo $tipopago; ?></td>
                    <td>
                        <div id="TbF" style="display: none;">
                            <label for="financiamiento" class="labels">Financiamiento:</label>
                            <?php echo $Financiamiento; ?>
                            <input type="checkbox" title="Considerar Adicional" checked="checked" id="ChkAdicional">   
                        </div>
                        
                    </td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><label for="productos" class="labels">Buscar Producto:</label></td>
                    <td colspan="2">
                        <input type="text" name="producto" id="producto" value="" class="ui-widget-content ui-corner-all text" style="width:240px;" />
                        <input type="hidden" name="idsubproductos_semi" id="idsubproductos_semi" value="" />
                        <label for="igv" class="labels" style="width:80px;">Afecto IGV:</label>
                        <?php $ck = ""; if($obj->afecto==1) $ck = "checked"; ?>
                        <input type="checkbox" name="aigv" id="aigv" value="1" <?php echo $ck; ?> />
                        <input type="hidden" name="igv_val" id="igv_val" value="<?php if($obj->igv!="") echo $obj->igv; else echo "18"; ?>" />
                    </td>
                    <td rowspan="2" align="center">
                        <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
                    </td>                    
                </tr>
                <tr>
                    <td><label for="idcliente" class="labels">Precio Cash:</label></td>
                    <td>
                        <input type="text" name="precio" id="precio" value="0.00" class="ui-widget-content ui-corner-all text" style="width:80px;" />
                    </td>                    
                    <td>
                        <label for="Cantidad" class="labels">Cantidad:</label> 
                        <input type="text" name="cantidad" id="cantidad" onkeypress="return permite(event,'num')" value="" class="ui-widget-content ui-corner-all text" style="width:80px;" /> 
                    </td>
                </tr>
                <tr id="TrCredito" style="display: none;">
                    <td><label for="Iniciales" class="labels">Inicial:</label></td>
                    <td><input type="text" name="inicial" id="inicial" value="0.00" class="ui-widget-content ui-corner-all text" style="width:80px;" /></td>                    
                    <td>
                        <label for="nromes" class="labels">N° Meses:</label>
                        <input id="NroMeses" class="ui-widget-content ui-corner-all text" type="text" style="width:40px;text-align:right" size="2" onkeypress="Calcular3(event)">
                        <img id="calcularfi" src="../web/images/calculadora.png" width="18" height="18" />
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
            <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:840px" border="0" >
                <thead class="ui-widget ui-widget-content" >
                    <tr class="ui-widget-header" style="height: 23px">          
                        <th align="center" width="120">Tipo Pago</th>
                        <th>Producto</th>
                        <th align="center" width="80">Precio</th>
                        <th align="center" width="80">Cantidad</th>
                        <th align="center" width="80">Inicial</th>
                        <th align="center" width="80">Mensual</th>
                        <th align="center" width="90">N° Meses</th>
                        <th align="center" width="80px">IMPORTE S/.</th>
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
                                    <td align="left"><?php echo $r['dni']; ?><input type="hidden" name="idproformaxcliente[]" value="<?php echo $r['idproformaxcliente']; ?>" /></td>
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
                        <td colspan="7" align="right"><b>SUB TOTAL S/.</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="7" align="right"><b>IGV S/.</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="7" align="right"><b>TOTAL S/.</b></td>
                        <td align="right"><b>0.00</b></td>
                        <td>&nbsp;</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div> 

</form>

<div id="divFinanciamiento" style="display: none;">
</div>
