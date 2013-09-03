<?php
include_once("Main.php");
include_once("movimiento.php");
class acabado extends Main
{    
    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        
        $sql = "SELECT  a.idacabado,
                        ps.descripcion||' '||sps.descripcion,
                        upper(pe.nombres || ' ' || pe.apellidos) AS personal,
                        a.cantidad,
                        substr(cast(a.fecha as text),9,2)||'/'||substr(cast(a.fecha as text),6,2)||'/'||substr(cast(a.fecha as text),1,4),
                        '<p style=\"color:green\">'||substr(cast(a.fechaini as text),9,2)||'/'||substr(cast(a.fechaini as text),6,2)||'/'||substr(cast(a.fechaini as text),1,4)||'</p>',
                        '<p style=\"color:red\">'||substr(cast(a.fechafin as text),9,2)||'/'||substr(cast(a.fechafin as text),6,2)||'/'||substr(cast(a.fechafin as text),1,4)||'</p>',                    
                        al.descripcion,
                        case a.estado when 1 then 'REGISTRADO'
                              when 2 then 'FINALIZADO'                                   
                              WHEN 0 THEN 'ANULADO'
                              else '&nbsp;' end,
                        case a.estado when 1 then
                           case a.usuarioreg when '".$_SESSION['idusuario']."' then
                           '<a class=\"anular box-boton boton-anular\" id=\"a-'||a.idacabado||'\" href=\"#\" title=\"Anular\" ></a>'
                           else
                            case ".$_SESSION['id_perfil']." when 1 then
                            '<a class=\"anular box-boton boton-anular\" id=\"a-'||a.idacabado||'\" href=\"#\" title=\"Anular\" ></a>'
                            else '&nbsp;'
                            end
                           end
                        else '&nbsp;'
                        end,
                        case p.estado when 1 
                        then '<a class=\"finalizar box-boton boton-hand\" id=\"f-'||a.idacabado||'\" href=\"#\" title=\"Finalizar acabado\" ></a>'
                            when 2
                        then '<a class=\"box-boton boton-ok\" title=\"Finalizado el acabado\" ></a>'
                        else '&nbsp;' end
                    FROM produccion.acabado AS a
                    INNER JOIN public.personal AS pe ON pe.idpersonal = a.idpersonal 
                    inner join produccion.produccion_detalle as pd on pd.idproduccion_detalle = a.idproduccion_detalle
                    inner join produccion.subproductos_semi as sps on sps.idsubproductos_semi = pd.idsubproductos_semi
                    inner join produccion.productos_semi as ps on ps.idproductos_semi = sps.idproductos_semi
                    inner join produccion.produccion as p on p.idproduccion = pd.idproduccion
                    inner join produccion.almacenes as al on al.idalmacen = p.idalmacen";
        
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT  a.*,
                                            pe.nombres || ' ' || pe.apellidos AS personal,
                                            pe.dni,
                                            ps.descripcion||' '||sps.descripcion as producto,
                                            pd.cantidad as tprod,
                                            (pd.stock+a.cantidad) as stock,
                                            pe2.nombres || ' ' || pe2.apellidos AS responsable
                                    FROM produccion.acabado AS a
                                         INNER JOIN public.personal AS pe ON pe.idpersonal = a.idpersonal 
                                            inner join produccion.produccion_detalle as pd on pd.idproduccion_detalle = a.idproduccion_detalle
                                            inner join produccion.subproductos_semi as sps on sps.idsubproductos_semi = pd.idsubproductos_semi
                                            inner join produccion.productos_semi as ps on ps.idproductos_semi = sps.idproductos_semi
                                            inner join produccion.produccion as p on p.idproduccion = pd.idproduccion
                                            inner join produccion.almacenes as al on al.idalmacen = p.idalmacen
                                            inner join personal as pe2 on pe2.idpersonal = p.idpersonal
                                    WHERE a.idacabado = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT m.idmateriales,
                                            m.descripcion,
                                            am.idunidad_medida,
                                            um.descripcion,
                                            am.cantidad 
                                    from produccion.acabadoxmateriales as am
                                    inner join produccion.materiales as m on m.idmateriales = am.idmateriales
                                    inner join unidad_medida as um on um.idunidad_medida = am.idunidad_medida
                                    WHERE am.idacabado = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idmaterial'=>$r[0],'material'=>$r[1],'idunidad'=>$r[2],'unidad'=>$r[3],'cantidad'=>$r[4]);
        }
        return $data;
    }

    function insert($_P ) 
    {             
         $materiales = json_decode($_P['materiales']);                  
         $item = $materiales->nitem;
         $cont_ma = 0;
         for($i=0;$i<$item;$i++)
         {
            if($materiales->estado[$i])
                $cont_ma ++;
         }
         
        $fechai=$this->fdate($_P['fechai'],"EN");
        $fechaf=$this->fdate($_P['fechaf'],"EN");
        $observacion=$_P['observacion'];
        $estado=1;
        $idpersonal=$_P['idpersonal'];
        $usuarioreg = $_SESSION['idusuario'];
        $cantidad = $_P['cantidad'];
        $fecha = date('Y-m-d');
        $idproduccion_detalle = $_P['idproduccion_detalle'];
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $sql="INSERT INTO produccion.acabado(
                                idproduccion_detalle, 
                                idpersonal, 
                                cantidad, 
                                fechaini,
                                fechafin,
                                usuarioreg, 
                                observacion,
                                estado,
                                fecha)
                VALUES (:p1, :p2, :p3, :p4,:p5,:p6,:p7,:p8,:p9)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p1',$idproduccion_detalle,PDO::PARAM_INT);
            $stmt->bindParam(':p2',$idpersonal,PDO::PARAM_INT);
            $stmt->bindParam(':p3',$cantidad,PDO::PARAM_INT);
            $stmt->bindParam(':p4',$fechai,PDO::PARAM_STR);
            $stmt->bindParam(':p5',$fechaf,PDO::PARAM_STR);
            $stmt->bindParam(':p6',$usuarioreg,PDO::PARAM_INT);            
            $stmt->bindParam(':p7',$observacion,PDO::PARAM_STR);            
            $stmt->bindParam(':p8',$estado,PDO::PARAM_INT);
            $stmt->bindParam(':p9',$fecha,PDO::PARAM_STR);            
            $stmt->execute();

            $idacabado =  $this->IdlastInsert('produccion.acabado','idacabado');


            $stmt = $this->db->prepare("UPDATE produccion.produccion_detalle set stock = stock - :c 
                                        where idproduccion_detalle = :id");
            $stmt->bindParam(':c',$cantidad,PDO::PARAM_INT);
            $stmt->bindParam(':id',$idproduccion_detalle,PDO::PARAM_INT);
            $stmt->execute();

            if($cont_ma>0)
            {
                $stmt2  = $this->db->prepare('INSERT INTO produccion.acabadoxmateriales(
                                                    idacabado, idmateriales, idunidad_medida, cantidad)
                                                VALUES (:p1, :p2, :p3, :p4) ');
                
                $estado = 1;                
                for($i=0;$i<$item;$i++)
                {
                    //$items = $prod->materiap[$i]->nitem;
                    $idmaterial = $materiales->idmaterial[$i];
                    $idunidad = $materiales->idunidad[$i];
                    $cantidad = $materiales->cantidad[$i];

                    $stmt2->bindParam(':p1',$idacabado,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idmaterial,PDO::PARAM_INT);
                    $stmt2->bindParam(':p3',$idunidad,PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$cantidad,PDO::PARAM_INT);                    
                    $stmt2->execute();
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
        $prod = json_decode($_P['prod']);
        $item = $prod->item;        
        $cont_prod = 0;
        for($i=0;$i<$item;$i++)
        {
            if($prod->estado[$i])
                $cont_prod ++;
        }
        
        $idmovimientostipo = 12; //Salida por produccion
        $idmoneda = 1; //Soles
        $fecha = date('Y-m-d');
        $referencia =  'SALIDAS';
        $estado = 1;
        $idsucursal = 1;
        $usuarioreg = $_SESSION['idusuario'];

        $idtipodocumento = 7;        
        $serie = '';
        $numero = '';
        $fechae =  date('Y-m-d');
        $idproveedor = 1;        
        $idformapago = 3; //No declara
        $guia_serie = '';
        $guia_numero = '';
        $fecha_guia =  date('Y-m-d');        
        $afecto=0;
        $idalmacen = $_P['idalmacenma']; //Almacen de movimiento
        $idalmacenp = $_P['idalmacenma'];; //Almacen de produccion
        $igv = 0;

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

            if($cont_prod>0)
            {
                $stmt->bindParam(':p1',$idmovimientostipo,PDO::PARAM_INT);
                $stmt->bindParam(':p2',$idmoneda,PDO::PARAM_INT);
                $stmt->bindParam(':p3',$fecha,PDO::PARAM_STR);
                $stmt->bindParam(':p4',$referencia,PDO::PARAM_STR);
                $stmt->bindParam(':p5',$estado,PDO::PARAM_INT);
                $stmt->bindParam(':p6',$idsucursal,PDO::PARAM_INT);
                $stmt->bindParam(':p7',$usuarioreg,PDO::PARAM_INT);
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

                $stmt2 = $this->db->prepare('INSERT INTO movimientosdetalle(
                                                                idmovimiento, idalmacen, item, idproducto,
                                                                 idtipoproducto, cantidad, precio, estado, 
                                                                 largo,alto,espesor,ctotal,ctotal_current) 
                                                    values(:p1, :p2, :p3, :p4, :p5, :p6, 
                                                           :p7, :p8, :p9,:p10,:p11,:p12,:p13);');
                
                $stmt3 = $this->db->prepare('UPDATE produccion.producto 
                                                        set stock = stock - :cant
                                                     WHERE idproducto = :idp');
                
                $stmt4 = $this->db->prepare('SELECT max(idmovimiento) as idm ,ctotal_current as c
                                                FROM movimientosdetalle
                                                where idtipoproducto = :idtp and idalmacen = :ida and idproducto = :idp
                                                group by ctotal_current,item
                                                order by item desc
                                                limit 1');
                $estado = 1;
                $items = 1;

                      
                for($i=0;$i<$item;$i++)
                {
                    $ite = $prod->materiap[$i]->nitem;
                    if($prod->estado[$i])
                    {
                        for($j=0;$j<$ite;$j++)
                        {
                            if($prod->materiap[$i]->estado->{$j})
                            {
                                $largo = 0; $alto = 0; $espesor = 0;
                                $too = (float)$prod->materiap[$i]->cantidad->{$j};
                                $idproducto = $prod->materiap[$i]->idproducto->{$j};
                                $idt = $prod->materiap[$i]->idt->{$j};

                                $stmt4->bindParam(':idtp',$idproducto,PDO::PARAM_INT);
                                $stmt4->bindParam(':ida',$idalmacen,PDO::PARAM_INT);
                                $stmt4->bindParam(':idp',$idproducto,PDO::PARAM_INT);
                                $stmt4->execute();
                                $row4 = $stmt4->fetchObject();                    
                                $too_current = (float)$row4->c - $too;

                                $cant = 1;
                                $precio = 0;

                                $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);
                                $stmt2->bindParam(':p2',$idalmacen,PDO::PARAM_INT);
                                $stmt2->bindParam(':p3',$items,PDO::PARAM_INT);
                                $stmt2->bindParam(':p4',$idproducto,PDO::PARAM_INT);
                                $stmt2->bindParam(':p5',$idt,PDO::PARAM_INT);
                                $stmt2->bindParam(':p6',$cant,PDO::PARAM_INT);
                                $stmt2->bindParam(':p7',$precio,PDO::PARAM_INT);
                                $stmt2->bindParam(':p8',$estado,PDO::PARAM_INT);
                                $stmt2->bindParam(':p9',$largo,PDO::PARAM_INT);
                                $stmt2->bindParam(':p10',$alto,PDO::PARAM_INT);
                                $stmt2->bindParam(':p11',$espesor,PDO::PARAM_INT);
                                $stmt2->bindParam(':p12',$too,PDO::PARAM_INT);
                                $stmt2->bindParam(':p13',$too_current,PDO::PARAM_INT);
                                $stmt2->execute();
                                $items += 1;

                                $stmt3->bindParam(':cant',$too,PDO::PARAM_INT);                    
                                $stmt3->bindParam(':idp',$idproducto,PDO::PARAM_INT);
                                $stmt3->execute();
                            }                        
                        }
                    }                
                }
            }



            $fechai=$_P['fechai'];
            $fechaf=$_P['fechaf'];
            $descripcion=$_P['descripcion'];
            $estado=1;
            $idpersonal=$_P['idpersonal'];
            $idproduccion= $_P['idproduccion'];

            $sql = "UPDATE produccion.produccion 
                        set 
                            descripcion=:p1,
                            fechaini=:p2,
                            fechafin=:p3,
                            estado=:p4,
                            idpersonal=:p5

                    WHERE   idproduccion = :idproduccion";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p1', $descripcion , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $fechai , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $fechaf , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $estado , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $idpersonal , PDO::PARAM_INT);

            $stmt->bindParam(':idproduccion', $idproduccion , PDO::PARAM_INT);
            $stmt->execute();

            $idprod = $idproduccion;
            if($cont_prod>0)
            {
                $stmt2  = $this->db->prepare('INSERT INTO produccion.produccion_detalle(
                                            idproduccion, 
                                            idsubproductos_semi, 
                                            cantidad, 
                                            stock, 
                                            estado)
                                            VALUES (:p1, :p2, :p3, :p4, :p5) ');
                $stmt3 = $this->db->prepare("INSERT INTO produccion.movim_proddet(
                                                idmovimiento,
                                            idproduccion_detalle) 
                                             values (:p1,:p2) ");
                $estado = 1;
                //$items = 1;
                for($i=0;$i<$item;$i++)
                {
                    //$items = $prod->materiap[$i]->nitem;
                    $idsps = $prod->idsps[$i];
                    $cantd = $prod->cantidad[$i];

                    $stmt2->bindParam(':p1',$idprod,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idsps,PDO::PARAM_INT);
                    $stmt2->bindParam(':p3',$cantd,PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$cantd,PDO::PARAM_INT);
                    $stmt2->bindParam(':p5',$estado,PDO::PARAM_INT);
                    $stmt2->execute();

                    $iddprod =  $this->IdlastInsert('produccion.produccion_detalle','idproduccion_detalle');

                    $stmt3->bindParam(':p1',$id,PDO::PARAM_INT);
                    $stmt3->bindParam(':p2',$iddprod,PDO::PARAM_INT);
                    $stmt3->execute();
                }
            }

            $this->db->commit();            
            return array('1','Bien!',$idproduccion);

        }
        catch(PDOException $e) 
            {
                $this->db->rollBack();
                return array('2',$e->getMessage().$str,'');
            } 
    }
    
    function delete($p) 
    {        
        $objmov = new movimiento();
        $stmtd = $this->db->prepare("SELECT distinct idmovimiento
                from produccion.movim_proddet as mp
                    inner join produccion.produccion_detalle as pd
                    on mp.idproduccion_detalle =
                      pd.idproduccion_detalle
                WHERE pd.idproduccion=:id");
        $stmtd->bindParam(':id',$p,PDO::PARAM_INT);
        $stmtd->execute();

        //Anulamos la produccion
        $stmtp = $this->db->prepare("UPDATE produccion.produccion set estado = 0 where idproduccion = :id");
        $stmtp->bindParam(':id',$p,PDO::PARAM_INT);
        $stmtp->execute();

        foreach($stmtd->fetchAll() as $r)
        {                
            $r = $objmov->delete($r['idmovimiento']);
        }
        return $r;        
    }

    function end($p)
    {
        $stmt = $this->db->prepare("UPDATE produccion.produccion set estado = 2
                                    where idproduccion = :id and estado = 1");
        $stmt->bindParam(':id',$p,PDO::PARAM_INT);
        $r = $stmt->execute();
        if($r) return array("1",'Ok, esta produccion fue finalizada');
            else return array("2",'Ha ocurrido un error, porfavor intentelo nuevamente');
    }
}
?>