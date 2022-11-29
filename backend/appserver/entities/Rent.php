<?php
class Rent extends BasicEntity implements JsonSerializable, IEntity {
/* Attributes */
/* @PrimaryKey */
	protected $id;
	protected $rent_date;
	protected $limit_date;
	protected $return_date;
/* @Index */
	protected $fk = null;
	protected $cli_id;
	protected $cop_id;
/* Getters */
	public function getId(){
		return $this->id;
	}

	public function getRent_date(){
		return $this->rent_date;
	}

	public function getLimit_date(){
		return $this->limit_date;
	}

	public function getReturn_date(){
		return $this->return_date;
	}

	public function getCli_id(){
		return $this->cli_id;
	}

/** Index **/
	public function getFk(){
		//if($this->fk===null){$model = new Model();$e = new ();$e->setCli_id($this->cli_id);$r = $model->getById($e);if($r->status===200){$this->fk = $model->getById($e)->data;}}		return $this->fk;
	}

	public function getCop_id(){
		return $this->cop_id;
	}

/** Index **/
	/*public function getFk(){
		//if($this->fk===null){$model = new Model();$e = new ();$e->setCop_id($this->cop_id);$r = $model->getById($e);if($r->status===200){$this->fk = $model->getById($e)->data;}}		return $this->fk;
	}*/

/* Setters */
	public function setId($param){
		$this->id = $param;
	}

	public function setRent_date($param){
		$this->rent_date = $param;
	}

	public function setLimit_date($param){
		$this->limit_date = $param;
	}

	public function setReturn_date($param){
		$this->return_date = $param;
	}

	public function setCli_id($param){
		$this->cli_id = $param;
	}

	public function setCop_id($param){
		$this->cop_id = $param;
	}

public function jsonSerialize() {
        $this->id = $this->id;
        return get_object_vars($this);
        }
        
        public function lazyLoad() {
        $this->getFk();$this->getFk();}
        
        /*public function serializeByArray($array) {
            foreach ($array as $key => $value) {
                $this->{"{$key}"} = $value;
            }
        }

        public function serializeByObject($o) {
            foreach ($o as $key => $value) {
                $this->{"{$key}"} = $value;
            }
        }*/
}