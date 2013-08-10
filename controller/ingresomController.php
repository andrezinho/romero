<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/movimiento.php';
class ingresomController extends Controller 
{   
    var $cols = array(
                        1 => array('Name'=>'Cod','NameDB'=>'m.idmovimiento','align'=>'center','width'=>50),
                        2 => array('Name'=>'Fecha','NameDB'=>'m.fecha','width'=>100,'search'=>true,'align'=>'center'),
                        3 => array('Name'=>'Referencia','NameDB'=>'m.referencia','search'=>true),
                        4 => array('Name'=>'Doc.','NameDB'=>'td.descripcion','width'=>50,'align'=>'center'),
                        5 => array('Name'=>'Serie','NameDB'=>'m.serie','align'=>'center','width'=>80),
                        6 => array('Name'=>'Numero','NameDB'=>'m.numero','align'=>'center','width'=>90),
                        7 => array('Name'=>'Fecha Doc','NameDB'=>'m.fechae','align'=>'center','width'=>100),
                        8 => array('Name'=>'Razon Social','NameDB'=>'p.razonsocial','align'=>'left'),
                        9 => array('Name'=>'RUC','NameDB'=>'p.ruc','align'=>'center','width'=>95),
                        10 => array('Name'=>'IGV','NameDB'=>'-','align'=>'center','width'=>50),
                        11 => array('Name'=>'Sub Total','NameDB'=>'-','align'=>'right','width'=>100),
                        12 => array('Name'=>'Total','NameDB'=>'-','align'=>'right','width'=>100),
                        13 => array('Name'=>'Estado','NameDB'=>'-','align'=>'center','width'=>60),
                        14 => array('Name'=>'&nbsp','NameDB'=>'-','align'=>'center','width'=>30)
                     );
    public function index() 
    {
        $data = array();                               
        $data['colsNames'] = $this->getColsVal($this->cols);
        $data['colsModels'] = $this->getColsModel($this->cols);        
        $data['cmb_search'] = $this->Select(array('id'=>'fltr','name'=>'fltr','text_null'=>'','table'=>$this->getColsSearch($this->cols)));
        $data['controlador'] = $_GET['controller'];
        $data['titulo'] = "Ingresos de Material";
        $data['script'] = "evt_index_ingresom.js";
        //(nuevo,editar,eliminar,ver,anular,imprimir)
        $data['actions'] = array(true,false,false,true,false,true);
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
        $data['idmadera'] = $this->Select(array('id'=>'idmadera','name'=>'idmadera','text_null'=>'Seleccione...','table'=>'produccion.vista_madera','width'=>'220px'));
        $data['linea'] = $this->Select(array('id'=>'idlinea','name'=>'idlinea','text_null'=>'Elija Linea...','table'=>'produccion.vista_linea','width'=>'100px'));
        $data['idmelamina'] = $this->Select(array('id'=>'idmelamina','name'=>'idmelamina','text_null'=>'Seleccione...','table'=>'produccion.vista_melamina','width'=>'120px'));
        $data['tipodocumento'] = $this->Select(array('id'=>'idtipodocumento','name'=>'idtipodocumento','text_null'=>'...','table'=>'facturacion.vista_tipodocumento','width'=>'80px'));
        $data['almacen'] = $this->Select(array('id'=>'idalmacen','name'=>'idalmacen','text_null'=>'','table'=>'produccion.almacenes','width'=>'120px'));        
        $data['formapago'] = $this->Select(array('id'=>'idformapagao','name'=>'idformapago','text_null'=>'','table'=>'formapago','width'=>'120px'));        
        $view->setData($data);
        $view->setTemplate( '../view/ingresosm/_form.php' );
        echo $view->renderPartial();
    }
    public function edit() 
    {
        $obj = new movimiento();
        $data = array();
        $view = new View();
        $rows = $obj->edit($_GET['id']);
        $data['obj'] = $rows;
        $data['idmadera'] = $this->Select(array('id'=>'idmadera','name'=>'idmadera','text_null'=>'Seleccione...','table'=>'produccion.vista_madera','width'=>'220px'));
        $data['linea'] = $this->Select(array('id'=>'idlinea','name'=>'idlinea','text_null'=>'Elija Linea...','table'=>'produccion.vista_linea','width'=>'100px'));
        $data['idmelamina'] = $this->Select(array('id'=>'idmelamina','name'=>'idmelamina','text_null'=>'Seleccione...','table'=>'produccion.vista_melamina','width'=>'120px'));
        $data['tipodocumento'] = $this->Select(array('id'=>'idtipodocumento','name'=>'idtipodocumento','text_null'=>'...','table'=>'facturacion.vista_tipodocumento','width'=>'80px','code'=>$rows->idtipodocumento));
        $data['almacen'] = $this->Select(array('id'=>'idalmacen','name'=>'idalmacen','text_null'=>'','table'=>'produccion.almacenes','width'=>'120px','code'=>$rows->idalmacen));        
        $data['formapago'] = $this->Select(array('id'=>'idformapagao','name'=>'idformapago','text_null'=>'','table'=>'formapago','width'=>'120px','code'=>$rows->idformapago));        

        $data['rowsd'] = $obj->getDetails($rows->idmovimiento);

        $view->setData($data);
        $view->setTemplate( '../view/ingresosm/_form.php' );
        echo $view->renderPartial();
    }
    public function save()
    {
        $obj = new movimiento();
        $result = array();        
        if ($_POST['idmovimiento']=='') 
            $p = $obj->insert($_POST);                        
        else         
            $p = $obj->update($_POST);
        if ($p[0]) $result = array(1,'');                
            else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
    public function delete()
    {
        $obj = new movimiento();
        $result = array();        
        $p = $obj->delete($_GET['id']);
        if ($p[0]) $result = array(1,$p[1]);
        else $result = array(2,$p[1]);
        print_r(json_encode($result));
    }
}
?>