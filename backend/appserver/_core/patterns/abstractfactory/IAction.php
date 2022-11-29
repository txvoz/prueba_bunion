<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author txvoz
 */
interface IAction {

    //ejecutar la accion de crear
    public function actionCreate();

//ejecutar la accion de editar
    public function actionUpdate();

//ejecutar la accion de eliminar
    public function actionDelete();

    //Listar
    public function actionList();

    public function actionListData();
}
