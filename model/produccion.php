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
        INNER JOIN public.personal AS pe ON pe.dni = p.idpersonal ";
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
        $fechai=$_P['fechai'];
        $fechaf=$_P['fechaf'];
        $descripcion=$_P['descripcion'];
        $estado=1;
        $idpersonal=$_P['dni'];

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
            $id =  $this->lastInsertId('produccion.produccion','idproduccion');
            $row = $stmt->fetchAll();

            $stmt2  = $this->db->prepare('INSERT INTO produccion.produccion_detalle(
            idproduccion, idproductos_semi, cantidad, stock, estado)
                VALUES (:p1, :p2, :p3, :p4, :p5) ');

            $estado = 1;

            foreach($_P['idtipod'] as $i => $idsubproducto)
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