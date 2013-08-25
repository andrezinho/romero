<?php
include_once("Main.php");
class Produccion extends Main
{    
    //indexGridi -> Grilla del index de ingresos.
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
        p.idproduccion,
        upper(p.descripcion),
        upper(pe.nombres || ' ' || pe.apellidos) AS personal,
        p.fechaini,
        p.fechafin,
        case p.estado when 1 then 'ACTIVO' else 'INCANTIVO' end
        
        FROM
        produccion.produccion AS p
        INNER JOIN public.personal AS pe ON pe.idpersonal = p.idpersonal ";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT
            p.idproduccion,
            p.descripcion,
            p.fechaini,
            p.fechafin,
            case p.estado when 1 then 'ACTIVO' else 'INCANTIVO' end,
            p.estado,
            p.idpersonal,
            pe.nombres || ' ' || pe.apellidos AS personal,
            pe.dni
            FROM
            produccion.produccion AS p
            INNER JOIN public.personal AS pe ON pe.idpersonal = p.idpersonal
            WHERE idproduccion = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT
            d.idproduccion,
            d.idsubproductos_semi,
            d.cantidad,
            pr.descripcion || ', ' || spr.descripcion AS descripcion
            FROM
            produccion.produccion AS p
            INNER JOIN produccion.produccion_detalle AS d ON p.idproduccion = d.idproduccion
            INNER JOIN produccion.subproductos_semi AS spr ON spr.idsubproductos_semi = d.idsubproductos_semi
            INNER JOIN produccion.productos_semi AS pr ON pr.idproductos_semi = spr.idproductos_semi

            WHERE d.idproduccion = :id    
            ORDER BY d.idproduccion ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function insert($_P ) 
    {
        // $prod = json_decode($_P['prod']);
        // $item = $prod->item;
        // for($i=0;$i<$item;$i++)
        // {
        //     echo $prod->descripcion[$i]."<br/>";
        //     $items = $prod->materiap[$i]->nitem;
        //     for($j=0;$j<$items;$j++)
        //     {
        //         print_r($prod->materiap[$i]);
        //         echo "<br/>";
        //         $cant = $prod->materiap[$i]->cantidad->{$j};
        //         echo $cant;
        //         echo "<br/>";
        //     }
        // }
        // die;
        $idmovimientostipo = 12; //Salida por produccion
        $idmoneda = 1; //Soles
        $fecha = date('Y-m-d');
        $referencia =  'SALIDAS';
        $estado = 1;
        $idsucursal = 1;
        $usuarioreg = $_SESSION['dni'];
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

            $prod = json_decode($_P['prod']);
            $item = $prod->item;        
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

            //Ahora insertamos la produccion.
            $fechai=$_P['fechai'];
            $fechaf=$_P['fechaf'];
            $descripcion=$_P['descripcion'];
            $estado=1;
            $idpersonal=$_P['dni'];
            $idpersonal=$_P['idpersonal'];
            $sql="INSERT INTO produccion.produccion(
                        descripcion, fechaini, fechafin, estado, idpersonal, idalmacen)
                VALUES (:p1, :p2, :p3, :p4,:p5,:p6)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p1',$descripcion,PDO::PARAM_STR);
            $stmt->bindParam(':p2',$fechai,PDO::PARAM_STR);
            $stmt->bindParam(':p3',$fechaf,PDO::PARAM_STR);
            $stmt->bindParam(':p4',$estado,PDO::PARAM_INT);
            $stmt->bindParam(':p5',$idpersonal,PDO::PARAM_STR);
            $stmt->bindParam(':p6',$idalmacenp,PDO::PARAM_INT);
            $stmt->execute();

            $idprod =  $this->IdlastInsert('produccion.produccion','idproduccion');

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
        
        $fechai=$_P['fechai'];
        $fechaf=$_P['fechaf'];
        $descripcion=$_P['descripcion'];
        $estado=1;
        $idpersonal=$_P['idpersonal'];
        $idproduccion= $_P['idproduccion'];

        $del="DELETE FROM produccion.produccion_detalle
                    WHERE idproduccion='$idproduccion' ";
                    
            $res = $this->db->prepare($del);
            $res->execute();

        $sql = "UPDATE produccion.produccion 
                    set 
                        descripcion=:p1,
                        fechaini=:p2,
                        fechafin=:p3,
                        estado=:p4,
                        idpersonal=:p5

                WHERE   idproduccion = :idproduccion";
        $stmt = $this->db->prepare($sql);
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            $stmt->bindParam(':p1', $descripcion , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $fechai , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $fechaf , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $estado , PDO::PARAM_INT);
            $stmt->bindParam(':p5', $idpersonal , PDO::PARAM_INT);

            $stmt->bindParam(':idproduccion', $idproduccion , PDO::PARAM_INT);
            $stmt->execute();

            $stmt2  = $this->db->prepare('INSERT INTO produccion.produccion_detalle(
            idproduccion, idsubproductos_semi, cantidad, stock, estado)
                VALUES (:p1, :p2, :p3, :p4, :p5) ');

            $estado = 1;

                foreach($_P['idsubproductos_semi'] as $i => $idsubproducto)
                {
                    $stmt2->bindParam(':p1',$idproduccion,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idsubproducto,PDO::PARAM_INT);                    
                    $stmt2->bindParam(':p3',$_P['cantd'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$_P['cantd'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p5',$estado,PDO::PARAM_INT);
                    
                    $stmt2->execute();                

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
        $stmt = $this->db->prepare("DELETE FROM produccion.produccion WHERE idproduccion = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>