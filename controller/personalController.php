<?php
    require_once '../lib/controller.php';
    require_once '../lib/view.php';
    require_once '../model/personal.php';

class PersonalController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'p.idpersonal','align'=>'center','width'=>80),
                        2 => array('Name'=>'DNI','NameDB'=>'p.dni','align'=>'center','width'=>80),
                        3 => array('Name'=>'Nombres','NameDB'=>'p.nombres','width'=>100,'search'=>true),
                        4 => array('Name'=>'Apellidos','NameDB'=>'p.apellidos','width'=>150,'search'=>true),
                        5 => array('Name'=>'Telefono','NameDB'=>'p.telefono'),
                        6 => array('Name'=>'Direccion','NameDB'=>'p.direccion'),
                        7 => array('Name'=>'Sexo','NameDB'=>'p.sexo','width'=>70),
                        8 => array('Name'=>'Estado Civil','NameDB'=>'e.descripcion','align'=>'left','width'=>80),
                        9 => array('Name'=>'Estado','NameDB'=>'p.estado','align'=>'center','width'=>'50')
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
        echo json_encode($obj->indexGrid($page,$limit,$sidx,$sord,$filtro,$query,$this->getColsVal($this->cols)));
    }
    
    public function create() 
    {
        $data = array();
        $view = new View();
        $data['idarea'] = $this->Select(array('id'=>'idarea','name'=>'idarea','text_null'=>'Seleccione...','table'=>'produccion.vista_area'));
        $data['idcargo'] = $this->Select(array('id'=>'idcargo','name'=>'idcargo','text_null'=>'Seleccione...','table'=>'produccion.vista_cargo'));
        $data['EstadoCivil'] = $this->Select(array('id'=>'idestado_civil','name'=>'idestado_civil','text_null'=>'Seleccione...','table'=>'vista_estadocivil'));
        $data['Perfil'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','text_null'=>'Seleccione...','table'=>'seguridad.vista_perfil'));
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
        $data['idarea'] = $this->Select(array('id'=>'idarea','name'=>'idarea','text_null'=>'Seleccione...','table'=>'produccion.vista_area','code'=>$obj->idarea));
        $data['idcargo'] = $this->Select(array('id'=>'idcargo','name'=>'idcargo','text_null'=>'Seleccione...','table'=>'produccion.vista_cargo','code'=>$obj->idcargo));
        $data['EstadoCivil'] = $this->Select(array('id'=>'idestado_civil','name'=>'idestado_civil','text_null'=>'Seleccione...','table'=>'vista_estadocivil','code'=>$obj->idestado_civil));
        $data['Perfil'] = $this->Select(array('id'=>'idperfil','name'=>'idperfil','text_null'=>'Seleccione...','table'=>'seguridad.vista_perfil','code'=>$obj->idperfil));
        $view->setData($data);
        $view->setTemplate( '../view/personal/_form.php' );
        echo $view->renderPartial();
    }
    public function save()
    {
        $obj = new Personal();
        $result = array();        
        if ($_POST['idpersonal']=='') 
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

    public function get()
    {
        $obj = new Personal();
        $data = array();        
        $field = "nompersonal";
        if($_GET['tipo']==1) $field = "dni";
        $value = $obj->get($_GET["term"],$field);

        $result = array();
        foreach ($value as $key => $val) 
        {
              array_push($result, array(
                        "idpersonal"=>$val['idpersonal'],
                        "dni"=>$val['dni'],
                        "nompersonal"=> strtoupper($val['nompersonal'])
                    )
                );
              if ( $key > 7 ) { break; }
        }
        print_r(json_encode($result));
    }
    
    //Ver historial de trabajo para los pagos
    public function VerTrabajo()
    {
        $obj = new Personal();
        $data = array();
        $view = new View();
        $ro = $obj->viewTrab($_GET);
        $data['produccion'] = $ro[0];
        $data['acabado'] = $ro[1];
        $view->setData($data);
        $view->setTemplate( '../view/pagopersonal/_datoshist.php' );
        $view->setLayout( '../template/empty.php' );
        echo $view->renderPartial();
    }

    //Ver historial de pagos
    public function VerPagos()
    {
        /*$obj = new Personal();
        $data = array();
        $view = new View();
        $ro = $obj->viewPag($_GET);
        $data['produccion'] = $ro[0];
        $data['acabado'] = $ro[1];
        $view->setData($data);
        $view->setTemplate( '../view/pagopersonal/_datoshist.php' );
        $view->setLayout( '../template/empty.php' );
        echo $view->renderPartial();*/

        $obj = new Personal();
        $data = array();
        $view = new View();
        $data['rowsd'] = $obj->viewPag($_GET);
        $view->setData($data);
        $view->setTemplate( '../view/pagopersonal/_pagoshist.php' );
        $view->setLayout( '../template/empty.php' );
        echo $view->renderPartial();
    }

}
 

?>