<?php

/*
  La clase config va almacenar las variables
  de configuracion del sistema.
 */

class Config {

    private static $instance = null;
    private $vars;

    private function __construct() {
        $this->vars = [];
        $this->settings();
    }

    public static function singleton() {
        if (self::$instance === null) {
            self::$instance = new Config();
        }
        return self::$instance;
    }

    public function get($key) {
        $value = false;
        if (isset($this->vars["{$key}"])) {
            $value = $this->vars["{$key}"];
        }
        return $value;
    }

    public function set($key, $value) {
        $this->vars["{$key}"] = $value;
    }

    private function settings() {
        //Configuracion general 
        $this->set("fldapp", "bancounion_prueba");
        $this->set("title", "Backend");
        $this->set("author", "Gustavo Adolfo Rodriguez Quinayas");
        $this->set("keywords", "Backend, Desarrollador, 3116469802");
        $this->set("description", "Backend project in PHP.");
        $this->set("copyright", "Derechos Reservados Txvoz.");

        //Configuracion DB
        $this->set("dbhost", "localhost");
        $this->set("dbuser", "root");
        $this->set("dbuserpassword", "");
        $this->set("dbname", "bancounion_prueba");

        //Configuracion de ruta general cliente y servidor
        $this->set("ftp", "{$_SERVER["DOCUMENT_ROOT"]}/{$this->get("fldapp")}/");
        $this->set("http", "http://{$_SERVER["HTTP_HOST"]}/{$this->get("fldapp")}/");
        $this->set("api", "http://localhost/");
        //Configuracion de paths cliente
        $this->set("css", "{$this->get("http")}appclient/css/");
        $this->set("js", "{$this->get("http")}appclient/js/");
        $this->set("cassets", "{$this->get("http")}appclient/assets/");
        $this->set("clibs", "{$this->get("http")}appclient/libs/"); //clibs librerias del cliente
        $this->set("cfiles", "{$this->get("http")}appclient/files/"); //clibs librerias del cliente
        //Configuracion de paths servidor
        $this->set("core", "{$this->get("ftp")}appserver/_core/");
        $this->set("scss", "{$this->get("ftp")}appclient/css/");
        $this->set("sjs", "{$this->get("ftp")}appclient/js/");
        $this->set("ab_proxy", "{$this->get("core")}patterns/proxy/");
        $this->set("ab_abstracfactory", "{$this->get("core")}patterns/abstractfactory/");
        $this->set("ab_entity", "{$this->get("core")}entity/");
        $this->set("ab_model", "{$this->get("core")}model/");
        $this->set("dep_bd", "{$this->get("core")}bd/");
        $this->set("dep_class", "{$this->get("core")}class_/");
        $this->set("dep_view", "{$this->get("core")}view/");
        $this->set("proxies", "{$this->get("ftp")}appserver/proxies/");
        $this->set("patterns", "{$this->get("ftp")}appserver/patterns/");
        $this->set("factories", "{$this->get("ftp")}appserver/factories/");
        $this->set("controllers", "{$this->get("ftp")}appserver/controllers/");
        $this->set("models", "{$this->get("ftp")}appserver/models/");
        $this->set("persistence", "{$this->get("ftp")}appserver/persistence/");
        $this->set("views", "{$this->get("ftp")}appserver/views/");
        $this->set("entities", "{$this->get("ftp")}appserver/entities/");
        $this->set("data", "{$this->get("ftp")}appserver/data/");
        $this->set("slibs", "{$this->get("ftp")}appserver/libs/");
        $this->set("sassets", "{$this->get("ftp")}appclient/assets/");
        $this->set("sfiles", "{$this->get("ftp")}appclient/files/"); //clibs librerias del cliente
        //Configuracion de envio de correo electronico
        //mensajes 
        $this->set("msg_error_login", "Debe iniciar sesion!");

        //colores
        $this->set("pclass", "bg-success");
        $this->set("sclass", "bg-warning");
    }

}

//Objecto singleton de configuracion 
$c = Config::singleton();
