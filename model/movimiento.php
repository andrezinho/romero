<?php
include_once("Main.php");
class movimiento extends Main
{   
    function indexGridi($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT * FROM produccion.movimiento";
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
        $idmovimientostipo = 1; //Ingreso de Materia Prima
        $idmoneda = 1; //Soles
        $fecha = date('Y-m-d');
        $referencia = $_P['referencia'];
        $estado = 1;
        $idsucursal = 1;
        $usuarioreg = $_SESSION['dni'];
        $idtipodocumento = $_P['idtipodocumento'];
        if($idtipodocumento=="") $idtipodocumento=7; //No definido
        $serie = $_P['serie'];
        $numero = $_P['numero'];
        $fechae =  $this->fdate($_P['fechae'],'EN');
        $idproveedor = $_P['idproveedor'];
        if($idproveedor=="") $idproveedor = 1;
        $idformapago = $_P['idformapago'];
        $guia_serie = $_P['guia_serie'];
        $guia_numero = $_P['guia_numero'];
        $fecha_guia =  $this->fdate($_P['fecha_guia'],'EN');
        if(isset($_P['afecto'])) $afecto = 1;
        $idalmacen = $_P['idalmacen'];
        $igv = $_P['igv_val'];

        $sql = "INSERT INTO movimientos(idmovimientostipo, idmoneda, fecha, referencia, 
                                        estado, idsucursal, usuarioreg, idtipodocumento, serie, numero, 
                                        fechae, idproveedor, idformapago, guia_serie, guia_numero, fecha_guia, 
                                        afecto, idalmacen, igv) 
                            values(:p1, :p2, :p3, :p4, :p5, :p6, :p7, :p8, :p9, :p10, 
                                    :p11, :p12, :p13, :p14, :p15, :p16, :p17, :p18)";
        $stmt = $this->db->prepare($sql);
        try 
        { 
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->beginTransaction();

                $stmt->bindParam(':p1',$idmovimientostipo,PDO::PARAM_INT);
                $stmt->bindParam(':p2',$idmoneda,PDO::PARAM_INT);
                $stmt->bindParam(':p3',$fecha,PDO::PARAM_STR);
                $stmt->bindParam(':p4',$referencia,PDO::PARAM_STR);
                $stmt->bindParam(':p5',$estado,PDO::PARAM_INT);
                $stmt->bindParam(':p6',$idsucursal,PDO::PARAM_INT);
                $stmt->bindParam(':p7',$usuarioreg,PDO::PARAM_STR);
                $stmt->bindParam(':p8',$idtipodocumento,PDO::PARAM_INT);
                $stmt->bindParam(':p9',$serie,PDO::PARAM_STR);
                $stmt->bindParam(':p10',$numero,PDO::PARAM_STR);
                $stmt->bindParam(':p11',$idproveedor,PDO::PARAM_INT);
                $stmt->bindParam(':p12',$idformapago,PDO::PARAM_INT);
                $stmt->bindParam(':p13',$guia_serie,PDO::PARAM_STR);
                $stmt->bindParam(':p14',$guia_numero,PDO::PARAM_STR);
                $stmt->bindParam(':p15',$fecha_guia,PDO::PARAM_STR);
                $stmt->bindParam(':p16',$afecto,PDO::PARAM_INT);
                $stmt->bindParam(':p17',$idalmacen,PDO::PARAM_INT);
                $stmt->bindParam(':p18',$igv,PDO::PARAM_INT);

                $stmt->execute();
                $row = $stmt->fetchAll();
                $idventa = $row[0][0];
                
                $stmt2  = $this->db->prepare('INSERT INTO movimientosdetalle(
                                                            idmovimiento, idalmacen, item, idproducto,
                                                             idtipoproducto, cantidad, precio, estado) 
                                                values(:p1, :p2, :p3, :p4, :p5, :p6, 
                                                       :p7, :p8);');                
                $estado = 1;
                $item = 1;
                foreach($_P['idtipod'] as $i => $v)
                {
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idalmacen,PDO::PARAM_INT);
                    $stmt2->bindParam(':p3',$item,PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$v,PDO::PARAM_INT);
                    $stmt2->bindParam(':p5',$_P['tipod'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p6',$_P['cantd'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p7',$_P['preciod'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p8',$estado,PDO::PARAM_INT);
                    $stmt2->execute();
                    $item += 1;

                }
               
            $this->db->commit();            
            return array('res'=>"1",'msg'=>'Bien!','id'=>$id);
        }
        catch(PDOException $e) 
        {
            $this->db->rollBack();
            return array('res'=>"2",'msg'=>'Error : '.$e->getMessage() . $str);
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