<?php

//PHP-Data-Object


class MyPDO extends PDO {

  private static $instance;

  private function __construct() {
    $conf = Config::singleton();
    try {
      $dsn = "mysql:host={$conf->get("dbhost")};dbname={$conf->get("dbname")}";
      $username = $conf->get("dbuser");
      $passwd = $conf->get("dbuserpassword");
      parent::__construct($dsn, $username, $passwd);
      $this->exec("SET CHARSET utf8");
      $this->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
      $this->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
    } catch (PDOException $exc) {
      echo $exc->getMessage();
    }
  }

  public static function singleton() {
    if (self::$instance === null) {
      $nombreClase = __CLASS__;
      self::$instance = new $nombreClase();
    }
    return self::$instance;
  }

}
