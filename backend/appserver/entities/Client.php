<?php

class Client extends BasicEntity implements JsonSerializable, IEntity
{
	/* Attributes */
	/* @PrimaryKey */
	protected $id;
	/* @Index */
	protected $fk = null;
	protected $dni;
	protected $name;
	protected $lastname;
	protected $second_lastname;
	protected $address;
	protected $email;
	/* Getters */
	public function getId()
	{
		return $this->id;
	}

	public function getDni()
	{
		return $this->dni;
	}

	/** Index **/
	public function getFk()
	{
		/*if($this->fk===null){$model = new Model();
		$e = new ();
		$e->setDni($this->dni);
		$r = $model->getById($e);
		if($r->status===200){
		$this->fk = $model->getById($e)->data;
		}
		}		
		return $this->fk;*/
	}

	public function getName()
	{
		return $this->name;
	}

	public function getLastname()
	{
		return $this->lastname;
	}

	public function getSecond_lastname()
	{
		return $this->second_lastname;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function getEmail()
	{
		return $this->email;
	}
	/* Setters */
	public function setId($param)
	{
		$this->id = $param;
	}

	public function setDni($param)
	{
		$this->dni = $param;
	}

	public function setName($param)
	{
		$this->name = $param;
	}

	public function setLastname($param)
	{
		$this->lastname = $param;
	}

	public function setSecond_lastname($param)
	{
		$this->second_lastname = $param;
	}

	public function setAddress($param)
	{
		$this->address = $param;
	}

	public function setEmail($param)
	{
		$this->email = $param;
	}

	public function jsonSerialize()
	{
		$this->id = $this->id;
		return get_object_vars($this);
	}

	public function lazyLoad()
	{
		$this->getFk();
	}

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