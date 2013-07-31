<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/personal.php';

class PersonalController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'p.dni','align'=>'center','width'=>80),
                        2 => array('Name'=>'Nombres','NameDB'=>'p.nombres','width'=>150,'search'=>true),
                        3 => array('Name'=>'Apellidos','NameDB'=>'p.apellidos','width'=>150,'search'=>true),
                        4 => array('Name'=>'Telefono','NameDB'=>'p.telefono'),
                        5 => array('Name'=>'Direccion','NameDB'=>'p.direccion'),
                        6 => array('Name'=>'Sexo','NameDB'=>'p.sexo','width'=>70),
                        7 => array('Name'=>'Estado Civil','NameDB'=>'p.estcivil','align'=>'left','width'=>80),
                        8 => array('Name'=>'Estado','NameDB'=>'p.estado','align'=>'center','width'=>'50')
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
        $obj = new Personal();        
        $page = (int)$_GET['page'];
        $limit = (int)$_GET['rows']; 
        $sidx = $_GET['sidx'];
        $sord = $_GET['sord'];
        $filtro = $this->getColNameDB($this->cols,(int)$_GET['f']);        
        $query = $_GET['q'];
        if(!$sidx) $sidx = 1;
        if(!$limit) $limit = 10;
        if(!$page) $page = 1;
        echo json_encode($obj->indexGrid($page,$limit,$sidx,$sord,$filtro,$query));
    }
    
    public function create() 
    {
        $data = array();
        $view = new View();
        //$data['PersonalsPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','text_null'=>'Seleccione...','table'=>'seguridad.vista_Personal'));
        $view->setData($data);
        $view->setTemplate( '../view/personal/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new Personal();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;
        //$data['PersonalsPadres'] = $this->Select(array('id'=>'idpadre','name'=>'idpadre','table'=>'seguridad.vista_Personal','code'=>$obj->idpadre));
        $view->setData($data);
        $view->setTemplate( '../view/personal/_form.php' );
        echo $view->renderPartial();
    }
    public function save()
    {
        $obj = new Personal();
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
        $obj = new Personal();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    
}
 

?>