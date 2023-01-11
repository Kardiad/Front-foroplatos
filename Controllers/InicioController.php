<?php

class Inicio extends BaseController{

    private bool $esAdmin = false;
    private $data;
    /*El inicio obtiene recetas con comentarios, además de que recibe
    cuestiones como la posibilidad de loguear usuarios*/

    private function recetas(){
        $resultados = [];
        $id = json_decode((new CurlModel(API."/furoplatos-api/Api.php/Inicio/cantidad_recetas", 'get'))->peticion());
        foreach($id->results as $receta){
            $resultado = new CurlModel(API."/furoplatos-api/Api.php/Inicio/recetas/$receta->id", 'get');
            array_push($resultados, json_decode($resultado->peticion()));
        }
        return $resultados;
    }

    public function borrarusuario(){
        (new CurlModel(API.'/furoplatos-api/Api.php/Administrador/usuario_borrar/'.$_SESSION[session_id()]['nombre_usuario'].'/'.$_POST['id'].'?api_key='.$_SESSION[session_id()]['api_key'], 'delete'))->peticion();
        $this->data = $this->datosAdmin();
        $this->data['admin'] = true;
        view('header', $this->data).view('inicio', $this->data).view('footer', $this->data);
    }

    public function borraradmin(){
        (new CurlModel(API.'/furoplatos-api/Api.php/Administrador/admin_borrar/'.$_SESSION[session_id()]['nombre_usuario'].'/'.$_POST['id'].'?api_key='.$_SESSION[session_id()]['api_key'], 'delete'))->peticion();
        $this->data = $this->datosAdmin();
        $this->data['admin'] = true;
        view('header', $this->data).view('inicio', $this->data).view('footer', $this->data);
    }

    public function leido(){
        (new CurlModel(API.'/furoplatos-api/Api.php/Administrador/leido/'.$_SESSION[session_id()]['nombre_usuario'].'/'.$_POST['id'].'?api_key='.$_SESSION[session_id()]['api_key'], 'put'))->peticion();
        $this->data = $this->datosAdmin();
        $this->data['admin'] = true;
        view('header', $this->data).view('inicio', $this->data).view('footer', $this->data);
    }

    public function borrarmensaje(){
        (new CurlModel(API.'/furoplatos-api/Api.php/Administrador/mensaje_borrar/'.$_SESSION[session_id()]['nombre_usuario'].'/'.$_POST['id'].'?api_key='.$_SESSION[session_id()]['api_key'], 'delete'))->peticion();
        $this->data = $this->datosAdmin();
        $this->data['admin'] = true;
        view('header', $this->data).view('inicio', $this->data).view('footer', $this->data);
    }

    public function recetaborrar(){
        (new CurlModel(API.'/furoplatos-api/Api.php/Administrador/receta_borrar/'.$_SESSION[session_id()]['nombre_usuario'].'/'.$_POST['id'].'?api_key='.$_SESSION[session_id()]['api_key'], 'delete'))->peticion(); 
        $this->data = $this->datosAdmin();
        $this->data['admin'] = true;
        view('header', $this->data).view('inicio', $this->data).view('footer', $this->data);
    }

    private function datosAdmin(){
        $resultados = [];
        $resultados['mensajes'] = json_decode((new CurlModel(API.'/furoplatos-api/Api.php/Administrador/mensajes/'.$_SESSION[session_id()]['nombre_usuario'].'?api_key='.$_SESSION[session_id()]['api_key'], 'get'))->peticion());
        $resultados['recetas'] = json_decode((new CurlModel(API.'/furoplatos-api/Api.php/Administrador/recetas_todas/'.$_SESSION[session_id()]['nombre_usuario'].'?api_key='.$_SESSION[session_id()]['api_key'], 'get'))->peticion());
        $resultados['usuarios'] = json_decode((new CurlModel(API.'/furoplatos-api/Api.php/Administrador/usuarios/'.$_SESSION[session_id()]['nombre_usuario'].'?api_key='.$_SESSION[session_id()]['api_key'], 'get'))->peticion());
        return $resultados;
    }

    public function nuevaReceta(){
        (new CurlModel(API.'/furoplatos-api/Api.php/Administrador/nueva_receta/'.$_SESSION[session_id()]['nombre_usuario'].'?api_key='.$_SESSION[session_id()]['api_key'], 'post'))->peticion();
        $this->data = $this->datosAdmin();
        $this->data['admin'] = true;
        view('header', $this->data).view('inicio', $this->data).view('footer', $this->data);
    }

    public function recetaedit(){
        $stringSet = '/';
        $id = $_POST['id'];
        unset($_POST['id']);
        foreach($_POST as $key => $value){
            $stringSet .=$key."=$value/";
            
        }
        $stringSet = substr($stringSet, 0, (strlen($stringSet)-1));
        (new CurlModel(API.'/furoplatos-api/Api.php/Administrador/modificar_receta/'.$_SESSION[session_id()]['nombre_usuario'].'/'.$id.'/'.$stringSet.'?api_key='.$_SESSION[session_id()]['api_key'], 'put'))->peticion();
        $this->data = $this->datosAdmin();
        $this->data['admin'] = true;
        view('header', $this->data).view('inicio', $this->data).view('footer', $this->data);
    }

    public function inicio(){
        if(!$this->esAdmin){
            $this->data = $this->recetas();      
            $this->data['admin'] = false;  
        }else{
            $this->data = $this->datosAdmin();
            $this->data['admin'] = true; 
        }
        view('header', $this->data).view('inicio', $this->data).view('footer', $this->data);
    }

    public function admingen(){
        if(strlen($_POST['password'])<6){
            (new CurlModel(API.'/furoplatos-api/Api.php/Administrador/nuevo_administrador/'.$_SESSION[session_id()]['nombre_usuario'].'?api_key='.$_SESSION[session_id()]['api_key'], 'post'))->peticion();
            $this->data = $_SESSION[session_id()];
            $this->esAdmin = true;
            $this->datosAdmin();
            $this->inicio();
        }
    }

    public function getReceta(){
        echo (new CurlModel(API."/furoplatos-api/Api.php/Inicio/recetas/".$_POST['id'], 'get'))->peticion();
    }

    public function comentar(){
        $datos = $_POST;
        unset($_POST);
        $_POST['id_usuario'] = $_SESSION[session_id()]['id'];
        $_POST['id_receta'] = $datos['id_receta'];
        $_POST['valoracion'] = $datos['valoracion'];
        $_POST['comentario'] = $datos['comentario'];
        if(empty($_SESSION[session_id()])){
            echo json_encode(['status' => 403, 'mensaje' => 'LOGUEATE O DATE DE ALTA EN NUESTRO FORO']);
        }else{
            $respuesta = (new CurlModel(API.'/furoplatos-api/Api.php/Usuarios/valorar/'.$_SESSION[session_id()]['nombre_usuario'].'?api_key='.$_SESSION[session_id()]['api_key'], 'post'))->peticion();
            $this->inicio();
        }
    }

    public function registro(){
        (new CurlModel(API.'/furoplatos-api/Api.php/Inicio/nuevo_usuario', 'post'))->peticion();
        $this->data = $this->recetas();
        $this->data['admin'] = false;
        view('header', $this->data).view('inicio', $this->data).view('footer', $this->data);
    }

    public function usuario(){
        $resultado = json_decode((new CurlModel(API.'/furoplatos-api/Api.php/Inicio/login', 'post'))->peticion());
        if($resultado->status!=404){
            if(!isset($resultado->results[0]->alias) ||!isset($resultado->results[0]->nombre)||!isset($resultado->results[0]->apellidos) ||!isset($resultado->results[0]->edad) ||!isset($resultado->results[0]->telefono)){
                $resultado->results[0]->alias = '';
                $resultado->results[0]->nombre = '';
                $resultado->results[0]->apellidos = '';
                $resultado->results[0]->edad = '';
                $resultado->results[0]->telefono = '';
                $resultado->results[0]->email = '';
                $this->esAdmin = true;
            }
            $data = [
                'id'  => $resultado->results[0]->id,
                'nombre_usuario' => $resultado->results[0]->username,
                'contrasena' => $resultado->results[0]->pass,
                'alias' => $resultado->results[0]->alias,
                'nombre' => $resultado->results[0]->nombre,
                'apellidos' => $resultado->results[0]->apellidos,
                'edad' => $resultado->results[0]->edad,
                'correo' => $resultado->results[0]->email,
                'telefono' => $resultado->results[0]->telefono,
                'api_key' => $resultado->results[0]->api_key,
            ];
            if($data['alias']==''){
                $this->esAdmin = true;
            } 
            $_SESSION[session_id()] = $data;
        }
        $this->inicio();
    }

    public function userdata(){
        echo json_encode($_SESSION[session_id()]);
    }

    public function logout(){
        echo json_encode(['status' => 'loggedout']);
        session_destroy();
        session_start();
        $_SESSION[session_id()] = [];
    }

    public function datos(){
        echo json_encode($_SESSION[session_id()]);
    }
    
    public function update(){
        $stringSet = '/';
        foreach($_POST as $key => $value){
            $stringSet .=$key."=$value/";
        }
        $stringSet = substr($stringSet, 0, strlen($stringSet)-1);
        $url = API.'/furoplatos-api/Api.php/Usuarios/modificar_perfil/'.$_SESSION[session_id()]['nombre_usuario'].$stringSet.'?api_key='.$_SESSION[session_id()]['api_key'];
        (new CurlModel($url, 'put'))->peticion();
        $this->inicio();
    }

    public function baja(){
        if(isset($_SESSION[session_id()]['contrasena']) && password_verify($_POST['password'], $_SESSION[session_id()]['contrasena'])){
            $url = API.'/furoplatos-api/Api.php/Usuarios/baja_usuario/'.$_SESSION[session_id()]['nombre_usuario'].'?api_key='.$_SESSION[session_id()]['api_key'];
            (new CurlModel($url, 'delete'))->peticion();
            $this->logout();
            $this->inicio();
        }else{
            $this->inicio();
        }
    }

    public function mensaje(){
        $texto = $_POST['texto'];
        unset($_POST);
        $_POST['id_usuario'] = intval($_SESSION[session_id()]['id']);
        $_POST['texto'] = $texto;
        $url = API.'/furoplatos-api/Api.php/Usuarios/mensaje/'.$_SESSION[session_id()]['nombre_usuario'].'?api_key='.$_SESSION[session_id()]['api_key'];
        (new CurlModel($url, 'post'))->peticion();
        $this->inicio();
    }

}

?>