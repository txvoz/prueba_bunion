<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BasicModel
 *
 * @author USER
 */
class BasicModel {
    //put your code here
    public function lazyLoad($data){
         if(is_array($data)){
             foreach ($data as $entity) {
                 $entity instanceof IEntity;
                 $entity->lazyLoad();
             }
         }else if(is_object($data)){
             $data instanceof IEntity;
             $data->lazyLoad();
         }
    }
}
