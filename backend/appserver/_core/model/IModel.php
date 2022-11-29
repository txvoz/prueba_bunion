<?php

interface IModel {
  /*get() : define la devolucion de
   una lista de objetos
   */
  public function get($filtro = null);
  
  /* getById(): Define la devolucion de un 
  solo objeto por medio del id 
   */
  public function getById($entity);
  
  /*insert(): Registra un nuevo objeto */
  public function insert($entity);
  
  /*update(): Actualiza un registro previo */
  public function update($entity);
  
  /*delete(): Elimina un registro previo */
  public function delete($entity);
}
