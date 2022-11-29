<?php
class CopyModel extends BasicModel implements IModel
{
  //***** Attributes *****//
  private $conexion;
  private $table = 'copy';
  private $nameEntity = 'Copy';
  private $filter = 'status';
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
    $retorno = new stdClass();
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
      $sql = "select c.*, f.title as title_film, 
      (select if(count(*)=0,'true','false') from rent where cop_id = c.id and return_date is null) as available 
      from {$this->table} as c 
      inner join film as f on c.fil_id = f.id 
      {$where} 
      order by c.{$this->filter} asc {$limit}";

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
      $entity instanceof Copy;
      $sql = "select c.*, f.title as title_film, 
      (select if(count(*)=0,'true','false') from rent where cop_id = c.id and return_date is null) as available 
      from {$this->table} as c 
      inner join film as f on c.fil_id = f.id 
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
      $entity instanceof Copy;
      $sql = "insert into {$this->table} values ( null,?,?,?,?)";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getStatus());
      @$query->bindParam(2, $entity->getFormat());
      @$query->bindParam(3, $entity->getPrice());
      @$query->bindParam(4, $entity->getFil_id());
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
      $entity instanceof Copy;
      $sql = "update {$this->table} set "
        . "status = ?,"
        . "format = ?,"
        . "price = ?,"
        . "fil_id = ? "
        . "where id=?";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getStatus());
      @$query->bindParam(2, $entity->getFormat());
      @$query->bindParam(3, $entity->getPrice());
      @$query->bindParam(4, $entity->getFil_id());
      @$query->bindParam(5, $entity->getId());
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
      $entity instanceof Copy;
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


  
  public function getByFilmId($filmId)
  {
    $retorno = new stdClass();
    try {
      //*****
      $sql = "select c.*, f.title as title_film, 
      (select if(count(*)=0,'true','false') from rent where cop_id = c.id and return_date is null) as available 
      from {$this->table} as c 
      inner join film as f on c.fil_id = f.id 
      where c.fil_id = {$filmId} and c.id not in (select cop_id from rent where return_date is null)
      ";

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

}