<?php
class RentModel extends BasicModel implements IModel
{
  //***** Attributes *****//
  private $conexion;
  private $table = 'rent';
  private $nameEntity = 'Rent';
  private $filter = 'rent_date';


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
          $where = " where r.{$this->filter} like '%{$obj->filtro}%' ";
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
      $sql = "select r.*, c.format as copy_format, c.status as copy_status,f.id as fil_id, f.title as film_title, 
      cl.name as client_name, cl.lastname as client_lastname, cl.dni as client_dni, 
      if((r.return_date is null),'true','false') as isPending, 
      if((r.return_date is null and limit_date <= CURRENT_DATE()),'true','false') as isExpired  
      from {$this->table} as r 
      inner join copy as c on c.id = r.cop_id 
      inner join film as f on f.id = c.fil_id 
      inner join client as cl on cl.id = r.cli_id
      {$where} 
      order by r.{$this->filter} asc {$limit}";

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
      $entity instanceof Rent;
      $sql = "select r.*, c.format as copy_format, c.status as copy_status,f.id as fil_id, f.title as film_title, 
      cl.name as client_name, cl.lastname as client_lastname, cl.dni as client_dni, 
      if((r.return_date is null),'true','false') as isPending, 
      if((r.return_date is null and limit_date <= CURRENT_DATE()),'true','false') as isExpired
      from {$this->table} as r 
      inner join copy as c on c.id = r.cop_id 
      inner join film as f on f.id = c.fil_id 
      inner join client as cl on cl.id = r.cli_id 
      where r.id = ?";
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
      $entity instanceof Rent;
      $sql = "insert into {$this->table} values ( null,?,?,?,?,?)";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getRent_date());
      @$query->bindParam(2, $entity->getLimit_date());
      @$query->bindParam(3, $entity->getReturn_date());
      @$query->bindParam(4, $entity->getCli_id());
      @$query->bindParam(5, $entity->getCop_id());
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
      $entity instanceof Rent;
      $sql = "update {$this->table} set "
        . "rent_date = ?,"
        . "limit_date = ?,"
        . "return_date = ?,"
        . "cli_id = ?,"
        . "cop_id = ? "
        . "where id=?";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getRent_date());
      @$query->bindParam(2, $entity->getLimit_date());
      @$query->bindParam(3, $entity->getReturn_date());
      @$query->bindParam(4, $entity->getCli_id());
      @$query->bindParam(5, $entity->getCop_id());
      @$query->bindParam(6, $entity->getId());
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
      $entity instanceof Rent;
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


  public function getCountActiveRentByUser($id)
  {
    $retorno = new stdClass();
    try {
      //****** Paginacion y Filtros
      $sql = "SELECT count(*) as cantidad 
      FROM {$this->table} as r 
      WHERE r.cli_id = {$id} and r.return_date is null";

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

  public function updateStatus($id, $date) {
    $retorno = new stdClass();
    try {
       $sql = "update {$this->table} set "
        . "return_date = ? "
        . "where id=?";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $date);
      @$query->bindParam(2, $id);
      $query->execute();
      $retorno->data = true;
      $retorno->status = 200;
      $retorno->message = "Registro Actualizado.";
    } catch (PDOException $e) {
      $retorno->message = Utils::simpleCatchMessage($e->getMessage());
      $retorno->status = 501;
    }
    return $retorno;
  }

}