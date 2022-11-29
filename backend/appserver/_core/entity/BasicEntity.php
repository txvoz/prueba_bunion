<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BasicEntity
 *
 * @author txvoz
 */
abstract class BasicEntity {

    protected $id;

    function getId() {
        return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    public function serializeByArray($array) {
        foreach ($array as $key => $value) {
            $this->{"{$key}"} = $value;
        }
    }

    public function serializeByObject($o) {
        foreach ($o as $key => $value) {
            $this->{"{$key}"} = $value;
        }
    }

    public function describeStr() {
        $str = $this->getId();
        $contador = 0;
        foreach ($this as $key => $value) {
            if($contador===1){
                $str = "{$str} - {$value}";
                break;
            }
            $contador++;
        }
        return $str;
    }

}
