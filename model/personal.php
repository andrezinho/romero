<?php
include_once("Main.php");
class Personal extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            p.idpersonal,
            p.dni,
            p.nombres,
            p.apellidos,
            p.telefono,
            p.direccion,
            p.sexo,
            e.descripcion,
            case p.estado when 1 then 'ACTIVO' else 'INCANTIVO' end

            FROM
            personal AS p
            INNER JOIN estado_civil AS e ON e.idestado_civil = p.idestado_civil ";
        
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM personal WHERE idpersonal = :id");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function insert($_P ) 
    {
        $stmt = $this->db->prepare("INSERT INTO personal(dni, nombres, apellidos, telefono, direccion, sexo, idestado_civil,
                        estado,idarea,idcargo,idperfil, usuario,clave,ruc)
                        values(:p1,:p2,:p3,:p5,:p6,:p7,:p8,:p9,:p10,:p11,:p12,:p13, :p14)");
             
        $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
        $stmt->bindParam(':p2', $_P['nombres'] , PDO::PARAM_STR);
        $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);        
        $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
        $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
        $stmt->bindParam(':p6', $_P['sexo'] , PDO::PARAM_STR);
        $stmt->bindParam(':p7', $_P['idestado_civil'] , PDO::PARAM_INT);
        $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p9', $_P['idarea'] , PDO::PARAM_INT);
        $stmt->bindParam(':p10', $_P['idcargo'] , PDO::PARAM_INT);
        $stmt->bindParam(':p11', $_P['idperfil'] , PDO::PARAM_INT);
        $stmt->bindParam(':p12', $_P['usuario'] , PDO::PARAM_STR);
        $stmt->bindParam(':p13', $_P['clave'] , PDO::PARAM_STR);
        $stmt->bindParam(':p14', $_P['ruc'] , PDO::PARAM_STR);

        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        
        return array($p1 , $p2[2]);
        
    }

    function update($_P ) 
    {
        $sql = "UPDATE personal set 
                            dni = :p1,
                           nombres=:p2,
                           apellidos=:p3,
                           telefono=:p4,
                           direccion=:p5,
                           sexo=:p6,
                           idestado_civil=:p7,
                           estado=:p8,
                           idarea=:p9,
                           idcargo=:p10,
                           idperfil=:p11,
                           usuario=:p12,
                           clave=:p13,
                           ruc=:p14

                       where idpersonal = :idpersonal";
        $stmt = $this->db->prepare($sql);
                
            $stmt->bindParam(':p1', $_P['dni'] , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $_P['nombres'] , PDO::PARAM_STR);
            $stmt->bindParam(':p3', $_P['apellidos'] , PDO::PARAM_STR);        
            $stmt->bindParam(':p4', $_P['telefono'] , PDO::PARAM_STR);
            $stmt->bindParam(':p5', $_P['direccion'] , PDO::PARAM_STR);
            $stmt->bindParam(':p6', $_P['sexo'] , PDO::PARAM_STR);
            $stmt->bindParam(':p7', $_P['idestado_civil'] , PDO::PARAM_INT);
            $stmt->bindParam(':p8', $_P['activo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p9', $_P['idarea'] , PDO::PARAM_INT);
            $stmt->bindParam(':p10', $_P['idcargo'] , PDO::PARAM_INT);
            $stmt->bindParam(':p11', $_P['idperfil'] , PDO::PARAM_INT);
            $stmt->bindParam(':p12', $_P['usuario'] , PDO::PARAM_STR);
            $stmt->bindParam(':p13', $_P['clave'] , PDO::PARAM_STR);
            $stmt->bindParam(':p14', $_P['ruc'] , PDO::PARAM_STR);

            $stmt->bindParam(':idpersonal', $_P['idpersonal'] , PDO::PARAM_INT);
        $p1 = $stmt->execute();
        $p2 = $stmt->errorInfo();
        return array($p1 , $p2[2]);
    }
    
    function delete($p) 
    {
        $stmt = $this->db->prepare("DELETE FROM personal WHERE idpersonal = :p1");
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