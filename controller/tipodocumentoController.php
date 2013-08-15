<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/tipodocumento.php';

class TipodocumentoController extends Controller
{
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'t.idtipodocumento','align'=>'center','width'=>'50'),
                        2 => array('Name'=>'Descripcion','NameDB'=>'t.descripcion','search'=>true),
                        3 => array('Name'=>'Abreviatura','NameDB'=>'t.abreviado','search'=>true),
                        4 => array('Name'=>'Tipo','NameDB'=>'tp.descripcion','search'=>true),
                        5 => array('Name'=>'Estado','NameDB'=>'t.estado','width'=>'30','align'=>'center')
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
        $obj = new Tipodocumento();        
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
        $data['Tipo'] = $this->Select(array('id'=>'idtipdoc','name'=>'idtipdoc','text_null'=>'Seleccione...','table'=>'facturacion.vista_tipdoc'));       
        $view->setData($data);
        $view->setTemplate( '../view/tipodocumento/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() {
        $obj = new Tipodocumento();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;        
        $data['Tipo'] = $this->Select(array('id'=>'idtipdoc','name'=>'idtipdoc','text_null'=>'Seleccione...','table'=>'facturacion.vista_tipdoc','code'=>$obj->idtipdoc));       
        $view->setData($data);
        $view->setTemplate( '../view/tipodocumento/_form.php' );
        echo $view->renderPartial();
        
    }

    public function save()
    {
        $obj = new Tipodocumento();
        $result = array();        
        if ($_POST['idtipodocumento']=='') 
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
        $obj = new Tipodocumento();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
   
   public function Correlativo()
   {
        $obj = new Tipodocumento();        
        $rows = $obj->GCorrelativo($_GET['idtp']);                               
        print_r(json_encode($rows));
   }


}

?>