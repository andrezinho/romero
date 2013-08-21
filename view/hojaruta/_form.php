<?php  include("../lib/helpers.php"); 
       include("../view/header_form.php");
?>

   
<form id="frm_hojaruta" >
    <fieldset class="ui-corner-all" style="padding: 2px 10px 7px">
        <input type="hidden" name="controller" value="Caja" />
        <input type="hidden" name="action" value="save" />
    
        <label for="idcaja" class="labels">Distrito:</label>
        <?php echo $Distrito; ?>

        <label for="fechareg" class="labels">Fecha:</label>
        <input id="fechareg" maxlength="15" name="fechareg" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 80px; text-align: left;" value="<?php echo (isset($obj->fechareg)?$obj->fechareg:  date('d/m/Y')); ?>" />
        <br>
        
        <!-- <label for="descripcion" class="labels">Descripcion:</label>
        <input id="descripcion" maxlength="100" name="descripcion" onkeypress="return permite(event,'num_car');" class="text ui-widget-content ui-corner-all" style=" width: 200px; text-align: left;" value="<?php echo $obj->descripcion; ?>" />
        
        <label for="estado" class="labels">Activo:</label>
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
        </div> -->
    </fieldset>

    <div id="box-tipo-ma" class="ui-widget-header ui-state-hover" style="color: #000000;text-align:center">
        <label for="tipo1">HOJA DE RUTA</label>        
    </div><br />
    
    <fieldset id="box-personal" class="ui-corner-all" style="padding: 2px 10px 7px;">  
        <legend>Datos del Personal</legend>
        <div id="box-1">
            <table id="table-per" class="table-form" border="0" cellpadding="0" cellspacing="0">                
                <tr>
                    <td>&nbsp;&nbsp;Zona</td>
                    <td>
                        <select id="idzona" name="idzona">                            
                        </select>
                    </td>                    
                    <td>&nbsp;</td> 
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;&nbsp;DNI</td>                    
                    <td>&nbsp;&nbsp;Nomber y Apellido</td> 
                    <td rowspan="3" align="center">
                        <!-- <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a>  -->
                    </td>                      
                </tr>
                <tr>
                    <td>Buscar Personal</td>
                    <td>
                        <input type="text" name="dni" id="dni" value="" class="ui-widget-content ui-corner-all text" style="width:80px;" /> 
                    </td>                    
                    <td>
                        <input type="text" name="personal" id="personal" value="" class="ui-widget-content ui-corner-all text" style="width:250px;" />
                        <input type="hidden" name="idpersonal" id="idpersonal" value="" /> 
                    </td>
                </tr>           
            </table>                        
        </div>
    </fieldset><br />
    <fieldset id="box-cliente" class="ui-corner-all" style="padding: 2px 10px 7px;">  
        <legend>Datos del Clinte</legend>
        <div id="box-1">
            <table width="800" id="table-cli" class="table-form" border="0" cellpadding="1" cellspacing="1">
              <tr>
                <td width="15%">&nbsp;</td>
                <td width="31%">&nbsp;</td>
                <td width="9%">&nbsp;</td>
                <td width="30%">&nbsp;</td>
                <td width="15%">&nbsp;</td>
              </tr>
              <tr>
                <td><label class="labels">Buscar Cliente:</label></td>
                <td colspan="3">
                    <input type="text" name="dnicli" id="dnicli" value="" class="ui-widget-content ui-corner-all text" style="width:80px;" />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="text" name="cliente" id="cliente" value="" class="ui-widget-content ui-corner-all text" style="width:250px;" />
                    <input type="hidden" name="idcliente" id="idcliente" value="" />
                </td>
                <td rowspan="2" align="center">
                    <a href="javascript:" id="addDetail" class="fm-button ui-state-default ui-corner-all fm-button-icon-right ui-reset"><span class="ui-icon ui-icon-plusthick"></span>Agregar</a> 
                </td>
              </tr>
              <tr>
                <td><label class="labels">Direccion:</label></td>
                <td><input type="text" name="direccion" id="direccion" value="" class="ui-widget-content ui-corner-all text" style="width:250px;" /></td>
                <td><label class="labels">Telefono:</label></td>
                <td><input type="text" name="telefono" id="telefono" value="" class="ui-widget-content ui-corner-all text" style="width:250px;" /></td>
              </tr>
              <tr>
                <td><label class="labels">Producto:</label></td>
                <td><input type="text" name="producto" id="producto" value="" class="ui-widget-content ui-corner-all text" style="width:250px;" /></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><label class="labels">Observacion:</label></td>
                <td rowspan="2">
                  <textarea name="observacion" id="observacion" cols="40" rows="3"></textarea>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
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
                        <th align="center" width="90">DNI</th>
                        <th width="190">Nombre y Apellidos</th>
                        <th>Direccion</th>
                        <th>Telefono</th>
                        <th>Producto</th>
                        <th>Observacion</th>
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
                                    <td align="left"><?php echo $r['dni']; ?><input type="hidden" name="idcajaxpersonal[]" value="<?php echo $r['idcajaxpersonal']; ?>" /></td>
                                    <td><?php echo $r['personal']; ?><input type="hidden" name="idpersonal[]" value="<?php echo $r['idpersonal']; ?>" /></td>                                    
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
