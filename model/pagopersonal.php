<?php
include_once("Main.php");

class PagoPersonal extends Main
{    
    function indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$cols)
    {
        $sql = "SELECT
            m.idmovimiento,
            c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno,
            tpd.descripcion ,
            m.documentonumero,
            tpp.descripcion,
            substr(cast(m.fecha as text),9,2)||'/'||substr(cast(m.fecha as text),6,2)||'/'||substr(cast(m.fecha as text),1,4),
            m.total,        
            case when m.idtipopago=2 then
                '<a class=\"pagar box-boton boton-pay\" id=\"v-'||m.idmovimiento||'\" title=\"Pagar sus cuotas\" ></a>'
            else '&nbsp;' end
               
            FROM
            facturacion.movimiento AS m
            INNER JOIN facturacion.movimientodetalle AS md ON m.idmovimiento = md.idmovimiento
            INNER JOIN cliente AS c ON c.idcliente = m.idcliente
            INNER JOIN facturacion.tipodocumento AS tpd ON tpd.idtipodocumento = m.idtipodocumento
            INNER JOIN produccion.tipopago AS tpp ON tpp.idtipopago = m.idtipopago ";                
        
        return $this->execQuery($page,$limit,$sidx,$sord,$filtro,$query,$cols,$sql);
    }

    function edit($id)
    {
        $stmt = $this->db->prepare("SELECT
            m.idmovimiento,
            m.fecha,
            m.idtipodocumento,
            m.documentoserie,
            m.documentonumero,
            m.documentofecha,
            m.idcliente,
            m.idmoneda,
            m.tipocambio,
            m.subtotal,
            m.porcentajeigv,
            m.total,
            m.pagoestado,
            m.pagofecha,
            m.estado,
            m.idusuarioreg,
            m.fechareg,
            m.idusuarioanu,
            m.fechaanu,
            m.obs,
            m.igv,
            m.motivoanulacion,
            m.tipodescuento,
            m.idtipopago,
            m.idalmacen,
            m.descuento,
            c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno AS nomcliente,
            c.dni,
            c.direccion
            FROM
            facturacion.movimiento AS m
            INNER JOIN cliente AS c ON c.idcliente = m.idcliente

            WHERE idmovimiento = :id ");
        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    function getDetails($id)
    {
        $stmt = $this->db->prepare("SELECT
            md.item,
            p.descripcion,
            md.idproducto,
            md.precio,
            md.cantidad,
            md.precio * md.cantidad AS importe
            FROM
            facturacion.movimiento AS m
            INNER JOIN facturacion.movimientodetalle AS md ON m.idmovimiento = md.idmovimiento
            INNER JOIN produccion.subproductos_semi AS p ON p.idsubproductos_semi = md.idproducto

            WHERE md.idmovimiento = :id    
            ORDER BY md.idmovimiento ");

        $stmt->bindParam(':id', $id , PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    function insert($_P ) 
    {
        
         
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

    function ViewCuotas($id)
    {
        $stmt = $this->db->prepare("SELECT
            mc.monto,
            substr(cast(mc.fechapago as text),9,2)||'/'||substr(cast(mc.fechapago as text),6,2)||'/'||substr(cast(mc.fechapago as text),1,4) AS fechapago,
            mc.monto_saldado
            FROM
            facturacion.movimiento AS m
            INNER JOIN facturacion.movimientocuotas AS mc ON m.idmovimiento = mc.idmovimiento

            WHERE mc.idmovimiento = :id
            ORDER BY mc.idmovimientocuota ");
        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    //Reporte
    function ViewResultado($_G)
    {
        $idpersonal =$_G['idper'];
        $fechai = $this->fdate($_G['fechai'], 'EN');
        $fechaf = $this->fdate($_G['fechaf'], 'EN');
        
        if($idpersonal==0)
        {   
            $sql="SELECT
              m.idmovimiento,
              c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno AS nomcliente,
              tpd.descripcion AS tipodoc ,
              m.documentonumero,
              tpp.descripcion AS tipopag,
              substr(cast(m.fecha as text),9,2)||'/'||substr(cast(m.fecha as text),6,2)||'/'||substr(cast(m.fecha as text),1,4) AS fechareg,
              m.total 
                 
              FROM
              facturacion.movimiento AS m
              INNER JOIN facturacion.movimientodetalle AS md ON m.idmovimiento = md.idmovimiento
              INNER JOIN cliente AS c ON c.idcliente = m.idcliente
              INNER JOIN facturacion.tipodocumento AS tpd ON tpd.idtipodocumento = m.idtipodocumento
              INNER JOIN produccion.tipopago AS tpp ON tpp.idtipopago = m.idtipopago

              WHERE
              m.fecha BETWEEN CAST(:p1 AS DATE) AND CAST(:p2 AS DATE) 
              ORDER BY
              m.idmovimiento ASC ";

            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':p1', $fechai , PDO::PARAM_STR);
            $stmt->bindParam(':p2', $fechaf, PDO::PARAM_STR);

            $stmt->execute();
            return $stmt->fetchAll();

        }else
            {   
                $sql="SELECT
                  m.idmovimiento,
                  c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno AS nomcliente,
                  tpd.descripcion AS tipodoc ,
                  m.documentonumero,
                  tpp.descripcion AS tipopag,
                  substr(cast(m.fecha as text),9,2)||'/'||substr(cast(m.fecha as text),6,2)||'/'||substr(cast(m.fecha as text),1,4) AS fechareg,
                  m.total 
                     
                  FROM
                  facturacion.movimiento AS m
                  INNER JOIN facturacion.movimientodetalle AS md ON m.idmovimiento = md.idmovimiento
                  INNER JOIN cliente AS c ON c.idcliente = m.idcliente
                  INNER JOIN facturacion.tipodocumento AS tpd ON tpd.idtipodocumento = m.idtipodocumento
                  INNER JOIN produccion.tipopago AS tpp ON tpp.idtipopago = m.idtipopago

                  WHERE
                  m.fecha BETWEEN CAST(:p1 AS DATE) AND CAST(:p2 AS DATE) AND
                  m.idusuarioreg= :id
                  ORDER BY
                  m.idmovimiento ASC ";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':id', $idpersonal , PDO::PARAM_INT);
                $stmt->bindParam(':p1', $fechai , PDO::PARAM_STR);
                $stmt->bindParam(':p2', $fechaf, PDO::PARAM_STR);

                $stmt->execute();
                return $stmt->fetchAll();
            }
        

    }
    
    // VER EL DETALLE DEL REPORTE
    function rptDetails($id)
    {
        $stmt = $this->db->prepare("SELECT
          sp.descripcion || ' ' || p.descripcion AS producto,
          md.precio,
          md.cantidad,
          md.precio * md.cantidad AS importe

          FROM
          facturacion.movimiento AS m
          INNER JOIN facturacion.movimientodetalle AS md ON m.idmovimiento = md.idmovimiento
          INNER JOIN produccion.subproductos_semi AS p ON p.idsubproductos_semi = md.idproducto
          INNER JOIN produccion.productos_semi AS sp ON sp.idproductos_semi = p.idproductos_semi

          WHERE md.idmovimiento = :id

          ORDER BY
          md.idmovimiento ASC ");

        $stmt->bindParam(':id', $id , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
?>