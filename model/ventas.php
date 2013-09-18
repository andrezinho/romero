<?php
include_once("Main.php");
include_once("tipodocumento.php");
class Ventas extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            m.idmovimiento,
            c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno,
            tpd.descripcion ,
            m.documentonumero,
            tpp.descripcion,
            substr(cast(m.fecha as text),9,2)||'/'||substr(cast(m.fecha as text),6,2)||'/'||substr(cast(m.fecha as text),1,4),
            m.total,        
            case when m.idtipopago=2 then
                '<a class=\"pagar box-boton boton-pay\" id=\"v-'||m.idmovimiento||'\" title=\"Pagar sus cuotas\" ></a>'
            else '&nbsp;' end
               
            FROM
            facturacion.movimiento AS m
            INNER JOIN facturacion.movimientodetalle AS md ON m.idmovimiento = md.idmovimiento
            INNER JOIN cliente AS c ON c.idcliente = m.idcliente
            INNER JOIN facturacion.tipodocumento AS tpd ON tpd.idtipodocumento = m.idtipodocumento
            INNER JOIN produccion.tipopago AS tpp ON tpp.idtipopago = m.idtipopago ";                
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM seguridad.modulo WHERE idmodulo = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        
         $obj_td = new Tipodocumento();
      
         $prod = json_decode($_P['producto']);         
         $item = $prod->nitem;
         $cont = 0;

         if(isset($_P['aigv'])) $afecto = 1;
            else $afecto=0;

         $st = 0;
         $igv = $_P['igv_val'];
         $tigv = 0;
         $t = 0;
         $dsct = $_P['monto_descuento'];
         $tdsct = $_P['tipod'];         
        
           for($i=0;$i<$item;$i++)
           {
                if($prod->estado[$i])
                {
                    $cont ++;
                    $st += $prod->cantidad[$i]*$prod->precio[$i];
                }
           }

           $st_bruto = $st;

           if($tdsct==1) $dsct_val = $dsct;
            else $dsct_val = $st*$dsct/100;

           $st = $st - $dsct_val;

           if($afecto==1)
           {
              $tigv = $st*$igv/100;
              $t = $st+$tigv;
           }
           else
           {
              $tigv = 0;
              $t = $st+$tigv;
           } 
         echo $st." - ".$dsct_val." - ".$tigv." - ".$t;          
         
         $idmoneda = 1; //Soles
         $tipocambio=0;
         $fecha = date('Y-m-d');         
         $fehcaemision = $this->fdate($_P['fechaemision'],'EN');
         $estado = 1;
         $idsucursal = $_SESSION['idsucursal'];
         $usuarioreg = $_SESSION['idusuario'];
         $idtipopago = $_P['idtipopago'];         
         $idcliente = $_P['idcliente'];
         $serie = '';
         $numero = '';
         $idtipodocumento = 7; //No declara    
         $idalmacen = $_P['idalmacen'];        

         $sql = "INSERT INTO facturacion.movimiento(
                        fecha, idtipodocumento, documentoserie, 
                        documentonumero, documentofecha, idcliente, idmoneda, tipocambio, 
                        subtotal, porcentajeigv, total, pagoestado,  estado, 
                        idusuarioreg, fechareg, obs, igv,  
                        tipodescuento, idtipopago,idalmacen,descuento)
                VALUES (:p2, :p3, :p4, 
                        :p5, :p6, :p7, :p8, :p9, 
                        :p10, :p11, :p12, :p13,:p15, 
                        :p16, :p17, :p21, :p22, 
                        :p23, :p24,:p25,:p26); ";
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            $stmt = $this->db->prepare($sql);            
            $stmt->bindParam(':p2',$fecha,PDO::PARAM_STR);
            $stmt->bindParam(':p3',$idtipodocumento,PDO::PARAM_INT);
            $stmt->bindParam(':p4',$serie,PDO::PARAM_STR);
            $stmt->bindParam(':p5',$numero,PDO::PARAM_STR);
            $stmt->bindParam(':p6',$fehcaemision,PDO::PARAM_STR);
            $stmt->bindParam(':p7',$idcliente,PDO::PARAM_INT);
            $stmt->bindParam(':p8',$idmoneda,PDO::PARAM_INT);
            $stmt->bindParam(':p9',$tipocambio,PDO::PARAM_INT);
            $stmt->bindParam(':p10',$st,PDO::PARAM_INT);
            $stmt->bindParam(':p11',$igv,PDO::PARAM_INT);
            $stmt->bindParam(':p12',$t,PDO::PARAM_INT);
            $stmt->bindParam(':p13',$estado,PDO::PARAM_INT);
            
            $stmt->bindParam(':p15',$estado,PDO::PARAM_INT);
            $stmt->bindParam(':p16',$usuarioreg,PDO::PARAM_INT);
            $stmt->bindParam(':p17',$fecha,PDO::PARAM_STR);
            $stmt->bindParam(':p21',$_P['observacion'],PDO::PARAM_STR);
            $stmt->bindParam(':p22',$tigv,PDO::PARAM_INT);
            
            
            $stmt->bindParam(':p23',$tdsct,PDO::PARAM_INT);
            $stmt->bindParam(':p24',$_P['idtipopago'],PDO::PARAM_INT);
            $stmt->bindParam(':p25',$idalmacen,PDO::PARAM_INT);
            $stmt->bindParam(':p26',$dsct_val,PDO::PARAM_INT);

            $stmt->execute();
            $id =  $this->IdlastInsert('facturacion.movimiento','idmovimiento');


            //Insertamos los detalles de la venta
            $detalle = $this->db->prepare("INSERT INTO facturacion.movimientodetalle(
                                            idmovimiento, idproducto, item, cantidad, precio)
                                            VALUES (:p1, :p2, :p3, :p4, :p5);");
            $itm = 0;
            for($i=0;$i<$item;$i++)
            {
                if($prod->estado[$i])
                {
                    $itm += 1;
                    $detalle->bindParam(':p1',$id,PDO::PARAM_INT);
                    $detalle->bindParam(':p2',$prod->idproducto[$i],PDO::PARAM_INT);
                    $detalle->bindParam(':p3',$itm,PDO::PARAM_INT);
                    $detalle->bindParam(':p4',$prod->cantidad[$i],PDO::PARAM_INT);
                    $detalle->bindParam(':p5',$prod->precio[$i],PDO::PARAM_INT);
                    $detalle->execute();

                    //Afectar stock de los productos
                    //Aqui
                }
            }

            //Cuotas
            if($idtipopago==2)
            {
                $estado = 0;
                $observacion = "";

                $cuotas = $this->db->prepare("INSERT INTO facturacion.movimientocuotas(
                                                      idmovimiento, monto, monto_saldado, fechareg, 
                                                      fechapago, estado, observacion, tipo)
                                              VALUES (:p1, :p2, 0, :p4, 
                                                      :p5, :p6, :p7, :p8);");                
                //Inicial
                $tipo = 1;
                if($_P['inicial']>0)
                {
                   $cuotas->bindParam(':p1',$id,PDO::PARAM_INT);
                   $cuotas->bindParam(':p2',$_P['inicial'],PDO::PARAM_INT);
                   //$cuotas->bindParam(':p3','',PDO::PARAM_INT);
                   $cuotas->bindParam(':p4',$fecha,PDO::PARAM_STR);
                   $cuotas->bindParam(':p5',$fecha,PDO::PARAM_STR);
                   $cuotas->bindParam(':p6',$estado,PDO::PARAM_INT);
                   $cuotas->bindParam(':p7',$observacion,PDO::PARAM_STR);
                   $cuotas->bindParam(':p8',$tipo,PDO::PARAM_INT);
                   $cuotas->execute();
                }

                $tipo = 2;
                foreach($_P['totalcouta'] as $k => $v)   
                {
                   
                   $cuotas->bindParam(':p1',$id,PDO::PARAM_INT);
                   $cuotas->bindParam(':p2',$v,PDO::PARAM_INT);
                   //$cuotas->bindParam(':p3','',PDO::PARAM_INT);
                   $cuotas->bindParam(':p4',$fecha,PDO::PARAM_STR);
                   $cuotas->bindParam(':p5',$_P['fechacuota'][$k],PDO::PARAM_STR);
                   $cuotas->bindParam(':p6',$estado,PDO::PARAM_INT);
                   $cuotas->bindParam(':p7',$observacion,PDO::PARAM_STR);
                   $cuotas->bindParam(':p8',$tipo,PDO::PARAM_INT);
                   $cuotas->execute();
                }
            }

            //Pagos
            $pagos = json_decode($_P['pagos']);         
            $item = $pagos->nitem;
            $total_pago = 0;
            for($i=0;$i<$item;$i++)
            {
                if($pagos->estado[$i])
                {
                    $total_pago += $pagos->monto[$i];
                }
            }

            $descuento = 0;
            $observacion_pago = "";
            $idtipodocumento = $_P['idtipodocumento'];
            
            $comprobante = $obj_td->GCorrelativo($idtipodocumento);
            $obj_td->UpdateCorrelativo($idtipodocumento);

            $pago = $this->db->prepare("INSERT INTO facturacion.movimientospago(
                                    idmovimiento, fecha, total, descuento, observacion, 
                                    idtipodocumento, serie, numero)
                                    VALUES (:p1, :p2, :p3, :p4, :p5, 
                                            :p6, :p7, :p8)");
            $pago->bindParam(':p1',$id,PDO::PARAM_INT);
            $pago->bindParam(':p2',$fecha,PDO::PARAM_STR);
            $pago->bindParam(':p3',$total_pago,PDO::PARAM_INT);
            $pago->bindParam(':p4',$descuento,PDO::PARAM_INT);
            $pago->bindParam(':p5',$observacion_pago,PDO::PARAM_STR);
            $pago->bindParam(':p6',$idtipodocumento,PDO::PARAM_INT);
            $pago->bindParam(':p7',$comprobante['serie'],PDO::PARAM_STR);
            $pago->bindParam(':p8',$comprobante['numero'],PDO::PARAM_STR);
            $pago->execute();

            $idp =  $this->IdlastInsert('facturacion.movimientospago','idmovimientopago');

            //
            if($idtipopago==1)
            {
              //Actualizamos las series y numero del documento generado
              //echo "AAA".$idtipodocumento."AAA";
              $updt_mov = $this->db->prepare("UPDATE facturacion.movimiento set documentoserie = :serie, 
                                                            documentonumero = :numero,
                                                            idtipodocumento = :idtd
                                  where idmovimiento = :id");
              $updt_mov->bindParam(':serie',$comprobante['serie'],PDO::PARAM_STR);
              $updt_mov->bindParam(':numero',$comprobante['numero'],PDO::PARAM_STR);
              $updt_mov->bindParam(':idtd',$idtipodocumento,PDO::PARAM_INT);
              $updt_mov->bindParam(':id',$id,PDO::PARAM_INT);
              $updt_mov->execute();
            }

            $pagodetalle = $this->db->prepare("INSERT INTO facturacion.mov_pagodetalle(
                                                idmovimientopago, idformapago, monto, nrotarjeta, nrocheque, 
                                                bancocheque, fechavcheque, observacion, estado,nrovoucher)
                                        VALUES (:p1, :p2, :p3, :p4, :p5, 
                                                :p6, :p7, :p8, :p9,:p10);");
            $observacion='';
            $estado = 1;
            for($i=0;$i<$item;$i++)
            {
                if($pagos->estado[$i])
                {
                    $f = $pagos->fechav[$i];
                    if(trim($f)=="")
                        $f = date('Y-m-d');
                    else 
                        $f = $this->fdate($f,'EN');

                    $pagodetalle->bindParam(':p1',$idp,PDO::PARAM_INT);
                    $pagodetalle->bindParam(':p2',$pagos->idformapago[$i],PDO::PARAM_INT);
                    $pagodetalle->bindParam(':p3',$pagos->monto[$i],PDO::PARAM_INT);
                    $pagodetalle->bindParam(':p4',$pagos->nrotarjeta[$i],PDO::PARAM_STR);
                    $pagodetalle->bindParam(':p5',$pagos->nrocheque[$i],PDO::PARAM_STR);
                    $pagodetalle->bindParam(':p6',$pagos->banco[$i],PDO::PARAM_STR);
                    $pagodetalle->bindParam(':p7',$f,PDO::PARAM_STR);
                    $pagodetalle->bindParam(':p8',$observacion,PDO::PARAM_STR);
                    $pagodetalle->bindParam(':p9',$estado,PDO::PARAM_INT);
                    $pagodetalle->bindParam(':p10',$pagos->nrovoucher[$i],PDO::PARAM_STR);
                    $pagodetalle->execute();

                    if($idtipopago==2)
                    {
                       //Si es al credito se hace el pago de la inicial
                       $idpd =  $this->IdlastInsert('facturacion.mov_pagodetalle','idmovimientopago');

                       $monto_pago = $pagos->monto[$i];
                       do
                       {
                          $s = $this->db->prepare("SELECT * from facturacion.movimientocuotas 
                                                  where idmovimiento = {$id} and estado = 0 
                                                  order by idmovimientocuota asc limit 1");
                          $s->execute();
                          $row = $s->fetchObject();
                          $mont_p = $row->monto-$row->monto_saldado;
                          if($mont_p>$monto_pago)
                          {
                             $s1 = $this->db->prepare("UPDATE facturacion.movimientocuotas
                                                        SET monto_saldado = monto_saldado + {$monto_pago}
                                                       where idmovimientocuota = {$row->idmovimientocuota}");
                             $s1->execute();
                             $s2 = $this->db->prepare("INSERT INTO facturacion.mov_pagocuota 
                                                      values({$idpd},{$row->idmovimientocuota})");
                             $s2->execute();
                             $monto_pago = 0;
                          }
                          else
                          {                             
                             $fecha = date('Y-m-d');
                             $s1 = $this->db->prepare("UPDATE facturacion.movimientocuotas
                                                        SET monto_saldado = monto_saldado + {$mont_p},
                                                            estado = 1,
                                                            fechapagoe = '{$fecha}'
                                                       where idmovimientocuota = {$row->idmovimientocuota}");
                             $s1->execute();
                             $s2 = $this->db->prepare("INSERT INTO facturacion.mov_pagocuota 
                                                      values({$idpd},{$row->idmovimientocuota})");
                             $s2->execute();                            
                             $monto_pago = $monto_pago - $mont_p;
                          }

                       }
                       while($monto_pago>0);
                    }

                }
            }

            $this->db->commit();
            return array('1','Bien!',$id);
        }
        catch(PDOException $e)
        {
            $this->db->rollBack();
            return array('2',$e->getMessage().$str,'');
        }
         
    }

    function update($_P ) 
    {
        $sql = "UPDATE seguridad.modulo set  idpadre=:p1,
                                   descripcion=:p2,
                                   url=:p3,
                                   estado=:p5,
                                   orden=:p6,
                                   controlador=:p7,
                                   accion=:p8
                       where idmodulo = :idmodulo";
        $stmt = $this->db->prepare($sql);
        if($_P['idpadre']==""){$_P['idpadre']=null;}        
            $stmt->bindParam(':p1', $_P['idpadre'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['url'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $_P['activo'] , PDO::PARAM_BOOL);
            $stmt->bindParam(':p6', $_P['orden'] , PDO::PARAM_INT);
            $stmt->bindParam(':idmodulo', $_P['idmodulo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p7', $_P['controlador'] , PDO::PARAM_STR);
            $stmt->bindParam(':p8', $_P['accion'] , PDO::PARAM_STR);   
            
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM seguridad.modulo WHERE idmodulo = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>