<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/melamina.php';

class MelaminaController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'p.idproducto','align'=>'center','width'=>50),
                        2 => array('Name'=>'Descripcion','NameDB'=>'p.descripcion','width'=>250,'search'=>true),
                        3 => array('Name'=>'Maderba','NameDB'=>'carac','width'=>120),
                        4 => array('Name'=>'Medida','NameDB'=>'p.medidas','align'=>'right','width'=>50),                        
                        5 => array('Name'=>'Precio Unitario','NameDB'=>'p.precio_u','align'=>'right','width'=>100),
                        6 => array('Name'=>'Stok','NameDB'=>'p.stock','align'=>'right','width'=>100),
                        7 => array('Name'=>'Unidad Medida','NameDB'=>'u.simbolo','align'=>'center','width'=>100),
                        9 => array('Name'=>'Estado','NameDB'=>'p.estado','align'=>'center','width'=>70)
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
        $obj = new Melamina();        
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
        $data['idlinea'] = $this->Select(array('id'=>'idlinea','name'=>'idlinea','table'=>'produccion.vista_linea','code'=>$obj->idlinea));
        $data['idmaderba'] = $this->Select(array('id'=>'idmaderba','name'=>'idmaderba','table'=>'produccion.vista_maderba','code'=>$obj->idmaderba));
        $data['idunidad_medida'] = $this->Select(array('id'=>'idunidad_medida','name'=>'idunidad_medida','table'=>'vista_unidadmedida','code'=>$obj->idunidad_medida));
        $view->setData($data);
        $view->setTemplate( '../view/melamina/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new Melamina();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['idlinea'] = $this->Select(array('id'=>'idlinea','name'=>'idlinea','table'=>'produccion.vista_linea','code'=>$obj->idlinea));
        $data['idmaderba'] = $this->Select(array('id'=>'idmaderba','name'=>'idmaderba','table'=>'produccion.vista_maderba','code'=>$obj->idmaderba));
        $data['idunidad_medida'] = $this->Select(array('id'=>'idunidad_medida','name'=>'idunidad_medida','table'=>'vista_unidadmedida','code'=>$obj->idunidad_medida));
        $view->setData($data);
        $view->setTemplate( '../view/melamina/_form.php' );
        echo $view->renderPartial();
    }
    public function save()
    {
        $obj = new Melamina();
        $result = array();        
        if ($_POST['idmelamina']=='') 
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
        $obj = new Melamina();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    public function getList()
    {
        $obj = new Melamina();
        $idlinea = (int)$_GET['idl'];
        $rows = $obj->getList($idlinea);
        print_r(json_encode($rows));
    }
    public function getPrice()
    {
        $obj = new Melamina();        
        $p = $obj->getPrice($_GET['id']);
        echo $p;
    } 
}
?>