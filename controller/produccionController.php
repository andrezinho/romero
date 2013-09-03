<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/produccion.php';
class ProduccionController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'p.idproduccion','align'=>'center','width'=>50),
                        2 => array('Name'=>'Descripcion','NameDB'=>'p.descripcion','width'=>280,'search'=>true),
                        3 => array('Name'=>'Personal','NameDB'=>"pe.nombres || ' ' || pe.apellidos",'align'=>'left','width'=>180,'search'=>true),
                        4 => array('Name'=>'Almacen','NameDB'=>'a.descripcion','align'=>'left','width'=>100,'search'=>true),
                        5 => array('Name'=>'Fecha Reg.','NameDB'=>'p.fecha','align'=>'center','width'=>80),
                        6 => array('Name'=>'Fecha Inicio','NameDB'=>'p.fechai','align'=>'center','width'=>80),
                        7 => array('Name'=>'Fecha Fin','NameDB'=>'p.fechaf','align'=>'center','width'=>80),
                        8 => array('Name'=>'Estado','NameDB'=>'p.estado','align'=>'center','width'=>80),
                        9 => array('Name'=>'','NameDB'=>'','align'=>'center','width'=>20),
                        10 => array('Name'=>'','NameDB'=>'','align'=>'center','width'=>20)
                     );
    
    var $cols_list = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'dp.idproduccion_detalle','align'=>'center','width'=>40),
                        2 => array('Name'=>'Producto','NameDB'=>"ps.descripcion||' '||sps.descripcion",'width'=>200,'search'=>true),
                        3 => array('Name'=>'Cantidad','NameDB'=>"dp.cantidad",'align'=>'center','width'=>50),
                        4 => array('Name'=>'Stock','NameDB'=>'dp.stock','align'=>'center','width'=>50),                        
                        5 => array('Name'=>'Fecha Inicio','NameDB'=>'p.fechaini','align'=>'center','width'=>80,'datefmt'=>'d/m/Y'),
                        6 => array('Name'=>'Fecha Fin','NameDB'=>'p.fechafin','align'=>'center','width'=>80),
                        7 => array('Name'=>'Alamcen','NameDB'=>'a.descripcion','align'=>'center','width'=>100),
                        8 => array('Name'=>'Responsable','NameDB'=>"pp.nombres||' '||pp.apellidos",'align'=>'left','width'=>150)                        
                     );

    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Produccion de muebles";
        $data['script'] = "evt_index_produccion.js";        
        $data['actions'] = array(true,true,false,true,false);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }
    public function indexGrid() 
    {
        $obj = new Produccion();        
        $page = (int)$_GET['page'];
        $limit = (int)$_GET['rows']; 
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $filtro = $this->getColNameDB($this->cols,(int)$_GET['f']);
        $query = $_GET['q'];
        if(!$sidx) $sidx = 1;
        if(!$limit) $limit = 10;
        if(!$page) $page = 1;
        echo json_encode($obj->indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$this->getColsVal($this->cols)));
    }

    public function lista()
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols_list);
        $data['colsModels'] = $this->getColsModel($this->cols_list);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols_list)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Produccion de Muebeles finalizadas";
        $data['script'] = "evt_index_produccion.js";
        $data['actions'] = array(false,false,false,false,false);
        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGridList.php');
        $view->setlayout('../template/list.php');
        $view->render();
    }
    public function indexGridList() 
    {
        $obj = new Produccion();        
        $page = (int)$_GET['page'];
        $limit = (int)$_GET['rows']; 
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $filtro = $this->getColNameDB($this->cols_list,(int)$_GET['f']);
        $query = $_GET['q'];
        if(!$sidx) $sidx = 1;
        if(!$limit) $limit = 10;
        if(!$page) $page = 1;
        echo json_encode($obj->indexGridList($page,$limit,$sidx,$sord,$filtro,$query,$this->getColsVal($this->cols_list)));
    }
    public function create() 
    {
        $data = array();
        $view = new View();
        $data['ProductoSemi'] = $this->Select(array('id'=>'idproductos_semi','name'=>'idproductos_semi','text_null'=>'Seleccione...','table'=>'produccion.vista_productosemi','width'=>'120px'));
        $data['almacenma'] = $this->Select(array('id'=>'idalmacenma','name'=>'idalmacenma','text_null'=>'','table'=>'produccion.almacenes','width'=>'120px'));        
        $data['almacenme'] = $this->Select(array('id'=>'idalmacenme','name'=>'idalmacenme','text_null'=>'','table'=>'produccion.almacenes','width'=>'120px'));        
        $data['idmadera'] = $this->Select(array('id'=>'idmadera','name'=>'idmadera','text_null'=>'Seleccione...','table'=>'produccion.vista_madera','width'=>'220px'));
        $data['linea'] = $this->Select(array('id'=>'idlinea','name'=>'idlinea','text_null'=>'Elija Linea...','table'=>'produccion.vista_linea','width'=>'100px'));
        $data['idmelamina'] = $this->Select(array('id'=>'idmelamina','name'=>'idmelamina','text_null'=>'Seleccione...','table'=>'produccion.vista_melamina','width'=>'120px'));
        $view->setData($data);
        $view->setTemplate( '../view/produccion/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new Produccion();
        $data = array();
        $view = new View();
        //Comprobamos si podemos editar
        $estado = $this->getEstado("produccion.produccion","idproduccion",$_GET['id']);
        if($estado==1)
        {            
            $rows = $obj->edit($_GET['id']);
            $data['obj'] = $rows;
            $data['ProductoSemi'] = $this->Select(array('id'=>'idproductos_semi','name'=>'idproductos_semi','text_null'=>'Seleccione...','table'=>'produccion.vista_productosemi','width'=>'120px'));                
            $data['idmadera'] = $this->Select(array('id'=>'idmadera','name'=>'idmadera','text_null'=>'Seleccione...','table'=>'produccion.vista_madera','width'=>'220px'));
            $data['linea'] = $this->Select(array('id'=>'idlinea','name'=>'idlinea','text_null'=>'Elija Linea...','table'=>'produccion.vista_linea','width'=>'100px'));
            $data['idmelamina'] = $this->Select(array('id'=>'idmelamina','name'=>'idmelamina','text_null'=>'Seleccione...','table'=>'produccion.vista_melamina','width'=>'120px'));        
            $data['rowsd'] = $obj->getDetails($rows->idproduccion);
            if(count($data['rowsd'])>0)        
                $data['almacenma'] = $this->Select(array('id'=>'idalmacenma','name'=>'idalmacenma','text_null'=>'','table'=>'produccion.almacenes','width'=>'120px','code'=>$obj->idalmacen,'disabled'=>'disabled'));                        
            else 
                $data['almacenma'] = $this->Select(array('id'=>'idalmacenma','name'=>'idalmacenma','text_null'=>'','table'=>'produccion.almacenes','width'=>'120px','code'=>$obj->idalmacen));                        
            $view->setData($data);
            $view->setTemplate( '../view/produccion/_form.php' );
            echo $view->renderPartial();
        }
        else
        {
            $view = new View();
            $data['msg'] = "<b>Esta produccion ya no es ediable. </b><br/><br/>
                  Si deseas ver los datos de esta produccion 
                  le recomendamos elegir la opcion 'VER' del menu de operaciones.<br/>
                  Si considera que este registro si deveria poder editarse, comuniquese con el administrador del sistema. ";
            $view->setData($data);
            $view->setTemplate( '../view/_error_app.php' );
            echo $view->renderPartial();
        }
    }
    public function view() 
    {
        $obj = new Produccion();
        $data = array();
        $view = new View();
        $rows = $obj->edit($_GET['id']);
        $data['obj'] = $rows;
        $data['ProductoSemi'] = $this->Select(array('id'=>'idproductos_semi','name'=>'idproductos_semi','text_null'=>'Seleccione...','table'=>'produccion.vista_productosemi','width'=>'120px','disabled'=>'disabled'));                
        $data['idmadera'] = $this->Select(array('id'=>'idmadera','name'=>'idmadera','text_null'=>'Seleccione...','table'=>'produccion.vista_madera','width'=>'220px','disabled'=>'disabled'));
        $data['linea'] = $this->Select(array('id'=>'idlinea','name'=>'idlinea','text_null'=>'Elija Linea...','table'=>'produccion.vista_linea','width'=>'100px','disabled'=>'disabled'));
        $data['idmelamina'] = $this->Select(array('id'=>'idmelamina','name'=>'idmelamina','text_null'=>'Seleccione...','table'=>'produccion.vista_melamina','width'=>'120px','disabled'=>'disabled'));        
        $data['rowsd'] = $obj->getDetails($rows->idproduccion);
        if(count($data['rowsd'])>0)        
            $data['almacenma'] = $this->Select(array('id'=>'idalmacenma','name'=>'idalmacenma','text_null'=>'','table'=>'produccion.almacenes','width'=>'120px','code'=>$obj->idalmacen,'disabled'=>'disabled'));                        
        else 
            $data['almacenma'] = $this->Select(array('id'=>'idalmacenma','name'=>'idalmacenma','text_null'=>'','table'=>'produccion.almacenes','width'=>'120px','code'=>$obj->idalmacen));                        
        $view->setData($data);
        $view->setTemplate( '../view/produccion/_form.php' );
        echo $view->renderPartial();
    }
    public function save()
    {
        $obj = new Produccion();        
        if(isset($_POST['idproduccion']))
        {            
            if ($_POST['idproduccion']=='') 
                $p = $obj->insert($_POST);
            else         
                $p = $obj->update($_POST);
            if ($p[0]==1)
                $result = array(1,'',$p[2]);
            else                 
                $result = array(2,$p[1],'');            
        }
        else
        {
            $result = array(2,"Esta operacion no se puede realizar.");
        }
        print_r(json_encode($result));
    }

    public function anular()
    {
        $obj = new Produccion();
        $result = array();        
        $p = $obj->delete($_POST['i']);
        if ($p[0]=="1") $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }

    public function end()
    {
        $obj = new Produccion();
        $result = array();        
        $p = $obj->end($_POST['i']);
        if ($p[0]=="1") $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }

    public function test()
    {
        $a = json_decode($_GET['m']);        
        echo $a->descripcion[0];
    }
}
?>