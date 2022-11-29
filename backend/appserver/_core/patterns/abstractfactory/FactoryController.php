<?php

/*
Clase base para crear y controlar la factoria de controladores
*/
class FactoryController implements IFactoryController {

    //Objeto de configuracion
    protected $c = null;
    //Especifica el path donde se encuentran los controladores
    protected $path_controllers;
    //Nombre del controlador
    protected $controllerName = null;
    //Nombre de la accion
    protected $action = null;
    //Controlador fijo
    protected $controller = null;

    //Contructor base de la fabrica
    protected function __construct($controllerName, $action) {
        $this->controllerName = $controllerName;
        $this->action = $action;
        $c = Config::singleton();
    }
    
    //Metodo de validacion del metodo (accion) en el controlador
    public function isCallableAndValidate(){
        //Instanciacion real del controlador
        $this->controller = new $this->controllerName;
        //is_callable([$this->controllerName, $this->action])
        if(is_callable(array($this->controller, "{$this->action}"))){
            if($this->controller instanceof IController){
                return true;
            }else{
                echo "{$this->controllerName} no implementa IController.";
                return false;
            }
        }else{ 
            echo "No se puede invocar la accion {$this->controllerName}->{$this->action}().";
            return false;
        }
    }

    //Validacion del path de un archivo controlador
    public function existPath() {
        $path = "{$this->path_controllers}/{$this->controllerName}.php";
        if (is_file($path)) {
            require_once "{$path}";
            return true;
        } else {
            echo "El archivo {$this->controllerName}.php no exite!";
            return false;
        }
    }

    protected function setPath($path) {
        $this->path_controllers = $path;
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    //Metodo para correr la accion en el controlador 
    public function run() {
        $action = $this->action;
        $this->controller->$action();
        return true;
    }
}