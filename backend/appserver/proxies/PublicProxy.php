<?php

class PublicProxy extends BasicProxy {

    /**
     * Constructor del proxy especifico
     */
    public function __construct() {
        parent::__construct();
        //Se especifica cual es la factoria que se va usar en este proxy
        require_once "{$this->c->get("factories")}FactoryPublicController.php";
        $this->fc = new FactoryPublicController($this->controllerName, $this->action);
    }

    //Metodo de validacion desde el proxy para el manejo de perfiles
    public function validate() {
//        $retorno = new stdClass();
//        $retorno->status = 200;
//        $c = strtolower(@$_REQUEST["c"]);
//        $a = strtolower(@$_REQUEST["a"]);
//        if ($c === "") {
//            $c = "Index";
//        }
//        if ($a === "") {
//            $a = "index";
//        }
//        $c = ucfirst($c);
//        $isJson = (strpos($a, "action") !== false);
//        //************************
//        if (!isset($_SESSION["session"]) && !isset($_SESSION["id"])) {
//            if (!($c === "Auth" || $c === "Index")) {
//                $retorno->status = 500;
//                $retorno->message = "No tiene acceso a esta acción o modulo!";
//            }
//        } else if (isset($_SESSION["session"])) {
//            if (!(($c === "Encuesta" || $c === "Index") || ($c === "Auth" && $a === "logout"))) {
//                $retorno->status = 500;
//                $retorno->message = "No tiene acceso a esta acción o modulo!";
//            }
//        } else if (isset($_SESSION["id"])) {
//            //|| $a==="actiondelete"
//            if (!(($c !== "Encuesta" && $c !== "Auth") || ($c === "Auth" && $a === "logout"))   ) {
//                $retorno->status = 500;
//                $retorno->message = "No tiene acceso a esta acción o modulo!";
//            }
//        }
//        //************************
//        if ($retorno->status !== 200) {
//            if ($isJson) {
//                echo json_encode($retorno);
//            } else {
//                View::show("public/noAccess");
//            }
//            die();
//        }
    }
}
