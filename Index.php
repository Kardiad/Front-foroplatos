<?php

require_once __DIR__.'/Config/bootstrap.php';
require_once ROOT_PATH.'/Config/config.php';
require_once HELPERS.DIRECTORY_SEPARATOR.'Helpers.php';
session_start();
if(!isset($_SESSION[session_id()])){
    $_SESSION[session_id()] = [];
}
$uri = [];
if(isset( $_SERVER['PATH_INFO'])){
    $uri = explode('/', $_SERVER['PATH_INFO']);
}
unset($uri[0]);
if(isset($_POST['killsession']) && $_POST['killsession']==true){
    dosomething();
}else{
    controller($uri);
}
?>