<?php include("../lib/helpers.php"); ?>
<style type="text/css">
    .box-n1 {
        width: 100%;
        float: left;
        border: 1px dotted #dadada;
        margin: 0 0 5px;
        background: #FAFAFA;
    }
    #box-pay {
        width: 55%;
        float: left;
                

    }
    #box-cuotas { width: 45%;
                  float: left;}
tbody tr:nth-child(even) { background: #ddd }
tbody tr:nth-child(odd) { background: #fff}
</style>
<script type="text/javascript" src="../web/js/app/evt_index_ventas.js"></script>
<div style="padding:5px; background:#FAFAFA;">
    <div id="data-head" class="box-n1">
        <div style="padding:10px; font-size:14px;">
            <h6>DATOS DE LA VENTA</h6>
            <input type="hidden" name="idmov" id="idmov" value="<?php echo $_GET['id'] ?>" />
            <label class="labels">Cliente: </label><?php echo $rowsv->nomcliente; ?> <br/>
            <label class="labels">Fecha de Venta: </label><?php echo $rowsv->fecha; ?> <br/>
            <label class="labels">Vendedor: </label><?php echo $rowsv->u; ?>
        </div>
    </div>
    <div id="box-operaciones" class="box-n1">
        <div style="padding:10px;" >
        <div id="box-pay">
            <div style="padding:3px; background:#FEFFCB; border:1px solid #F9FCAB">
            <h6>REALIZAR PAGOS</h6>
            <span id="box-pay-doc">
            <label class="labels">Documento: </label>            
            <label class="">RECIBO DE INGRESO</label>
            </span> 
            <br/>
            <span>
                <label class="labels">Forma de pago: </label>
                <?php echo $formapago2; ?>
            </span>
            <br />
            <span id="box-pay-tarjeta" style="display:none;margin-left:105px;">
             <input type="text" name="nrotarjeta" id="nrotarjeta" value="" class="ui-widget-content ui-corner-all text" placeholder="N&deg; de Tarjeta" />
             <input type="text" name="nrovoucher" id="nrovoucher" value="" class="ui-widget-content ui-corner-all text" placeholder="N&deg; de Voucher" style="width:200px" />
            </span>
            <span id="box-pay-cheque" style="display:none;margin-left:105px;">
                <input type="text" name="nrocheque" id="nrocheque" value="" class="ui-widget-content ui-corner-all text" placeholder="N&deg; de Cheque" />
                <input type="text" name="banco" id="banco" value="" class="ui-widget-content ui-corner-all text" placeholder="Banco del cheque" style="width:200px" />                                
                <input type="text" name="fechav" id="fechav" value="" class="ui-widget-content ui-corner-all text text-date"  placeholder="Fecha Vencimiento" />
            </span>
            <br/>

            <label class="labels">Monto: </label>
            <input type="text" name="monto_efectivo" id="monto_efectivo" value="0.00"  class="ui-widget-content ui-corner-all text text-num" />
            S/. 
            <a href="javascript:" id="add-fp" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset ui-state-active"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
            

            <a href="javascript:" id="btn-pago" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset ui-state-active" style="float:right"><span class="ui-icon ui-icon-check"></span>Confirmar Pago</a> 

            <div class="contain">
                <table id="table-detalle-pagos" class="ui-widget ui-widget-content">
                    <thead>
                        <tr class="ui-widget-header">
                            <td width="120px" align="center">Forma de Pago</td>                             
                            <td >Descripcion</td>
                            <td width="100" align="center">Monto</td>
                            <td width="30px">&nbsp;</td>
                        </tr>
                    </thead> 
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td align="right" colspan="2"><b>Total de Pago:</b></td>
                            <td align="right"><b>0.00</b></td>
                            <td>&nbsp;</td>                        
                        </tr>                        
                    </tfoot>
                </table>  
            </div>            
            <div style="clear:both"></div>
            </div>
        </div>
        <div id="box-cuotas">
            <div style="padding:5px;">
            <h6>CRONOGRAMA DE CUOTAS</h6>
            <table class="ui-widget ui-widget-content" border="0" width="100%" >
                <thead>
                    <tr class="ui-widget-header" style="height:23px">
                        <th>&nbsp;</th>
                        <th>Monto a pagar</td>
                        <th>Monto pagado</td>
                        <th>Monto Pendiente</td>
                        <th>Fecha de Programada</td>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    if(count($rowsd)>0)
                    {    
                        foreach ($rowsd as $i => $r) 
                        {       
                            $m= (float)$r['monto'];
                            $ms= (float)$r['monto_saldado'];
                            $p= $m - $ms;
                            $style="";
                            if($p==0)
                                $style='style="text-decoration:line-through; color:#999"';
                            ?>
                        <tr>
                            <td align="center"><?php echo ($i+1) ?></td>
                            <td align="right" <?php echo $style ?>><?php echo number_format($r['monto'],2); ?></td>
                            <td align="right" <?php echo $style ?>><?php echo number_format($r['monto_saldado'],2); ?></td>
                            <td align="right" <?php echo $style ?>><b><?php echo number_format($p,2); ?></b></td>
                            <td align="center" <?php echo $style ?>><?php echo strtoupper($r['fechapago']); ?></td>
                            <td align="center">
                                <?php 
                                    if($p==0) { echo "PAGADO"; }
                                        else { echo "PENDIENTE";}
                                ?>
                            </td>
                        </tr>
                         <?php    
                        }  
                    }
                ?>
                </tbody>
                
            </table>
            </div>
        </div>
        </div>
    </div>
    <div id="box-pay-e" class="box-n1">
        <div style="padding:10px;">
            <h6>PAGOS REALIZADOS</h6>
             <div class="contain">
                <table class="ui-widget ui-widget-content">
                    <thead>
                    <tr class="ui-widget-header">
                        <th>Fecha</th>
                        <th>Documento</th>
                        <th>Serie</th>
                        <th>Numero</th>
                        <th>Total</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($rowsp as $key => $value) {
                            ?>
                            <tr style="background:#fafafa;">
                                <td align="center"><b><?php echo ffecha($value['fecha'],'ES') ?></b></td>
                                <td><b><?php echo $value['documento'] ?></b></td>
                                <td align="center"><b><?php echo $value['serie'] ?></b></td>
                                <td align="center"><b><?php echo $value['numero'] ?></b></td>
                                <td align="right"><b><?php echo $value['total'] ?></b></td>
                                <td></td>
                            </tr>
                            <?php
                            foreach($value['detalle'] as $r)
                            {
                                ?>
                                <tr>
                                    <td align="center"><?php echo $r['descripcion'] ?></td>
                                    <td colspan="3"><?php echo $r['d'] ?></td>
                                    <td align="right"><?php echo $r['monto'] ?></td>
                                    <td></td>
                                </tr>
                                <?php
                            }
                        }
                     ?>
                </tbody>
            </table>
            </div>
        </div>        
    </div>
</div>    

<br/>
<!-- <fieldset class="resports">
    <legend>Datos de la Venta</legend>            
    <br />
    <fieldset style="width:560px; float:left; margin-left:20px; padding:10px;">
        <legend>Pago de cuotas</legend>

        

    </fieldset>

    <fieldset style="width:300px; float:right; margin-right:20px;">
        <legend>Cuotas de la venta</legend>

    </fieldset>
</fieldset> -->
