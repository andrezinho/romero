<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/ventas.php';

class VentasController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'m.idventas','align'=>'center','width'=>50),
                        2 => array('Name'=>'Descripcion','NameDB'=>'m.descripcion','width'=>250,'search'=>true),
                        3 => array('Name'=>'Principal','NameDB'=>'mm.descripcion','search'=>true),
                        4 => array('Name'=>'URL Link','NameDB'=>'m.url'),
                        5 => array('Name'=>'Controlador','NameDB'=>'m.url'),
                        6 => array('Name'=>'Accion','NameDB'=>'m.controlador','width'=>70),
                        7 => array('Name'=>'Estado','NameDB'=>'m.estado','align'=>'center','width'=>70),
                        8 => array('Name'=>'Orden','NameDB'=>'m.orden','align'=>'center','width'=>'50')
                     );
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];

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
        $obj = new Ventas();  
              
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
        $data['tipodocumento'] = $this->Select(array('id'=>'idtipodocumento','name'=>'idtipodocumento','text_null'=>'...','table'=>'facturacion.vista_tipodoc','width'=>'120px'));
        $data['formapago'] = $this->Select(array('id'=>'idformapagao','name'=>'idformapago','text_null'=>'','table'=>'formapago','width'=>'120px'));
        $data['moneda'] = $this->Select(array('id'=>'idmoneda','name'=>'idmoneda','text_null'=>'','table'=>'vista_moneda','width'=>'120px'));
        $data['Almacen'] = $this->Select(array('id'=>'idalmacen','name'=>'idalmacen','text_null'=>'','table'=>'produccion.vista_almacen','width'=>'120px'));
        $view->setData($data);
        $view->setTemplate( '../view/ventas/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new Ventas();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['ventassPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','table'=>'seguridad.vista_ventas','code'=>$obj->idpadre));
        $view->setData($data);
        $view->setTemplate( '../view/ventas/_form.php' );
        echo $view->renderPartial();
    }
    public function save()
    {
        $obj = new Ventas();
        $result = array();        
        if ($_POST['idventas']=='') 
            $p = $obj->insert($_POST);                        
        else         
            $p = $obj->update($_POST);                                
        if ($p[0])                
            $result = array(1,'');                
        else                 
            $result = array(2,$p[1]);
        print_r(json_encode($result));

    }
    public function delete()
    {
        $obj = new Ventas();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
    }
 

?>