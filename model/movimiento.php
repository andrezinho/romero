<?php
include_once("Main.php");
class movimiento extends Main
{   
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT  m.idmovimiento,
                        m.fecha,
                        m.referencia,
                        td.abreviado,
                        m.serie,
                        m.numero,
                        m.fechae,
                        p.razonsocial,
                        p.ruc,
                        case m.afecto when 1 then '18%' else '' end,
                        t.total as subtotal,
                        cast(t.total*m.igv/100+t.total as numeric(18,2)) as total,
                        case m.estado when 1 then 'Activo'
                                      when 2 then 'Anulado'
                             else ''
                        end,
                        case m.estado when 1 then
                           case m.usuarioreg when '".$_SESSION['dni']."' then
                           '<a class=\"anular box-boton boton-anular\" id=\"v-'||m.idmovimiento||'\" href=\"#\" title=\"Anular\" ></a>'
                           else
                                case ".$_SESSION['id_perfil']." when 1 then
                                '<a class=\"anular box-boton boton-anular\" id=\"v-'||m.idmovimiento||'\" href=\"#\" title=\"Anular\" ></a>'
                                else '&nbsp;'
                                end
                           end
                        else '&nbsp;'
                        end
                    FROM movimientos as m inner join movimientostipo as mt on
                        mt.idmovimientostipo = m.idmovimientostipo
                        inner join facturacion.tipodocumento as td on td.idtipodocumento = m.idtipodocumento
                        inner join proveedor as p on p.idproveedor = m.idproveedor
                        inner join (select idmovimiento,sum(precio*cantidad) as total
                                    from movimientosdetalle 
                                    group by idmovimiento) as t on t.idmovimiento = m.idmovimiento 
                    WHERE mt.idmovimientostipo = 1 ";                   
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }
    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT m.*,p.ruc,p.razonsocial
                                    FROM movimientos as m
                                        inner join proveedor as p on p.idproveedor = m.idproveedor
                                    WHERE idmovimiento = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }    
    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT mv.* ,
                                            case mv.idtipoproducto when 1 then p.descripcion
                                                        when 2 then l.descripcion||', '||ma.descripcion||' '||ma.espesor||' - '||p.medidas
                                            else ''
                                            end as descripcion
                                        FROM movimientosdetalle as mv inner join produccion.producto as p on p.idproducto = mv.idproducto
                                            inner join produccion.maderba as ma on ma.idmaderba = p.idmaderba
                                            inner join produccion.linea as l on l.idlinea = ma.idlinea
                                        WHERE idmovimiento = :id    
                                        order by item ");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    function insert($_P) 
    {
        $idmovimientostipo = $_P['idmovimientosubtipo']; //Ingreso de Materia Prima
        $idmoneda = 1; //Soles
        $fecha = date('Y-m-d');
        $referencia = $_P['referencia'];
        $estado = 1;
        $idsucursal = 1;
        $usuarioreg = $_SESSION['dni'];
        $idtipodocumento = $_P['idtipodocumento'];
        if($idtipodocumento=="") $idtipodocumento=7; //No definido
        $serie = $_P['serie'];
        $numero = $_P['numero'];
        $fechae =  $this->fdate($_P['fechae'],'EN');
        $idproveedor = $_P['idproveedor'];
        if($idproveedor=="") $idproveedor = 1;
        $idformapago = $_P['idformapago'];
        $guia_serie = $_P['guia_serie'];
        $guia_numero = $_P['guia_numero'];
        $fecha_guia =  $this->fdate($_P['fecha_guia'],'EN');
        if(isset($_P['afecto'])) $afecto = 1;
            else $afecto=0;
        $idalmacen = $_P['idalmacen'];
        $igv = $_P['igv_val'];

        $stmt = $this->db->prepare("SELECT idmovimientostipo from movimientosubtipo
                                    where idmovimientosubtipo = :id");
        $stmt->bindParam(':id',$idmovimientosubtipo,PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchObject();
        $idmovimientostipo = $r->idmovimientostipo;

        $sql = "INSERT INTO movimientos(idmovimientosubtipo, idmoneda, fecha, referencia, 
                                        estado, idsucursal, usuarioreg, idtipodocumento, serie, numero, 
                                        fechae, idproveedor, idformapago, guia_serie, guia_numero, 
                                        fecha_guia, afecto, idalmacen, igv) 
                            values(:p1, :p2, :p3, :p4, 
                                        :p5, :p6, :p7, :p8, :p9, :p10, 
                                        :p11, :p12, :p13, :p14, :p15, 
                                        :p16, :p17, :p18, :p19)";
        $stmt = $this->db->prepare($sql);
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

                $stmt->bindParam(':p1',$idmovimientostipo,PDO::PARAM_INT);
                $stmt->bindParam(':p2',$idmoneda,PDO::PARAM_INT);
                $stmt->bindParam(':p3',$fecha,PDO::PARAM_STR);
                $stmt->bindParam(':p4',$referencia,PDO::PARAM_STR);
                $stmt->bindParam(':p5',$estado,PDO::PARAM_INT);
                $stmt->bindParam(':p6',$idsucursal,PDO::PARAM_INT);
                $stmt->bindParam(':p7',$usuarioreg,PDO::PARAM_STR);
                $stmt->bindParam(':p8',$idtipodocumento,PDO::PARAM_INT);
                $stmt->bindParam(':p9',$serie,PDO::PARAM_STR);
                $stmt->bindParam(':p10',$numero,PDO::PARAM_STR);
                $stmt->bindParam(':p11',$fechae,PDO::PARAM_STR);
                $stmt->bindParam(':p12',$idproveedor,PDO::PARAM_INT);
                $stmt->bindParam(':p13',$idformapago,PDO::PARAM_INT);
                $stmt->bindParam(':p14',$guia_serie,PDO::PARAM_STR);
                $stmt->bindParam(':p15',$guia_numero,PDO::PARAM_STR);
                $stmt->bindParam(':p16',$fecha_guia,PDO::PARAM_STR);
                $stmt->bindParam(':p17',$afecto,PDO::PARAM_INT);
                $stmt->bindParam(':p18',$idalmacen,PDO::PARAM_INT);
                $stmt->bindParam(':p19',$igv,PDO::PARAM_INT);

                $stmt->execute();
                $id =  $this->IdlastInsert('movimientos','idmovimiento');
                $row = $stmt->fetchAll();

                $stmt2  = $this->db->prepare('INSERT INTO movimientosdetalle(
                                                            idmovimiento, idalmacen, item, idproducto,
                                                             idtipoproducto, cantidad, precio, estado, 
                                                             largo,alto,espesor,ctotal,ctotal_current) 
                                                values(:p1, :p2, :p3, :p4, :p5, :p6, 
                                                       :p7, :p8, :p9,:p10,:p11,:p12,:p13);');                
                if($idmovimientostipo==1)
                {
                    //ingresos
                    $stmt3 = $this->db->prepare('UPDATE produccion.producto 
                                                    set stock = stock + :cant
                                                 WHERE idproducto = :idp');
                }
                else
                {
                    //salidas
                    $stmt3 = $this->db->prepare('UPDATE produccion.producto 
                                                    set stock = stock - :cant
                                                 WHERE idproducto = :idp');
                }


                $stmt4 = $this->db->prepare('SELECT max(idmovimiento) as idm ,ctotal_current as c
                                            FROM movimientosdetalle
                                            where idtipoproducto = :idtp and idalmacen = :ida and idproducto = :idp
                                            group by ctotal_current,item
                                            order by item desc
                                            limit 1');

                $estado = 1;
                $item = 1;

                foreach($_P['idtipod'] as $i => $idproducto)
                {
                    $largo = 0;
                    if($_P['largod'][$i]!="") $largo = $_P['largod'][$i];
                    $alto = 0;
                    if($_P['altod'][$i]!="") $alto = $_P['altod'][$i];
                    $espesor = 0;
                    if($_P['espesord'][$i]!="") $espesor = $_P['espesord'][$i];

                    if($_P['tipod'][$i]==1) $too = $_P['cantd'][$i]*$largo*$alto*$espesor/12;
                        else $too = $_P['cantd'][$i];

                    $stmt4->bindParam(':idtp',$idproducto,PDO::PARAM_INT);
                    $stmt4->bindParam(':ida',$idalmacen,PDO::PARAM_INT);
                    $stmt4->bindParam(':idp',$idproducto,PDO::PARAM_INT);
                    $stmt4->execute();
                    $row4 = $stmt4->fetchObject();
                    if($idmovimientostipo==1) 
                        $too_current = (float)$row4->c + $too;
                    else 
                        $too_current = (float)$row4->c - $too;

                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idalmacen,PDO::PARAM_INT);
                    $stmt2->bindParam(':p3',$item,PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$idproducto,PDO::PARAM_INT);
                    $stmt2->bindParam(':p5',$_P['tipod'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p6',$_P['cantd'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p7',$_P['preciod'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p8',$estado,PDO::PARAM_INT);
                    $stmt2->bindParam(':p9',$largo,PDO::PARAM_INT);
                    $stmt2->bindParam(':p10',$alto,PDO::PARAM_INT);
                    $stmt2->bindParam(':p11',$espesor,PDO::PARAM_INT);
                    $stmt2->bindParam(':p12',$too,PDO::PARAM_INT);
                    $stmt2->bindParam(':p13',$too_current,PDO::PARAM_INT);
                    $stmt2->execute();
                    $item += 1;
                    
                    $stmt3->bindParam(':cant',$too,PDO::PARAM_INT);                    
                    $stmt3->bindParam(':idp',$idproducto,PDO::PARAM_INT);
                    $stmt3->execute();
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
    
    function delete($p) 
    {
        try 
        {
            $stmt = $this->db->prepare("UPDATE movimientos set estado = 2 WHERE idmovimiento = :p1 and estado = 1");            
            $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
            $stmt->execute();

            $stmt2 = $this->db->prepare("SELECT idproducto,cantidad from movimientosdetalle where idmovimiento = :p1");
            $stmt2->bindParam(':p1', $p, PDO::PARAM_INT);
            $stmt2->execute();

            $stmt3 = $this->db->prepare("UPDATE produccion.producto 
                                                SET stock = stock - :cant 
                                         WHERE idproducto = :idp");
            foreach($stmt2->fetchAll() as $r)
            {   
                $stmt3->bindParam(':cant',$r['cantidad'],PDO::PARAM_INT);
                $stmt3->bindParam(':idp',$r['idproducto'],PDO::PARAM_INT);
                $stmt3->execute();
            }

            $this->db->commit();            
            return array('1','Bien!');
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('2',$e->getMessage().$str);
        }
    }
}
?>