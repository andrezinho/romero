<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/correlativos.php';

class CorrelativosController extends Controller 
{   
    var $cols = array(
                        
                1 => array('Name'=>'Codigo','NameDB'=>'c.idcorrelativo','width'=>80),
                2 => array('Name'=>'Tipo Documento','NameDB'=>'t.descripcion','search'=>true),
                3 => array('Name'=>'Serie','NameDB'=>'c.serie','align'=>'center'),
                4 => array('Name'=>'Numero','NameDB'=>'c.numero','align'=>'center'),
                5 => array('Name'=>'Valor Máximo','NameDB'=>'c.valormaximo','align'=>'center'),
                6 => array('Name'=>'Valor Mínimo','NameDB'=>'c.valorminimo','align'=>'center'),
                7 => array('Name'=>'Estado','NameDB'=>'c.estado','align'=>'center')
                        
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
        $obj = new Correlativos();        
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
        $data['Tipodocumento'] = $this->Select(array('id'=>'idtipodocumento','name'=>'idtipodocumento','text_null'=>'Seleccione...','table'=>'facturacion.vista_tipodocumento'));
        $view->setData($data);
        $view->setTemplate( '../view/correlativos/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new Correlativos();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['Tipodocumento'] = $this->Select(array('id'=>'idtipodocumento','name'=>'idtipodocumento','text_null'=>'Seleccione...','table'=>'facturacion.vista_tipodocumento','code'=>$obj->idtipodocumento));
        $view->setData($data);
        $view->setTemplate( '../view/correlativos/_form.php' );
        echo $view->renderPartial();
    }

    public function save()
    {
        $obj = new Correlativos();
        $result = array();        
        if ($_POST['idcorrelativo']=='') 
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
        $obj = new Correlativos();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
 
}

?>