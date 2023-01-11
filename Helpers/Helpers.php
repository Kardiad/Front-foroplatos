<?php
require_once CONTROLLERS.'/InicioController.php';

if(!function_exists('view')){
    function view(String $string, $data){
        require_once VIEWS.'/'.$string.'.php';
    }
}

if(!function_exists('controller')){
    function controller($arrayUri){
        if(empty($arrayUri)){
            $arrayUri[1]='inicio';
        }   
        $class = new Inicio();
        if(method_exists($class, $arrayUri[1])){
            $method = $arrayUri[1];
            $class->$method();
        }
    }
}
//hace que si se muere cookie, pues adios sesion XD
if(!function_exists('dosomething')){
    function dosomething(){
        (new Inicio())->logout();
    }   
}
?>