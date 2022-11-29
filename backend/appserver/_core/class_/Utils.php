<?php

class Utils {

    private static $letras = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    private static $numeros = "0123456789";

    public static function randText($long, $alphanumber = true) {
        $keys = "";
        if ($alphanumber) {
            $keys = self::$letras . self::$numeros;
        } else {
            $keys = self::$letras;
        }
        $caracteres = strlen($keys);
        //******
        $cadenaRetorno = "";
        for ($i = 0; $i < $long; $i++) {
            $index = rand(0, $caracteres - 1);
            $letra = $keys[$index];
            $cadenaRetorno .= $letra;
        }
        return $cadenaRetorno;
    }

    public static function objectToB64($o) {
        $json = json_encode($o);
        $b64 = base64_encode($json);
        return $b64;
    }

    public static function b64ToObject($b64) {
        $json = base64_decode($b64);
        $o = json_decode($json);
        return $o;
    }

    public static function uploadFile($file) {
        $size = $file["size"]; //Tamaño archivo
        $tmpName = $file["tmp_name"]; //Nombre temporal de archivo
        $name = $file["name"]; //Nombre cliente
        //mi.foto.bonita.para.facebook.png
        $a = explode(".", $name);
        $t = count($a);
        $ext = $a[$t - 1];
        $nuevoNombre = self::randText(15);
        //atYUnK67n1I*QYT
        $nuevoNombre .= ".{$ext}";
        //atYUnK67n1I*QYT.png
        $c = Config::singleton();
        $path = "{$c->get("sassets")}usuarios/{$nuevoNombre}";

        if (move_uploaded_file($tmpName, $path)) {
            return $nuevoNombre;
        } else {
            return "usuario.png";
        }
    }

    public static function getParamsByBody() {
        $jData = file_get_contents("php://input");
        $oData = json_decode($jData);
        return $oData;
    }

    public static function simpleCatchMessage($message) {
        if (strpos($message, "violation: 1451") !== false) {
            $array = explode("FOREIGN KEY", $message);
            $msg2 = $array[0];
            $msg2 = str_replace("SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails", "", $msg2);
            $array = explode("CONSTRAINT", $msg2);
            $msg2 = $array[1];
            $array = explode(".", $msg2);
            @$msg2 = $array[1];
            $msg2 = str_replace(",", "", $msg2);
            $msg2 = str_replace("`", "", $msg2);
            if($msg2===""){
                $msg2 = "Referencia foranea";
            }
            $message = "No se puede eliminar el registro debido a que hay "
                    . "<br>datos asociados en el modulo de <b>{$msg2}</b>!";
        } else if (strpos($message, "violation: 1452") !== false) {
            $array = explode("REFERENCES", $message);
            $msg2 = $array[1];
            $msg2 = str_replace("SQLSTATE[23000]: Integrity constraint violation: 1451 Cannot delete or update a parent row: a foreign key constraint fails", "", $msg2);
            $array = explode("(", $msg2);
            $msg2 = $array[0];
            $msg2 = str_replace("`", "", $msg2);
            //$array = explode("(", $msg2);
            $message = "No se puede crear el registro debido a que hay "
                    . "<br>una referecia hacia el modulo de <b>{$msg2}</b>!";
        } else if (strpos($message, "violation: 1062") !== false) {
            $msg2 = str_replace("SQLSTATE[23000]: Integrity constraint violation: 1062 Duplicate entry", "", $message);
            $msg2 = str_replace("for key", "-", $msg2);
            $msg2 = str_replace("'", "", $msg2);
            $array = explode("-", $msg2);
            $campo = substr($array[1], 4);
            $message = "El valor '<b>{$array[0]}</b>' ya se encuentra<br> "
                    . "registrado para el campo <b>{$campo}</b> <br>"
                    . "por favor, verifíque la información!";
        } else if (strpos($message, "violation: 1048") !== false) {
            $msg2 = str_replace("SQLSTATE[23000]: Integrity constraint violation: 1048 Column", "", $message);
            $msg2 = str_replace("cannot be null", "", $msg2);
            $msg2 = str_replace("'", "", $msg2);
            $msg2 = substr($msg2, 4);
            $message = "El campo <b>{$msg2}</b> no puede ser un valor vacío!";
        } else if (strpos($message, "violation: 1064")) {
            $msg2 = $message;
        }
        $msg2 = str_replace("`", "", $msg2);
        return $message;
    }

}
