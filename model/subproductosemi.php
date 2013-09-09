<?php
include_once("Main.php");
class SubProductoSemi extends Main
{
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            p.idsubproductos_semi,
            ps.descripcion,
            p.descripcion,
            p.precio,            
            case p.estado when 1 then 'ACTIVO' else 'INCANTIVO' end            

            FROM
            produccion.subproductos_semi AS p
            INNER JOIN produccion.productos_semi AS ps ON ps.idproductos_semi = p.idproductos_semi "; 

        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id ) {
        $stmt = $this->db->prepare("SELECT * FROM produccion.subproductos_semi WHERE idsubproductos_semi = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }

    function insert($_P ) {
        $stmt = $this->db->prepare("INSERT INTO produccion.subproductos_semi 
                        (descripcion,idproductos_semi, estado, precio,idunidad_medida,factor, observacion) 
                        VALUES(:p1,:p2,:p3,:p4,:p5,:p6,:p7)");
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['idproductos_semi'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['precio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['idunidad_medida'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['factor'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['obs'] , PDO::PARAM_STR);
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function update($_P ) {
        $stmt = $this->db->prepare("UPDATE produccion.subproductos_semi 
                set descripcion = :p1,
                    idproductos_semi = :p2,
                    estado= :p3,
                    precio= :p4,
                    idunidad_medida= :p5,
                    factor= :p6,
                    observacion= :p7

                WHERE idsubproductos_semi = :idsubproductos_semi ");
        
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['idproductos_semi'] , PDO::PARAM_INT);
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p4', $_P['precio'] , PDO::PARAM_INT);
        $stmt->bindParam(':p5', $_P['idunidad_medida'] , PDO::PARAM_INT);
        $stmt->bindParam(':p6', $_P['factor'] , PDO::PARAM_INT);
        $stmt->bindParam(':p7', $_P['obs'] , PDO::PARAM_STR);
        
        $stmt->bindParam(':idsubproductos_semi', $_P['idsubproductos_semi'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($_P ) {
        $stmt = $this->db->prepare("DELETE FROM produccion.subproductos_semi WHERE idsubproductos_semi = :p1");
        $stmt->bindParam(':p1', $_P , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }

    function getList($idl=null)
    {
        $sql = "SELECT idsubproductos_semi, descripcion from produccion.subproductos_semi ";
        if($idl!=null)
        {
            $sql .= " WHERE idproductos_semi = {$idl}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = array();
        foreach($stmt->fetchAll() as $r)
        {
            $data[] = array('idsubproductos_semi'=>$r[0],'descripcion'=>$r[1]);
        }
        return $data;
    }

    function get($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT
                                            sps.idsubproductos_semi,
                                            ps.descripcion || ' ' || sps.descripcion AS producto,
                                            sps.precio
                                            FROM
                                            produccion.productos_semi AS ps
                                            INNER JOIN produccion.subproductos_semi AS sps ON ps.idproductos_semi = sps.idproductos_semi
                                            
                                            WHERE {$field} ilike :query and ps.descripcion || ' ' || sps.descripcion <> ''
                                                    AND ps.idproductos_semi <> 1
                                            limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }

    function stock($idalmacenp,$idsps)
    {        
        $stmt4 = $this->db->prepare("SELECT t.idp,t.c
                                    from (
                                    SELECT max(idproduccion) as idp ,ctotal as c, item
                                    FROM produccion.produccion_detalle
                                    where idalmacen = :idal and idsubproductos_semi = :idsps
                                    group by ctotal,item,idproduccion
                                    order by idproduccion desc
                                    limit 1
                                    ) as t
                                    order by t.item,t.c");
        $stmt4->bindParam(':idal',$idalmacenp,PDO::PARAM_INT);
        $stmt4->bindParam(':idsps',$idsps,PDO::PARAM_INT);
        $stmt4->execute();
        $row4 = $stmt4->fetchObject();                 
        return $row4->c;
    }
}
?>