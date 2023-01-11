<?php

    class BaseController {
        
        public function peticion($url, $metodo){
            return (new CurlModel($url,$metodo))->peticion();
        }

    }

?>