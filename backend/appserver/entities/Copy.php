<?php
class Copy extends BasicEntity implements JsonSerializable, IEntity
{
	/* Attributes */
	/* @PrimaryKey */
	protected $id;
	protected $status;
	protected $format;
	protected $price;
	/* @Index */
	//protected $fk = null;
	protected $fil_id;
	/* Getters */
	public function getId()
	{
		return $this->id;
	}

	public function getStatus()
	{
		return $this->status;
	}

	public function getFormat()
	{
		return $this->format;
	}

	public function getPrice()
	{
		return $this->price;
	}

	public function getFil_id()
	{
		return $this->fil_id;
	}

	/** Index **/
	public function getFk()
	{
		return null;
	}

	/* Setters */
	public function setId($param)
	{
		$this->id = $param;
	}

	public function setStatus($param)
	{
		$this->status = $param;
	}

	public function setFormat($param)
	{
		$this->format = $param;
	}

	public function setPrice($param)
	{
		$this->price = $param;
	}

	public function setFil_id($param)
	{
		$this->fil_id = $param;
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