<?php

/**
  Factoria para crear los controladores publicos
 */
class FactoryPublicController extends FactoryController {

    public function __construct($controllerName, $action) {
        parent::__construct($controllerName, $action);
        //Definicion del objeto de configuracion
        $this->c = Config::singleton();
        //Definicion del path base de busqueda de controladores en la fabrica
        $sub = "";
        $this->path_controllers = "{$this->c->get("controllers")}{$sub}/";
    }

}
