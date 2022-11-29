<?php
class ClientModel extends BasicModel implements IModel
{
  //***** Attributes *****//
  private $conexion;
  private $table = 'client';
  private $nameEntity = 'Client';
  private $filter = 'dni';
  //***** Constructs *****//
  public function __construct()
  {
    $this->conexion = MyPDO::singleton();
  }

  //***** Methods *****//
  public function getCount($obj = null)
  {
    $retorno = new stdClass();
    try {
      //****** Paginacion y Filtros
      $where = '';
      if ($obj != '') {
        $where = " where {$this->filter} like '%{$obj}%' ";
      }
      //*****
      $sql = "SELECT count(*) as cantidad FROM {$this->table} {$where} ";
      $query = $this->conexion->prepare($sql);
      $query->execute();
      $r = $query->fetchObject();
      $retorno->cantidad = $r->cantidad;
    } catch (PDOException $e) {
      $retorno->status = 501;
      $retorno->message = Utils::simpleCatchMessage($e->getMessage());
    }
    return $retorno;
  }
  public function get($obj = null, $all = true)
  {
    $retorno = new stdClass()
      ;
    try {


      //****** Paginacion y Filtros
      $where = '';
      $limit = '';
      if ($obj !== null) {
        if ($obj->filtro != '') {
          $where = " where c.{$this->filter} like '%{$obj->filtro}%' ";
        }
        if (!$all) {
          $paginacion = $obj->paginator;
          $paginacion instanceof Paginator;
          $c = Paginator::$COUNT_BY_PAG;
          $i = $paginacion->getInicioLimit();
          $limit = "limit {$i},{$c}";
        }
      }
      //*****

      //*****
      $sql = "select c.*,
      (select count(*) from rent where cli_id=c.id and return_date IS NULL) as films_pending, 
      (select count(*) from rent where cli_id=c.id and return_date IS NULL and limit_date <= CURRENT_DATE()) as films_expired
      from {$this->table} as c {$where} order by {$this->filter} asc {$limit}";

      $query = $this->conexion->prepare($sql);
      $query->execute();
      $retorno->data = $query->fetchAll(PDO::FETCH_CLASS, $this->nameEntity);
      $retorno->status = 200;
      $retorno->message = "Consulta exitosa";
      if (count($retorno->data) === 0) {
        $retorno->status = 201;
        $retorno->message = "No hay registros en la base de datos.";
      }
    } catch (PDOException $e) {
      $retorno->message = Utils::simpleCatchMessage($e->getMessage());
      $retorno->status = 501;
    }
    //$this->lazyLoad($retorno->data);
    return $retorno;
  }

  public function getById($entity)
  {
    $retorno = new stdClass();
    try {
      $entity instanceof Client;
      $sql = "select c.*,
      (select count(*) from rent where cli_id=c.id and return_date IS NULL) as films_pending, 
      (select count(*) from rent where cli_id=c.id and return_date IS NULL and limit_date <= CURRENT_DATE()) as films_expired  
      from {$this->table} as c
      where c.id = ?";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getId());
      $query->execute();
      $retorno->data = $query->fetchObject($this->nameEntity);
      $retorno->status = 200;
      $retorno->message = "{$this->nameEntity} ncontrado";
      if (!$retorno->data instanceof $this->nameEntity) {
        $retorno->status = 404;
        $retorno->message = "{$this->nameEntity} no encontrado";
      }
    } catch (PDOException $e) {
      $retorno->message = Utils::simpleCatchMessage($e->getMessage());
      $retorno->status = 501;
    }
    //$this->lazyLoad($retorno->data);
    return $retorno;
  }

  public function insert($entity)
  {
    $retorno = new stdClass();
    try {
      $entity instanceof Client;
      $sql = "insert into {$this->table} values ( null,?,?,?,?,?,?)";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getDni());
      @$query->bindParam(2, $entity->getName());
      @$query->bindParam(3, $entity->getLastname());
      @$query->bindParam(4, $entity->getSecond_lastname());
      @$query->bindParam(5, $entity->getAddress());
      @$query->bindParam(6, $entity->getEmail());
      $query->execute();
      $id = $this->conexion->lastInsertId();
      $entity->setId($id);
      $retorno->data = $entity;
      $retorno->status = 200;
      $retorno->message = "Registro insertado.";
    } catch (PDOException $e) {
      $retorno->message = Utils::simpleCatchMessage($e->getMessage());
      $retorno->status = 501;
    }
    return $retorno;
  }

  public function update($entity)
  {
    $retorno = new stdClass();
    try {
      $entity instanceof Client;
      $sql = "update {$this->table} set "
        . "dni = ?,"
        . "name = ?,"
        . "lastname = ?,"
        . "second_lastname = ?,"
        . "address = ?,"
        . "email = ? "
        . "where id=?";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getDni());
      @$query->bindParam(2, $entity->getName());
      @$query->bindParam(3, $entity->getLastname());
      @$query->bindParam(4, $entity->getSecond_lastname());
      @$query->bindParam(5, $entity->getAddress());
      @$query->bindParam(6, $entity->getEmail());
      @$query->bindParam(7, $entity->getId());
      $query->execute();
      $retorno->data = $entity;
      $retorno->status = 200;
      $retorno->message = "Registro Actualizado.";
    } catch (PDOException $e) {
      $retorno->message = Utils::simpleCatchMessage($e->getMessage());
      $retorno->status = 501;
    }
    return $retorno;
  }

  public function delete($entity)
  {
    $retorno = new stdClass();
    try {
      $entity instanceof Client;
      $sql = "delete from {$this->table} where id = ?";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getId());
      $query->execute();
      $retorno->status = 200;
      $retorno->message = "{$this->nameEntity} eliminado";
    } catch (PDOException $e) {
      $retorno->message = Utils::simpleCatchMessage($e->getMessage());
      $retorno->status = 501;
    }
    return $retorno;
  }


}