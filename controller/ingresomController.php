<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/movimiento.php';

class ingresomController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'m.idmovimiento','align'=>'center','width'=>50),
                        2 => array('Name'=>'Fecha','NameDB'=>'m.fecha','width'=>100,'search'=>true),
                        3 => array('Name'=>'Referencia','NameDB'=>'m.referencia','search'=>true),
                        4 => array('Name'=>'Estado','NameDB'=>'m.estado'),
                        5 => array('Name'=>'Usuario','NameDB'=>'m.usuarioreg'),
                        6 => array('Name'=>'Impr.','NameDB'=>'-','align'=>'center','width'=>20),
                        7 => array('Name'=>'Anul.','NameDB'=>'-','align'=>'center','width'=>20)
                     );
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Ingresos de Material";
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
        $obj = new movimiento();        
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
        $data['idmadera'] = $this->Select(array('id'=>'idmadera','name'=>'idmadera','text_null'=>'Seleccione...','table'=>'produccion.vista_madera','width'=>'250px'));
        $data['idmelamina'] = $this->Select(array('id'=>'idmelamina','name'=>'idmelamina','text_null'=>'Seleccione...','table'=>'produccion.vista_melamina','width'=>'250px'));
        $view->setData($data);
        $view->setTemplate( '../view/ingresosm/_form.php' );
        echo $view->renderPartial();
    }
    public function edit() 
    {
        $obj = new Modulo();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        $data['ModulosPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','table'=>'seguridad.vista_modulo','code'=>$obj->idpadre));
        $view->setData($data);
        $view->setTemplate( '../view/ingresosm/_form.php' );
        echo $view->renderPartial();
    }
    public function save()
    {
        $obj = new Modulo();
        $result = array();        
        if ($_POST['idmodulo']=='') 
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
        $obj = new Modulo();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
    }
 

?>