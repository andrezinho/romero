<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/clientes.php';

class ClientesController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'c.idcliente','width'=>50),
                        2 => array('Name'=>'DNI / RUC','NameDB'=>'c.dni','width'=>80,'search'=>true),
                        3 => array('Name'=>'Razon Social','NameDB'=>"'c.nombres || ' ' || c.apematerno || ' ' || c.apepaterno'",'width'=>150,'search'=>true),
                        4 => array('Name'=>'Direccion','NameDB'=>'c.direccion','width'=>130),
                        5 => array('Name'=>'Telefono','NameDB'=>'p.telefono','width'=>70),
                        6 => array('Name'=>'Estado Civil','NameDB'=>'e.descripcion','width'=>75),
                        7 => array('Name'=>'N. Educacion','NameDB'=>'g.descripcion','width'=>100),
                        8 => array('Name'=>'Ubigeo','NameDB'=>'u.descripcion','align'=>'left','width'=>100)
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
        $obj = new Clientes();        
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
        $data['Departamento'] = $this->Select(array('id'=>'Departamento','name'=>'Departamento','text_null'=>'Seleccione...','table'=>'vista_dep'));
        $data['TipoVivienda'] = $this->Select(array('id'=>'idtipovivienda','name'=>'idtipovivienda','text_null'=>'Seleccione...','table'=>'facturacion.vista_tipovivienda'));
        $data['TipoCliente'] = $this->Select(array('id'=>'idtipocliente','name'=>'idtipocliente','text_null'=>'Seleccione...','table'=>'vista_tipocliente'));
        $data['NivelEducacion'] = $this->Select(array('id'=>'idgradinstruccion','name'=>'idgradinstruccion','text_null'=>'Seleccione...','table'=>'vista_grado'));
        $data['EstadoCivil'] = $this->Select(array('id'=>'idestado_civil','name'=>'idestado_civil','text_null'=>'Seleccione...','table'=>'vista_estadocivil'));
        $view->setData($data);
        $view->setTemplate( '../view/clientes/_form.php' );
        echo $view->renderPartial();
    }

    public function edit() 
    {
        $obj = new Clientes();
        $data = array();
        $view = new View();
        $obj = $obj->edit($_GET['id']);
        $data['obj'] = $obj;        
        $data['Departamento'] = $this->Select(array('id'=>'Departamento','name'=>'Departamento','text_null'=>'Seleccione...','table'=>'vista_dep','code'=>$obj->IdDep));
        $data['idprovincia'] = $this->Select(array('id'=>'idprovincia','name'=>'idprovincia','text_null'=>'Seleccione...','table'=>'produccion.vista_cargo','code'=>$obj->Idpro));
        $data['TipoVivienda'] = $this->Select(array('id'=>'idtipovivienda','name'=>'idtipovivienda','text_null'=>'Seleccione...','table'=>'facturacion.vista_tipovivienda','code'=>$obj->idtipovivienda));
        $data['TipoCliente'] = $this->Select(array('id'=>'idtipocliente','name'=>'idtipocliente','text_null'=>'Seleccione...','table'=>'vista_tipocliente','code'=>$obj->idtipocliente));
        $data['NivelEducacion'] = $this->Select(array('id'=>'idgradinstruccion','name'=>'idgradinstruccion','text_null'=>'Seleccione...','table'=>'vista_grado','code'=>$obj->idgradinstruccion));
        $data['EstadoCivil'] = $this->Select(array('id'=>'idestado_civil','name'=>'idestado_civil','text_null'=>'Seleccione...','table'=>'vista_estadocivil','code'=>$obj->idestado_civil));
        $view->setData($data);
        $view->setTemplate( '../view/clientes/_form.php' );
        echo $view->renderPartial();
    }
    
    public function save()
    {
        $obj = new Clientes();
        $result = array();        
        if ($_POST['idcliente']=='') 
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
        $obj = new Clientes();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }

    public function get()
    {
        $obj = new Clientes();
        $data = array();        
        $field = "c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno";
        if($_GET['tipo']==1) $field = "dni";
        $value = $obj->get($_GET["term"],$field);

        $result = array();
        foreach ($value as $key => $val) 
        {
              array_push($result, array(
                                        "idcliente"=>$val['idcliente'], 
                                        "dni"=>$val['dni'],
                                        "direccion"=>$val['direccion'],
                                        "telefono"=>$val['telefono'],
                                        "nomcliente"=> strtoupper($val['nomcliente'])
                                    )
                        );
              if ( $key > 7 ) { break; }
        }
        print_r(json_encode($result));
    }
}
?>