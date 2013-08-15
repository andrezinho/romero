<?php
include_once("Main.php");
class Personal extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT p.dni,
                        p.nombres,
                        p.apellidos,
                        p.telefono,
                        p.direccion,
                        p.sexo,
                        p.estcivil,
                        p.estado
                FROM
                public.personal AS p ";
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
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
        $stmt = $this->db->prepare("INSERT INTO personal(dni, nombres, apellidos, telefono, direccion, sexo, estcivil, estado,idarea,idcargo)
                                    values(:p1,:p2,:p3,:p5,:p6,:p7,:p8,:p9,:p10)");
             
        $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['nombres'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['sexo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['estcivil'] , PDO::PARAM_STR);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['idarea'] , PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['idcargo'] , PDO::PARAM_INT);

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
                                   estado=:p8,
                                   idarea=:p9,
                                   idcargo=:p10
                       where dni = :dni";
        $stmt = $this->db->prepare($sql);
                
            //$stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['nombres'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);
            $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);            
            $stmt->bindParam(':p6', $_P['sexo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p7', $_P['estcivil'] , PDO::PARAM_STR);   
            $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p9', $_P['idarea'] , PDO::PARAM_INT);
            $stmt->bindParam(':p10', $_P['idcargo'] , PDO::PARAM_INT);

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

    function get($query,$field)
    {
        $query = "%".$query."%";
        $statement = $this->db->prepare("SELECT 
                                            idpersonal,
                                            dni, 
                                            nombres || ' ' || apellidos AS nompersonal
                                                
                                         FROM personal
                                         WHERE {$field} like :query and dni <> ''
                                         limit 10");
        $statement->bindParam (":query", $query , PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }

}
?>