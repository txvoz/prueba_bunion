<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ICrud
 *
 * @author Aprendiz
 */
interface IManagementForm {

    //Renderizar la vista d ela lista
    public function viewList();

//renderizar la vista/formulario crear
    public function viewCreate();

//renderizar la vista/formulario detaller
    public function viewDetail();

}
