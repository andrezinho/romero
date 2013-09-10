<fieldset class="resport">
    <legend>Resultados de la Consula</legend>
    <table id="table-detalle" class="ui-widget ui-widget-content" style="margin: 0 auto; width:840px" border="0" >
        <thead class="ui-widget ui-widget-content" >
            <tr class="ui-widget-header" style="height: 23px">          
                <th align="center" width="120">Sucursal</th>                
                <th align="center" width="80">Cliente</th>
                <th align="center" width="80">Fecha</th>
                <th align="center" width="80">Vendedor</th>
                <th align="center" width="80">Estado</th>
            </tr>
        </thead>  
        <tbody>
            <?php 
                if(count($rowsd)>0)
                {    
                    foreach ($rowsd as $i => $r) 
                    {       
                        //$est= $r['estado'];
                        //$men= $r['cuota'];                                        
                        //$ini= $r['inicial'];
                        //$subt= (floatval($nro) * floatval($men))+ $ini;
                            
                        ?>
                        <tr class="tr-detalle">
                            <td align="left"><?php echo $r['descripcion']; ?></td>
                            <td><?php echo $r['nomcliente']; ?></td>
                            <td align="left"><?php echo $r['fecha']; ?></td>
                            <td align="left"><?php echo $r['vendedor']; ?></td>
                            <td align="left"><?php echo $r['estado']; ?></td>                            
                        </tr>
                        <?php    
                        }  
                }
             ?>                      
        </tbody>
         <tfoot>
            <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>                
            </tr>
            
        </tfoot>
    </table>
    
</fieldset>
<br />
<br />