<?php
class Film extends BasicEntity implements JsonSerializable, IEntity
{
	/* Attributes */
	/* @PrimaryKey */
	protected $id;
	protected $title;
	protected $year;
	protected $resume;
	protected $image_cover;
	/* Getters */
	public function getId()
	{
		return $this->id;
	}

	public function getTitle()
	{
		return $this->title;
	}

	public function getYear()
	{
		return $this->year;
	}

	public function getResume()
	{
		return $this->resume;
	}

	public function getImage_cover()
	{
		return $this->image_cover;
	}

	/* Setters */
	public function setId($param)
	{
		$this->id = $param;
	}

	public function setTitle($param)
	{
		$this->title = $param;
	}

	public function setYear($param)
	{
		$this->year = $param;
	}

	public function setResume($param)
	{
		$this->resume = $param;
	}

	public function setImage_cover($param)
	{
		$this->image_cover = $param;
	}

	public function jsonSerialize()
	{
		$this->id = $this->id;
		return get_object_vars($this);
	}

	public function lazyLoad()
	{
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