<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/proformas.php';

class ProformasController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'p.idproforma','align'=>'center','width'=>'40'),
                        2 => array('Name'=>'Cliente','NameDB'=>'c.nombres','search'=>true),
                        3 => array('Name'=>'Sucursal','NameDB'=>'s.descripcion','search'=>true), 
                        4 => array('Name'=>'Fecha','NameDB'=>'p.fecha','width'=>'50','align'=>'center'),                       
                        5 => array('Name'=>'Estado','NameDB'=>'p.estado','width'=>'60','align'=>'center')
                     );

    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        //(nuevo,editar,eliminar,ver,anular,imprimir)
        $data['actions'] = array(true,true,false,false,true,true);

        $view = new View();
        $view->setData($data);
        $view->setTemplate('../view/_indexGrid.php');
        $view->setlayout('../template/layout.php');
        $view->render();
    }

    public function indexGrid() 
    {
        $obj = new Proformas();        
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
        $data['tipopago'] = $this->Select(array('id'=>'idtipopago','name'=>'idtipopago','text_null'=>'Seleccione...','table'=>'produccion.vista_tipopago'));       
        $data['Financiamiento'] = $this->Select(array('id'=>'idfinanciamiento','name'=>'idfinanciamiento','text_null'=>'Seleccione...','table'=>'facturacion.vista_financiamiento'));
        $data['Sucursal'] = $this->Select(array('id'=>'idsucursal','name'=>'idsucursal','text_null'=>'Seleccione...','table'=>'vista_sucursal'));       
        $view->setData($data);
        $view->setTemplate( '../view/Proformas/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new Proformas();
        $data = array();
        $view = new View();
        $rows = $obj->edit($_GET['id']);
        $data['obj'] = $rows;
        $data['tipopago'] = $this->Select(array('id'=>'idtipopago','name'=>'idtipopago','text_null'=>'Seleccione...','table'=>'produccion.vista_tipopago'));       
        $data['Financiamiento'] = $this->Select(array('id'=>'idfinanciamiento','name'=>'idfinanciamiento','text_null'=>'Seleccione...','table'=>'facturacion.vista_financiamiento'));       
        $data['Sucursal'] = $this->Select(array('id'=>'idsucursal','name'=>'idsucursal','text_null'=>'Seleccione...','table'=>'vista_sucursal','code'=>$rows->idsucursal));
        $data['rowsd'] = $obj->getDetails($rows->idproforma);
        $view->setData($data);
        $view->setTemplate( '../view/Proformas/_form.php' );
        echo $view->renderPartial();
        
    }

    public function save()
    {
        $obj = new Proformas();
        $result = array();        
        if ($_POST['idproforma']=='')
            
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
        $obj = new Proformas();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
   
   
}

?>