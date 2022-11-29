<?php
class FilmModel extends BasicModel implements IModel
{
  //***** Attributes *****//
  private $conexion;
  private $table = 'film';
  private $nameEntity = 'Film';
  private $filter = 'title';
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
          $where = " where f.{$this->filter} like '%{$obj->filtro}%' ";
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
      $sql = "select f.*, 
      (select count(*) from copy where fil_id = f.id ) as count_copies,
      (select count(c.id) from copy as c where c.fil_id = f.id and c.id not in (select cop_id from rent where cop_id=c.id and return_date is null) ) as count_available 
      from {$this->table} as f 
      {$where} 
      order by {$this->filter} asc {$limit}";

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
      $entity instanceof Film;
      $sql = "select f.*, 
      (select count(*) from copy where fil_id = f.id ) as count_copies,
      (select count(*) from copy as c where c.fil_id = f.id and  c.id not in (select cop_id from rent where cop_id=c.id and return_date is null) ) as count_available 
      from {$this->table} as f where f.id = ?";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getId());
      $query->execute();
      $retorno->data = $query->fetchObject($this->nameEntity);
      $retorno->status = 200;
      $retorno->message = "{$this->nameEntity} ncontrado";
      if (!$retorno->data instanceof $this->nameEntity) {
        $retorno->data = new Film();
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
      $entity instanceof Film;
      $sql = "insert into {$this->table} values ( null,?,?,?,?)";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getTitle());
      @$query->bindParam(2, $entity->getYear());
      @$query->bindParam(3, $entity->getResume());
      @$query->bindParam(4, $entity->getImage_cover());
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
      $entity instanceof Film;
      $sql = "update {$this->table} set "
        . "title = ?,"
        . "year = ?,"
        . "resume = ?,"
        . "image_cover = ? "
        . "where id=?";
      $query = $this->conexion->prepare($sql);
      @$query->bindParam(1, $entity->getTitle());
      @$query->bindParam(2, $entity->getYear());
      @$query->bindParam(3, $entity->getResume());
      @$query->bindParam(4, $entity->getImage_cover());
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
      $entity instanceof Film;
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