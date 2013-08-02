<?php
include_once("Main.php");
class Personal extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query)
    {
        $offset = ($page-1)*$limit;
        $query = "%".$query."%";
        $sql = "SELECT
            p.dni,
            p.nombres,
            p.apellidos,
            p.telefono,
            p.direccion,
            p.sexo,
            p.estcivil,
            p.estado
            FROM
            public.personal AS p ";

        if($filtro!="") 
        $sql .= " where ".$filtro." ilike :query ";
        $sql .= " order by {$sidx} {$sord}
                 limit {$limit}
                 offset  {$offset} "; 
        
        $stmt = $this->db->prepare($sql);
        
        if($filtro!="") 
        $stmt->bindParam(':query',$query,PDO::PARAM_STR);
        $stmt->execute();
        
        $responce->records = $stmt->rowCount();
        $responce->page = $page;
        $responce->total = "1";        
        $i = 0;
        foreach($stmt->fetchAll() as $i => $row)
        {
            $responce->rows[$i]['id']=$row[0];
            $responce->rows[$i]['cell']=array($row[0],$row[1],$row[2],$row[3],$row[4],$row[5],$row[6],$row[7]);
            $i ++;
        }
        return $responce;
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM personal WHERE dni = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO personal(dni, nombres, apellidos, telefono, direccion, sexo, estcivil, estado)
                                    values(:p1,:p2,:p3,:p5,:p6,:p7,:p8)");
        //if($_P['dni']==""){$_P['dni']=null;}        
        $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['nombres'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['sexo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['estcivil'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['estado'] , PDO::PARAM_INT);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }
    function update($_P ) 
    {
        $sql = "UPDATE personal set 
                                   nombres=:p2,
                                   apellidos=:p3,
                                   telefono=:p4,
                                   direccion=:p5,
                                   sexo=:p6,
                                   estcivil=:p7,
                                   estado=:p8
                       where dni = :dni";
        $stmt = $this->db->prepare($sql);
                
            //$stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['nombres'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);            
            $stmt->bindParam(':p6', $_P['sexo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p7', $_P['estcivil'] , PDO::PARAM_STR);   
            $stmt->bindParam(':p8', $_P['estado'] , PDO::PARAM_INT);
            $stmt->bindParam(':dni', $_P['dni'] , PDO::PARAM_STR);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM personal WHERE dni = :p1");
        $stmt->bindParam(':p1', $p, PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
}
?>