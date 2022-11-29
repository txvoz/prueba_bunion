<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Profiles
 *
 * @author USER
 */
class Profiles {
    
    private static $ACCESS = null;
    
    public static function GET_ACCESS(){
        self::$ACCESS = new stdClass();
    }
    
}