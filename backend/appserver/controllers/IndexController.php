<?php

class IndexController implements IController {

    function __construct() {
        $c = Config::singleton();
        //incluir entidad
        //incluir modulo 
    }
    
    public function index() {
        View::show("public/index");
    }
    
}
