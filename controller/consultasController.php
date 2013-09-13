<?php
require_once '../lib/controller.php';
require_once '../lib/view.php';
require_once '../model/consultas.php';

class ConsultasController extends Controller 
{   
    
    public function proformas() 
    {        
        $data = array();
        $view = new View();
        $data['Personal'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>'.: Seleccione :.','table'=>'vista_personal'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/_proformas.php' );       
        $view->setLayout( '../template/Layout.php' );
        $view->render();
    }

    public function hojaruta() 
    {        
        $data = array();
        $view = new View();
        $data['Personal'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>'.: Seleccione :.','table'=>'vista_personal'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/_hojaruta.php' );       
        $view->setLayout( '../template/Layout.php' );
        $view->render();
    }

    public function ingresos() 
    {        
        $data = array();
        $view = new View();
        //$data['Personal'] = $this->Select(array('id'=>'idpersonal','name'=>'idpersonal','text_null'=>'.: Seleccione :.','table'=>'vista_personal'));
        $view->setData($data);
        $view->setTemplate( '../view/consultas/_ingresos.php' );       
        $view->setLayout( '../template/Layout.php' );
        $view->render();
    }
}

?>