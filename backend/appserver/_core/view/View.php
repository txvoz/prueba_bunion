<?php

class View {
  public static function show($templateName,$vars=[],$master="masterPage"){
    //$templateName es la ruta de la vista 
    //$vars son los parametros que llegan a la vista
    $conf = Config::singleton();
    $path = "{$conf->get("views")}{$templateName}.php";
    if(is_file($path)){
      $aPath = explode("/", $templateName);
      $lastIdx = count($aPath)-1;
      $view = $aPath[$lastIdx];
      $core = str_replace($view,"core",$templateName);
      //El template existe en las vistas
      $pCSSC = "{$conf->get("scss")}{$core}.css";
      $csscore = "";
      if(is_file($pCSSC)){
        $csscore = "{$core}.css";
      }
      /*****/
      $pCSS = "{$conf->get("scss")}{$templateName}.css";
      $css = "";
      if(is_file($pCSS)){
        $css = "{$templateName}.css";
      }
      /*****/
      $pJS = "{$conf->get("sjs")}{$templateName}.js";
      $js = "";
      if(is_file($pJS)){
        $js = "{$templateName}.js";
      }
      /*****/
      $pJSC = "{$conf->get("sjs")}{$core}.js";
      $jscore = "";
      if(is_file($pJSC)){
        $jscore = "{$core}.js";
      }
      /*****/
      extract($vars);
      $main = $path;
      
      $r = null;
      if(isset($_REQUEST["r"])){
        $r = Utils::b64ToObject($_REQUEST["r"]);
      }
      $pathMaster = "{$conf->get("views")}template/{$master}.php";
      require_once "{$pathMaster}";
    }else{
      //El template no existe en las vistas
      die("El template {$path} no existe!");
    }
  }
}
