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
            p.estado
            FROM
            facturacion.proforma AS p
            INNER JOIN cliente AS c ON c.idcliente = p.idcliente
            INNER JOIN sucursales AS s ON s.idsucursal = p.idsucursal ";    
            
            return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM facturacion.caja WHERE idproforma = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT
            d.idproformaxpersonal,
            d.idpersonal,
            p.dni,
            p.nombres || ' ' || p.apellidos AS personal

            FROM
            facturacion.cajaxpersonal AS d
            INNER JOIN facturacion.caja AS c ON c.idproforma = d.idproforma
            INNER JOIN personal AS p ON p.idpersonal = d.idpersonal

            WHERE d.idproforma = :id    
            ORDER BY d.idpersonal ");

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

                foreach($_P['idtipopago'] as $i => $idtipopago)
                {                    
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);
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
        
         $del="DELETE FROM facturacion.cajaxpersonal
                    WHERE idproforma='$idproforma' ";
                    
            $res = $this->db->prepare($del);
            $res->execute();
            
        $sql="UPDATE facturacion.caja 
                set nombre = :p1, 
                descripcion= :p2, 
                estado = :p3              
                
                WHERE idproforma = :idproforma";
        $stmt = $this->db->prepare($sql);

        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            $stmt->bindParam(':p1', $_P['nombre'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
           
            $stmt->bindParam(':idproforma', $idproforma , PDO::PARAM_INT);
            $stmt->execute();
            
            $stmt2  = $this->db->prepare("INSERT INTO facturacion.cajaxpersonal(
                            idpersonal, idproforma)
                        VALUES ( :p1, :p2) ");

                foreach($_P['idpersonal'] as $i => $idpersonal)
                {
                    $stmt2->bindParam(':p1',$idpersonal,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idproforma,PDO::PARAM_INT);                    
                   
                    $stmt2->execute();                

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