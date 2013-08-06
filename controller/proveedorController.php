<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/proveedor.php';

class ProveedorController extends Controller 
{   
    var $cols = array(
                        
                        1 => array('Name'=>'RUC','NameDB'=>'p.ruc','width'=>100,'search'=>true),
                        2 => array('Name'=>'Razon Social','NameDB'=>'p.razonsocial','width'=>150,'search'=>true),
                        3 => array('Name'=>'Codigo','NameDB'=>'p.dni','align'=>'center','width'=>80),
                        4 => array('Name'=>'Replegal','NameDB'=>'p.replegal','width'=>120,'search'=>true),
                        5 => array('Name'=>'Telefono','NameDB'=>'p.telefono','width'=>70),
                        6 => array('Name'=>'Direccion','NameDB'=>'p.direccion','width'=>100),
                        7 => array('Name'=>'Ubigeo','NameDB'=>'u.descripcion','width'=>100),
                        8 => array('Name'=>'Estado','NameDB'=>'p.estado','align'=>'center','width'=>50)
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
        $obj = new Proveedor();        
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
        $data['idarea'] = $this->Select(array('id'=>'idarea','name'=>'idarea','text_null'=>'Seleccione...','table'=>'produccion.vista_area'));
        $data['idcargo'] = $this->Select(array('id'=>'idcargo','name'=>'idcargo','text_null'=>'Seleccione...','table'=>'produccion.vista_cargo'));
        $view->setData($data);
        $view->setTemplate( '../view/proveedor/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new Proveedor();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['idarea'] = $this->Select(array('id'=>'idarea','name'=>'idarea','text_null'=>'Seleccione...','table'=>'produccion.vista_area','code'=>$obj->idarea));
        $data['idcargo'] = $this->Select(array('id'=>'idcargo','name'=>'idcargo','text_null'=>'Seleccione...','table'=>'produccion.vista_cargo','code'=>$obj->idcargo));
        $view->setData($data);
        $view->setTemplate( '../view/proveedor/_form.php' );
        echo $view->renderPartial();
    }
    public function save()
    {
        $obj = new Proveedor();
        $result = array();        
        if ($_POST['dni']=='') 
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
        $obj = new Proveedor();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
}
 

?>