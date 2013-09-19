<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/ventas.php';

class VentasController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Codigo','NameDB'=>'m.idmovimiento','align'=>'center','width'=>50),
                        2 => array('Name'=>'Cliente','NameDB'=>"c.nombres || ' ' || c.apepaterno || ' ' || c.apematerno",'width'=>150,'search'=>true),
                        3 => array('Name'=>'Tipo documento.','NameDB'=>'tpd.descripcion','search'=>true,'width'=>80),
                        4 => array('Name'=>'N° Recibo','NameDB'=>'m.documentonumero','search'=>true,'width'=>80),
                        5 => array('Name'=>'Tipo Pago','NameDB'=>'tpp.descripcion','search'=>true,'width'=>80),
                        6 => array('Name'=>'Fecha','NameDB'=>'m.fecha','width'=>70,'align'=>'center'),
                        7 => array('Name'=>'Total','NameDB'=>'m.total','align'=>'right','width'=>70),
                        8 => array('Name'=>'','NameDB'=>'-','align'=>'center','width'=>40)

                     );
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['script'] = "evt_index_ventas.js";
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
        $data['formapago'] = $this->Select(array('id'=>'idformapago','name'=>'idformapago','text_null'=>'','table'=>'formapago','width'=>'120px'));
        $data['formapago2'] = $this->Select(array('id'=>'idformapago2','name'=>'idformapago2','text_null'=>'','table'=>'formapago','width'=>'120px'));
        $data['moneda'] = $this->Select(array('id'=>'idmoneda','name'=>'idmoneda','text_null'=>'','table'=>'vista_moneda','width'=>'120px','code'=>'1','disabled'=>'disabled'));
        $data['Almacen'] = $this->Select(array('id'=>'idalmacen','name'=>'idalmacen','text_null'=>'','table'=>'produccion.vista_almacen','width'=>'120px'));
        $data['tipopago'] = $this->Select(array('id'=>'idtipopago','name'=>'idtipopago','text_null'=>'Seleccione...','table'=>'produccion.vista_tipopago'));       
        $data['Financiamiento'] = $this->Select(array('id'=>'idfinanciamiento','name'=>'idfinanciamiento','text_null'=>'Seleccione...','table'=>'facturacion.vista_financiamiento'));
        $data['subproductosemi'] = $this->Select(array('id'=>'idsubproductos_semi','name'=>'idsubproductos_semi','text_null'=>'...','table'=>'produccion.vista_subproductosemi'));
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
        if ($p[0]=="1")
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

    public function test()
    {
        print_r($_GET['producto']);
        //$a = json_decode($_GET['producto']);        
        //echo $a->descripcion[0];
    }

    public function pagarcuota()
    {
        
        $obj = new Ventas();
        $data = array();
        $view = new View();
        $data['rowsd'] = $obj->ViewCuotas($_GET['id']);
        $data['formapago2'] = $this->Select(array('id'=>'idformapago2','name'=>'idformapago2','text_null'=>'','table'=>'formapago','width'=>'120px'));
        $view->setData($data);
        $view->setTemplate( '../view/ventas/_pagocuota.php' );
        $view->setLayout( '../template/list.php' );
        $view->render();
    
    }    
}
 

?>