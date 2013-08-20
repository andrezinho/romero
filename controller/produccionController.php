<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/produccion.php';
class ProduccionController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'p.idproduccion','align'=>'center','width'=>50),
                        2 => array('Name'=>'Descripcion','NameDB'=>'p.descripcion','width'=>280,'search'=>true),
                        3 => array('Name'=>'Personal','NameDB'=>'personal','align'=>'left','width'=>180),
                        4 => array('Name'=>'Fecha Inicio','NameDB'=>'p.fechai','align'=>'center','width'=>100),
                        5 => array('Name'=>'Fecha Inicio','NameDB'=>'p.fechaf','align'=>'center','width'=>100),
                        6 => array('Name'=>'Estado','NameDB'=>'p.estado','align'=>'center','width'=>50)
                        
                        
                     );
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Produccion";
        //(nuevo,editar,eliminar,ver)
        $data['actions'] = array(true,true,true,false);
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
        $rows = $obj->edit($_GET['id']);
        $data['obj'] = $rows;
        $data['ProductoSemi'] = $this->Select(array('id'=>'idproductos_semi','name'=>'idproductos_semi','text_null'=>'Seleccione...','table'=>'produccion.vista_productosemi','width'=>'120px'));
        $data['rowsd'] = $obj->getDetails($rows->idproduccion);
        $view->setData($data);
        $view->setTemplate( '../view/produccion/_form.php' );
        echo $view->renderPartial();
    }

    public function save()
    {
        $obj = new Produccion();
        $result = array();        
        if ($_POST['idproduccion']=='') 
            $p = $obj->insert($_POST);                        
        else         
            $p = $obj->update($_POST);                                
        if ($p[0]==1)                
            $result = array(1,'',$p[2]);                
        else                 
            $result = array(2,$p[1],'');
        print_r(json_encode($result));

    }

    public function delete()
    {
        $obj = new Modulo();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
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