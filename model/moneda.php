<?php
include_once("Main.php");
class Moneda extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = " SELECT
                idmoneda,
                descripcion,
                simbolo,
                case nacional when 1 then 'NACIONAL' else 'OTROS' end
                
                FROM
                moneda";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
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
        $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);        
        
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) 
    {
        $sql = "UPDATE moneda 
                set  descripcion=:p1,
                    simbolo=:p2,
                    nacional=:p3
                                   
                WHERE idmoneda = :idmoneda";
        $stmt = $this->db->prepare($sql);
            
            $stmt->bindParam(':p1', $_P['descripcion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['simbolo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['activo'] , PDO::PARAM_INT);
            
            $stmt->bindParam(':idmoneda', $_P['idmoneda'] , PDO::PARAM_INT);


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