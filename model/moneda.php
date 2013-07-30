<?php
include_once("Main.php");
class Moneda extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query)
    {
        $offset = ($page-1)*$limit;
        $query = "%".$query."%";
        $sql = " SELECT
                idmoneda,
                descripcion,
                simbolo,
                case nacional when 1 then 'NACIONAL' else 'OTROS' end
                
                FROM
                moneda";
        //print_r($sql);
        if($filtro!="") //$sql .= " WHERE ".$filtro." ilike :query ";
        $sql .= " where cast(".$filtro." as varchar) ilike :query ";

        $sql .= " order by {$sidx} {$sord}
                 limit {$limit}
                 offset  {$offset} "; 
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':query',$query,PDO::PARAM_STR);
        $stmt->execute();
        
        $responce->records = $stmt->rowCount();
        $responce->page = $page;
        $responce->total = "1";        
        $i = 0;
        foreach($stmt->fetchAll() as $i => $row)
        {
            $responce->rows[$i]['id']=$row[0];
            $responce->rows[$i]['cell']=array($row[0],$row[1],$row[2],$row[3]);
            $i ++;
        }
        return $responce;
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM moneda WHERE idmoneda = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO moneda(descripcion,simbolo,nacional)
                                    values(:p1,:p2,:p3) ");
        //if($_P['descripcion']==""){$_P['descripcion']=null;}        
        $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);       
        $stmt->bindParam(':p2', $_P['simbolo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['nacional'] , PDO::PARAM_INT);        
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }
    function update($_P ) 
    {
        $sql = "UPDATE moneda set  descripcion=:p1,
                                   simbolo=:p2,
                                   nacional=:p3
                                   
                       where idmoneda = :idmoneda";
        $stmt = $this->db->prepare($sql);
        //if($_P['idpadre']==""){$_P['idpadre']=null;}        
            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['simbolo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['nacional'] , PDO::PARAM_INT);
            
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM moneda WHERE idmoneda = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>