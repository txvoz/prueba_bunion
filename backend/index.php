<?php
//error_reporting(0);
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");
$method = $_SERVER['REQUEST_METHOD'];

session_start();
require_once "appserver/_core/class_/Config.php";
require_once "{$c->get("ab_proxy")}IProxy.php";
require_once "{$c->get("ab_proxy")}BasicProxy.php";
require_once "{$c->get("proxies")}PublicProxy.php";
$proxy = new PublicProxy();
$proxy->main();
?>