<?php
include_once("Main.php");
class HojaRuta extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            h.idhojarutas,
            h.descripcion,
            p.nombres || ' ' || p.apellidos AS personal,
            z.descripcion || ' - ' || u.descripcion AS zonas,
            h.fechareg

            FROM
            public.hojarutas AS h
            INNER JOIN public.personal AS p ON p.idpersonal = h.idpersonal
            INNER JOIN public.zona AS z ON z.idzona = h.idzona
            INNER JOIN public.ubigeo AS u ON u.idubigeo = z.idubigeo ";    
            
            return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT
            h.idhojarutas,
            h.descripcion,
            h.idpersonal,
            p.dni,
            p.nombres || ' ' || p.apellidos AS personal,
            z.idubigeo,
            h.idzona,
            h.fechareg

            FROM
            hojarutas AS h
            INNER JOIN personal AS p ON p.idpersonal = h.idpersonal
            INNER JOIN zona AS z ON z.idzona = h.idzona
            INNER JOIN ubigeo AS u ON u.idubigeo = z.idubigeo
            WHERE idhojarutas = :id ");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT
            dh.idcliente,
            dh.idsubproductos_semi,
            c.dni,
            c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno as cliente,
            c.direccion,
            c.telefono,
            sp.descripcion || ' '|| sps.descripcion as producto,
            dh.cantidad,
            dh.observacion

            FROM
            public.hojarutas_detalle AS dh
            INNER JOIN public.cliente AS c ON c.idcliente = dh.idcliente
            INNER JOIN produccion.subproductos_semi AS sps ON sps.idsubproductos_semi = dh.idsubproductos_semi
            INNER JOIN produccion.productos_semi AS sp ON sp.idproductos_semi = sps.idproductos_semi
            WHERE dh.idhojarutas = :id    
            ORDER BY dh.idsubproductos_semi ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function insert($_P ) {

        $sql="INSERT INTO hojarutas(
            descripcion, idpersonal, idzona, fechareg) 
                    VALUES(:p1,:p2,:p3,:p4)" ;

        $stmt = $this->db->prepare($sql);
        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
            $_P['fechareg']=$this->fdate($_P['fechareg'], 'EN');
            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['idpersonal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['idzona'] , PDO::PARAM_INT);
            $stmt->bindParam(':p4', $_P['fechareg'], PDO::PARAM_INT);
            $stmt->execute();
            $id =  $this->IdlastInsert('hojarutas','idhojarutas');
            $row = $stmt->fetchAll();

            $stmt2  = $this->db->prepare("INSERT INTO hojarutas_detalle(
            idhojarutas, idcliente, idsubproductos_semi,observacion, cantidad)
                VALUES ( :p1, :p2,:p3, :p4,:p5) ");

                foreach($_P['idcliente'] as $i => $idcliente)
                {                    
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);                    
                    $stmt2->bindParam(':p2',$idcliente,PDO::PARAM_INT);
                    $stmt2->bindParam(':p3',$_P['idsubproductos_semi'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$_P['observacion'][$i],PDO::PARAM_STR);
                    $stmt2->bindParam(':p5',$_P['cantidad'][$i],PDO::PARAM_INT);                    
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

        $idhojarutas= $_P['idhojarutas'];
        
        $del="DELETE FROM hojarutas_detalle
             WHERE idhojarutas='$idhojarutas' ";
                    
            $res = $this->db->prepare($del);
            $res->execute();
            
        $sql="UPDATE hojarutas 
                set descripcion = :p1, 
                    idpersonal= :p2, 
                    idzona = :p3,
                    fechareg= :p4
                
                WHERE idhojarutas = :idhojarutas";
        $stmt = $this->db->prepare($sql);

        try 
        {
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['idpersonal'] , PDO::PARAM_INT);
            $stmt->bindParam(':p3', $_P['idzona'] , PDO::PARAM_INT);
            $stmt->bindParam(':p4', $_P['fechareg'] , PDO::PARAM_INT);
           
            $stmt->bindParam(':idhojarutas', $idhojarutas , PDO::PARAM_INT);
            $stmt->execute();
            $id =  $this->IdlastInsert('hojarutas','idhojarutas');
            $row = $stmt->fetchAll();
            
            $stmt2  = $this->db->prepare("INSERT INTO hojarutas_detalle(
            idhojarutas, idcliente, idsubproductos_semi,observacion, cantidad)
                VALUES ( :p1, :p2,:p3, :p4,:p5) ");

                foreach($_P['idcliente'] as $i => $idcliente)
                {                    
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);                    
                    $stmt2->bindParam(':p2',$idcliente,PDO::PARAM_INT);
                    $stmt2->bindParam(':p3',$_P['idsubproductos_semi'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$_P['observacion'][$i],PDO::PARAM_STR);
                    $stmt2->bindParam(':p5',$_P['cantidad'][$i],PDO::PARAM_INT);                    
                    $stmt2->execute();             

                }

            $this->db->commit();            
            return array('1','Bien!',$idhojarutas);

        }
        catch(PDOException $e) 
            {
                $this->db->rollBack();
                return array('2',$e->getMessage().$str,'');
            } 
        
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM hojarutas WHERE idhojarutas = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>