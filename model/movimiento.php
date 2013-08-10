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
                                        fechae, idproveedor, idformapago, guia_serie, guia_numero, 
                                        fecha_guia, afecto, idalmacen, igv) 
                            values(:p1, :p2, :p3, :p4, 
                                        :p5, :p6, :p7, :p8, :p9, :p10, 
                                        :p11, :p12, :p13, :p14, :p15, 
                                        :p16, :p17, :p18, :p19)";
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
                $stmt->bindParam(':p11',$fechae,PDO::PARAM_STR);
                $stmt->bindParam(':p12',$idproveedor,PDO::PARAM_INT);
                $stmt->bindParam(':p13',$idformapago,PDO::PARAM_INT);
                $stmt->bindParam(':p14',$guia_serie,PDO::PARAM_STR);
                $stmt->bindParam(':p15',$guia_numero,PDO::PARAM_STR);
                $stmt->bindParam(':p16',$fecha_guia,PDO::PARAM_STR);
                $stmt->bindParam(':p17',$afecto,PDO::PARAM_INT);
                $stmt->bindParam(':p18',$idalmacen,PDO::PARAM_INT);
                $stmt->bindParam(':p19',$igv,PDO::PARAM_INT);

                $stmt->execute();
                $id =  $this->lastInsertId('movimientos','idmovimiento');
                $row = $stmt->fetchAll();

                $stmt2  = $this->db->prepare('INSERT INTO movimientosdetalle(
                                                            idmovimiento, idalmacen, item, idproducto,
                                                             idtipoproducto, cantidad, precio, estado) 
                                                values(:p1, :p2, :p3, :p4, :p5, :p6, 
                                                       :p7, :p8);');                
                
                $stmt3 = $this->db->preapre('UPDATE produccion.producto 
                                                    set stock = stock + :cant
                                                 WHERE idproducto = :idp');

                $estado = 1;
                $item = 1;

                foreach($_P['idtipod'] as $i => $idproducto)
                {
                    $stmt2->bindParam(':p1',$id,PDO::PARAM_INT);
                    $stmt2->bindParam(':p2',$idalmacen,PDO::PARAM_INT);
                    $stmt2->bindParam(':p3',$item,PDO::PARAM_INT);
                    $stmt2->bindParam(':p4',$idproducto,PDO::PARAM_INT);
                    $stmt2->bindParam(':p5',$_P['tipod'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p6',$_P['cantd'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p7',$_P['preciod'][$i],PDO::PARAM_INT);
                    $stmt2->bindParam(':p8',$estado,PDO::PARAM_INT);
                    $stmt2->execute();
                    $item += 1;

                    $stmt3->bindParam(':cant',$_P['cantd'][$i],PDO::PARAM_INT);
                    $stmt3->bindParam(':idp',$idproducto,PDO::PARAM_INT);
                    $stmt3->execute();
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