<?php

//Las variables request del sistema son 
//c(controlador) url/?c=Usuario
//a(action) url/?c=Usuario&a=buscar
//r(return) url/?c=Usuario&a=buscar&r='JSON' comunicacion entre peticiones
abstract class BasicProxy implements IProxy {
    //Controlador
    protected $c = null;
    //Fabrica de controladores
    protected $fc = null;
    //Nombre de controlador dinamico
    protected $controllerName = null;
    //Nombre de accion dinamico
    protected $action = null;
    protected $factoryController = null;

    protected function __construct() {
        //Cargar Config
        //require_once "appserver/class_/Config.php";
        $this->c = Config::singleton();
        //Cargar dependencias
        require_once "{$this->c->get("dep_class")}Utils.php";
        require_once "{$this->c->get("dep_class")}Paginator.php";
        require_once "{$this->c->get("dep_bd")}MyPDO.php";
        require_once "{$this->c->get("dep_view")}View.php";
        require_once "{$this->c->get("ab_abstracfactory")}IFactoryController.php";
        require_once "{$this->c->get("ab_abstracfactory")}IController.php";
        require_once "{$this->c->get("ab_abstracfactory")}IManagementForm.php";
        require_once "{$this->c->get("ab_abstracfactory")}IAction.php";
        require_once "{$this->c->get("ab_abstracfactory")}FactoryController.php";
        require_once "{$this->c->get("ab_entity")}IEntity.php";
        require_once "{$this->c->get("ab_entity")}BasicEntity.php";
        require_once "{$this->c->get("ab_model")}IModel.php";
        require_once "{$this->c->get("ab_model")}BasicModel.php";
        //require_once "{$this->c->get("class")}RestClient.php";
        //require_once "{$this->c->get("persistence")}MyRestClient.php";
        //**************************
        //Definir controlador a cargar
        $this->controllerName = "IndexController";
        if (isset($_REQUEST["c"])) {
            $_REQUEST["c"] = ucfirst($_REQUEST["c"]);
            $this->controllerName = "{$_REQUEST["c"]}Controller";
        }
        //Definir la accion a invocar
        $this->action = "index";
        if (isset($_REQUEST["a"])) {
            $this->action = $_REQUEST["a"];
        }
    }

    //require_once "{$conf->get("factories")}FactoryPublicController.php";

    public function main() {
        //Define el path del archivo controlador
        $this->validate();
        //*******************
        if ($this->fc instanceof IFactoryController) {
            if ($this->fc->existPath()) {
                if ($this->fc->isCallableAndValidate()) {
                    $this->fc->run();
                }
            }
        } else {
            echo "Se necesita definir la fabrica de controladores!";
        }
    }

    public function validate() {
        return false;
    }

}
