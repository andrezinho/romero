<?php
include_once("Main.php");
class Produccion extends Main
{    
    //indexGridi -> Grilla del index de ingresos.
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
        p.idproduccion,
        p.descripcion,
        pe.nombres || ' ' || pe.apellidos AS personal,
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

        $prod = json_decode($_P['prod']);                
        $item = $prod->item;        
        for($i=0;$i<$item;$i++)
        {
            echo $prod->descripcion[$i]."<br/>";
            $items = $prod->materiap[$i]->nitem;            
            for($j=0;$j<$items;$j++)
            {                
                $cant = $prod->materiap[$i]->cantidad->{$j};
                echo $cant;
                echo "<br/>";
            }
        }
        

        die;

        $sql="INSERT INTO produccion.produccion(
            descripcion, fechaini, fechafin, estado, idpersonal)
            VALUES (:p1, :p2, :p3, :p4,:p5)";
        $stmt = $this->db->prepare($sql);
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();
                $stmt->bindParam(':p1',$descripcion,PDO::PARAM_STR);
                $stmt->bindParam(':p2',$fechai,PDO::PARAM_STR);
                $stmt->bindParam(':p3',$fechaf,PDO::PARAM_STR);
                $stmt->bindParam(':p4',$estado,PDO::PARAM_INT);
                $stmt->bindParam(':p5',$idpersonal,PDO::PARAM_STR);
            $stmt->execute();
            $id =  $this->IdlastInsert('produccion.produccion','idproduccion');
            $row = $stmt->fetchAll();

            $stmt2  = $this->db->prepare('INSERT INTO produccion.produccion_detalle(
            idproduccion, idsubproductos_semi, cantidad, stock, estado)
                VALUES (:p1, :p2, :p3, :p4, :p5) ');
            $estado = 1;

            //
            foreach($_P['idsubproductos_semi'] as $i => $idsubproducto)
                {
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idsubproducto,PDO::PARAM_INT);                    
                    $stmt2->bindParam(':p3',$_P['cantd'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$_P['cantd'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p5',$estado,PDO::PARAM_INT);
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