<?php
include_once("Main.php");
class Proformas extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            p.idproforma,
            c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno AS nomcliente,
            s.descripcion,
            p.fecha,
            case p.estado when 0 then 'REGISTRADO' else 'PASO A SOLICITUD' end            
            
            FROM
            facturacion.proforma AS p
            INNER JOIN cliente AS c ON c.idcliente = p.idcliente
            INNER JOIN sucursales AS s ON s.idsucursal = p.idsucursal ";    
            
            return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT
            p.idproforma,
            c.dni,
            c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno AS cliente,
            p.idsucursal,
            p.idcliente,
            p.fecha,
            p.estado,
            p.hora,
            p.observacion
            FROM
            cliente AS c
            INNER JOIN facturacion.proforma AS p ON c.idcliente = p.idcliente 
            WHERE idproforma = :id ");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT
            p.idproforma,
            dp.idproforma,
            dp.idproducto,
            dp.tipo,
            tp.descripcion,
            dp.preciocash,
            dp.inicial,
            dp.nromeses,
            dp.cuota,
            dp.cantidad,
            dp.idfinanciamiento,
            dp.producto
            FROM
            facturacion.proforma AS p
            INNER JOIN facturacion.proformadetalle AS dp ON p.idproforma = dp.idproforma
            INNER JOIN produccion.tipopago AS tp ON tp.idtipopago = dp.tipo
            LEFT JOIN produccion.subproductos_semi AS pr ON pr.idsubproductos_semi = dp.idproducto

            WHERE dp.idproforma = :id    
            ORDER BY dp.iddet_proforma ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function insert($_P ) {
        $idvendedor=1;
        $estado= 0;
        $sql="INSERT INTO facturacion.proforma(
            idsucursal, idcliente, fecha,hora, estado, observacion,idvendedor) 
            VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7)" ;

        $stmt = $this->db->prepare($sql);

        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            $stmt->bindParam(':p1', $_P['idsucursal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['idcliente'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['fecha'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['hora'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $estado , PDO::PARAM_INT);
            $stmt->bindParam(':p6', $_P['observacion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p7', $idvendedor , PDO::PARAM_STR);
            $stmt->execute();
            $id =  $this->IdlastInsert('facturacion.proforma','idproforma');
            $row = $stmt->fetchAll();


            $stmt2  = $this->db->prepare("INSERT INTO facturacion.proformadetalle(
            idproforma, idsucursal, tipo, preciocash, inicial, 
            nromeses, cuota, idfinanciamiento, producto,cantidad,idproducto)
                VALUES ( :p1, :p2,:p3, :p4,:p5, :p6,:p7, :p8,:p9,:p10,:p11) ");

            $stmt3  = $this->db->prepare("INSERT INTO facturacion.proformadetalle(
            idproforma, idsucursal, tipo,preciocash, producto,cantidad,idproducto)
                VALUES ( :p1, :p2,:p3, :p4,:p9,:p10,:p11) ");

                foreach($_P['idtipopago'] as $i => $idtipopago)
                {                    
                    if($idtipopago==2)
                    {
                        $stmt2->bindParam(':p1',$idproforma,PDO::PARAM_INT);
                        $stmt2->bindParam(':p2',$_P['idsucursal'],PDO::PARAM_INT);
                        $stmt2->bindParam(':p3',$idtipopago,PDO::PARAM_INT);
                        $stmt2->bindParam(':p4',$_P['precio'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p5',$_P['inicial'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p6',$_P['nromeses'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p7',$_P['mensual'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p8',$_P['idfinanciamiento'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p9',$_P['producto'][$i],PDO::PARAM_STR);
                        $stmt2->bindParam(':p10',$_P['cantidad'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p11',$_P['idproducto'][$i],PDO::PARAM_INT);
                        $stmt2->execute();
                    } else
                        {
                            $stmt3->bindParam(':p1',$idproforma,PDO::PARAM_INT);
                            $stmt3->bindParam(':p2',$_P['idsucursal'],PDO::PARAM_INT);
                            $stmt3->bindParam(':p3',$idtipopago,PDO::PARAM_INT);
                            $stmt3->bindParam(':p4',$_P['precio'][$i],PDO::PARAM_INT);
                            //$stmt2->bindParam(':p5',$_P['inicial'][$i],PDO::PARAM_INT);
                            //$stmt2->bindParam(':p6',$_P['nromeses'][$i],PDO::PARAM_INT);
                            //$stmt2->bindParam(':p7',$_P['mensual'][$i],PDO::PARAM_INT);
                            //$stmt2->bindParam(':p8',$_P['idfinanciamiento'][$i],PDO::PARAM_INT);
                            $stmt3->bindParam(':p9',$_P['producto'][$i],PDO::PARAM_STR);
                            $stmt3->bindParam(':p10',$_P['cantidad'][$i],PDO::PARAM_INT);
                            $stmt3->bindParam(':p11',$_P['idproducto'][$i],PDO::PARAM_INT);
                            $stmt3->execute();
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

    function update($_P ) {

        $idproforma= $_P['idproforma'];
        $idvendedor=1;

        $del="DELETE FROM facturacion.proformadetalle
                    WHERE idproforma='$idproforma' ";
                    
        $res = $this->db->prepare($del);
        $res->execute();
            
        $sql="UPDATE facturacion.proforma 
            set 
                idsucursal = :p1, 
                idcliente = :p2, 
                fecha =:p3,
                hora = :p4,
                observacion = :p5,
                idvendedor= :p6                         
                
                WHERE idproforma = :idproforma";
        $stmt = $this->db->prepare($sql);

        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            $stmt->bindParam(':p1', $_P['idsucursal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p2', $_P['idcliente'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['fecha'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['hora'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $_P['observacion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p6', $idvendedor , PDO::PARAM_STR);
                       
            $stmt->bindParam(':idproforma', $idproforma , PDO::PARAM_INT);
            $stmt->execute();
            
            $stmt2  = $this->db->prepare("INSERT INTO facturacion.proformadetalle(
            idproforma, idsucursal, tipo, preciocash, inicial, 
            nromeses, cuota, idfinanciamiento, producto,cantidad,idproducto)
                VALUES ( :p1, :p2,:p3, :p4,:p5, :p6,:p7, :p8,:p9,:p10,:p11) ");

            $stmt3  = $this->db->prepare("INSERT INTO facturacion.proformadetalle(
            idproforma, idsucursal, tipo,preciocash, producto,cantidad,idproducto)
                VALUES ( :p1, :p2,:p3, :p4,:p9,:p10,:p11) ");

                foreach($_P['idtipopago'] as $i => $idtipopago)
                {   
                    if($idtipopago==2)
                    {
                        $stmt2->bindParam(':p1',$idproforma,PDO::PARAM_INT);
                        $stmt2->bindParam(':p2',$_P['idsucursal'],PDO::PARAM_INT);
                        $stmt2->bindParam(':p3',$idtipopago,PDO::PARAM_INT);
                        $stmt2->bindParam(':p4',$_P['precio'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p5',$_P['inicial'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p6',$_P['nromeses'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p7',$_P['mensual'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p8',$_P['idfinanciamiento'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p9',$_P['producto'][$i],PDO::PARAM_STR);
                        $stmt2->bindParam(':p10',$_P['cantidad'][$i],PDO::PARAM_INT);
                        $stmt2->bindParam(':p11',$_P['idproducto'][$i],PDO::PARAM_INT);
                        $stmt2->execute();
                    } else
                        {
                            $stmt3->bindParam(':p1',$idproforma,PDO::PARAM_INT);
                            $stmt3->bindParam(':p2',$_P['idsucursal'],PDO::PARAM_INT);
                            $stmt3->bindParam(':p3',$idtipopago,PDO::PARAM_INT);
                            $stmt3->bindParam(':p4',$_P['precio'][$i],PDO::PARAM_INT);
                            //$stmt2->bindParam(':p5',$_P['inicial'][$i],PDO::PARAM_INT);
                            //$stmt2->bindParam(':p6',$_P['nromeses'][$i],PDO::PARAM_INT);
                            //$stmt2->bindParam(':p7',$_P['mensual'][$i],PDO::PARAM_INT);
                            //$stmt2->bindParam(':p8',$_P['idfinanciamiento'][$i],PDO::PARAM_INT);
                            $stmt3->bindParam(':p9',$_P['producto'][$i],PDO::PARAM_STR);
                            $stmt3->bindParam(':p10',$_P['cantidad'][$i],PDO::PARAM_INT);
                            $stmt3->bindParam(':p11',$_P['idproducto'][$i],PDO::PARAM_INT);
                            $stmt3->execute();
                        }
                    
                }

            $this->db->commit();            
            return array('1','Bien!',$idproforma);

        }
        catch(PDOException $e) 
            {
                $this->db->rollBack();
                return array('2',$e->getMessage().$str,'');
            } 
        
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM facturacion.caja WHERE idproforma = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>